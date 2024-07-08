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

// Memproses penghapusan delete jika ID diberikan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_barang"])) {
    $id_barang = $_GET["id_barang"];

    // Membuat query untuk menghapus barang dari database
    $sql = "DELETE FROM barang WHERE id_barang = $id_barang";

    try {
        if ($db->query($sql) === TRUE) {
            // Barang berhasil dihapus, tampilkan pesan dan redirect ke halaman utama
            echo "<script>alert('Barang berhasil dihapus!');</script>";
            echo "<script>window.location.href = 'http://localhost/minimarket/barang/';</script>";
            exit();
        } else {
            // Gagal menghapus artikel, tampilkan pesan error
            throw new Exception("Gagal menghapus barang. Kesalahan: " . $db->error);
        }
    } catch (mysqli_sql_exception $e) {
        // Menangkap kesalahan MySQL dan menampilkan pesan kustom
        echo "<script>alert('Error: Tidak dapat menghapus pelajaran karena terkait dengan data barang.');</script>";
        echo "<script>window.location.href = 'http://localhost/minimarket/barang/';</script>";
        exit();
    } catch (Exception $e) {
        // Menangkap kesalahan lainnya dan menampilkan pesan kustom
        echo "<script>alert('" . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = 'http://localhost/minimarket/barang/';</script>";
        exit();
    }
}
?>
