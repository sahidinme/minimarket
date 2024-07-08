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

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Mengecek apakah form telah di-submit
    $id_kasir = $_POST['id_kasir'];  // Mendapatkan nama kelas dari form  // Mendapatkan nama kelas dari form
    $saldo_awal = $_POST['saldo_awal'];  // Mendapatkan jumlah siswa dari form
    $waktu_buka = date('Y-m-d H:i:s');
    try {
        // Query untuk menambahkan kelas baru ke database
        $query = "INSERT INTO shift (id_kasir, saldo_awal, waktu_buka) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);  // Mempersiapkan query
        $stmt->bind_param("iss", $id_kasir, $saldo_awal, $waktu_buka);  // Mengikat parameter

        if ($stmt->execute()) {  // Menjalankan query
            echo "<script>alert('buka shift berhasil ditambahkan.');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan kelas.');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            echo "<script>alert('Error: Kode Kelas sudah ada.');</script>";
        } else {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

// header
require_once '../tamplate/header.php';
// end header

?>

<!-- side bar -->

<?php require_once '../tamplate/sidebar.php'; ?>

<!-- end sidebar -->


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
    
    <!-- breadcrumb -->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>bukashift">buka shift</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Buka Sift</h1>
    </div>

    <!-- Form untuk menambah kelas baru -->
    <form method="post" action="create.php">

        <div class="mb-3">
            <label for="nip" class="form-label">Id Kasir :</label>
            <select name="id_kasir" id="id_kasir"  class="form-control">
            <?php
            // Ambil data dari tabel guru
            $sqlkasir = "SELECT * FROM kasir ORDER BY id_kasir DESC";
            $resultkasir = $db->query($sqlkasir);
            if ($resultkasir->num_rows > 0) {
                // Output data dari setiap baris
                while ($kasir = $resultkasir->fetch_assoc()) {
            ?>        
                <option value="<?= $kasir["id_kasir"] ?>"><?= $kasir["id_kasir"] ?> - <?= $kasir["nama_kasir"] ?> </option>  
            <?php        
                }
            } else {
                echo "Tidak ada shift yang ditemukan.";
            }
            ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_kasir" class="form-label">Nama Kasir :</label>
            <select name="nama_kasir" id="nama_kasir"  class="form-control">
            <?php
            // Ambil data dari tabel guru
            $sqlkasir = "SELECT * FROM kasir ORDER BY id_kasir DESC";
            $resultkasir = $db->query($sqlkasir);
            if ($resultkasir->num_rows > 0) {
                // Output data dari setiap baris
                while ($kasir = $resultkasir->fetch_assoc()) {
            ?>        
                <option value="<?= $kasir["nama_kasir"] ?>"><?= $kasir["nama_kasir"] ?></option>  
            <?php        
                }
            } else {
                echo "Tidak ada kasir yang ditemukan.";
            }
            ?>
            </select>
        </div>

        
        <div class="mb-3">
            <label for="nama_kasir" class="form-label">Saldo Awal :</label>
            <input type="text" name="saldo_awal" id="saldo_awal"  class="form-control">
        </div>

        <input type="submit" value="Buka Sift Baru" class="btn btn-success">
    </form>
</main>
</div>
</div>    

<!-- footer -->
<?php require_once '../tamplate/footer.php'; ?>
<!-- end footer -->
