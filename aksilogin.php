<?php
session_start();
include "koneksi.php";
$username = $_POST['username'];
$password = $_POST['password'];
$op = $_GET['op'];

if($op=="in")
	{
		$sql="SELECT * from users where username='$username' AND password='$password'";
		$query= $koneksi->query($sql);
		if(mysqli_num_rows($query)==1){
			$data = $query->fetch_array();
			$_SESSION['username'] = $data['username'];
			$_SESSION['level'] = $data['level'];
			if($data['level']=='Admin'){
				header("location:dashboard.php");
			}else if($data['level']=="User"){
				header("location:dashboard.php");
			}
		}else
		{
			die("password salah <a href=\"javascript:history.back()\">kembali</a>");
		}
	}
	else if($op=="out"){
		unset($_SESSION['username']);
		unset($_SESSION['level']);
		header("location:logininspinia.php");
	}
?>