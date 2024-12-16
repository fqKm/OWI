<?php 
require_once "../Model/Database.php";
class TransactionService
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createTransaction($id_post, $nik_penerima, $nik_donatur, $no_resi, $tipe_transaksi) : ?int
    {
        $query = "INSERT INTO transaksi(id_postingan, nik_penerima, nik_donatur, nomor_resi, waktu_transaksi, tipe_transaksi) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $this->db->prepare($query);
        $now = date("Y-m-d H:i:s");
        $statement->bind_param("iiisss", $id_post, $nik_penerima,$nik_donatur, $no_resi, $now, $tipe_transaksi);
        if($statement->execute()){
            return $statement->insert_id;
        }
        return null;
    }
}