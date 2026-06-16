<?php
session_start();
include 'config/db.php'; // Hubungkan ke database

// Jika sudah login, langsung arahkan ke admin.php
if(isset($_SESSION['status_login'])){
    header("Location: admin.php");
    exit;
}

// Jika tombol masuk ditekan
if(isset($_POST['masuk'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Cek ke database, apakah ada username dan password yang cocok
    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");
    
    // mysqli_num_rows menghitung jumlah baris yang ditemukan. Jika > 0, berarti datanya ada.
    if(mysqli_num_rows($cek) > 0){
        $_SESSION['status_login'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-secondary d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="text-center mb-4">Login Admin</h3>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger p-2 text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" name="masuk" class="btn btn-primary w-100 fw-bold">Masuk</button>
        <a href="index.php" class="btn btn-light w-100 mt-2">Kembali ke Web</a>
    </form>
</div>

</body>
</html>