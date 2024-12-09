<?php  
session_start();
if (!isset($_SESSION['username'])) {
	header("location:../login.php");
}else{
	include '../koneksi.php';
	$id_transaksi=$_POST['id_transaksi'];
	$id_dtransaksi=$_POST['id_dtransaksi'];
	$nama_kons=$_POST['nama_kons'];
	$no_hp=$_POST['hp'];
	$terima_tgl=$_POST['terima_tgl'];
	$selesai_tgl=$_POST['selesai_tgl'];
	$id_layanan=$_POST['id_layanan'];
	$id_item=$_POST['id_item'];
	$jumlah=$_POST['jumlah'];
	$harga_total=0;
	$pembayaran=$_POST['pembayaran'];
	$status=$_POST['status'];
	$hasil = [];
	foreach ($id_dtransaksi as $key => $value) {
		if ($id_dtransaksi[$key]!=null && !isset($id_item[$key]) && !isset($jumlah[$key])) {
			$id_item[$key]='';
			$jumlah[$key]='';
		}
	    $hasil[$key] = array(
	        'id_dtransaksi'  => $id_dtransaksi[$key],
	        'id_item' => $id_item[$key],
	        'jumlah' => $jumlah[$key]
	    );
	}
	foreach($hasil as $k => $v) {
		if ($v['id_item']=='' && $v['jumlah']=='') {
			$dtransaksi = mysqli_query($conn, "DELETE FROM d_transaksi WHERE id_dtransaksi='".$v['id_dtransaksi']."'");			
		}else{
			$x=mysqli_query($conn,"select harga from item where id_item='".$v['id_item']."'");
			$item=mysqli_fetch_array($x);
			// menghitung harga dari per item
			var_dump($v['id_dtransaksi'],$v['id_item'],$v['jumlah']);
			$harga=$item['harga']*$v['jumlah'];
			// menghitung semua total harga
			$harga_total=$harga_total+($item['harga']*$v['jumlah']);
			if ($v['id_dtransaksi']!='') {
				$dtransaksi=mysqli_query($conn, "UPDATE d_transaksi SET id_dtransaksi='".$v['id_dtransaksi']."',id_transaksi='$id_transaksi', id_item='".$v['id_item']."', jumlah='".$v['jumlah']."', total='$harga' WHERE id_dtransaksi='".$v['id_dtransaksi']."'");	
			}else{
				$dtransaksi=mysqli_query($conn, "INSERT INTO `d_transaksi` VALUES (null,'$id_transaksi','".$v['id_item']."','".$v['jumlah']."','$harga')");
			}
		}
        
	}
	$transaksi=mysqli_query($conn, "UPDATE transaksi SET id_transaksi='$id_transaksi', nama_kons='$nama_kons', hp='$no_hp', terima_tgl='$terima_tgl', selesai_tgl='$selesai_tgl', id_layanan='$id_layanan', total_harga='$harga_total', pembayaran='$pembayaran', status='$status' WHERE id_transaksi='$id_transaksi'");
	if ($transaksi) {
		header("location:../index.php");
	}else{
		echo "Gagal";
	}
}

?>
