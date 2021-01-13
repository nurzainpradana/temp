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
if ($module=='pinjaman' AND $act=='hapus'){
  // mysql_query("DELETE FROM pinjaman WHERE id_pinjaman='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input pinjaman
if ($module=='pinjaman' AND $act=='input'){
	$tampil1=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[nik]' ");
	$r1=mysql_fetch_array($tampil1);
	// Kirim email ke pengelola toko online
	$subjek="Pengajuan Pinjaman Koperasi";
	$dari = "From: info@kki.web.id \n";
	$dari .= "Content-type: text/html \r\n";
	$pesan="<h3>Permohonan Pinjaman Koperasi</h3><br/>
	   NIK: $_POST[nik] <br/>
      Nama: $_POST[nama] <br/>
		Tanggal Mulai: $_POST[tgl_mulai] <br/>
		Lama Pinjaman: $_POST[tenor] Bulan <br/>
		Ketentuan Tambahan: $_POST[keterangan] <br/>
		Counter: $_SESSION[id_user]<br/>
		Cabang: $_POST[id_cabang]";
	//mail("daniyusuf@yahoo.com",$subjek,$pesan,$dari);
	//mail("daniyusuf@gmail.com",$subjek,$pesan,$dari);
	mysql_query("INSERT INTO pinjaman(kd_pinjaman,
										nik,
										tgl_pengajuan, 
										jam_pengajuan,
										tgl_mulai,
										tgl_selesai,
										pinjaman, 
										tenor,
										bunga,
										 id_cabang,
										 id_user,
										 tujuan,
										 keterangan) 
                        VALUES (
								'$_POST[kd_pinjaman]',
								'$_POST[nik]',
								'$_POST[tgl_pengajuan]',
								sysdate(),
								'$_POST[tgl_mulai]',
								'$_POST[tgl_selesai]',		
								'$_POST[pinjaman]',	
								'$_POST[tenor]',
								'$_POST[bunga]',
								'$_POST[id_cabang]',
								'$_POST[id_user]',
								'$_POST[tujuan]',
								'$_POST[keterangan]')");
  header('location:../../media.php?module='.$module);

}


// Update pinjaman
elseif ($module=='pinjaman' AND $act=='update'){
	$s1 = strtoupper($_POST[s1]);
	$s2 = strtoupper($_POST[s2]);
	$s3 = strtoupper($_POST[s3]);
	$s4 = strtoupper($_POST[s4]);
	$s5 = strtoupper($_POST[s5]);
	mysql_query("UPDATE pinjaman SET kd_pinjaman='$_POST[kd_pinjaman]',
												nik='$_POST[nik]',
												tgl_pengajuan='$_POST[tgl_pengajuan]',
												tgl_mulai='$_POST[tgl_mulai]',
												tgl_selesai='$_POST[tgl_selesai]',		
												pinjaman='$_POST[pinjaman]',											
												pinjamandisetujui='$_POST[pinjamandisetujui]',	
												tenor='$_POST[tenor]',
												bunga='$_POST[bunga]',
												tujuan='$_POST[tujuan]',
												keterangan='$_POST[keterangan]',
												s1='$s1',
												s2='$s2',
												s3='$s3',
												s4='$s4',
												s5='$s5'
												WHERE id_pinjaman = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}
}
?>
