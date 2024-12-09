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
        date_default_timezone_set('Asia/Jakarta');
    }
 ?>
<head>
  <!-- menginclude file head.php yang berisi css dll -->
  <?php include 'other/head.php'; ?>
  <title>E-laundry - Transaksi</title>
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- menginclude file sidebar.php yang berisi menu2 pada sidebar -->
        <?php include 'other/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
              <!-- bagian topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Tombol menutup sidebar dan akan muncul di beberapa ukuran layar device-->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    <!-- menginclude file topbar.php yang berisi menu2 pada topbar -->
                    <?php include 'other/topbar.php'; ?>
                </nav>
                <!-- bagian awal container -->
                <div class="container-fluid">
                  <!-- judul pada konten -->
                    <h1 class="h3 mb-2 text-gray-800">Daftar Transaksi</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                          <!-- tombol untuk memunculkan modal tambah data -->
                            <button class="btn btn-primary btn-icon-split" Data-toggle="modal" data-target="#tambahModal">
                                <span class="text">Tambah</span>
                            </button>
                            <!-- modal tambah data-->
                              <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Tambah Data Transaksi</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <form method="post" action="transaksi/add.php">
                                          <div class="form-group" id>
                                            <?php 
                                              // query untuk mengambil nilai id transaksi paling besar
                                              $id_trans=mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(id_transaksi) as id FROM transaksi"));
                                              //deklarasi $urutan untuk membagi id transaksi terbesar kemudian mengambil 3 nilai terakhir dan di konversi menjadi int
                                              // misal id transaksi terbesar = TRN001, maka yang diambil hanya 001
                                              $urutan=(int)substr($id_trans['id'], 3,3);
                                              // menambahkan nilai +1 pada $urutan (id transaksi)
                                              $urutan++;
                                              // deklarasi id_transaksi dengan format khusus, disini "DTRN" adalah teks awalan id. kemudian sprintf("%03s", $urutan) digunakan untuk memformat string yang mana "%03s" artinya menghasilkan string 3 karakter, kemudian $urutan adalah urutan id_transaksi.
                                              // jika $urutan memiliki nilai 5 (id terbesar setelah ditambahkan 1 memiliki nilai 5), maka id yang dihasilkan akan menjadi "TRN005"
                                              $id_transaksi="TRN".sprintf("%03s", $urutan);
                                              // sama seperti diatas
                                            ?>
                                              <label for="exampleFormControlInput1">ID Transaksi</label>
                                              <!-- inputan id_transaksi yang mana isinya otomatis di buat berdasarkan nilai id terbesar pada database dan memiliki atribut readonly(tidak dapat diubah)-->
                                              <input type="text" name="id_transaksi" class="form-control" value="<?php echo $id_transaksi ?>" readonly="readonly">
                                              <!-- input id_dtransaksi yang mana inputan ini berupa type hidden(inputan tidak ditampilkan pada web) dan diisi  otomatis berdasarkan nilai id terbesar pada database-->
                                              <input type="hidden" name="id_dtransaksi" value="<?php echo $id_dtransaksi ?>">
                                           </div>
                                           <div class="form-group">
                                              <label for="exampleFormControlInput1">Nama Konsumen</label>
                                              <input type="text" name="nama_kons" class="form-control" required>
                                           </div>
                                           <div class="form-group">
                                              <label for="exampleFormControlInput1">No Hp</label>
                                              <input type="number" name="hp" class="form-control" required>
                                           </div>
                                           <div class="form-group">
                                              <label for="exampleFormControlInput1">Tanggal Terima</label>
                                              <input type="date" name="terima_tgl" class="form-control"  required>
                                           </div>
                                           <div class="form-group">
                                              <label for="exampleFormControlInput1">Tanggal Selesai</label>
                                              <input type="date" name="selesai_tgl" class="form-control" required>
                                           </div>
                                           <div class="form-group">
                                              <label for="exampleFormControlInput1">Layanan</label><br>
                                              <select class="form-control"  name="id_layanan"  required>
                                                <?php 
                                                  // query untuk mengambil semua data pada tabel layanan
                                                  $a=mysqli_query($conn,"select * from layanan") ;
                                                  // while yang digunakan untuk menampilkan data hasil dari $query yang disimpan pada variabel lyn
                                                  while($lyn=mysqli_fetch_array($a)){
                                                  ?>  
                                                    <!-- option value yang mana diisi berupa id layanan, dan teks berupa nama layanan yang tersedia pada database -->
                                                    <option value="<?php echo $lyn['id_layanan'] ?>"><?php echo $lyn["nama_layanan"]; ?></option> 
                                                <?php } ?>    
                                              </select>
                                           </div>
                                           <!-- bagian form untuk item dan jumlah/berat -->
                                           <div class="form-group">
                                              <div class="row">
                                                  <div class="col-8">
                                                      <!-- label inputan item -->
                                                      <label for="exampleFormControlInput1">Item</label><br>    
                                                  </div>
                                                  <div class="col-4"> 
                                                      <!-- label inputan jumlah/berat -->
                                                      <label for="exampleFormControlInput1">Jumlah/Berat</label><br>
                                                  </div>
                                              </div>
                                               <div class="row">
                                                   <div class="col-8">
                                                      <!-- atribut select  yang dengan name='id_item[]'(id item disini berupa array, dikarenakan satu kali transaksi bisa terdapat item lebih dari satu) -->
                                                       <select class="form-control" name="id_item[]"  required>
                                                          <?php 
                                                              // query untuk mengambil semua data pada table item
                                                              $x=mysqli_query($conn,"select * from item") ;
                                                              // while yang digunakan untuk menampilkan data hasil dari $x yang disimpan pada variabel item
                                                              while($item=mysqli_fetch_array($x)){
                                                          ?>  
                                                              <!-- option value yang mana diisi berupa id item, dan teks berupa nama item yang tersedia pada database -->
                                                              <option value="<?php echo $item['id_item'] ?>"><?php echo $item["nama_item"]; ?></option> 
                                                          <?php } ?>    
                                                      </select>
                                                   </div>
                                                   <div class="col-4">
                                                      <!-- input jumlah yang memiliki name="jumlah[]"(jumlah disini berupa array, dikarenakan satu kali transaksi bisa terdapat jumlah lebih dari satu) -->
                                                       <input type="text" name="jumlah[]" class="form-control" style="width: 60%; display: inline;"  required>
                                                       <!-- button dengan icon tambah. yang mana id='tambah' digunakan untuk identifier button-->
                                                       <button id="tambahitem" class="btn btn-success btn-box">
                                                           <i class='fas fa-plus'></i>
                                                       </button>
                                                   </div>
                                               </div>
                                               <!-- dibuat atribut dengan id="itembaru" yang digunakan untuk tempat penambahan inputan item dan jumlah dari javascript -->
                                               <div id="itembaru"></div>
                                           </div>
                                           <div class="form-group">
                                               <label for="exampleFormControlInput1">Pembayaran</label><br>
                                               <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="pembayaran" id="inlineRadio1" value="Cash"  required>
                                                  <label class="form-check-label" for="inlineRadio1">Cash</label>
                                               </div>
                                               <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" name="pembayaran" id="inlineRadio2" value="Transfer" required>
                                                  <label class="form-check-label" for="inlineRadio2">Transfer</label>
                                               </div>
                                           </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button name="simpan" class="btn btn-primary">Simpan</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>

                        <!-- isi konten -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px">No</th>
                                            <th style="width: 20px">Detail</th>
                                            <th style="width: 100px">ID Transaksi</th>
                                            <th>Nama Konsumen</th>
                                            <th>Tanggal Terima</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Layanan</th>
                                            <th>Status</th>
                                            <th style="width: 140px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        // query join untuk mengambil semua data dari transaksi dan data dari layanan berdasarkan id layanan yang ada di transaksi
                                        $query= mysqli_query($conn, "SELECT * FROM `transaksi` JOIN `layanan` on transaksi.id_layanan=layanan.id_layanan ORDER BY transaksi.id_transaksi;
");
                                        // while yang digunakan untuk menampilkan data hasil dari $query yang disimpan pada variabel dt
                                        while ($dt=mysqli_fetch_assoc($query)) { 
                                          // deklarasi variabel terima_tgl untuk menyimpan data tanggal menerima laudry
                                          $terima_tgl=$dt['terima_tgl'];
                                          // deklarasi variabel selesai_tgl untuk menyimpan data tanggal selesai laudry
                                          $selesai_tgl=$dt['selesai_tgl'];
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <a href="detail_transaksi.php?id_transaksi=<?php echo $dt['id_transaksi'] ?>" class="btn btn-primary btn-box">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                            <td><?php echo $dt['id_transaksi']; ?></td>
                                            <td><?php echo $dt['nama_kons']; ?></td>
                                            <!-- menampilkan tanggal terima dengan format tanggal indonesia, karena default data di database berupa format US-->
                                            <td><?php echo date('d-m-Y', strtotime($terima_tgl)); ?></td>
                                            <!-- menampilkan tanggal selesai dengan format tanggal indonesia, karena default data di database berupa format US-->
                                            <td><?php echo date('d-m-Y', strtotime($selesai_tgl)); ?></td>
                                            <td>
                                               <?php echo $dt['nama_layanan']; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                  // mengecek jika status berupa 0 maka akan ditampilkan teks belum diambil
                                                  if ($dt['status']==0) {
                                                      echo "<label class='badge badge-danger'>Belum Diambil</label>";
                                                  // jika status berupa 1 maka akan ditampilkan teks sudah diambil
                                                  }else if($dt['status']==1) {
                                                      echo "<label class='badge badge-success'>Sudah Diambil</label>";
                                                  }
                                                ?>
                                            </td>
                                            <td>
                                              <!-- bagian edit data -->
                                              <?php 
                                                  if ($dt['status']==0) {
                                               ?>
                                                    <button class="btn btn-warning" Data-toggle="modal" data-target="#editModal<?php echo $dt['id_transaksi'] ?>">
                                                        <i class='fas fa-pen'></i>
                                                    </button>
                                              <?php 
                                                  }else{
                                               ?>
                                                    <button class="btn btn-warning" Data-toggle="modal" data-target="#editModal<?php echo $dt['id_transaksi'] ?>" disabled>
                                                        <i class='fas fa-pen'></i>
                                                    </button>
                                              <?php } ?>
                                              <!-- modal tambah data-->
                                                <div class="modal fade" id="editModal<?php echo $dt['id_transaksi'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Transaksi</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <form method="post" action="transaksi/edit.php">
                                                            <div class="form-group" id>
                                                                <label for="exampleFormControlInput1">ID Transaksi</label>
                                                                <input type="text" name="id_transaksi" class="form-control" value="<?php echo $dt['id_transaksi'] ?>" readonly="readonly">
                                                                <input type="hidden" name="status" value="<?php echo $dt['status'] ?>">
                                                             </div>
                                                             <div class="form-group">
                                                                <label for="exampleFormControlInput1">Nama Konsumen</label>
                                                                <input type="text" name="nama_kons" class="form-control" value="<?php echo $dt['nama_kons'] ?>" required>
                                                             </div>
                                                             <div class="form-group">
                                                                <label for="exampleFormControlInput1">No Hp</label>
                                                                <input type="number" name="hp" class="form-control" value="<?php echo $dt['hp'] ?>" required>
                                                             </div>
                                                             <div class="form-group">
                                                                <label for="exampleFormControlInput1">Tanggal Terima</label>
                                                                <input type="date" name="terima_tgl" class="form-control" value="<?php echo $dt['terima_tgl'] ?>"  required>
                                                             </div>
                                                             <div class="form-group">
                                                                <label for="exampleFormControlInput1">Tanggal Selesai</label>
                                                                <input type="date" name="selesai_tgl" class="form-control" value="<?php echo $dt['selesai_tgl'] ?>" required>
                                                             </div>
                                                             <div class="form-group">
                                                                <label for="exampleFormControlInput1">Layanan</label><br>
                                                                <select class="form-control"  name="id_layanan" value="<?php echo $dt['nama_kons'] ?>"  required>
                                                                  <?php 
                                                                    // query untuk mengambil semua data pada tabel layanan
                                                                    $a=mysqli_query($conn,"select * from layanan") ;
                                                                    // while yang digunakan untuk menampilkan data hasil dari $query yang disimpan pada variabel lyn
                                                                    while($lyn=mysqli_fetch_array($a)){
                                                                    ?>  
                                                                      <!-- option value yang mana diisi berupa id layanan, dan teks berupa nama layanan yang tersedia pada database -->
                                                                      <option value="<?php echo $lyn['id_layanan'] ?>" <?php if($lyn['id_layanan']==$dt['id_layanan']){echo "selected";}?>>
                                                                        <?php echo $lyn["nama_layanan"]; ?>
                                                                      </option> 
                                                                  <?php } ?>    
                                                                </select>
                                                             </div>
                                                             <!-- bagian form untuk item dan jumlah/berat -->
                                                             <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <!-- label inputan item -->
                                                                        <label for="exampleFormControlInput1">Item</label><br>    
                                                                    </div>
                                                                    <div class="col-4"> 
                                                                        <!-- label inputan jumlah/berat -->
                                                                        <label for="exampleFormControlInput1">Jumlah/Berat</label><br>
                                                                    </div>
                                                                </div>
                                                                <?php 
                                                                    $a=mysqli_query($conn,"SELECT * FROM `d_transaksi` WHERE id_transaksi='".$dt['id_transaksi']."'");
                                                                                // while yang digunakan untuk menampilkan data hasil dari $x yang disimpan pada variabel dtrn
                                                                                $n=0;
                                                                                while ($dtrn=mysqli_fetch_assoc($a)) {
                                                                 ?>
                                                                  <div id="itemEdit">                                                                 
                                                                    <div class="row">
                                                                      <div class="col-8">
                                                                          <select class="form-control" name="id_item[]"  required>
                                                                            <?php 
                                                                              // query untuk mengambil semua data pada table item
                                                                              $x=mysqli_query($conn,"select * from item") ;
                                                                              // while yang digunakan untuk menampilkan data hasil dari $x yang disimpan pada variabel item
                                                                              while($item=mysqli_fetch_array($x)){
                                                                            ?>  
                                                                                <!-- option value yang mana diisi berupa id item, dan teks berupa nama item yang tersedia pada database -->
                                                                                <option value="<?php echo $item['id_item'] ?>" <?php if($item['id_item']==$dtrn['id_item']) {echo "selected";}?>>
                                                                                  <?php echo $item["nama_item"]; ?>
                                                                                </option> 
                                                                            <?php 
                                                                               }
                                                                            ?>    
                                                                          </select>
                                                                      </div>
                                                                      <div class="col-4">
                                                                         <!-- input jumlah yang memiliki name="jumlah[]"(jumlah disini berupa array, dikarenakan satu kali transaksi bisa terdapat jumlah lebih dari satu) -->
                                                                          <input type="text" id="jmlh_itm<?php echo $n?>" name="jumlah[]" value="<?php echo $dtrn['jumlah'] ?>" class="form-control" style="width: 60%; display: inline;"  required>
                                                                          <?php 
                                                                            if ($n==0) {
                                                                          ?>
                                                                              <button onclick="tambahedit('itembaruEdit<?php echo substr($dt['id_transaksi'],4,2) ?>')" class="tmbhedit btn btn-success btn-box">
                                                                                  <i class="fas fa-plus"></i>
                                                                              </button>
                                                                          <?php 
                                                                            }else{
                                                                              echo '
                                                                                <button id="removetmbhedit" class="btn btn-danger btn-box">
                                                                                <i class="fas fa-minus"></i>
                                                                                </button>'; 
                                                                              }
                                                                          ?>
                                                                       </div>
                                                                    </div>
                                                                  </div>
                                                                 <input type="hidden" name="id_dtransaksi[]" value="<?php echo $dtrn['id_dtransaksi'] ?>">
                                                                 <?php 
                                                                  $n++;
                                                                  } ?>
                                                                 <!-- dibuat atribut dengan id="itembaru" yang digunakan untuk tempat penambahan inputan item dan jumlah dari javascript -->
                                                                 <div id="itembaruEdit<?php echo substr($dt['id_transaksi'],4,2) ?>"></div>
                                                             </div>
                                                             <div class="form-group">
                                                                 <label for="exampleFormControlInput1">Pembayaran</label><br>
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="pembayaran" id="inlineRadio1" value="Cash" <?php if ($dt['pembayaran']=='Cash') {echo 'checked';} ?> required>
                                                                    <label class="form-check-label" for="inlineRadio1">Cash</label>
                                                                 </div>
                                                                 <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="pembayaran" id="inlineRadio2" value="Transfer" <?php if($dt['pembayaran']=='Transfer'){echo 'checked';} ?> required>
                                                                    <label class="form-check-label" for="inlineRadio2">Transfer</label>
                                                                 </div>
                                                             </div>
                                                      </div>
                                                      <div class="modal-footer">
                                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                          <button name="simpan" class="btn btn-primary">Simpan</button>
                                                        </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                          </div>


                                              <!-- bagian diambil -->
                                                <?php 
                                                  // mengecek jika status berupa 0 maka akan ditampilkan tombol button diambil yang bisa diklik dan menampilkan modal konfirmasi diambil
                                                  if ($dt['status']==0 && $selesai_tgl==date("Y-m-d")){
                                                      echo "
                                                           <button class='btn btn-primary btn-box' data-toggle='modal' data-target='#diambil".$dt['id_transaksi']."'>
                                                              <i class='fas fa-check'></i>
                                                           </button>";
                                                  // jika status berupa 1 maka akan ditampilkan tombol button diambil yang di disabled(dimatikan, tidak bisa diklik).
                                                  }else{
                                                      echo "
                                                           <button class='btn btn-primary btn-box' disabled>
                                                                <i class='fas fa-check'></i>
                                                           </button>";
                                                  } ?>
                                                  <!-- Modal untuk konfirmasi diambil -->
                                                  <div class="modal fade" id="diambil<?php echo $dt['id_transaksi']  ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          Apakah Laundry sudah diambil?
                                                        </div>
                                                        <div class="modal-footer">
                                                           <button class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                           <a href="transaksi/diambil.php?id_transaksi=<?php echo $dt['id_transaksi']?>" class="btn btn-success">YA</a>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <!-- bagian kirim nota ke wa -->
                                                  <?php 
                                                    $awal_hp=substr($dt['hp'],0,2);
                                                    if ($awal_hp!='08') {
                                                      $hp=$dt['hp'];
                                                    }else{
                                                      $hp="62".substr($dt['hp'], 1, 12);
                                                    }
                                                    $text="Terima%20Kasih%20telah%20melaundry%20di%20E-Laundry,%20klik%20link%20berikut%20untuk%20melihat%20nota%0A".base_url()."nota.php?id_transaksi=".$dt['id_transaksi'];
                                                  ?>
                                                  <a href="https://api.whatsapp.com/send?phone=<?php echo $hp ?>&text=<?php echo $text ?>" class="btn btn-success">
                                                    <i class="far fa-paper-plane"></i>
                                                  </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- akhir container -->
            </div>

           <!-- menginclude footer.php yang berisi teks bagian footer-->
            <?php include 'other/footer.php'; ?>
        </div>
    </div>

    <!-- tombol scroll to up -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- mengimport file footer2.php yang berisi script dan deklarasi func untuk mengambil base url-->
    <?php
      include 'other/footer2.php'; 
      function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
          $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
          $hostname = $_SERVER['HTTP_HOST'];
          $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

          $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
          $core = $core[0];

          $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
          $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
          $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
      else $base_url = 'http://localhost/';

      if ($parse) {
        $base_url = parse_url($base_url);
        if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
      }

      return $base_url;
      }

    ?>

    <!-- bagian javasript -->
    <script>
      // jquery yang akan mendeteksi apakah tombol dengan id #tambah diklik, jika iya maka akan dijalankan
      $("#tambahitem").click(function () {
          // menghapus action pada button
          event.preventDefault();
          // deklarasi variabel var yang berisi code html yang akan ditambahkan pada halaman
          var html = '';
          html+='<div id="columnitem">';
          html+='<div class="row">';
          html+='<div class="col-8">';
          html+='<select class="form-control" name="id_item[]" required>';
          html+='<?php $itm=mysqli_query($conn,"select * from item");?>';
          html+='<?php while($item=mysqli_fetch_array($itm)){?>';
          html+="<option value='<?php echo $item['id_item'] ?>'><?php echo $item['nama_item']; ?></option>";
          html+='<?php } ?>';
          html+='</select>';
          html+='</div>';
          html+='<div class="col-4">';
          html+='<input type="text" name="jumlah[]" class="form-control" style="width: 60%; display: inline;" required>';
          html+='<button id="removetmbh" class="btn btn-danger btn-box" style="margin-left:5px;">';
          html+='<i class="fas fa-minus"></i>';
          html+='</button>';
          html+='</div>';
          html+='</div>';
          html+='</div>'
          // menambahkan kode html pada variabel html pada kode dengan id='itembaru' dengan menggunakan fungsi append dari jquery
          $('#itembaru').append(html);
      });
      // code yang digunakan untuk menghapus kode dengan id #columnitem menggunakan fungsi jquery remove
      $(document).on('click', '#removetmbh', function () {
          $(this).closest('#columnitem').remove();
      });


     // jquery yang akan mendeteksi apakah tombol dengan id #tambah diklik, jika iya maka akan dijalankan
      function tambahedit(a) {
        event.preventDefault();
        var x= '#'+a;
        var html = '';
          html+='<div id="itemEdit">';
          html+='<div class="row">';
          html+='<div class="col-8">';
          html+='<select class="form-control" name="id_item[]" required>';
          html+='<?php $itm=mysqli_query($conn,"select * from item");?>';
          html+='<?php while($item=mysqli_fetch_array($itm)){?>';
          html+="<option value='<?php echo $item['id_item'] ?>'><?php echo $item['nama_item']; ?></option>";
          html+='<?php } ?>';
          html+='</select>';
          html+='</div>';
          html+='<div class="col-4">';
          html+='<input type="text" name="jumlah[]" class="form-control" style="width: 60%; display: inline;" required>';
          html+='<input type="hidden" name="id_dtransaksi[]" value="" class="form-control">';
          html+='<button id="removetmbhedit" class="btn btn-danger btn-box" style="margin-left:5px;">';
          html+='<i class="fas fa-minus"></i>';
          html+='</button>';
          html+='</div>';
          html+='</div>';
          html+='</div>'
          // menambahkan kode html pada variabel html pada kode dengan id='itembaru' dengan menggunakan fungsi append dari jquery
          $(x).append(html);
        
      }

      // code yang digunakan untuk menghapus kode dengan id #itemid menggunakan fungsi jquery remove
      $(document).on('click', '#removetmbhedit', function () {
          $(this).closest('#itemEdit').remove();
      });
    </script>
</body>
</html>