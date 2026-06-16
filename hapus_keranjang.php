<?php
session_start();

// Ambil ID menu dari URL
$id_menu = $_GET['id'];

// Hapus menu tersebut dari session keranjang
unset($_SESSION['keranjang'][$id_menu]);

// Gunakan session notifikasi, BUKAN echo script alert
$_SESSION['notifikasi'] = "Menu batal dibeli dan dihapus dari keranjang.";
header('Location: keranjang.php');
exit;
?>