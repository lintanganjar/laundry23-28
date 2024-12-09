<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("location:../login.php");
}else{
  include '../koneksi.php';
  $username=$_POST['username'];
  $fotolama=$_POST['fotolama'];
  $namaSementara = $_FILES['foto']['tmp_name'];
  $dirUpload = "../assets/img/profil/";
  $namaFile=$username."_".$_FILES['foto']['name'];
  if (file_exists($dirUpload.$namaFile)) {
    unlink($dirUpload.$namaFile);
  }else{
    unlink($dirUpload.$fotolama);
  }
  $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);
  $exec = mysqli_query($conn, "UPDATE  user  SET  foto = '$namaFile' WHERE  username='$username' ");      
  if ($exec) {
    header("location:../profil.php") ;
  }else{
    echo "gagal";
}
}
?>
