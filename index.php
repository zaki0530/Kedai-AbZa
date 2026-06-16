<?php 
session_start(); 
include 'config/db.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kedai AbZa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container-fluid bg-success text-white text-center py-5 mb-4">
    <h1>Selamat Datang di Kedai AbZa</h1>
    <p>Silakan pilih menu favorit Anda!</p>
</div>

<div class="container">
    
    <?php if(isset($_SESSION['notifikasi'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>Yeay!</strong> <?php echo $_SESSION['notifikasi']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php 
        // Hapus pesan setelah ditampilkan agar tidak muncul terus saat di-refresh
        unset($_SESSION['notifikasi']); 
        ?>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Daftar Menu</h4>
        <a href="keranjang.php" class="btn btn-warning fw-bold text-dark">
            🛒 Lihat Keranjang 
            <?php 
            if(isset($_SESSION['keranjang'])) {
                $total_barang = array_sum($_SESSION['keranjang']);
                echo "($total_barang)";
            } else {
                echo "(0)";
            }
            ?>
        </a>
    </div>

    <div class="row">
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM menu");
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="assets/img/<?php echo $row['foto']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?php echo $row['nama_menu']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-success">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></h6>
                        <p class="card-text text-muted"><?php echo $row['deskripsi']; ?></p>
                        
                        <form action="beli.php?id=<?php echo $row['id']; ?>" method="POST" class="d-flex mt-2">
                            <input type="number" name="jumlah" class="form-control me-2 text-center" value="1" min="1" style="width: 80px;" required>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">+ Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <div class="text-center mt-5 mb-4">
        <a href="login.php" class="text-muted text-decoration-none" style="font-size: 14px;">Login sebagai Admin</a>
    </div>
</div>

</body>
</html>