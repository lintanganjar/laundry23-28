<?php 
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$id=$_GET['id_layanan'];
	$query = mysqli_query($conn, "DELETE FROM layanan WHERE id_layanan='$id'");
	if ($query) {
		header("location:../layanan.php");	
	}else{
		echo "gagal";
	}
}
?>