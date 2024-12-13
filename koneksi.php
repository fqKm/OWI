<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'OWI';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi bodo". $conn->connect_error);
}
?>