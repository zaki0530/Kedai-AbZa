<?php
session_start();
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit;
}

include 'config/db.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kedai AbZa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="text-center mb-4">Panel Admin Kedai AbZa</h1>
    
    <?php if(isset($_SESSION['notifikasi'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>Sukses!</strong> <?php echo $_SESSION['notifikasi']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['notifikasi']); // Hapus setelah ditampilkan ?>
    <?php endif; ?>

   <div class="text-center mb-4">
        <a href="tambah.php" class="btn btn-primary me-2">+ Tambah Menu Baru</a>
        <a href="pesanan.php" class="btn btn-info me-2 text-white fw-bold">📋 Pesanan Masuk</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
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
                        
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning w-100 fw-bold mb-2">Edit Menu</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin hapus menu ini?')">Hapus Menu</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>