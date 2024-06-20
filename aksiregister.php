<?php
include "koneksi.php";
$level = $_POST['level'];
$namalengkap = $_POST['namalengkap'];
$email = $_POST['email'];
$username = $_POST['username'];
$psw = $_POST['password'];

$sql = "INSERT INTO users (level, namalengkap, email, username, password) VALUES ('" . $level . "','" . $namalengkap . "','" . $email . "','" . $username . "','" . $psw . "')";
$query = $koneksi->query($sql);
if ($query === true) {
	header('location: logininspinia.php');
} else {
	echo "erooooooorrrrrrr";
}
