<?php
session_start();
// Kunci halaman agar hanya admin/kasir yang bisa akses
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit;
}

include 'config/db.php';

// Menangkap ID pesanan dari URL
$id_pesanan = $_GET['id'];

// Perintah SQL untuk mengubah status menjadi 'Selesai'
$update = mysqli_query($koneksi, "UPDATE pesanan SET status='Selesai' WHERE id_pesanan='$id_pesanan'");

if($update) {
    // Menggunakan sistem notifikasi halus yang sudah kita buat sebelumnya
    $_SESSION['notifikasi'] = "Pesanan #$id_pesanan berhasil diselesaikan!";
} else {
    $_SESSION['notifikasi'] = "Gagal mengubah status pesanan.";
}

// Kembalikan kasir ke halaman daftar pesanan
header('Location: pesanan.php');
exit;
?>