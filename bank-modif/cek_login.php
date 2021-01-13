<?php
include "config/koneksi.php";
/*function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}*/

$username = $_POST['username'];
$pass     = md5($_POST['password']);

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "Sekarang loginnya tidak bisa di injeksi lho.";
}
else{
$login=mysqli_query($koneksi,"SELECT * FROM users WHERE username='$username' AND password='$pass' ");
$ketemu=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();

  $_SESSION['namauser']     = $r['username'];
  $_SESSION['namalengkap']  = $r['nama_lengkap'];
  $_SESSION['passuser']     = $r['password'];
  $_SESSION['leveluser']    = $r['level'];
  $_SESSION['poto']  				= $r['foto'];
	$_SESSION['iduser']  				= $r['id_user'];
	$_SESSION['iddept']  				= $r['id_departemen'];
	$_SESSION['idseksi']  				= $r['id_seksi'];
 
  // session timeout
  $_SESSION['login'] = 1;

	$sid_lama = session_id();
	session_regenerate_id();
	$sid_baru = session_id();
  mysqli_query($koneksi,"UPDATE users SET id_session='$sid_baru' WHERE username='$username'");
  header('location:media.php?module=home');
}
else{
  include "error-login.php";
}
}
?>
