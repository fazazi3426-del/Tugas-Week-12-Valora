<?php
// Menghubungkan ke file konfigurasi database
include 'config.php';

// Menangkap ID dari URL yang dikirim oleh tombol Hapus di halaman index
$id = $_GET['id'];

// Mengeksekusi perintah hapus data di database VALORA
mysqli_query($conn, "DELETE FROM layanan WHERE id='$id'");

// Setelah berhasil dihapus, langsung tendang balik ke halaman dashboard
header("Location: index.php");
?>