<?php

// memulai session
session_start();

// membatasi akses
if (!isset($_SESSION['username']) ) {
    header("Location: ../login.php");
    exit();
}

include_once '../config/config.php';  // Menghubungkan file konfigurasi database
include_once '../config/database.php';  // Menghubungkan file konfigurasi database

$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database


// Memproses penghapusan Kasir jika ID diberikan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_kasir"])) {
    $id_kasir = $_GET["id_kasir"];

    // Membuat query untuk menghapus kasir dari database
    $sql = "DELETE FROM kasir WHERE id_kasir = $id_kasir";

    if ($db->query($sql) === TRUE) {
        // Kasir berhasil dihapus, tampilkan pesan dan redirect ke halaman utama
        echo "<script>alert('Kasir berhasil dihapus!');</script>";
        echo "<script>window.location.href = 'http://localhost/minimarket/kasir/';</script>";
        exit();
    } else {
        // Gagal menghapus kasir, tampilkan pesan error
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}


?>
