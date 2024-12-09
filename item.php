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
    <title>E-laundry - Item</title>
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
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <!-- menginclude file topbar.php yang berisi menu2 pada topbar -->
                    <?php include 'other/topbar.php'; ?>
                </nav>
              <!-- bagian awal container -->
                <div class="container-fluid">
                    <!-- judul pada konten -->
                    <h1 class="h3 mb-2 text-gray-800">Daftar Item</h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <button class="btn btn-primary btn-icon-split" Data-toggle="modal" data-target="#tambahModal">
                                 <!-- tombol untuk memunculkan modal tambah data -->
                                <span class="text">Tambah</span>
                            </button>
                            <!-- modal tambah data-->
                            <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post" action="item/add.php">
                                        <div class="form-group">
                                            <?php 
                                                // query untuk mengambil nilai id item paling besar
                                                $data=mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(id_item) as id FROM item"));
                                                //deklarasi $urutan untuk membagi id item terbesar kemudian mengambil 3 nilai terakhir dan di konversi menjadi int
                                                // misal id item terbesar = ITM001, maka  yang diambil hanya 001
                                                $urutan=(int)substr($data['id'], 3,3);
                                                // menambahkan nilai +1 pada $urutan (id item)
                                                $urutan++;
                                                // deklarasi id dengan format khusus, disini "ITM" adalah teks awalan id. kemudian sprintf("%03s", $urutan) digunakan untuk memformat string yang mana "%03s" artinya menghasilkan string 3 karakter, kemudian $urutan adalah urutan id.
                                                // jika $urutan memiliki nilai 5 (id terbesar setelah ditambahkan 1 memiliki nilai 5), maka id yang dihasilkan akan menjadi "ITM005"
                                                $id="ITM".sprintf("%03s", $urutan);
                                            ?>
                                            <label for="exampleFormControlInput1">ID Item</label>
                                             <!-- inputan id_item yang mana isinya otomatis di buat berdasarkan nilai id terbesar pada database dan memiliki atribut readonly(tidak dapat diubah)-->
                                            <input type="text" name="id" class="form-control" value="<?php echo $id ?>" readonly="readonly">
                                         </div>
                                         <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Item</label>
                                            <input type="text" name="nama_item" class="form-control">
                                         </div>
                                         <div class="form-group">
                                            <label for="exampleFormControlInput1">Harga</label>
                                            <input type="text" name="harga" class="form-control">
                                         </div>
                                         <div class="form-group">
                                           <label for="exampleFormControlTextarea1">Keterangan</label>
                                            <textarea class="form-control" name="ket" rows="5"></textarea>
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
                                            <th style="width: 150px">Id Item</th>
                                            <th>Nama Item</th>
                                            <th style="width: 200px;">Harga</th>
                                            <th>Keterangan</th>
                                            <th style="width: 75px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            // query  untuk mengambil semua data dari item 
                                            $query= mysqli_query($conn,"select * from item");
                                            // while yang digunakan untuk menampilkan data hasil dari $query yang disimpan pada variabel dt
                                            while ($dt=mysqli_fetch_assoc($query)) {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo $dt["id_item"]; ?></td>
                                            <td><?php echo $dt["nama_item"] ?></td>
                                            <td>Rp.<?php echo $dt["harga"] ?></td>
                                            <td><?php echo $dt["ket"] ?></td>
                                            <td>
                                              <!-- button untuk menampilkan modal edit data berdasarkan id item mana yang diedit -->
                                                <button class="btn btn-success btn-box" Data-toggle="modal" data-target="#editModal<?php echo $dt['id_item'] ?>">
                                                    <i class='fas fa-pen'></i>
                                                </button>
                                                <!-- modal edit data berdasarkan id item mana yang diedit -->
                                                <div class="modal fade" id="editModal<?php echo $dt['id_item'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Item</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <form method="post" action="item/edit.php?id_item=<?php echo $dt['id_item']; ?>">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">ID Item</label>
                                                                <input type="text" name="id" class="form-control" value="<?php echo $dt['id_item'] ?>" readonly="readonly">
                                                             </div>
                                                             <div class="form-group">
                                                                <label for="exampleFormControlInput1">Nama Item</label>
                                                                <input type="text" name="nama_item" class="form-control" value="<?php echo $dt['nama_item'] ?>">
                                                             </div>
                                                             <div class="form-group">
                                                                <label for="exampleFormControlInput1">Harga</label>
                                                                <input type="text" name="harga" class="form-control" value="<?php echo $dt['harga'] ?>">
                                                             </div>
                                                             <div class="form-group">
                                                               <label for="exampleFormControlTextarea1">Keterangan</label>
                                                                <textarea class="form-control" name="ket" rows="5"><?php echo $dt['ket'] ?></textarea>
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

                                                <!-- button untuk menampilkan modal hapus data berdasarkan id item mana yang diedit -->
                                                <button class="btn btn-danger btn-box" Data-toggle="modal" data-target="#delModal<?php echo $dt['id_item'] ?>">
                                                    <i class='fas fa-trash'></i>
                                                </button>
                                                 <!-- modal hapus data berdasarkan id item mana yang dihapus -->
                                                <div class="modal fade" id="delModal<?php echo $dt['id_item'] ?>" tabindex="-1" role="dialog">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title">Perhatian</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        Apakah anda ingin menghapus Item "<?php echo $dt['nama_item'] ?>" ?
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                        <a href="item/delete.php?id_item=<?php echo $dt['id_item']; ?>" class="btn btn-success">Ya</a>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        
                                    </tbody>
                                </table>
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