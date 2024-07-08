<?php

// memulai session
session_start();

// membatasi akses
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include_once '../config/config.php';  // Menghubungkan file konfigurasi database
include_once '../config/database.php';  // Menghubungkan file konfigurasi database

require_once '../tamplate/header.php';
?>

<!-- side bar -->
<?php require_once '../tamplate/sidebar.php'; ?>
<!-- end sidebar -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>barang">Barang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Update barang</h1>
    </div>

<?php
$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Mengecek apakah form telah di-submit
    $id_barang = $_POST['id_barang'];  // Mendapatkan ID barang dari form
    $nama_barang = $_POST['nama_barang'];  // Mendapatkan nama barang dari form
    $satuan = $_POST['satuan'];  // Mendapatkan satuan dari form
    $harga_satuan = $_POST['harga_satuan'];  // Mendapatkan harga satuan dari form

    // Query untuk mengupdate data barang
    $query = "UPDATE barang SET nama_barang=?, satuan=?, harga_satuan=? WHERE id_barang=?";
    $stmt = $db->prepare($query);  // Mempersiapkan query
    $stmt->bind_param("ssii", $nama_barang, $satuan, $harga_satuan, $id_barang);  // Mengikat parameter

    if ($stmt->execute()) {  // Menjalankan query
        echo "<script>alert('Barang berhasil diupdate.');</script>";
        echo "<script>window.location.href = 'http://localhost/minimarket/barang/';</script>";
    } else {
        echo "Gagal mengupdate barang.";
    }
} else {
    $id_barang = $_GET['id_barang'];  // Mendapatkan ID barang dari URL
    // Query untuk mendapatkan data barang berdasarkan ID
    $query = "SELECT * FROM barang WHERE id_barang=?";
    $stmt = $db->prepare($query);  // Mempersiapkan query
    $stmt->bind_param("i", $id_barang);  // Mengikat parameter
    $stmt->execute();  // Menjalankan query
    $result = $stmt->get_result();  // Mendapatkan hasil query
    $row = $result->fetch_assoc();  // Mengambil data barang
?>
<!-- Form untuk mengupdate data barang -->
<form method="post" action="">
    <input type="hidden" class="form-control" id="id_barang" name="id_barang" value="<?php echo $row['id_barang']; ?>">

    <div class="mb-3">
        <label for="id_barang" class="form-label">ID Barang :</label>
        <input type="text" class="form-control" id="id_barang" name="id_barang" value="<?php echo $row['id_barang']; ?>" disabled>
    </div>

    <div class="mb-3">
        <label for="nama_barang" class="form-label">Nama Barang :</label>
        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="satuan" class="form-label">Satuan :</label>
        <input type="text" class="form-control" id="satuan" name="satuan" value="<?php echo $row['satuan']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="harga_satuan" class="form-label">Harga Satuan :</label>
        <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" value="<?php echo $row['harga_satuan']; ?>" required>
    </div>

    <input type="submit" value="Update Barang" class="btn btn-success">
</form>

<br>
<br>
<?php
}
?>

</main>
</div>
</div>    

<?php
require_once '../tamplate/footer.php';
?>
