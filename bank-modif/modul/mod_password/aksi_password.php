<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
	<center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	include "../../config/koneksi.php";
	$pass_baru=md5($_POST['pass_baru']);
	$pass_ulangi=md5($_POST['pass_ulangi']);
	$username=$_SESSION['username'];
	if (empty($_POST['pass_baru']) OR empty($_POST['pass_ulangi'])){
		echo "<p align=center>Passwor kurang lengkap, atau tidak sama...<br />"; 
		echo "<a href=javascript:history.go(-1)><b>Ulangi Lagi</b></a></p>";
	}
	else{ 
  // Pastikan bahwa password baru yang dimasukkan sebanyak dua kali sudah cocok
		if ($pass_baru==$pass_ulangi){
			mysqli_query($koneksi, "UPDATE users SET password = '$pass_baru' where username='$username' ");
			header('location:../../media.php?module=home');
		}
		else{
			echo "<p align=center>Password baru yang Anda masukkan sebanyak dua kali belum cocok.<br />"; 
			echo "<a href=javascript:history.go(-1)><b>Ulangi Lagi</b></a></p>";  
		}
	}
}

?>
