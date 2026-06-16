<?php
session_start();
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit;
}

include 'config/db.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM menu WHERE id='$id'");

// Gunakan session notifikasi, BUKAN echo script alert
$_SESSION['notifikasi'] = "Menu berhasil dihapus dari daftar!";
header('Location: admin.php');
exit;
?>