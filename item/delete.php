<?php 
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$id=$_GET['id_item'];
	$query = mysqli_query($conn, "DELETE FROM item WHERE id_item='$id'");
	if ($query) {
		header("location:../item.php");	
	}else{
		echo "gagal";
	}
}
?>