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
    <title>Daftar Pesanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📋 Daftar Pesanan Masuk</h2>
    
    <?php if(isset($_SESSION['notifikasi'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>Info:</strong> <?php echo $_SESSION['notifikasi']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['notifikasi']); ?>
    <?php endif; ?>

    <div class="mb-3">
        <a href="admin.php" class="btn btn-secondary">⬅ Kembali ke Kelola Menu</a>
    </div>

    <div class="card shadow-sm p-4">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No. Nota</th>
                    <th>Waktu</th>
                    <th>Nama Pelanggan</th>
                    <th>Meja</th>
                    <th>Catatan</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY id_pesanan DESC");
                while($row = mysqli_fetch_assoc($query)) {
                    
                    // Membuat warna badge dinamis tergantung status
                    if($row['status'] == 'Pending') {
                        $badge_color = 'bg-warning text-dark';
                    } else {
                        $badge_color = 'bg-success text-white';
                    }
                ?>
                <tr>
                    <td class="fw-bold">#<?php echo $row['id_pesanan']; ?></td>
                    <td><?php echo date('d-m-Y H:i', strtotime($row['tanggal'])); ?></td>
                    <td><?php echo $row['nama_pelanggan']; ?></td>
                    <td><?php echo $row['nomor_meja']; ?></td>
                    <td><small class="text-muted"><?php echo $row['catatan']; ?></small></td>
                    <td class="text-danger fw-bold">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                    <td><span class="badge <?php echo $badge_color; ?>"><?php echo $row['status']; ?></span></td>
                    <td>
                        <a href="detail_pesanan.php?id=<?php echo $row['id_pesanan']; ?>" class="btn btn-primary btn-sm mb-1">Lihat Detail</a>
                        
                        <?php if($row['status'] == 'Pending'): ?>
                            <a href="update_status.php?id=<?php echo $row['id_pesanan']; ?>" class="btn btn-success btn-sm mb-1" onclick="return confirm('Tandai pesanan ini sudah selesai dan disajikan?')">✔ Selesai</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>