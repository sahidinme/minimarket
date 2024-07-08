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
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>kasir">Kasir</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Update Kasir</h1>
    </div>

<?php

$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Mengecek apakah form telah di-submit
    $id_kasir = $_POST['id_kasir'];  // Mendapatkan ID kasir dari form
    $nama_kasir = $_POST['nama_kasir'];  // Mendapatkan nama kasir dari form
    $alamat = $_POST['alamat'];  // Mendapatkan alamat dari form
    $no_tlp = $_POST['no_tlp'];  // Mendapatkan no telp dari form
    $no_ktp = $_POST['no_ktp'];  // Mendapatkan no ktp dari form
    $username = $_POST['username'];  // Mendapatkan username dari form
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;  // Mendapatkan dan meng-hash password jika diisi

    // Query untuk mengupdate data pengguna
    if ($password) {
        $query = "UPDATE kasir SET nama_kasir=?, alamat=?, no_tlp=?, no_ktp=?, username=?, password=? WHERE id_kasir=?";
        $stmt = $db->prepare($query);  // Mempersiapkan query
        $stmt->bind_param("ssssssi", $nama_kasir, $alamat, $no_tlp, $no_ktp, $username, $password, $id_kasir);  // Mengikat parameter
    } else {
        $query = "UPDATE kasir SET nama_kasir=?, alamat=?, no_tlp=?, no_ktp=?, username=? WHERE id_kasir=?";
        $stmt = $db->prepare($query);  // Mempersiapkan query
        $stmt->bind_param("sssssi", $nama_kasir, $alamat, $no_tlp, $no_ktp, $username, $id_kasir);  // Mengikat parameter
    }

    if ($stmt->execute()) {  // Menjalankan query
        echo "<script>alert('Kasir berhasil diupdate.');</script>";
        echo "<script>window.location.href = 'http://localhost/minimarket/kasir/';</script>";
    } else {
        echo "Gagal mengupdate pengguna.";
    }
} else {
    $id_kasir = $_GET['id_kasir'];  // Mendapatkan ID pengguna dari URL
    // Query untuk mendapatkan data kasir berdasarkan ID
    $query = "SELECT * FROM kasir WHERE id_kasir=?";
    $stmt = $db->prepare($query);  // Mempersiapkan query
    $stmt->bind_param("i", $id_kasir);  // Mengikat parameter
    $stmt->execute();  // Menjalankan query
    $result = $stmt->get_result();  // Mendapatkan hasil query
    $row = $result->fetch_assoc();  // Mengambil data pengguna
?>

<!-- Form untuk mengupdate data kasir -->
<form method="post" action="">

    <input type="hidden" class="form-control" id="id_kasir" name="id_kasir" value="<?php echo $row['id_kasir']; ?>">
    <input type="hidden" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>">
    
    <div class="mb-3">
        <label for="nama_kasir" class="form-label">Nama Kasir :</label>
        <input type="text" class="form-control" id="nama_kasir" name="nama_kasir" value="<?php echo $row['nama_kasir']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat :</label>
        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="no_tlp" class="form-label">No Telp :</label>
        <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="<?php echo $row['no_tlp']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="no_ktp" class="form-label">No KTP :</label>
        <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?php echo $row['no_ktp']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username :</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" disabled>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password :</label>
        <input type="password" class="form-control" id="password" name="password" value="">
        <small id="password" class="form-text text-muted">Kosongkan jika tidak ingin merubah</small>
    </div>

    <input type="submit" value="Update Kasir" class="btn btn-success">
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
