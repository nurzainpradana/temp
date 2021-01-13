<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];
$ip=$_SERVER['REMOTE_ADDR'];
// Input pesan
if ($module=='pesan' AND $act=='input'){
    mysql_query("INSERT INTO pesan VALUES('NULL','$ip',
                                             '$_POST[nama]',
                                             sysdate(),
                                             '$_POST[pesan]')");
  header('location:../../media.php?module='.$module);
}

// Update pesan
elseif ($module=='pesan' AND $act=='update'){
    mysql_query("UPDATE pesan SET nama='$_POST[nama]',
                                     alamat='$_POST[alamat]',
                                     kota='$_POST[kota]',
                                     telp='$_POST[telp]',
                                     email='$_POST[email]',
																		 keterangan='$_POST[keterangan]',
                                     ppn='$_POST[ppn]'
                           WHERE  id_pesan     = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}

// Hapus pesan
elseif ($module=='pesan' AND $act=='hapus'){
    mysql_query("delete from pesan
                           WHERE  id_pesan     = '$_GET[id]'");
  header('location:../../media.php?module='.$module);
}


}
?>
