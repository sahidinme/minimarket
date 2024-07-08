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

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Mengecek apakah form telah di-submit
    $id_barang = $_POST['id_barang'];  // Mendapatkan id_barang dari form
    $satuan = $_POST['satuan'];  // Mendapatkan satuan dari form
    $kuantitas = $_POST['kuantitas'];  // Mendapatkan kuantitas dari form
    $harga_satuan = $_POST['harga_satuan'];  // Mendapatkan harga_satuan dari form
    $sub_total = $harga_satuan * $kuantitas;  // Menghitung sub_total
    $total = $sub_total;  // Total penjualan (dapat disesuaikan jika ada lebih dari satu barang)

    try {
        // Query untuk menambahkan penjualan baru ke database
        $query_penjualan = "INSERT INTO penjualan (waktu_transaksi, total, id_shift) VALUES (NOW(), ?, ?)";
        $stmt_penjualan = $db->prepare($query_penjualan);  // Mempersiapkan query
        $id_shift = 1; // Assuming id_shift is 1 for now, you can change it accordingly
        $stmt_penjualan->bind_param("ii", $total, $id_shift);  // Mengikat parameter

        if ($stmt_penjualan->execute()) {  // Menjalankan query
            $id_penjualan = $db->insert_id;  // Mendapatkan id_penjualan yang baru saja ditambahkan

            // Query untuk menambahkan detail penjualan baru ke database
            $query_detail = "INSERT INTO detailpenjualan (id_penjualan, id_barang, kuantitas, harga_satuan, sub_total) VALUES (?, ?, ?, ?, ?)";
            $stmt_detail = $db->prepare($query_detail);  // Mempersiapkan query
            $stmt_detail->bind_param("iiiii", $id_penjualan, $id_barang, $kuantitas, $harga_satuan, $sub_total);  // Mengikat parameter

            if ($stmt_detail->execute()) {  // Menjalankan query
                echo "<script>alert('Penjualan berhasil ditambahkan.');</script>";
            } else {
                echo "<script>alert('Gagal menambahkan detail penjualan.');</script>";
            }
        } else {
            echo "<script>alert('Gagal menambahkan penjualan.');</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
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
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>penjualan">penjualan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Penjualan</h1>
    </div>

    <!-- Form untuk menambah penjualan baru -->
    <form method="post" action="create.php">

        <div class="mb-3">
            <label for="id_barang" class="form-label">ID Barang :</label>
            <select name="id_barang" id="id_barang" class="form-control">
            <?php
            // Ambil data dari tabel barang
            $sqlbarang = "SELECT * FROM barang ORDER BY id_barang DESC";
            $resultbarang = $db->query($sqlbarang);
            if ($resultbarang->num_rows > 0) {
                // Output data dari setiap baris
                while ($barang = $resultbarang->fetch_assoc()) {
            ?>        
                <option value="<?= $barang["id_barang"] ?>"><?= $barang["id_barang"] ?> - <?= $barang["nama_barang"] ?></option>  
            <?php        
                }
            } else {
                echo "Tidak ada barang yang ditemukan.";
            }
            ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang :</label>
            <select name="nama_barang" id="nama_barang" class="form-control">
            <?php
            // Ambil data dari tabel barang
            $sqlbarang = "SELECT * FROM barang ORDER BY id_barang DESC";
            $resultbarang = $db->query($sqlbarang);
            if ($resultbarang->num_rows > 0) {
                // Output data dari setiap baris
                while ($barang = $resultbarang->fetch_assoc()) {
            ?>        
                <option value="<?= $barang["nama_barang"] ?>"><?= $barang["nama_barang"] ?></option>  
            <?php        
                }
            } else {
                echo "Tidak ada barang yang ditemukan.";
            }
            ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan Barang :</label>
            <select name="satuan" id="satuan" class="form-control">
            <?php
            // Ambil data dari tabel barang
            $sqlbarang = "SELECT * FROM barang ORDER BY id_barang DESC";
            $resultbarang = $db->query($sqlbarang);
            if ($resultbarang->num_rows > 0) {
                // Output data dari setiap baris
                while ($barang = $resultbarang->fetch_assoc()) {
            ?>        
                <option value="<?= $barang["satuan"] ?>"><?= $barang["satuan"] ?> - <?= $barang["nama_barang"] ?></option>  
            <?php        
                }
            } else {
                echo "Tidak ada barang yang ditemukan.";
            }
            ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan :</label>
            <select name="harga_satuan" id="harga_satuan" class="form-control">
            <?php
            // Ambil data dari tabel barang
            $sqlbarang = "SELECT * FROM barang ORDER BY id_barang DESC";
            $resultbarang = $db->query($sqlbarang);
            if ($resultbarang->num_rows > 0) {
                // Output data dari setiap baris
                while ($barang = $resultbarang->fetch_assoc()) {
            ?>        
                <option value="<?= $barang["harga_satuan"] ?>"><?= $barang["harga_satuan"] ?> - <?= $barang["nama_barang"] ?></option>  
            <?php        
                }
            } else {
                echo "Tidak ada barang yang ditemukan.";
            }
            ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="kuantitas" class="form-label">Kuantitas :</label>
            <input type="text" class="form-control" id="kuantitas" name="kuantitas" required>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total :</label>
            <input type="text" class="form-control" id="total" name="total" readonly>
        </div>
        
        <input type="submit" value="Selesai Dan Bayar" class="btn btn-success">
        <br><br>
    </form>
</main>
</div>
</div>    

<!-- footer -->
<?php require_once '../tamplate/footer.php'; ?>
<!-- end footer -->

<script>
// Mengambil elemen-elemen yang diperlukan
const kuantitasInput = document.getElementById('kuantitas');
const hargaSatuanSelect = document.getElementById('harga_satuan');
const totalInput = document.getElementById('total');

// Fungsi untuk menghitung total
function calculateTotal() {
    const kuantitas = parseFloat(kuantitasInput.value) || 0;
    const hargaSatuan = parseFloat(hargaSatuanSelect.value) || 0;
    const total = kuantitas * hargaSatuan;
    totalInput.value = total.toFixed(2); // Menampilkan total dengan dua angka desimal
}

// Menambahkan event listener untuk menghitung total setiap kali kuantitas berubah
kuantitasInput.addEventListener('input', calculateTotal);
hargaSatuanSelect.addEventListener('change', calculateTotal);

// Menghitung total saat halaman dimuat pertama kali
calculateTotal();
</script>
