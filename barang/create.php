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

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Mengecek apakah form telah di-submit
    $nama_barang = $_POST['nama_barang'];  // Mendapatkan nama barang dari form
    $satuan = $_POST['satuan'];  // Mendapatkan satuan pelajaran dari form
    $harga_satuan = $_POST['harga_satuan'];  // Mendapatkan harga satuan dari form

    try {
        // Query untuk menambahkan barang baru ke database
        $query = "INSERT INTO barang (nama_barang, satuan, harga_satuan) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);  // Mempersiapkan query
        $stmt->bind_param("sss", $nama_barang, $satuan, $harga_satuan);  // Mengikat parameter

        if ($stmt->execute()) {  // Menjalankan query
            echo "<script>alert('Barang berhasil ditambahkan.');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan barang.');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            echo "<script>alert('Error: Kode Barang sudah ada.');</script>";
        } else {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

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
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Barang</h1>
    </div>

    <!-- Form untuk menambah barang baru -->
    <form method="post" action="create.php">
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang :</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan :</label>
            <input type="text" class="form-control" id="satuan" name="satuan" required>
        </div>

        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan :</label>
            <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" required>
        </div>
        <input type="submit" value="Tambah Barang" class="btn btn-success">
    </form>
</main>
</div>
</div>    

<!-- footer -->
<?php require_once '../tamplate/footer.php'; ?>
<!-- end footer -->

