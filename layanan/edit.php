<?php 
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$id=$_POST['id'];
	$nama_layanan = $_POST['nama_layanan'];
	$ket = $_POST['ket'];
	$query = mysqli_query($conn, "UPDATE layanan SET nama_layanan='$nama_layanan', ket='$ket' WHERE id_layanan='$id'");	
	if ($query) {
		header("location:../layanan.php");
	}else{
		echo "Gagal";
	}
}
?>