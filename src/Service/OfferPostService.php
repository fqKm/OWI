<?php
require_once "../Model/Database.php";
class OfferPostService
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getPostByLatestUpdate(): array
    {
        $query = "SELECT penawaran_donasi.id, penawaran_donasi.judul, penawaran_donasi.foto, penawaran_donasi.dibuat_pada, user.nama_depan, user.nama_belakang FROM penawaran_donasi JOIN user ON penawaran_donasi.nik_pembuat = user.nik ORDER BY dibuat_pada DESC LIMIT 5";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getAllOfferPost(): ?array
    {
        $query = "SELECT penawaran_donasi.id, penawaran_donasi.judul, penawaran_donasi.foto, penawaran_donasi.dibuat_pada, penawaran_donasi.nik_pembuat, user.nama_depan, user.nama_belakang FROM penawaran_donasi JOIN user ON penawaran_donasi.nik_pembuat = user.nik";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function getOfferPostDetailsById(int $id): ?array
    {
        $query = "SELECT pd.id AS penawaran_id, pd.judul, pd.deskripsi, pd.foto, pd.nik_pembuat,pd.id_alamat, pd.dibuat_pada, a.id as alamat_id, a.jalan, a.rt, a.rw, a.dusun, a.desa, a.kecamatan, a.kota, a.kode_pos,u.nik AS pembuat_nik, u.nama_depan, u.nama_belakang FROM penawaran_donasi pd JOIN alamat a ON pd.id_alamat = a.id JOIN user u ON pd.nik_pembuat = u.nik WHERE pd.id = ?;";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if(!empty($result)){
            return $result->fetch_assoc();
        }
        return null;
    }
    public function createOfferingPost($judul, $deskripsi, $id_alamat, $foto, $nik_pembuat) : ?int
    {
        $query = "INSERT INTO penawaran_donasi(judul, deskripsi, dibuat_pada, id_alamat, foto, nik_pembuat) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        $now = date("Y-m-d H:i:s");
        $statement->bind_param("sssisi", $judul, $deskripsi, $now, $id_alamat, $foto, $nik_pembuat );
        if($statement->execute()){
            return $statement->insert_id;
        }
        return null;
    }

    public function getOfferingPostByNik($nik_pembuat): ?array
    {
        $query = "SELECT penawaran_donasi.id, penawaran_donasi.judul, penawaran_donasi.foto, penawaran_donasi.dibuat_pada, user.nama_depan, user.nama_belakang FROM penawaran_donasi JOIN user ON penawaran_donasi.nik_pembuat = user.nik WHERE penawaran_donasi.nik_pembuat = ?;";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $nik_pembuat);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function updateOfferingPost($judul, $deskripsi, $id_alamat, $foto, $id): bool
    {
        $query = "UPDATE penawaran_donasi  SET judul = ?, deskripsi = ?, id_alamat = ?, foto = ? WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ssssi", $judul, $deskripsi, $id_alamat, $foto, $id);
        return $statement->execute();
    }
    public function deleteOfferingPost(int $id): bool{
        $query = "DELETE FROM penawaran_donasi WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $id);
        return $statement->execute();
    }
}