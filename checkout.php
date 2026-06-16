<?php
session_start();
include 'config/db.php';

// Jika keranjang kosong
if(empty($_SESSION['keranjang'])) {
    $_SESSION['notifikasi'] = "Keranjang belanja kosong, silakan pilih menu dulu!";
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 600px;">
    
    <?php if(isset($error_msg)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error_msg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow p-4 mb-5">
        <h2 class="text-center mb-4">📋 Form Checkout Pesanan</h2>
        
        <h5 class="mb-3">Ringkasan Pesanan:</h5>
        <ul class="list-group mb-4">
            <?php
            $total_belanja = 0;
            foreach ($_SESSION['keranjang'] as $id_menu => $jumlah) {
                $query = mysqli_query($koneksi, "SELECT * FROM menu WHERE id='$id_menu'");
                $data = mysqli_fetch_assoc($query);
                
                $subtotal = $data['harga'] * $jumlah;
                $total_belanja += $subtotal;
                
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                echo "<div><strong>" . $data['nama_menu'] . "</strong> <small class='text-muted'>x$jumlah</small></div>";
                echo "<span>Rp " . number_format($subtotal, 0, ',', '.') . "</span>";
                echo "</li>";
            }
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center table-success fw-bold">
                Total Pembayaran:
                <span class="text-danger fs-5">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></span>
            </li>
        </ul>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Pelanggan</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor Meja</label>
                <input type="text" name="meja" class="form-control" placeholder="Contoh: Meja 04 / Take Away" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Catatan Khusus (Opsional)</label>
                <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Nasi gorengnya pedas, es teh jangan pakai es..."></textarea>
            </div>
            
            <button type="submit" name="proses_checkout" class="btn btn-success w-100 fw-bold fs-5 mb-2">Konfirmasi & Kirim Pesanan</button>
            <a href="keranjang.php" class="btn btn-secondary w-100">Kembali ke Keranjang</a>
        </form>
    </div>
</div>

<?php
if(isset($_POST['proses_checkout'])) {
    $nama_pelanggan = $_POST['nama'];
    $nomor_meja = $_POST['meja'];
    $catatan = $_POST['catatan']; 
    
    $insert_pesanan = mysqli_query($koneksi, "INSERT INTO pesanan (nama_pelanggan, nomor_meja, catatan, total_harga, status) VALUES ('$nama_pelanggan', '$nomor_meja', '$catatan', '$total_belanja', 'Pending')");
    
    if($insert_pesanan) {
        $id_pesanan_baru = mysqli_insert_id($koneksi);
        
        foreach ($_SESSION['keranjang'] as $id_menu => $jumlah) {
            $query_harga = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id='$id_menu'");
            $data_harga = mysqli_fetch_assoc($query_harga);
            $harga_satuan = $data_harga['harga'];
            
            mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, harga_satuan) VALUES ('$id_pesanan_baru', '$id_menu', '$jumlah', '$harga_satuan')");
        }
        
        unset($_SESSION['keranjang']);
        
        // PENGALIHAN MULUS TANPA POP-UP
        $_SESSION['notifikasi'] = "Pesanan atas nama <strong>$nama_pelanggan</strong> berhasil dikirim! Silakan tunggu hidangan Anda.";
        header('Location: index.php');
        exit;
    } else {
        $error_msg = "Terjadi kesalahan sistem, gagal memproses transaksi.";
    }
}
?>

</body>
</html>