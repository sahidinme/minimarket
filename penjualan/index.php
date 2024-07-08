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

$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database

$query = "SELECT 
            penjualan.id_penjualan, 
            penjualan.waktu_transaksi, 
            penjualan.total, 
            kasir.nama_kasir 
        FROM 
            penjualan
        JOIN 
            shift ON penjualan.id_shift = shift.id_shift
        JOIN 
            kasir ON shift.id_kasir = kasir.id_kasir
        ORDER BY 
            penjualan.id_penjualan";

$result = $db->query($query);

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
        </ol>
    </nav>
    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Penjualan</h1>
    </div>

    <h2><a href="create.php" class="btn btn-success">Tambah</a></h2>
    <div class="table-responsive">
        <table id="siswaTable" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">ID Penjualan</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jam</th>
                    <th scope="col">Total</th>
                    <th scope="col">Kasir</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $timestamp = strtotime($row['waktu_transaksi']);  // Convert the datetime string to a timestamp
                    $formatted_time = date('H:i:s', $timestamp);  // Format the timestamp to 'HH:MM:SS'
                    ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['id_penjualan']; ?></td>
                        <td><?= date('Y-m-d', $timestamp); ?></td>
                        <td><?= $formatted_time; ?></td> <!-- Only time -->
                        <td><?= $row['total']; ?></td>
                        <td><?= $row['nama_kasir']; ?></td> 
                        <td class="action-buttons">
                            <a href="detail.php?id_penjualan=<?= $row['id_penjualan']; ?>" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7"><center>Tidak ada data barang.</center></td>
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
