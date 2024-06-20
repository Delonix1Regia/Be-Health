<?php
session_start();
include "koneksi.php";

// Pemeriksaan apakah 'op' telah didefinisikan
$op = isset($_GET['op']) ? $_GET['op'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Jika ada post dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($op == "in") {
        $sql = "SELECT * from users where username='$username' AND password='$password'";
        $query = $koneksi->query($sql);
        if (mysqli_num_rows($query) == 1) {
            $data = $query->fetch_array();
            $_SESSION['username'] = $data['username'];
            $_SESSION['level'] = $data['level'];
            if ($data['level'] == 'Admin') {
                header("location:dashboard.php");
                exit(); // Pastikan untuk keluar setelah mengarahkan header
            } else if ($data['level'] == "User") {
                header("location:dashboard.php");
                exit(); // Pastikan untuk keluar setelah mengarahkan header
            }
        } else {
            die("password salah <a href=\"javascript:history.back()\">kembali</a>");
        }
    } else if ($op == "out") {
        unset($_SESSION['username']);
        unset($_SESSION['level']);
        header("location:logininspinia.php");
        exit(); // Pastikan untuk keluar setelah mengarahkan header
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name"></h1>
            </div>
            <h3>Selamat Datang!</h3>
            <p>Silakan login untuk memulai.</p>
            <form class="m-t" role="form" action="?op=in" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <p class="text-muted text-center"><small>Don't have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="registerinspinia.php">Create an account</a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
