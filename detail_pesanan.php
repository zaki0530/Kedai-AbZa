<?php
session_start();
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit;
}
include 'config/db.php'; 

$id_pesanan = $_GET['id'];

// Ambil data pelanggan (Nota utama)
$query_pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'");
$nota = mysqli_fetch_assoc($query_pesanan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 700px;">
    <div class="card shadow p-4">
        <h3 class="mb-3">Detail Nota #<?php echo $nota['id_pesanan']; ?></h3>
        
        <div class="row mb-4">
            <div class="col-sm-6">
                <strong>Pelanggan:</strong> <?php echo $nota['nama_pelanggan']; ?><br>
                <strong>Meja:</strong> <?php echo $nota['nomor_meja']; ?>
            </div>
            <div class="col-sm-6 text-sm-end">
                <strong>Waktu:</strong> <?php echo date('d-m-Y H:i', strtotime($nota['tanggal'])); ?><br>
                <strong>Catatan:</strong> <?php echo $nota['catatan'] ? $nota['catatan'] : '-'; ?>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="table-success">
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil rincian pesanan dengan menggabungkan (JOIN) tabel detail dan menu
                $query_detail = mysqli_query($koneksi, "
                    SELECT detail_pesanan.*, menu.nama_menu 
                    FROM detail_pesanan 
                    JOIN menu ON detail_pesanan.id_menu = menu.id 
                    WHERE detail_pesanan.id_pesanan='$id_pesanan'
                ");
                
                while($detail = mysqli_fetch_assoc($query_detail)) {
                    $subtotal = $detail['harga_satuan'] * $detail['jumlah'];
                ?>
                <tr>
                    <td><?php echo $detail['nama_menu']; ?></td>
                    <td>Rp <?php echo number_format($detail['harga_satuan'], 0, ',', '.'); ?></td>
                    <td><?php echo $detail['jumlah']; ?></td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total Bayar:</th>
                    <th class="text-danger fs-5">Rp <?php echo number_format($nota['total_harga'], 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>
        
       <div class="mt-4 d-flex justify-content-between">
            <a href="pesanan.php" class="btn btn-secondary">⬅ Kembali ke Daftar Pesanan</a>
            <a href="cetak_struk.php?id=<?php echo $nota['id_pesanan']; ?>" target="_blank" class="btn btn-dark fw-bold">🖨️ Cetak Struk</a>
        </div>
    </div>
</div>
</body>
</html>