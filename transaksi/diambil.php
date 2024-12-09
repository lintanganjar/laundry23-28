<?php 
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$id_transaksi=$_GET['id_transaksi'];
	$x=mysqli_query($conn,"UPDATE transaksi SET status='1' WHERE id_transaksi='$id_transaksi'");
	if ($x) {
		header("location:../index.php");
	}else{
		echo "Gagal";
	}
}	

?>