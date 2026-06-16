<?php
session_start();

if(isset($_GET['id'])) {
    $id_menu = $_GET['id'];
    $jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;

    if (isset($_SESSION['keranjang'][$id_menu])) {
        $_SESSION['keranjang'][$id_menu] += $jumlah;
    } else {
        $_SESSION['keranjang'][$id_menu] = $jumlah;
    }

    // SIMPAN PESAN KE DALAM SESSION (Bukan Pop-up JS)
    $_SESSION['notifikasi'] = "Berhasil menambahkan $jumlah porsi ke keranjang!";
    
    // Arahkan kembali ke index.php secara diam-diam
    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}
?>