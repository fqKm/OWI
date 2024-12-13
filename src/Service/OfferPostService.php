<?php
require "../Model/Database.php";

class OfferPostService
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getPostByHighestUpvote(): ?array
    {
        $query = "SELECT penawaran_donasi.id, penawaran_donasi.judul, penawaran_donasi.foto, penawaran_donasi.dibuat_pada, user.nama_depan, user.nama_belakang FROM penawaran_donasi JOIN user ON penawaran_donasi.nik_pembuat = user.nik ORDER BY upvote DESC LIMIT 5";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function getAllOfferPost($page): ?array
    {
        $post_per_page = 10;
        $offset = ($page) * $post_per_page;
        $query = "SELECT penawaran_donasi.id, penawaran_donasi.judul, penawaran_donasi.foto, penawaran_donasi.dibuat_pada, user.nama_depan, user.nama_belakang FROM penawaran_donasi JOIN user ON penawaran_donasi.nik_pembuat = user.nik LIMIT ? OFFSET ? ";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $post_per_page, $offset);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    private function getOfferPostDetailsById(int $id): ?array
    {
        $query = "SELECT * FROM penawaran_donasi WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if ($statement->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
}