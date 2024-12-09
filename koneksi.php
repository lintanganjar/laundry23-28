<?php 
	$host="localhost";
	$username="root";
	$password="";
	$database="laundry";

	$conn=mysqli_connect($host,$username,$password,$database);
	if (mysqli_connect_errno()) {
		echo "koneksi Gagal";
	}
 ?>