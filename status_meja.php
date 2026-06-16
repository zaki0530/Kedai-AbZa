<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status & Denah Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-2">🪑 Status Ketersediaan Meja</h2>
    <p class="text-center text-muted mb-5">Informasi meja yang kosong dan sedang digunakan pelanggan</p>

    <div class="mb-4 text-center">
        <a href="index.php" class="btn btn-secondary me-2">⬅ Kembali ke Menu Utama</a>
        <?php if(isset($_SESSION['status_login'])): ?>
            <a href="pesanan.php" class="btn btn-info text-white fw-bold">📋 Ke Halaman Kasir</a>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-center gap-4 mb-4">
        <div><span class="badge bg-success p-2">&nbsp;&nbsp;</span> Tersedia / Kosong</div>
        <div><span class="badge bg-danger p-2">&nbsp;&nbsp;</span> Terisi / Dipesan</div>
    </div>

    <div class="row">
        <?php
        // Kita tentukan daftar meja yang ada di warung kita (Misal Meja 01 sampai Meja 09)
        $daftar_meja = ['Meja 01', 'Meja 02', 'Meja 03', 'Meja 04', 'Meja 05', 'Meja 06', 'Meja 07', 'Meja 08', 'Meja 09'];

        foreach ($daftar_meja as $meja) {
            // Cek ke database apakah meja ini sedang dipakai oleh pesanan yang berstatus 'Pending'
            $query = mysqli_query($koneksi, "SELECT nama_pelanggan FROM pesanan WHERE nomor_meja = '$meja' AND status = 'Pending' LIMIT 1");
            $cek = mysqli_fetch_assoc($query);

            if ($cek) {
                // Jika data ditemukan, berarti meja TERISI
                $warna_card = 'bg-danger text-white';
                $status_teks = 'TERISI';
                $pelanggan = $cek['nama_pelanggan'];
            } else {
                // Jika tidak ditemukan pesanan aktif, berarti meja KOSONG
                $warna_card = 'bg-success text-white';
                $status_teks = 'KOSONG';
                $pelanggan = '-';
            }
        ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm <?php echo $warna_card; ?> text-center p-3">
                    <div class="card-body">
                        <h3 class="card-title fw-bold"><?php echo $meja; ?></h3>
                        <h5 class="fw-bold my-2">[ <?php echo $status_teks; ?> ]</h5>
                        <p class="card-text mb-0" style="font-size: 14px;">
                            <?php if($status_teks == 'TERISI'): ?>
                                Atas Nama: <strong><?php echo $pelanggan; ?></strong>
                            <?php else: ?>
                                Siap Digunakan
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>