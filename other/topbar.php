<?php 
	// include file koneksi.php
	include 'koneksi.php';
	// query mengambil data dari user berdasarkan username
	$query = mysqli_query($conn, "SELECT * FROM `user` WHERE username='".$_SESSION['username']."'");
	$user=mysqli_fetch_assoc($query);
 ?>
<ul class="navbar-nav ml-auto">
	<!-- Nav Item - User Information -->
	<li class="nav-item dropdown no-arrow">
		<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
		data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="mr-2 d-none d-lg-flex text-gray-600"><?php echo $user['nama']; ?></span>
		<img class="rounded-circle" style="width: 45px;" src="assets/img/profil/<?php echo $user['foto'] ?>">
		
	</a>
	<!-- Dropdown - User Information -->
	<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
	aria-labelledby="userDropdown">
	<a class="dropdown-item" href="profil.php">
		<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
		Profil
	</a>
	<div class="dropdown-divider"></div>
	<a class="dropdown-item" href="logout.php">
		<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
		Logout
	</a>
	</div>
	</li>
</ul>