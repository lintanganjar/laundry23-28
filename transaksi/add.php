<?php  
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$id_transaksi=$_POST['id_transaksi'];
	$nama_kons=$_POST['nama_kons'];
	$no_hp=$_POST['hp'];
	$terima_tgl=$_POST['terima_tgl'];
	$selesai_tgl=$_POST['selesai_tgl'];
	$id_layanan=$_POST['id_layanan'];
	$id_item=$_POST['id_item'];
	$jumlah=$_POST['jumlah'];
	$harga_total=0;
	$pembayaran=$_POST['pembayaran'];
	$status=0;
	// mengeluarkan isi dari array inputan item & jumlah
	foreach (array_combine($id_item, $jumlah) as $id_itm=> $jmlh) {
		// query mengambil harga dari table item
		$x=mysqli_query($conn,"select harga from item where id_item='$id_itm'");
		$item=mysqli_fetch_array($x);
		// menghitung harga dari per item
		$harga=$item['harga']*$jmlh;
		// menghitung semua total harga
		$harga_total=$harga_total+($item['harga']*$jmlh);
		// query insert data ke table d_transaksi yg akan diulang sampai semua item berhasil diinput
		$dtransaksi=mysqli_query($conn, "INSERT INTO `d_transaksi` VALUES (null,'$id_transaksi','$id_itm','$jmlh','$harga')");
	}
	// query insert data Transaksi
	$transaksi=mysqli_query($conn, "INSERT INTO `transaksi` VALUES ('$id_transaksi','$nama_kons','$no_hp','$terima_tgl','$selesai_tgl','$id_layanan','$harga_total','$pembayaran','$status')");
	if ($transaksi) {
		header("location:../index.php");
	}else{
		echo "Gagal";
	}
}

?>
