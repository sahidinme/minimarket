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

// Query untuk membaca data kasir
$query = "SELECT * FROM kasir ORDER BY id_kasir DESC ";
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
        <li class="breadcrumb-item active"><a href="<?php echo BASE_URL; ?>kasir">Kasir</a></li>
        <!-- <li class="breadcrumb-item active" aria-current="page">Data</li> -->
        </ol>
    </nav>
    <!-- end breadcrumb -->
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Kasir</h1>
    </div>

      <h2><a href="create.php" class="btn btn-success">Tambah</a></h2>
      <div class="table-responsive">
        <table id="siswaTable" class="table table-striped dt-responsive nowrap" style="width:100%">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">ID Kasir</th>
              <th scope="col">Username</th>
              <th scope="col">Nama Kasir</th>
              <th scope="col">Alamat</th>
              <th scope="col">No Hp</th>
              <th scope="col">No KTP</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php $i = "1"; if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row['id_kasir']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['nama_kasir']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['no_tlp']; ?></td>
                        <td><?= $row['no_ktp']; ?></td>
                        <td class="action-buttons">
                            <a href="update.php?id_kasir=<?= $row['id_kasir']; ?>" class="btn btn-warning">Update</a>
                            <a href="delete.php?id_kasir=<?= $row['id_kasir']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Tidak ada data pelajaran.</td>
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

