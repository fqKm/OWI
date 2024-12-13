<?php
require "../Model/Database.php";
class RequestPostService
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getPostByHighestUpvote(): ?array
    {
        $query = "SELECT permintaan_donasi.id, permintaan_donasi.judul, penawaran_donasi.foto, penawaran_donasi.dibuat_pada, organisasi.nama FROM penawaran_donasi JOIN organisasi ON penawaran_donasi.organisasi = organisasi.id ORDER BY upvote DESC LIMIT 5";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function getAllRequestPost($page): ?array
    {
        $post_per_page = 10;
        $offset = ($page) * $post_per_page;
        $query = "SELECT permintaan_donasi.id, permintaan_donasi.judul, permintaan_donasi.foto, permintaan_donasi.dibuat_pada, organisasi.nama FROM permintaan_donasi JOIN organisasi ON permintaan_donasi.organisasi = organisasi.id LIMIT ? OFFSET ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $post_per_page, $offset);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    private function getRequestPostDetailsById(int $id): ?array
    {
        $query = "SELECT * FROM permintaan_donasi WHERE id = ?";
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