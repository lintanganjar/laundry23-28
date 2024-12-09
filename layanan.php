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
    <title>E-laundry - Layanan</title>
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
                    <h1 class="h3 mb-2 text-gray-800">Daftar Layanan</h1>
                    <!-- DataTales-->
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
                                      <h5 class="modal-title" id="exampleModalLabel">Tambah Data Layanan</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <form method="post" action="layanan/add.php">
                                          <div class="form-group">
                                              <?php 
                                                // query untuk mengambil nilai id Layaanan paling besar
                                                  $data=mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(id_layanan) as id FROM layanan"));
                                                  //deklarasi $urutan untuk membagi id Layanan terbesar kemudian mengambil 3 nilai terakhir dan di konversi menjadi int
                                                  // misal id Layanan terbesar = LYN001,   maka  yang diambil hanya 001
                                                  $urutan=(int)substr($data['id'], 3,3);
                                                  // menambahkan nilai +1 pada $urutan (id Layanan)
                                                  $urutan++;
                                                  // deklarasi id dengan format khusus, disini "LYN" adalah teks awalan id. kemudian sprintf("%03s", $urutan) digunakan untuk memformat string yang mana "%03s" artinya menghasilkan string 3 karakter, kemudian $urutan adalah urutan id.
                                                  // jika $urutan memiliki nilai 5 (id terbesar setelah ditambahkan 1 memiliki nilai 5), maka id yang dihasilkan akan menjadi "LYN005"
                                                  $id="LYN".sprintf("%03s", $urutan);
                                              ?>
                                              <label>ID Layanan</label>
                                               <!-- inputan id_layanan yang mana isinya otomatis di buat berdasarkan nilai id terbesar pada database dan memiliki atribut readonly(tidak dapat diubah)-->
                                              <input type="text" name="id" class="form-control" value="<?php echo $id ?>" readonly="readonly">
                                           </div>
                                           <div class="form-group">
                                              <label>Nama Layanan</label>
                                              <input type="text" name="nama_layanan" class="form-control">
                                           </div>
                                           <div class="form-group">
                                             <label">Keterangan</label>
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
                                            <th style="width: 150px">Id Layanan</th>
                                            <th>Nama Layanan</th>
                                            <th>Keterangan</th>
                                            <th style="width: 75px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            // query  untuk mengambil semua data dari layanan
                                            $query= mysqli_query($conn, "select * from layanan");
                                            // while yang digunakan untuk menampilkan data hasil dari $query yang disimpan pada variabel dt
                                            while ($dt=mysqli_fetch_assoc($query)) {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo $dt["id_layanan"]; ?></td>
                                            <td><?php echo $dt["nama_layanan"] ?></td>
                                            <td><?php echo $dt["ket"] ?></td>
                                            <td>
                                                <!-- button untuk menampilkan modal edit data berdasarkan id layanan mana yang diedit -->
                                                <button class="btn btn-success btn-box" Data-toggle="modal" data-target="#editModal<?php echo $dt['id_layanan'] ?>">
                                                    <i class='fas fa-pen'></i>
                                                </button>
                                                <!-- modal edit data berdasarkan id layanan mana yang diedit -->
                                                <div class="modal fade" id="editModal<?php echo $dt['id_layanan'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Layanan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <form method="post" action="layanan/edit.php?id_layanan=<?php echo $dt['id_layanan']; ?>">
                                                            <div class="form-group">
                                                                <label>ID Layanan</label>
                                                                <input type="text" name="id" class="form-control" value="<?php echo $dt['id_layanan'] ?>" readonly="readonly">
                                                             </div>
                                                             <div class="form-group">
                                                                <label>Nama Layanan</label>
                                                                <input type="text" name="nama_layanan" class="form-control" value="<?php echo $dt['nama_layanan'] ?>">
                                                             </div>
                                                             <div class="form-group">
                                                               <labela1">Keterangan</label>
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

                                                <!-- button untuk menampilkan modal hapus data berdasarkan id layanan mana yang diedit -->
                                                <button class="btn btn-danger btn-box" Data-toggle="modal" data-target="#delModal<?php echo $dt['id_layanan'] ?>">
                                                    <i class='fas fa-trash'></i>
                                                </button>
                                                <!-- modal hapus data berdasarkan id layanan mana yang dihapus -->
                                                <div class="modal fade" id="delModal<?php echo $dt['id_layanan'] ?>" tabindex="-1" role="dialog">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title">Perhatian</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        Apakah anda ingin menghapus Layanan "<?php echo $dt['nama_layanan'] ?>" ?
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                        <a href="layanan/delete.php?id_layanan=<?php echo $dt['id_layanan']; ?>" class="btn btn-success">Ya</a>
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