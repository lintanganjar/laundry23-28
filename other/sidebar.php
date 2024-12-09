 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
            <img src="assets/img/logo.png" style="width: 45px;">
        </div>
        <div class="sidebar-brand-text mx-3">E-Laundry</div>
    </a>
    <div class="sidebar-heading">Main Menu</div>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <?php
        // include file koneksi.php
        include 'koneksi.php';
        // query mengambil semua data dari table menu
        $query= mysqli_query($conn,"select * from menu");
        // while yang digunakan untuk menampilkan data hasil dari $query yang disimpan pada variabel dt
        while ($dt=mysqli_fetch_assoc($query)) {
    ?>        
    <?php $a = $_SERVER['REQUEST_URI'];
        $b = explode("/", $a);
        ?>
        <li class="nav-item <?php if($b['2']==$dt['url']){echo'active';}?>">
            <a class="nav-link" href="<?php echo $dt['url']; ?>">
                <img src="assets/img/<?php echo $dt['icon'] ?>" width="20px">
                <span><?php echo $dt['nama']; ?></span></a>
        </li>
    <?php 
        } 
    ?>

</ul>
<!-- End of Sidebar -->