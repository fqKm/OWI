<?php
require_once "../Model/Database.php";
class AddressService
{
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    public function createAddress($rt, $rw, $jalan, $dusun, $desa, $kecamatan, $kota) : ?int
    {
        $query = "INSERT INTO alamat (rt, rw, jalan, dusun, desa, kecamatan, kota) VALUES (?,?,?,?,?,?,?)";
        $statement = $this->db->prepare($query);
        $statement->bind_param("iisssss", $rt, $rw, $jalan, $dusun, $desa, $kecamatan, $kota);
        $statement->execute();
        if($statement->affected_rows === 1){
            return $this->db->insert_id;
        }
        return null;
    }

}