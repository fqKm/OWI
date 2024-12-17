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
    public function getAddressById(int $id) : ?array{
        $query = "SELECT * FROM alamat WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        if(!empty($result)){
            return $result->fetch_assoc();
        }
        return null;
    }

    public function updateAddressById($id,$rt,$rw,$jalan,$dusun,$desa,$kecamatan,$kota,$kode_pos) : ? array
    {
        $query = "UPDATE alamat SET rt = ?, rw = ?, jalan = ?, dusun = ?, desa = ?, kecamatan = ?, kota = ? ,kode_pos= ? WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->bind_param("sssssssii", $rt, $rw, $jalan, $dusun, $desa, $kecamatan, $kota, $kode_pos, $id);
        $statement->execute();
        $result = $statement->get_result();
        if(!empty($result)){
            return $result->fetch_assoc();
        }
        return null;
    }
}