<!DOCTYPE html>
<html>
<head>
	<?php 
		// mengimport file koneksi.php
		include 'koneksi.php';
		// menginclude file head.php yang berisi css dll
		include 'other/head.php'; 
		// memulai sesi
	?>
	<title>E-Laundry - Nota</title>
	<style>
		body{
			color: black;
		}
		.table-me{
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
		}
		.brand{
			font-size: 24px;
			font-weight: bold;
		}

	</style>
</head>
<body>
	<div class="container-fluid my-auto">
		<div class="row">
			<div class="col-xs-5">

				<!-- DataTales-->
				<div class="card" style="border-color: black">
					<div class="card-header py-3" style="border-color: black">
						<div class="row">
							<div class="col-1"></div>
							<div class="col-2 ml-5"><img src="assets/img/logo2.png" width="65px;"></div>
							<div class="col-6">
								<table>
									<tr>
										<th><span class="brand">E-Laundry</span></th>
									</tr>
									<tr>
										<td><em>Bersih Rapi Wangi</em></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="card-body">
						<?php 
							// deklarasi $id_transaksi yang berisi data dari method $_GET['transaksi']
                        	$id_transaksi=$_GET['id_transaksi'];
                            // query join untuk mengambil semua data berdasarkan id transaksi dari tabel transaksi dan data dari layanan berdasarkan id layanan yang ada di transaksi
                            $query= mysqli_query($conn, "SELECT * FROM `transaksi` JOIN `layanan` on transaksi.id_layanan=layanan.id_layanan where id_transaksi='$id_transaksi'");
                            // deklarasi $data dan mengambil data hasil dari $query Disimpan menjadi array asosiatif
                            $data = mysqli_fetch_assoc($query);
                            // deklarasi variabel terima_tgl untuk menyimpan data tanggal menerima laudry
                            $terima_tgl=$data['terima_tgl'];
                            // deklarasi variabel terima_tgl untuk menyimpan data tanggal menerima laudry
                            $selesai_tgl=$data['selesai_tgl'];
						?>
						<table>
							<tr>
								<td>ID Transaksi</td>
								<td>:</td>
								<td><?php echo $data['id_transaksi']; ?></td>
							</tr>
							<tr>
								<td>Nama Konsumen</td>
								<td>:</td>
								<td><?php echo $data['nama_kons']; ?></td>
							</tr>
							<tr>
								<td>Tanggal Terima</td>
								<td>:</td>
								 <!-- menampilkan tanggal terima dengan format tanggal indonesia, karena default data di database berupa format US-->
								<td><?php echo date('d-m-Y', strtotime($terima_tgl)); ?></td>
							</tr>
							<tr>
								<td>Tanggal Selesai</td>
								<td>:</td>
								<!-- menampilkan tanggal selesai dengan format tanggal indonesia, karena default data di database berupa format US-->
								<td><?php echo date('d-m-Y', strtotime($selesai_tgl)); ?></td>
							</tr>
							<tr>
								<td>Layanan</td>
								<td>:</td>
								<td><?php echo $data['nama_layanan']; ?></td>
							</tr>
							<tr>
								<td>Pembayaran</td>
								<td>:</td>
								<td><?php echo $data['pembayaran']; ?></td>
							</tr>
						</table>
						<br>
						<table style="width: 450px">
							<tr>
								<th class="table-me">Nama Item</th>
								<th class="table-me">Harga</th>
								<th class="table-me">Jumlah / Berat</th>
								<th class="table-me">Total</th>
							</tr>
							<?php 
							 	// query right join untuk mengambil semua data berdasarkan id dtransaksi dari tabel dtransaksi dan data dari item berdasarkan id item yang ada di dtransaksi
                                $x=mysqli_query($conn,"SELECT * FROM `d_transaksi` JOIN `item` on d_transaksi.id_item=item.id_item WHERE id_transaksi='".$data['id_transaksi']."'");
                                // while yang digunakan untuk menampilkan data hasil dari $x yang disimpan pada variabel dtrn
                                while ($dtrn=mysqli_fetch_assoc($x)) {
                            ?>
							<tr>                                           
                                <td class="table-me"><?php echo $dtrn['nama_item']; ?></td>
                                <td class="table-me">
                                    <?php echo "Rp.".$dtrn['harga'];  
                               		    if ($dtrn['nama_item']!="Pakaian") {
                                            echo "/Satuan";
                                        }else{
                                            echo "/kg";
                                        }
                                    ?>
                                </td>
                                <td class="table-me"><?php echo $dtrn['jumlah']; ?></td>
                                <td class="table-me">Rp.<?php echo $dtrn['total']; ?></td>
                            </tr>
							<?php } ?>
							<tr>
								<th class="table-me" colspan="3" style="text-align: center;">Total Harga</th>
								<td class="table-me">Rp.<?php echo $data['total_harga'] ?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- mengimport file footer2.php yang berisi script -->
	<?php include 'other/footer2.php'; ?>

</body>
</html>