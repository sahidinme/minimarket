<?php
class Database {
    private $host = "localhost";  // Nama host database
    private $db_name = "minimarket";  // Nama database
    private $username = "root";  // Username database
    private $password = "";  // Password database
    public $conn;

    // Fungsi untuk mendapatkan koneksi ke database
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();  // Menampilkan pesan error jika koneksi gagal
        }
        return $this->conn;
    }
}
?>
