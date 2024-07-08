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
    $nama_kasir = $_POST['nama_kasir'];  // Mendapatkan nama_user dari form
    $alamat = $_POST['alamat'];  // Mendapatkan alamat dari form
    $no_tlp = $_POST['no_tlp'];  // Mendapatkan notlp dari form
    $no_ktp = $_POST['no_ktp'];  // Mendapatkan noktp dari form
    $username = $_POST['username'];  // Mendapatkan username dari form
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Mendapatkan password dari form dan meng-hash-nya
   
    // Query untuk menambahkan pengguna baru ke database
    $query = "INSERT INTO kasir (nama_kasir, alamat, no_tlp, no_ktp, username, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);  // Mempersiapkan query
    $stmt->bind_param("ssiiss", $nama_kasir, $alamat, $no_tlp, $no_ktp, $username, $password);  // Mengikat parameter

    if ($stmt->execute()) {  // Menjalankan query
        echo "<script>alert('Kasir berhasil ditambahkan.');</script>";
    } else {
        echo "Gagal menambahkan kasir.";
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
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>kasir">Kasir</a></li>
        <li li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Kasir</h1>
    </div>


    <!-- Form untuk menambah pelajaran baru -->
    <form method="post" action="create.php">

        <div class="mb-3">
            <label for="nama_kasir" class="form-label">Nama Kasir :</label>
            <input type="text" class="form-control" id="nama_kasir" name="nama_kasir" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">alamat :</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>

        <div class="mb-3">
            <label for="no_tlp" class="form-label">no_tlp :</label>
            <input type="text" class="form-control" id="no_tlp" name="no_tlp" required>
        </div>

        <div class="mb-3">
            <label for="no_ktp" class="form-label">no_ktp :</label>
            <input type="text" class="form-control" id="no_ktp" name="no_ktp" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username :</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password :</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        
        <input type="submit" value="Tambah Kasir" class="btn btn-success">
    </form>

    <br><br>

    </main>
  </div>
</div>    

<!-- footer -->
<?php require_once '../tamplate/footer.php'; ?>
<!-- end footer -->
