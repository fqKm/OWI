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

    public function getDonateTransaction(int $nik): ?array
    {
        $query = "SELECT 
        transaksi.id_transaksi,
        transaksi.id_postingan,
        transaksi.waktu_transaksi,
        transaksi.nomor_resi,
        user.nama_depan AS nama_penerima
        FROM transaksi
        JOIN user ON transaksi.nik_penerima = user.nik
        where nik_donatur = ?";

        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $nik);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function getRequestTransaction(int $nik): ?array
    {
        $query = "SELECT 
        transaksi.id_transaksi,
        transaksi.id_postingan,
        transaksi.waktu_transaksi,
        transaksi.nomor_resi,
        user.nama_depan AS nama_donatur
        FROM transaksi
        JOIN user ON transaksi.nik_donatur = user.nik
        where nik_penerima = ?";

        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $nik);
        $statement->execute();
        $result = $statement->get_result();
        if (!empty($result)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
}