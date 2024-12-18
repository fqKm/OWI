<?php
require_once "../Model/Database.php";
require_once "../Service/UserService.php";
class RequestPostService
{
    private $db;
    private $userService;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->userService = new UserService();
    }
    public function getPostByHighestUpvote(): array
    {
        $query = "SELECT permintaan_donasi.id, permintaan_donasi.judul, permintaan_donasi.foto, permintaan_donasi.dibuat_pada, permintaan_donasi.nik_pembuat, user.organisasi FROM permintaan_donasi JOIN user ON permintaan_donasi.nik_pembuat = user.nik ORDER BY dibuat_pada DESC LIMIT 5";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getAllRequestPost(): ?array
    {
        $query = "SELECT permintaan_donasi.id, permintaan_donasi.judul, permintaan_donasi.foto, permintaan_donasi.dibuat_pada, user.nama_depan, user.nama_belakang FROM permintaan_donasi JOIN user ON permintaan_donasi.nik_pembuat = user.nik";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function getRequestPostDetailsById(int $id): ?array
    {
        $query = "SELECT permintaan_donasi.id, permintaan_donasi.judul, permintaan_donasi.deskripsi, permintaan_donasi.dibuat_pada, permintaan_donasi.id_alamat, permintaan_donasi.foto, permintaan_donasi.nik_pembuat, user.organisasi FROM permintaan_donasi JOIN user ON permintaan_donasi.nik_pembuat = user.nik WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function createRequestPost($judul, $deskripsi, $id_alamat, $nik_pembuat, $foto): ?int
    {
        $organisasi = $this->userService->getUserOrganisationByNik($nik_pembuat);
        if($organisasi == null){
            return null;
        };
        $query = "INSERT INTO permintaan_donasi (judul, deskripsi, dibuat_pada, id_alamat, nik_pembuat, foto) VALUES (?,?,?,?,?,?)";
        $now = date("Y-m-d H:i:s");
        $statement = $this->db->prepare($query);
        $statement->bind_param("sssiis", $judul, $deskripsi, $now, $id_alamat,$nik_pembuat, $foto);
        if ($statement->execute()) {
            return $statement->insert_id;
        }
        return null;
    }
    public function getRequestPostByNik($nik_pembuat): ?array
    {
        $query = "SELECT permintaan_donasi.id, permintaan_donasi.judul, permintaan_donasi.foto, permintaan_donasi.dibuat_pada, permintaan_donasi.nik_pembuat, user.organisasi FROM permintaan_donasi JOIN user ON permintaan_donasi.nik_pembuat = user.nik WHERE permintaan_donasi.nik_pembuat = ?;";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $nik_pembuat);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function updateRequestPost($judul, $deskripsi, $foto, $id): bool
    {
        $query = "UPDATE permintaan_donasi  SET judul = ?, deskripsi = ?, foto = ? WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("sssi", $judul, $deskripsi, $foto, $id);
        return $statement->execute();
    }
    public function deleteRequestPost(int $id): bool{
        $query = "DELETE FROM permintaan_donasi WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $id);
        return $statement->execute();
    }
}