<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'owi_database';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("owi_database". $conn->connect_error);
}
?>