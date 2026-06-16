<?php
session_start();
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit;
}

include 'config/db.php'; 

// PROSES SIMPAN DATA
if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $desk = $_POST['desk'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if(move_uploaded_file($tmp, 'assets/img/'.$foto)){
        mysqli_query($koneksi, "INSERT INTO menu (nama_menu, harga, deskripsi, foto) VALUES ('$nama', '$harga', '$desk', '$foto')");
        
        // Simpan pesan sukses dan arahkan ke admin.php
        $_SESSION['notifikasi'] = "Menu baru berhasil ditambahkan!";
        header("Location: admin.php");
        exit;
    } else {
        $error_upload = "Gagal mengunggah foto.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    
    <?php if(isset($error_upload)): ?>
        <div class="alert alert-danger"><?php echo $error_upload; ?></div>
    <?php endif; ?>

    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Tambah Menu Baru</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3"><input type="text" name="nama" class="form-control" placeholder="Nama Menu" required></div>
            <div class="mb-3"><input type="number" name="harga" class="form-control" placeholder="Harga" required></div>
            <div class="mb-3"><textarea name="desk" class="form-control" placeholder="Deskripsi"></textarea></div>
            <div class="mb-3"><input type="file" name="foto" class="form-control" required></div>
            
            <button type="submit" name="simpan" class="btn btn-primary w-100 fw-bold mb-2">Simpan Menu</button>
            <a href="admin.php" class="btn btn-secondary w-100">Batal / Kembali</a>
        </form>
    </div>
</div>
</body>
</html>