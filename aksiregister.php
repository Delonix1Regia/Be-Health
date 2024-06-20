<?php
include "koneksi.php";
$level = $_POST['level'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$username = $_POST['username'];
$psw = $_POST['password'];

$sql="INSERT INTO users (level, nama, email, username, password) VALUES ('".$level."','".$nama."','".$email."','".$username."','".$psw."')";
	$query=$koneksi->query($sql);
	if ($query === true) {
		header('location: logininspinia.php');
	} else {
		echo "erooooooorrrrrrr";
	}
?>