<?php 
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
else{
	include '../koneksi.php';
	$id=$_POST['id'];
	$nama_item = $_POST['nama_item'];
	$harga= $_POST['harga'];
	$ket = $_POST['ket'];
	$query = mysqli_query($conn, "INSERT INTO item VALUES('$id', '$nama_item','$harga','$ket')");
	header("location:item.php");
	if ($query) {
		header("location:../item.php");	
	}
	else{
		echo "Gagal";
	}
}
?>