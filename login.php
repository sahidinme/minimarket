<?php

include_once 'config/database.php';  // Menghubungkan file konfigurasi database

$database = new Database();  // Membuat objek database
$db = $database->getConnection();  // Mendapatkan koneksi ke database

session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$username = $_POST['username'];
    $id_kasir = $_POST['id_kasir'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM kasir WHERE id_kasir = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id_kasir);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal Login.');</script>";
    }
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin Template · Bootstrap v5.0</title>


    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Favicons -->

<meta name="theme-color" content="#7952b3">


<style>
html,
body {
  height: 100%;
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}



@media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
}
</style>

    
</head>
<body class="text-center">

<main class="form-signin">
  <form method="POST">
    <h1 class="h3 mb-3 fw-normal">Login</h1>

    <div class="form-floating">
      <input type="text" name="id_kasir" class="form-control" id="floatingInput" placeholder="id_kasir" required>
      <label for="floatingInput">id_kasir</label>
    </div>

    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
      <label for="floatingPassword">Password</label>
    </div>

    
    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button><br><br>
    <button class="w-100 btn btn-lg btn-danger" type="reset">Batal</button>
  </form>
</main>
