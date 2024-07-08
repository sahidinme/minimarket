<?php

session_start();
if (!isset($_SESSION['username']) ) {
    header("Location: ../login.php");
    exit();
}

include_once '../config/config.php';  // Menghubungkan file konfigurasi database
include_once '../config/database.php';  // Menghubungkan file konfigurasi database

$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database

// Memproses penghapusan shift jika ID diberikan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id_shift"])) {
    $id_shift = $_GET["id_shift"];

    // Membuat query untuk menghapus shift dari database
    $sql = "DELETE FROM shift WHERE id_shift = $id_shift";

    try {
        if ($db->query($sql) === TRUE) {
            // shift berhasil dihapus, tampilkan pesan dan redirect ke halaman utama
            echo "<script>alert('Shift berhasil dihapus!');</script>";
            echo "<script>window.location.href = 'http://localhost/minimarket/bukashift/';</script>";
            exit();
        } else {
            // Gagal menghapus Shift, tampilkan pesan error
            throw new Exception("Gagal menghapus shift. Kesalahan: " . $db->error);
        }
    } catch (mysqli_sql_exception $e) {
        // Menangkap kesalahan MySQL dan menampilkan pesan kustom
        echo "<script>alert('Error: Tidak dapat menghapus shift karena terkait dengan data lainnya.');</script>";
        echo "<script>window.location.href = 'http://localhost/minimarket/bukashift/';</script>";
        exit();
    } catch (Exception $e) {
        // Menangkap kesalahan lainnya dan menampilkan pesan kustom
        echo "<script>alert('" . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = 'http://localhost/minimarket/bukashift/';</script>";
        exit();
    }
}
?>
