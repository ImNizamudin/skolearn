<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$conn->query("DELETE FROM submissions WHERE assignment_id = $id");
$conn->query("DELETE FROM assignments WHERE id = $id");

header("Location: daftar_tugas-dosen.php");
exit();
?>
