<?php
require 'kon.php';
require 'functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: home.php');
    exit;
}

$id = inputMasuk($_GET['id']);
$result = mysqli_query($conn, "SELECT id FROM tk WHERE id = $id");

if (mysqli_num_rows($result) == 0) {
    header('Location: home.php');
    exit;
}

$delete_sql = "DELETE FROM tk WHERE id = $id";
session_start();
if ($mysqli_query($conn, $delete_sql)) {
    $_SESSION['flash_message'] = "Data mahasiswa berhasil dihapus!";
    $_SESSION['flash_type'] = "success";
} else {
    $_SESSION['flash_message'] = "Gagal menghapus data mahasiswa. Silakan coba lagi.";
    $_SESSION['flash_type'] = "error";
}


header('Location: home.php');
exit;