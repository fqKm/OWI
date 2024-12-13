<?php
require_once "../Model/Database.php";
require "AddressService.php";
class UserService {
    private $db;
    private $addressService;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->addressService = new AddressService();
    }
    public function loginService($email, $password): ?array
    {
        $query = "SELECT * FROM user WHERE email = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('s', $email);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return null;
    }

    public function isUserAlreadyRegistered($nik): bool{
        $query = "SELECT * FROM user WHERE nik = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param('i', $nik);
        $statement->execute();
        $result = $statement->get_result();
        return $result->num_rows > 0;
    }
    public function registerService($nik, $nama_depan, $nama_belakang, $email, $password, $nomor_telepon, $rt, $rw, $jalan, $dusun, $desa, $kecamatan, $kota): bool
    {
        $id_alamat = $this->addressService->createAddress($rt, $rw, $jalan, $dusun, $desa, $kecamatan, $kota);
        if (!$this->isUserAlreadyRegistered($nik) && $id_alamat != null) {
            $user_query = "INSERT INTO user (nik, nama_depan, nama_belakang, email, password, nomor_telepon, id_alamat) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement = $this->db->prepare($user_query);
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $statement->bind_param("isssssi", $nik, $nama_depan, $nama_belakang, $email, $hashed_password, $nomor_telepon, $id_alamat);
            return $statement->execute();
        }
        return false;
    }
}
?>