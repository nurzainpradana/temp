<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

if ($module=='dokumen' AND $act=='hapus'){
  mysqli_query($koneksi,"DELETE FROM dokumen WHERE id_dokumen='$_GET[id]'");
  header('location:../../media.php?module='.$module);
}

// Input dokumen
elseif ($module=='dokumen' AND $act=='input'){
  mysqli_query($koneksi,"INSERT INTO dokumen(nomor_dokumen,
																		nama_dokumen,
                                      tgl_dokumen,
                                      tgl_diterima,
                                      id_kategori,
																			id_sifatdokumen,
                                      keterangan,
																			username)

                              VALUES('$_POST[nomor_dokumen]',
																		'$_POST[nama_dokumen]',
                                     '$_POST[tgl_dokumen]',
                                     sysdate(),
                                     '$_POST[id_kategori]',
																		 '$_POST[id_sifatdokumen]',
                                     '$_POST[keterangan]',
																		 '$_SESSION[namauser] ')");
// Kirim email ke Kepala BBLK
$subjek="Dokumen Baru";
$dari = "From: daniyusuf@yahoo.com \n";
$dari .= "Content-type: text/html \r\n";
$pesan="Ada dokumen bary yang perlu dilihat:<br />
        Nama Dokumen: $_POST[nama_dokumen] <br />
        Keterangan: $_POST[keterangan] <br />
				Tanggal Dokumen: $_POST[tgl_dokumen] <br />	";
/*				
mail("daniyusuf@gmail.com",$subjek,$pesan,$dari);
mail("dwi.yudha@1firstrent.com",$subjek,$pesan,$dari); 
mail("suryo@1firstrent.com",$subjek,$pesan,$dari);
*/																		 
  header('location:../../media.php?module='.$module);
}

// Update dokumen
elseif ($module=='dokumen' AND $act=='update'){
  mysqli_query($koneksi,"UPDATE dokumen SET nomor_dokumen='$_POST[nomor_dokumen]',
																	nama_dokumen='$_POST[nama_dokumen]',
                                     tgl_dokumen='$_POST[tgl_dokumen]',
                                     tgl_diterima='$_POST[tgl_diterima]',
                                     id_kategori='$_POST[id_kategori]',
                                     keterangan='$_POST[keterangan]'
               WHERE id_dokumen = '$_POST[id]'");
  header('location:../../media.php?module='.$module);
}
// Update dokumen
elseif ($module=='dokumen' AND $act=='disposisi'){
	$chk=$_POST['chk'];
	mysqli_query($koneksi,"update disposisi set view ='0' where id_dokumen='$_POST[id]' ");
	foreach($chk as $id){
		mysqli_query($koneksi,"update disposisi set view ='1' where id_disposisi = '$id' ");
		
	}
	/*
  mysqli_query("INSERT INTO disposisi(id_dokumen,
																		id_departemen,
																		tgl_disposisi)
                              VALUES('$_POST[id]',
																		'$_POST[id_departemen]',
																		sysdate()
																		)");

  mysqli_query("UPDATE dokumen SET disposisi='$_POST[disposisi]' WHERE id_dokumen = '$_POST[id]'");			
	$tampil=mysqli_query("SELECT * FROM departemen ORDER BY nama_departemen");
	while($r=mysqli_fetch_array($tampil)){	
	
	}
 */	
  header("location:../../media.php?module=dokumen&act=distribusi&id=$_POST[id]");

}
// Update dokumen
elseif ($module=='dokumen' AND $act=='disposisi2'){
  mysqli_query($koneksi,"INSERT INTO disposisi(id_dokumen,
																		id_seksi,
																		tgl_disposisi)
                              VALUES('$_POST[id]',
																		'$_POST[id_seksi]',
																		sysdate()
																		)");
			 
 header("location:../../media.php?module=dokumen&act=distribusi&id=$_POST[id]");
}
// Update dokumen
elseif ($module=='dokumen' AND $act=='hapusdisposisi'){
  mysqli_query($koneksi,"DELETE FROM disposisi WHERE id_disposisi='$_GET[id]'");
  header("location:../../media.php?module=dokumen&act=distribusi&id=$_GET[idd]");
}
// Update dokumen
elseif ($module=='dokumen' AND $act=='lajur'){
	$chk=$_POST['lajur'];
	mysqli_query("update lajurdetail set view ='0' where id_dokumen='$_POST[id]' ");
	foreach($chk as $id){
		//echo "Update record dengan id = $id <br>";
		mysqli_query("update lajurdetail set view ='1' where id_lajurdetail = '$id' ");
		
	}		 
 header("location:../../media.php?module=dokumen&act=distribusi&id=$_POST[id]");
}
// Update dokumen
elseif ($module=='dokumen' AND $act=='hapuslajur'){
  mysqli_query($koneksi,"DELETE FROM lajurdetail WHERE id_lajurdetail='$_GET[id]'");
  header("location:../../media.php?module=dokumen&act=distribusi&id=$_GET[idd]");
}
// Update dokumen
elseif ($module=='dokumen' AND $act=='komentar'){
  mysqli_query($koneksi,"INSERT INTO komentar(id_dokumen,
																		id_user,
																		tgl_komentar,
																		komentar)
                              VALUES('$_POST[id]',
																		'$_SESSION[iduser]',
																		sysdate(),
																		'$_POST[komentar]'
																		)");				 
 header("location:../../media.php?module=dokumen&act=distribusi&id=$_POST[id]");
}
}
?>
