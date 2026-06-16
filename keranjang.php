<?php
session_start();
include 'config/db.php';

// Jika keranjang kosong
if(empty($_SESSION['keranjang'])) {
    $_SESSION['notifikasi'] = "Keranjang belanja Anda masih kosong! Silakan pilih menu dulu.";
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">🛒 Keranjang Belanja</h2>
    
    <?php if(isset($_SESSION['notifikasi'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <?php echo $_SESSION['notifikasi']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['notifikasi']); ?>
    <?php endif; ?>

    <div class="card shadow-sm p-4">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                $total_belanja = 0;
                
                foreach ($_SESSION['keranjang'] as $id_menu => $jumlah):
                    $query = mysqli_query($koneksi, "SELECT * FROM menu WHERE id='$id_menu'");
                    $data = mysqli_fetch_assoc($query);
                    
                    $subtotal = $data['harga'] * $jumlah;
                    $total_belanja += $subtotal;
                ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td class="text-start"><?php echo $data['nama_menu']; ?></td>
                    <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $jumlah; ?></td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td>
                        <a href="hapus_keranjang.php?id=<?php echo $id_menu; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin batal beli menu ini?')">Hapus</a>
                    </td>
                </tr>
                <?php 
                $nomor++;
                endforeach; 
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total Belanja:</th>
                    <th class="text-danger fs-5">Rp <?php echo number_format($total_belanja, 0, ',', '.'); ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        
        <div class="d-flex justify-content-between mt-3">
            <a href="index.php" class="btn btn-secondary">⬅ Lanjutkan Belanja</a>
            <a href="checkout.php" class="btn btn-success fw-bold">Checkout Sekarang ➡</a>
        </div>
    </div>
</div>

</body>
</html>