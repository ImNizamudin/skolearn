<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tugas_mahasiswa";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
