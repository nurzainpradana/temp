<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";
include "../../config/fungsi_thumb.php";
$module=$_GET['module'];
$act=$_GET['act'];

// Input user
if ($module=='profil' AND $act=='input'){
  $pass=md5($_POST[password]);
  mysqli_query($koneksi, "INSERT INTO users(username,
                                 password,
                                 nama_lengkap,
                                 email, 
                                 no_telp) 
	                       VALUES('$_POST[username]',
                                '$pass',
                                '$_POST[nama_lengkap]',
                                '$_POST[email]',
                                '$_POST[no_telp]')");
  header('location:../../media.php?module='.$module);
}

// Update pinjaman
elseif ($module=='profil' AND $act=='update'){
	$lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $acak           = rand(1,999);
  $nama_file_unik = $acak.$nama_file; 
	if (empty($lokasi_file)){
		mysqli_query($koneksi, "UPDATE anggota SET 										
													email='$_POST[email]',
													telp='$_POST[telp]'
													WHERE nik = '$_POST[nik]' ");
		 header('location:../../media.php?module='.$module);
	}
	else {
		UploadImage2($nama_file_unik);	
		mysqli_query($koneksi, "UPDATE users SET foto='$nama_file_unik' WHERE username = '$_POST[nik]' ");		
		mysqli_query($koneksi, "UPDATE anggota SET 
													email='$_POST[email]',
													telp='$_POST[telp]'
													WHERE nik = '$_POST[nik]' ");
	header('location:../../media.php?module='.$module);		
	}
}
}
?>
