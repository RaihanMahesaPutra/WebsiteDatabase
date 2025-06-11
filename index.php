<?php
// Mulai session jika belum dimulai
session_start();

// Jika sudah login, arahkan ke folder sesuai level
if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    switch ($_SESSION['level']) {
        case 'admin':
            header("Location: admin/index.php");
            exit();
        case 'guru':
            header("Location: guru/index.php");
            exit();
        case 'siswa':
            header("Location: siswa/index.php");
            exit();
        default:
            header("Location: unauthorized.php");
            exit();
    }
}

// Jika belum login, arahkan ke login.php
header("Location: login.php");
exit();
