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
        $query = "SELECT jenis, ukuran, jumlah FROM pakaian WHERE id_penawaran = ?";
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
        foreach ($jenis as $key => $item) {
            $itemUkuran = $ukuran[$key];
            $itemJumlah = $jumlah[$key];
            $validSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
            if (!in_array($itemUkuran, $validSizes)) {
                return false;
            }
            $statement = $this->db->prepare($query);
            $statement->bind_param("issi", $id_penawaran, $item, $itemUkuran, $itemJumlah);
            return $statement->execute();
        }
        return false;
    }
}