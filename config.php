<?php
$host = "localhost";
$user = "root"; 
$pass = ""; 
$db   = "valora_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database VALORA gagal: " . mysqli_connect_error());
}
?>