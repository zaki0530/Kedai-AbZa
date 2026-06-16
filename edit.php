<?php
session_start();
if(!isset($_SESSION['status_login'])){
    header("Location: login.php");
    exit;
}

include 'config/db.php';

// Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM menu WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// PROSES UPDATE DATA
if(isset($_POST['update'])){
    $nama  = $_POST['nama'];
    $harga = $_POST['harga'];
    $desk  = $_POST['desk'];
    $foto_baru = $_FILES['foto']['name'];
    $tmp       = $_FILES['foto']['tmp_name'];

    if($foto_baru != "") {
        move_uploaded_file($tmp, 'assets/img/'.$foto_baru);
        mysqli_query($koneksi, "UPDATE menu SET nama_menu='$nama', harga='$harga', deskripsi='$desk', foto='$foto_baru' WHERE id='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE menu SET nama_menu='$nama', harga='$harga', deskripsi='$desk' WHERE id='$id'");
    }

    // Simpan pesan sukses dan arahkan ke admin.php
    $_SESSION['notifikasi'] = "Data menu berhasil diperbarui!";
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Edit Menu</h2>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $data['nama_menu']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" value="<?php echo $data['harga']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="desk" class="form-control"><?php echo $data['deskripsi']; ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Foto Saat Ini:</label><br>
                <img src="assets/img/<?php echo $data['foto']; ?>" width="100" class="mb-2 rounded shadow-sm">
                <input type="file" name="foto" class="form-control">
                <small class="text-muted">*Abaikan jika tidak ingin mengganti foto</small>
            </div>
            
            <button type="submit" name="update" class="btn btn-warning w-100 fw-bold mb-2">Update Menu</button>
            <a href="admin.php" class="btn btn-secondary w-100">Batal / Kembali</a>
        </form>
    </div>
</div>
</body>
</html>