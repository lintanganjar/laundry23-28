<!DOCTYPE html>
<html lang="en">
<?php
// mengimport file koneksi
include 'koneksi.php';
// memulai sesi
session_start();
// mengecek apakah cookie dengan nama username sudah diset
if (isset($_COOKIE['username'])) {
	// jika sudah maka men set session['username'] dengan data cookie['username']
	$_SESSION['username']=$_COOKIE['username'];
	// mengalihkan ke halaman index.php
	header("location:index.php");
} 
?>
<head>
	<!-- menginclude file head.php yang berisi css dll -->
	<?php include 'other/head.php'; ?>
	<title>E-Laundry - Login</title>
	<style>
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

<body class="bg-gradient-primary">
	<div class="container">
		<!-- Outer Row -->
		<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-12 col-md-9">
				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">                            
							<div class="col-lg-12">
								<div class="p-5">
									<div class="row">
										<div class="col-sm-2"></div>
										<div class="col-sm-2 ml-sm-3"><img src="assets/img/logo2.png" width="65px;"></div>
										<div class="col-sm-6">
											<table>
												<tr>
													<th><span class="brand">E-Laundry</span></th>
												</tr>
												<tr>
													<td><em>Bersih Rapi Wangi</em></td>
												</tr>
											</table>
										</div>
										<div class="col-sm-2"></div>
									</div>
									<br>
									<?php 
									// deklarasi variabel error dengan isi kosong
									$err="";
									// mengecek apakah server mengirimkan method post
									if ($_SERVER["REQUEST_METHOD"]=="POST") {
										// mengambil username dari input post['username']
										$username=$_POST['username'];
										// mengambil password dari input post['password'] kemudian diencrypt menggunakan md5
										$password=md5($_POST['password']);
										// deklarasi $query  yang berisi query untuk mengambil data user berdasarkan username yang di isikan
										$query = mysqli_query($conn, "SELECT * FROM `user` WHERE username='$username'");
										// deklarasi $data dan mengambil data hasil dari $query Disimpan menjadi array asosiatif
										$data = mysqli_fetch_assoc($query);
										// mengecek apakah $data['username']&password sudah diset
										if(isset($data['username'])&&isset($data['password'])){
											// mengecek apakah inputan $username dan $password sama dengan datapada database
											if ($username==$data['username'] && $password==$data['password']) {
												// menset session dengan nama username dengan isi dari variabel $username
												$_SESSION['username']=$username;
												// mengecek apakah tombol remember me di centang atau tidak
												if(isset($_POST['remember'])){
													// menset cookie dengan nama username dan diisi dari variabel username dengan batas waktu 1 jam
													setcookie("username", $username, time()+3600);
												}
												// mengalihkan halaman ke index.php
												header("location:index.php");	
											}
										}else{
											// jika $data['username'] belum diset (data user pada database tidak ada)
											// maka $err di isi dengan "Username atau password salah"
											$err="Username Atau Password Salah";
										}
									}
									?>
									<form class="user" method="post">
										<?php 
											// mengecek apakah varuabel $err tidak sama dengan ""
											if ($err!="") {
												// jika iya maka ditampilkan message error
												echo '<center><span class="small" style="color: red">'.$err.'</span></center>';
											}
										?>
										<div class="form-group">
											<input type="text" class="form-control form-control-user" name="username" placeholder="Username" required>		
										</div>
										<div class="form-group">
											<input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
										</div>
										<div class="form-group">
											<div class="custom-control custom-checkbox small">
												<input type="checkbox" class="custom-control-input" name="remember" id="customCheck">
												<label class="custom-control-label" for="customCheck">Remember
												Me</label>
											</div>
										</div>
										<button class="btn btn-primary btn-user btn-block" name="login">Login</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
<?php 
	// mengimport file footer2.php yang berisi script
	include 'other/footer2.php'; 
 ?>
	</html>