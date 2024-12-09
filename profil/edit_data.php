<?php 
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$username=$_POST['username'];
	$nama=$_POST['nama'];
	$email=$_POST['email'];
	$password=md5($_POST['password']);
	if ($_POST['password']!="") {
		$query = mysqli_query($conn, "UPDATE user SET username='$username', nama='$nama', email='$email', password='$password' WHERE username='$username'");		
	}else{
		$query = mysqli_query($conn, "UPDATE user SET username='$username', nama='$nama', email='$email' WHERE username='$username'");		
	}
	
	if ($query) {
		header("location:../profil.php");
	}else{
		echo "Gagal";
	}
}
?>