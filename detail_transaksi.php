<!DOCTYPE html>
<html lang="en">
<?php 
    // mengimport file koneksi.php
    include 'koneksi.php';
    // memulai sesi
    session_start();
    // mengecek apakah sesi dengan nama username belum di set
    if (!isset($_SESSION['username'])) {
        // jika belum maka akan dialihkan ke login.php
        header("location:login.php");
    }
 ?>
<head>
    <!-- menginclude file head.php yang berisi css dll -->
    <?php include 'other/head.php'; ?>
    <title>E-Laundry - Detail Transaksi</title>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- menginclude file sidebar.php yang berisi menu2 pada sidebar -->
        <?php include 'other/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Tombol menutup sidebar dan akan muncul di beberapa ukuran layar device-->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <!-- menginclude file topbar.php yang berisi menu2 pada topbar -->
                    <?php include 'other/topbar.php'; ?>

                </nav>

                <!-- bagian awal container -->
                <div class="container-fluid" style="overflow-x:auto;">
                    <!-- judul pada konten -->
                    <h1 class="h3 mb-2 text-gray-800">Detail Transaksi</h1>
                    <div class="row ml-1">
                        <div class="col-xs-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <!-- tombol kembali ke halaman index.php(transaksi) -->
                                    <a href="index.php" class="btn btn-primary btn-icon-split">
                                        <span class="text">Kembali</span>
                                    </a>
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
                                            <td>No Hp</td>
                                            <td>:</td>
                                            <td>
                                              <?php 
                                               $awal_hp=substr($data['hp'],0,2);
                                               if ($awal_hp!='08') {
                                                 echo "08".substr($data['hp'],3,12);
                                               }else{
                                                echo $data['hp'];
                                               }
                                              ?>
                                            </td>
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
                                    <table class="table table-bordered" style="width: 100%;">
                                        <tr>
                                                <th>Nama Item</th>
                                                <th>Harga</th>
                                                <th>Jumlah / Berat</th>
                                                <th>Total</th>
                                        </tr>
                                        <?php 
                                             // query right join untuk mengambil semua data berdasarkan id dtransaksi dari tabel dtransaksi dan data dari item berdasarkan id item yang ada di dtransaksi
                                            $x=mysqli_query($conn,"SELECT * FROM `d_transaksi` JOIN `item` on d_transaksi.id_item=item.id_item WHERE id_transaksi='".$data['id_transaksi']."'");
                                            // while yang digunakan untuk menampilkan data hasil dari $x yang disimpan pada variabel dtrn
                                            while ($dtrn=mysqli_fetch_assoc($x)) {
                                         ?>
                                        <tr>                                           
                                            <td><?php echo $dtrn['nama_item']; ?></td>
                                            <td>
                                                <?php echo "Rp.".$dtrn['harga'];  
                                                    if ($dtrn['nama_item']!="Pakaian") {
                                                        echo "/Satuan";
                                                    }else{
                                                        echo "/kg";
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $dtrn['jumlah']; ?></td>
                                            <td>Rp.<?php echo $dtrn['total']; ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <th colspan="3" style="text-align: center;">Total Harga</th>
                                            <td>Rp.<?php echo $data['total_harga'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="nota.php?id_transaksi=<?php echo $data['id_transaksi'] ?>" name="simpan" class="btn btn-success align-content-end" style="margin-right: 20px;">Nota</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bagian akhir container -->
            </div>

           <!-- menginclude footer.php yang berisi teks bagian footer-->
            <?php include 'other/footer.php'; ?>

        </div>

    </div>

    <!-- tombol scroll to up -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- mengimport file footer2.php yang berisi script -->
    <?php include 'other/footer2.php'; ?>
</body>

</html>