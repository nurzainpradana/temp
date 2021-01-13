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

// Hapus servis
if ($module=='pinjaman' AND $act=='hapus'){
  //mysql_query("DELETE FROM pinjaman WHERE id_pinjaman='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input pinjaman
if ($module=='pinjaman' AND $act=='input'){
	$tampil1=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik ='$_SESSION[namauser]' ");
	$r1=mysqli_fetch_array($tampil1);
	$cari=mysqli_query($koneksi, "SELECT * FROM pinjaman WHERE nik ='$_SESSION[namauser]' and lunas !='Y' ");
	$c=mysqli_fetch_array($cari);	
	$ketemu=mysqli_num_rows($cari);
	if ($ketemu > 0){
		echo "<center><H1>Maaf Anda masih memiliki pinjaman yang belum lunas...</h1></center>";
		echo "<center><H1><a href=../../media.php?module=home>Back</h1></a></center>";
		return;
	}		
	// Kirim email ke pengelola toko online
	$subjek="Pengajuan Pinjaman Koperasi";
	$dari = "From: info@koperasi-ubharajaya.com \n";
	$dari .= "Content-type: text/html \r\n";
	$pesan="<h3>Permohonan Pinjaman Koperasi</h3><br/>
	NIK: $_SESSION[namauser] <br/>
	Lama Pinjaman: $_POST[tenor] <br/>
	Jumlah Pinjaman: $_POST[pinjaman] <br/>
	";
	//mail("daniyusuf@yahoo.com",$subjek,$pesan,$dari);
	//mail("daniyusuf@gmail.com",$subjek,$pesan,$dari);
	//Inisialisasi
$tanggal=date("Y-m-d");
		
	
			mysqli_query($koneksi, "INSERT INTO pinjaman(
											nik,
											tgl_pengajuan, 
											pinjaman, 
											tenor,
											bunga,
											keterangan,
											angsuran_perbulan,
											nohp) 
					VALUES (
									'$_SESSION[namauser]',
									sysdate(),							
									'$_POST[pinjaman]',	
									'$_POST[tenor]',
									'$_POST[bunga]',
									'$_POST[keterangan]',
									'$_POST[angsuran]',
									'$_POST[nohp]' )");
	header('location:../../media.php?module='.$module);	
}


// Update pinjaman
elseif ($module=='pinjaman' AND $act=='update'){
	$s1 = strtoupper($_POST[s1]);
	$s2 = strtoupper($_POST[s2]);
	$s3 = strtoupper($_POST[s3]);
	$s4 = strtoupper($_POST[s4]);
	$s5 = strtoupper($_POST[s5]);
	$s5 = strtoupper($_POST[s5]);
	$lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $acak           = rand(1,999);
  $nama_file_unik = $acak.$nama_file; 
	if (empty($lokasi_file)){
		mysql_query("UPDATE pinjaman SET 
													no_bukti=id_pinjaman,
													kode_pinjaman='$_POST[kode_pinjaman]',
													nik='$_POST[nik]',
													tgl_mulai='$_POST[tgl_mulai]',
													tgl_selesai='$_POST[tgl_selesai]',		
													pinjaman='$_POST[pinjaman]',											
													pinjamandisetujui='$_POST[pinjamandisetujui]',	
													tenor='$_POST[tenor]',
													bunga='$_POST[bunga]',
													keterangan='$_POST[keterangan]',
													gajiterakhir='$_POST[gajiterakhir]',
													nohp='$_POST[nohp]',
													s1='$s1',
													s2='$s2',
													s3='$s3',
													s4='$s4',
													s5='$s5'
													WHERE id_pinjaman = '$_POST[id]' and tgl_pengajuan >='2019-01-01' ");
		header('location:../../media.php?module='.$module);
	}
	else {
		UploadImage($nama_file_unik);	
		mysql_query("UPDATE pinjaman SET 
													no_bukti=id_pinjaman,
													kode_pinjaman='$_POST[kode_pinjaman]',
													nik='$_POST[nik]',
													tgl_mulai='$_POST[tgl_mulai]',
													tgl_selesai='$_POST[tgl_selesai]',		
													pinjaman='$_POST[pinjaman]',											
													pinjamandisetujui='$_POST[pinjamandisetujui]',	
													tenor='$_POST[tenor]',
													bunga='$_POST[bunga]',
													keterangan='$_POST[keterangan]',
													gajiterakhir='$_POST[gajiterakhir]',
													slipgaji='$nama_file_unik',
													nohp='$_POST[nohp]',
													s1='$s1',
													s2='$s2',
													s3='$s3',
													s4='$s4',
													s5='$s5'
													WHERE id_pinjaman = '$_POST[id]' and tgl_pengajuan >='2019-01-01' ");
		header('location:../../media.php?module='.$module);
	}
}
}
?>
