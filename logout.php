<?php
session_start();
session_destroy(); // Menghapus memori login
header("Location: login.php");
?>