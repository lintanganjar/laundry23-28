<!DOCTYPE html>
<html lang="en">
<?php 
include 'koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
?>
<head>
    <?php include 'other/head.php'; ?>
    <title>E-laundry - Profil</title>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include 'other/sidebar.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <?php include 'other/topbar.php'; ?>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-11 col-xs-12">
                            <h1 class="h3 mb-2 text-gray-800">Profil</h1>
                            <!-- DataTales-->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <a class="btn btn-primary" href="index.php"> Kembali</a>

                                </div>
                                <div class="card-body">
                                    <?php 
                                    $query=mysqli_query($conn, "SELECT * FROM `user` WHERE username='".$_SESSION['username']."'");
                                    $user=mysqli_fetch_assoc($query);                                    
                                    ?>
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <!-- Profile picture card-->
                                            <div class="card mb-4 mb-xl-0">
                                                <div class="card-header">Foto Profil</div>
                                                <div class="card-body text-center">
                                                    <!-- Profile picture image-->
                                                    <img class="img-account-profile rounded-circle mb-2 w-50" src="assets/img/profil/<?php echo $user['foto'] ?>" alt="">
                                                    <!-- Profile picture help block-->
                                                    <form method="POST" action="profil/edit_foto.php" enctype="multipart/form-data">
                                                        <div class="mt-3">
                                                            <input type="hidden" name="username" value="<?php echo $user['username'] ?>">
                                                            <input type="hidden" name="fotolama" value="<?php echo $user['foto']?>">
                                                            <input type="file" name="foto" class="form-control" style="padding-bottom: 35px;" required>
                                                            <label class="small">* JPG or PNG no larger than 5 MB</label>
                                                        </div>
                                                        <input class="btn btn-primary" type="submit" name="upload" value="Upload Foto Baru">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-8">
                                            <!-- Account details card-->
                                            <div class="card mb-4">
                                                <div class="card-header">Detail Profil</div>
                                                <div class="card-body">
                                                    <form action="profil/edit_data.php" method="POST">
                                                        <!-- Form Group (username)-->
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Username</label>
                                                            <input class="form-control" name="username" type="text" value="<?php echo $user['username'] ?>" required>
                                                            <label class="small mb-1">* username hanya boleh berisi huruf (a-z), angka (0-9) dan titik (.)</label>

                                                        </div>
                                                        <!-- Form Group (Nama)-->
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Nama</label>
                                                            <input class="form-control" name="nama" type="text" value="<?php echo $user['nama'] ?>" required>
                                                        </div>
                                                        <!-- Form Group (Email)-->
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Email</label>
                                                            <input class="form-control" name="email" type="email" value="<?php echo $user['email'] ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Password Baru (* optional)</label>
                                                            <input class="form-control" name="password" type="password">
                                                        </div>
                                                        <!-- Save changes button-->
                                                        <input class="btn btn-primary" type="submit" name="submit" value="Simpan Perubahan">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>


                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- footer -->
            <?php include 'other/footer.php'; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php include 'other/footer2.php'; ?>
</body>

</html>