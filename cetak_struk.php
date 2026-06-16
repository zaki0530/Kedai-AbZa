<?php
session_start();
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit;
}
include 'config/db.php'; 

$id_pesanan = $_GET['id'];

// Ambil data nota
$query_pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'");
$nota = mysqli_fetch_assoc($query_pesanan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan #<?php echo $nota['id_pesanan']; ?></title>
    <style>
        /* Desain khusus kertas Thermal Kasir */
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 300px; /* Lebar standar struk kasir */
            margin: 0 auto;
            padding: 20px 10px;
            color: #000;
            background-color: #fff;
            font-size: 14px;
        }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .garis { border-bottom: 1px dashed #000; margin: 10px 0; }
        .item-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .item-name { width: 50%; }
        .item-qty { width: 15%; text-align: center; }
        .item-subtotal { width: 35%; text-align: right; }
        
        /* Hilangkan margin jika sedang diprint */
        @media print {
            body { width: 100%; padding: 0; margin: 0; }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h3 style="margin: 0;">Kedai AbZa</h3>
        <p style="margin: 5px 0 0 0; font-size: 12px;">Jl. Raya Mahasiswa No. 123</p>
        <p style="margin: 0; font-size: 12px;">Telp: 0812-3456-7890</p>
    </div>

    <div class="garis"></div>

    <div style="font-size: 12px;">
        <div class="item-row">
            <span>No. Nota</span>
            <span>: #<?php echo $nota['id_pesanan']; ?></span>
        </div>
        <div class="item-row">
            <span>Tanggal</span>
            <span>: <?php echo date('d/m/Y H:i', strtotime($nota['tanggal'])); ?></span>
        </div>
        <div class="item-row">
            <span>Pelanggan</span>
            <span>: <?php echo $nota['nama_pelanggan']; ?></span>
        </div>
        <div class="item-row">
            <span>Meja</span>
            <span>: <?php echo $nota['nomor_meja']; ?></span>
        </div>
    </div>

    <div class="garis"></div>

    <div class="item-row fw-bold" style="font-size: 12px;">
        <div class="item-name">Menu</div>
        <div class="item-qty">Qty</div>
        <div class="item-subtotal">Subtotal</div>
    </div>
    
    <div class="garis"></div>

    <?php
    $query_detail = mysqli_query($koneksi, "
        SELECT detail_pesanan.*, menu.nama_menu 
        FROM detail_pesanan 
        JOIN menu ON detail_pesanan.id_menu = menu.id 
        WHERE detail_pesanan.id_pesanan='$id_pesanan'
    ");
    
    while($detail = mysqli_fetch_assoc($query_detail)) {
        $subtotal = $detail['harga_satuan'] * $detail['jumlah'];
    ?>
    <div class="item-row">
        <div class="item-name"><?php echo $detail['nama_menu']; ?></div>
        <div class="item-qty">x<?php echo $detail['jumlah']; ?></div>
        <div class="item-subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?></div>
    </div>
    <?php } ?>

    <div class="garis"></div>

    <div class="item-row fw-bold fs-5">
        <span>TOTAL</span>
        <span>Rp <?php echo number_format($nota['total_harga'], 0, ',', '.'); ?></span>
    </div>

    <div class="garis"></div>
    
    <?php if($nota['catatan'] != ''): ?>
    <div style="font-size: 12px; margin-bottom: 10px;">
        <strong>Catatan:</strong> <?php echo $nota['catatan']; ?>
    </div>
    <div class="garis"></div>
    <?php endif; ?>

    <div class="text-center" style="margin-top: 20px; font-size: 12px;">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>--- Layanan Kasir Digital ---</p>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>