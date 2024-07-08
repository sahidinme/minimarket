<?php

// Memulai session
session_start();

// Membatasi akses
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include_once '../config/config.php';  // Menghubungkan file konfigurasi database
include_once '../config/database.php';  // Menghubungkan file konfigurasi database

$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database

$id_penjualan = $_GET['id_penjualan'];  // Mendapatkan ID penjualan dari URL
        
$query = "SELECT 
        *
    FROM 
        detailpenjualan
    JOIN 
        barang ON detailpenjualan.id_barang = barang.id_barang

    WHERE detailpenjualan.id_penjualan = ?";        

// Menggunakan prepared statement
$stmt = $db->prepare($query);
$stmt->bind_param('i', $id_penjualan);
$stmt->execute();
$result = $stmt->get_result();

require_once '../tamplate/header.php';

?>

<!-- side bar -->

<?php require_once '../tamplate/sidebar.php'; ?>

<!-- end sidebar -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
    
    <!-- breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
        <li class="breadcrumb-item active"><a href="<?php echo BASE_URL; ?>penjualan">Penjualan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Penjualan</h1>
    </div>

    <div class="table-responsive">
        <table id="siswaTable" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">ID Penjualan</th>
                    <th scope="col">ID Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Harga Satuan</th>
                    <th scope="col">Kuantitas</th>
                    <th scope="col">Sub Total</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['id_penjualan']; ?></td>
                        <td><?= $row['id_barang']; ?></td>
                        <td><?= $row['nama_barang']; ?></td>
                        <td><?= $row['satuan']; ?></td>
                        <td><?= $row['harga_satuan']; ?></td>
                        <td><?= $row['kuantitas']; ?></td>         
                        <td><?= $row['sub_total']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6"><center>Tidak ada data barang.</center></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <br><br>

    </div>
      
</main>
</div>
</div>    

<?php

require_once '../tamplate/footer.php';

?>
