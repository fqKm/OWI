<?php
require_once "../Model/Database.php";
class OrganisationService
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
}