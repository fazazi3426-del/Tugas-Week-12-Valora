<?php
// Memulai sesi untuk mengenali siapa yang sedang login
session_start();

// Menghancurkan/menghapus semua sesi yang sedang aktif
session_destroy();

// Mengarahkan pengguna kembali ke halaman login utama
header("Location: login.php");
?>