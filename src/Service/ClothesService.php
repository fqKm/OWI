<?php
require_once "../Model/Database.php";
class ClothesService
{
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getAllClothes($id_penawaran): ?array
    {
        $query = "SELECT id, jenis, ukuran, jumlah FROM pakaian WHERE id_penawaran = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $id_penawaran);
        $statement->execute();
        $result = $statement->get_result();
        if(!empty($result)){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function insertAllClothes($id_penawaran, $jenis, $ukuran, $jumlah)
    {
        $query = "INSERT INTO pakaian (id_penawaran, jenis, ukuran, jumlah) VALUES (?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        foreach ($jenis as $key => $item) {
            $itemUkuran = $ukuran[$key];
            $itemJumlah = $jumlah[$key];

            $statement->bind_param("issi", $id_penawaran, $item, $jenis[$key], $jumlah[$key]);
            return $statement->execute();
        }
        return false;
    }
    public function deleteClothes($id, $id_penawaran)
    {
        $query = "DELETE FROM pakaian WHERE id = ? AND id_penawaran = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("ii", $id, $id_penawaran);
        return $statement->execute();
    }

    public function updateClothes($id_penawaran, $id, $jenis, $ukuran, $jumlah) : bool
    {
        $query = "UPDATE pakaian SET jenis = ?, ukuran = ?, jumlah = ? WHERE id =? AND id_penawaran = ?";
        $statement = $this->db->prepare($query);
        foreach ($jenis as $key => $item) {
            $statement->bind_param("ssiii", $jenis[$key], $ukuran[$key], $jumlah[$key], $id[$key], $id_penawaran);
            return $statement->execute();
        }
        return false;
    }
}