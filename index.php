<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include_once 'config/config.php';  // Menghubungkan file konfigurasi database
include_once 'config/database.php';  // Menghubungkan file konfigurasi database

$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database

// Fungsi untuk menghitung jumlah data di setiap tabel
function getCount($db, $tableName) {
    $query = "SELECT COUNT(*) as total FROM " . $tableName;
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Menghitung jumlah data di setiap tabel
$jmlBarang = getCount($db, 'barang');
$jmlKasir = getCount($db, 'kasir');
$jmlPenjualan = getCount($db, 'penjualan');
$jmlShift = getCount($db, 'shift');
$jmlDetail = getCount($db, 'detailpenjualan');

require_once 'tamplate/header.php';

?>

<!-- side bar -->

<?php require_once 'tamplate/sidebar.php'; ?>

<!-- end sidebar -->


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
       
    </div>

    <div class="alert alert-success" role="alert">
        <p>Selamat datang <u> <?= $_SESSION['username']; ?> </u>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"  style="float: right;"></button>
        </p>
      </div>

    <div class="row g-3 mb-3">
        
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card text-bg-primary h-85">
            <div class="card-header">Barang</div>
            <div class="card-body">
              <h5 class="card-title">Total <?= $jmlBarang ?></h5>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card text-bg-secondary h-85">
            <div class="card-header">Kasir</div>
            <div class="card-body">
              <h5 class="card-title">Total <?= $jmlKasir ?></h5>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card text-bg-primary h-85">
            <div class="card-header">Penjualan</div>
            <div class="card-body">
              <h5 class="card-title">Total <?= $jmlPenjualan ?></h5>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card text-bg-secondary h-85">
            <div class="card-header">Shift</div>
            <div class="card-body">
              <h5 class="card-title">Total <?= $jmlShift ?></h5>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
          <div class="card text-bg-primary h-85">
            <div class="card-header">Detail Penjualan</div>
            <div class="card-body">
              <h5 class="card-title">Total <?= $jmlDetail ?></h5>
            </div>
          </div>
        </div>

    </div>    

    </main>

    </div>
</div>    
  
<!-- footer -->
<?php

require_once 'tamplate/footer.php';

?>

<!-- end footer -->


