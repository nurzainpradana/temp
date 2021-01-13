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

// Hapus servis
if ($module=='trpenarikan' AND $act=='hapus'){
  //mysql_query("DELETE FROM rekeningss WHERE id_rekeningss='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}
$tanggal=date('Y-m-d');
// Input simpanan
if ($module=='penarikan' AND $act=='input'){
	mysql_query("INSERT INTO penarikandetail(
										tanggal,
										nik, 
										total_tarik,
										keterangan) 
            VALUES (
								'$tanggal',			
								'$_POST[nik]',	
								'$_POST[total_tarik]',
								'$_POST[keterangan]'	)");
  header('location:../../media.php?module='.$module);

}


// Update simpanan
elseif ($module=='penarikan' AND $act=='update'){
	$s1 = strtoupper($_POST[s1]);
	$s2 = strtoupper($_POST[s2]);
	mysql_query("UPDATE penarikandetail SET
												tgl_cair='$_POST[tgl_cair]',
												total_tarik='$_POST[total_tarik]',
												keterangan='$_POST[keterangan]',
												s1='$s1'
												WHERE id_penarikandetail = '$_POST[id]'");
  header('location:../../media.php?module='.$module);

}
}
?>
