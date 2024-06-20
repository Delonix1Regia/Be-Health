<?php
session_start();
include "koneksi.php";

// Inisialisasi variabel
$username = '';
$password = '';
$op = '';

// Cek apakah form login telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
}

// Cek apakah variabel 'op' ada di query string
if (isset($_GET['op'])) {
	$op = $_GET['op'];
}

if ($op == "in") {
	if (!empty($username) && !empty($password)) {
		$sql = "SELECT * FROM users WHERE username=? AND password=?";
		$stmt = $koneksi->prepare($sql);
		$stmt->bind_param('ss', $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 1) {
			$data = $result->fetch_array();
			$_SESSION['username'] = $data['username'];
			$_SESSION['level'] = $data['level'];
			if ($data['level'] == 'Admin') {
				header("Location: dashboard.php");
				exit();
			} else if ($data['level'] == "User") {
				header("Location: dashboard.php");
				exit();
			}
		} else {
			die("Password salah <a href=\"javascript:history.back()\">kembali</a>");
		}
	} else {
		die("Username dan Password harus diisi <a href=\"javascript:history.back()\">kembali</a>");
	}
} else if ($op == "out") {
	unset($_SESSION['username']);
	unset($_SESSION['level']);
	header("Location: logininspinia.php");
	exit();
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
			<p>Selamat Datang!</p>
			<p>Silakan login untuk memulai.</p>
			<form class="m-t" role="form" action="?op=in" method="post">
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Username" required="">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder="Password" required="">
				</div>
				<button type="submit" class="btn btn-primary block full-width m-b">Login</button>
				<p class="text-muted text-center"><small>Do not have an account?</small></p>
				<a class="btn btn-sm btn-white btn-block" href="registerinspinia.php">Create an account</a>
			</form>
		</div>
	</div>
	<!-- Mainly scripts -->
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>