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
        $query = "SELECT id, judul, foto, dibuat_pada, nik_pembuat FROM permintaan_donasi ORDER BY dibuat_pada DESC LIMIT 5";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $result = $statement->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getAllRequestPost($page): ?array
    {
        $post_per_page = 10;
        $offset = ($page) * $post_per_page;
        $query = "SELECT id, judul, foto, dibuat_pada, nik_pembuat FROM permintaan_donasi LIMIT ? OFFSET ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $post_per_page, $offset);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function getRequestPostDetailsById(int $id): ?array
    {
        $query = "SELECT permintaan_donasi.id, permintaan_donasi.judul, permintaan_donasi.deskripsi, permintaan_donasi.dibuat_pada, permintaan_donasi.id_alamat, permintaan_donasi.foto, user.nik_pembuat user.organisasi FROM permintaan_donasi JOIN user ON permintaan_donasi.nik_pembuat = user.nik WHERE id = ?";
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
        $statement->bind_param("sssiiis", $judul, $deskripsi, $now, $id_alamat,$nik_pembuat, $foto);
        if ($statement->execute()) {
            return $statement->insert_id;
        }
        return null;
    }
}