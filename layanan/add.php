<?php 
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$id=$_POST['id'];
	$nama_layanan = $_POST['nama_layanan'];
	$ket = $_POST['ket'];
	$query = mysqli_query($conn, "INSERT INTO layanan VALUES('$id', '$nama_layanan','$ket')");
	if ($query) {
		header("location:../layanan.php");	
	}else{
		echo "Gagal";
	}
}
?>