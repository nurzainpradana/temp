<?php
	session_start();
	echo "<link href='style.css' rel='stylesheet' type='text/css'>";
	include('../../../config/koneksi.php');
	$tanggal=date('Y-m-d');
	$id_pinjaman=$_GET[pinjaman];	
	$caripinjaman=mysql_query("SELECT * FROM pinjaman where id_pinjaman='$_GET[id]' ");		
	$rk=mysql_fetch_array($caripinjaman);
	//----------------------------------------------------- pinjaman 
	$bunga=($rk[bunga]*$rk[tenor])/100;
	$bungatampil=$bunga*100;
	$pokok=$rk[pinjaman];
	$jumlahbunga=$pokok*$bunga;
	//$totalpinjaman=$pokok+$jumlahbunga;
	//$angsuran=$totalpinjaman/$rk[tenor];

	
	$tampil0=mysql_query("SELECT * FROM anggota where nik='$rk[nik]' ");
	$r0=mysql_fetch_array($tampil0);
	
	$tampil1=mysql_query("SELECT * FROM pinjamankategori where kode_pinjaman='$rk[kode_pinjaman]' ");
	$r1=mysql_fetch_array($tampil1);

	$tampil2=mysql_query("SELECT * FROM pinjamanjenis where jn_pinjaman='$rk[jn_pinjaman]' ");
	$r2=mysql_fetch_array($tampil2);
	
	echo "
	<img src=../../images/logo.png width='200'><br><br>
	Jl. Raya Nayor Oking - Cibinong 16961<br>
	Telp. 21 8750701, Fax. 021 8750701<br>
	<center>
		<h2>Surat Permohonan Pinjaman Koperasi</h2>
		No. Surat Pinjaman / SP-KKI / $rk[id_pinjaman]
	</center>
	<br>
	<h2>Pemohon Pinjaman</h2>
	<table width=100% border=1 cellspadding=0 cellspacing=0>
		<tr>
			<td>NIK</td><td>$r0[nik]</td><td>Nama</td><td>$r0[nama]</td>
		</tr>
		<tr>
			<td>Plant</td><td>$r0[id_divisi]</td><td>Section/Eselon</td><td>$r0[id_seksi] / $r0[eselon]</td>
		</tr>
		<tr>
			<td>Telepon</td><td>$r0[telp] </td><td>Tanggal Lahir</td><td>$r0[tgl_lahir]</td>
		</tr>		
	</table>		
   <br>
	<h2>Data Pinjaman</h2>
	<table width=100% border=1 cellspadding=0 cellspacing=0>
		<tr><td width=300>Kategori Pinjaman</td><td align=right>$r1[nama_pinjaman] | $rk[kode_pinjaman]</td></tr>
		<tr><td width=300>Jenis Pinjaman</td><td align=right>$r2[nama_jenis] | $rk[jn_pinjaman]</td></tr>		
		<tr><td>Permohonan Pinjaman  </td><td align=right>".number_format($rk[pinjaman])."</td></tr>
		<tr><td>Tenor Pinjaman </td><td align=right>$rk[tenor] Bulan / THR</td></tr>
		<tr><td>Bunga Pinjaman per Bulan </td><td align=right>".round($rk[bunga],2)." %</td></tr>			
		<tr><td>Perkiraan Angsuran per Bulan</td><td align=right>".number_format($rk[angsuran_perbulan])."</td></tr>			
		<tr><td>Perkiraan Tanggal Cair</td><td align=right>$rk[tgl_mulai]</td></tr>					
	</table><br>";
echo "
<b>PERNYATAAN:</b>
<br>
a. Angsuran pinjaman tersebut poin II tidak melebihi dari 30% x gaji sebulan<br>
b. Bersedia dipotong gaji dan pembayaran lain yang diterima dari perusahaan sebagai angsuran/pelunasan pinjaman<br>
c. Bersedia memberikan jaminan/angunan sesuai yang diminta oleh KKI sebagai persyaratan<br>
d. Pinjaman ini saya gunakan untuk <b>$rk[tujuan]</b> sesuai pengajuan ke KKI.<br>
		
<br>
Tanggal: $tanggal <br>
<table border=0 width=400>
	<tr>
		<td>Hormat kami,</td>
	</tr>		
  <tr height=110>
		<td valign=bottom>$_SESSION[namalengkap]<br>Staff Koperasi</td>
	</tr>	
</table>"; 
 mysql_query("UPDATE pinjaman SET s4='Y' WHERE id_pinjaman = '$_GET[id]'");
 echo "<br><br><br><br><br>
 
 NB:<br>
 Status pengajuan pinjaman dapat dilihat secara online di alamat: <br>
 https://simpin.onlinekki.com<br>
 username: [nomor nik]<br>
 password: [tanggal lahir] <br>contoh 19981129 [tahunbulantanggal] untuk tanggal lahir 29-11-1998";
 
?>
