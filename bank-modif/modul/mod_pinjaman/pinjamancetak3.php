<?php
	echo "<link href='style.css' rel='stylesheet' type='text/css'>";
	include('../../../config/koneksi.php');
	$tanggal=date('Y-m-d');
	$id_pinjaman=$_GET[pinjaman];	
	$caripinjaman=mysql_query("SELECT * FROM pinjaman where id_pinjaman='$_GET[id]' ");		
	$rk=mysql_fetch_array($caripinjaman);
	//----------------------------------------------------- pinjaman primer
	$bungaprimer=($rk[bunga_primer]*$rk[tenor_primer])/100;
	$bungatampilprimer=$bungaprimer*100;
	$pokok=$rk[pinjaman_primer];
	$jumlahbungaprimer=$pokok*$bungaprimer;
	$totalpinjamanprimer=$pokok+$jumlahbungaprimer;
	$angsuranprimer=$totalpinjamanprimer/$rk[tenor_primer];
	//------------------------------------------------------ pinjman sekunder
	if ($rk[pinjaman_sekunder]!=0){
		$bungasekunder=($rk[bunga_sekunder]*$rk[tenor_sekunder])/100;
		$bungatampilsekunder=$bungasekunder*100;
		$pokoksekunder=$rk[pinjaman_sekunder];
		$jumlahbungasekunder=$pokoksekunder*$bungasekunder;
		$totalpinjamansekunder=$pokoksekunder+$jumlahbungasekunder;
		$angsuransekunder=$totalpinjamansekunder/$rk[tenor_sekunder];
	}	
	
	$tampil0=mysql_query("SELECT * FROM anggota where nik='$rk[nik]' ");
	$r0=mysql_fetch_array($tampil0);
	
	$tampil1=mysql_query("SELECT * FROM pinjamankategori where kd_pinjaman='$rk[kd_pinjaman]' ");
	$r1=mysql_fetch_array($tampil1);
	echo "
	<img src=../../images/logo.png width='200'><br>
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
			<td>Telepon</td><td>$r0[telp] / $r0[eselon] </td><td>Tanggal Lahir</td><td>$r0[tgl_lahir]</td>
		</tr>		
	</table>		
   <br>
	<h2>Pinjaman Primer</h2>
	<table width=100% border=1 cellspadding=0 cellspacing=0>
		<tr><td width=300>Jenis Pinjaman</td><td align=right>$r1[nama_pinjaman] | $rk[kd_pinjaman]</td></tr>
		<tr><td>Jumlah Pinjaman Primer </td><td align=right>".number_format($rk[pinjaman_primer])."</td></tr>
		<tr><td>Tenor Pinjaman Primer</td><td align=right>$rk[tenor_primer] Bulan</td></tr>
		<tr><td>Bunga Pinjaman Primer</td><td align=right>$rk[bunga_primer] %</td></tr>			
		<tr><td>Total Bunga Pinjaman Primer Selama $rk[tenor_primer] Bulan </td><td align=right>$bungatampilprimer %</td></tr>	
		<tr><td>Bunga Pinjaman</td><td align=right>".number_format($jumlahbungaprimer)."</td></tr>	
		<tr><td>Pokok + Bunga Pinjaman Primer</td><td align=right>".number_format($totalpinjamanprimer)."</td></tr>	
		<tr><td>Angsuran per Bulan</td><td align=right>".number_format($angsuranprimer)."</td></tr>			
	</table><br>";
	if ($rk[pinjaman_sekunder]!=0){
	echo "
		<h2>Pinjaman Sekunder</h2>
		<table width=100% border=1 cellspadding=0 cellspacing=0>
			<tr><td width=300>Jenis Potongan</td><td align=right>$rk[kd_pp]</td></tr>
			<tr><td>Jumlah Pinjaman Sekunder </td><td align=right>".number_format($rk[pinjaman_sekunder])."</td></tr>
			<tr><td>Tenor Pinjaman Sekunder</td><td align=right>$rk[tenor_sekunder] Kali potongan $rk[kd_pp]</td></tr>		
			<tr><td>Total Bunga Pinjaman Sekunder Selama $rk[tenor_sekunder] kali THR </td><td align=right>$bungatampilsekunder %</td></tr>	
			<tr><td>Bunga Pinjaman Sekunder</td><td align=right>".number_format($jumlahbungasekunder)."</td></tr>	
			<tr><td>Pokok + Bunga Pinjaman Sekunder</td><td align=right>".number_format($totalpinjaman)."</td></tr>	
			<tr><td>Angsuran per $rk[kd_pp]</td><td align=right>".number_format($angsuran)."</td></tr>			
		</table><br>";
	}
echo "
<b>PERNYATAAN:</b>
<br>
a. Angsuran pinjaman tersebut poin II tidak melebihi dari 30% x gaji sebulan<br>
b. Bersedia dipotong gaji dan pembayaran lain yang diterima dari perusahaan sebagai angsuran/pelunasan pinjaman<br>
c. Bersedia memberikan jaminan/angunan sesuai yang diminta oleh KKI sebagai persyaratan<br>
d. Pinjaman ini saya gunakan sesuai keperluan yang tercantum pada poin I<br>
		
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
?>
