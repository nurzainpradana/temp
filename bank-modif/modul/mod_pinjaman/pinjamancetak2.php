<?php
	echo "<link href='style.css' rel='stylesheet' type='text/css'>";
	include('../../../config/koneksi.php');
	$tanggal=date('Y-m-d');
	$id_pinjaman=$_GET[pinjaman];	
	$caripinjaman=mysql_query("SELECT * FROM pinjaman where id_pinjaman='$_GET[id]' ");		
	$rk=mysql_fetch_array($caripinjaman);
	$bunga=($rk[bunga]*$rk[tenor_primer])/100;
	$bungatampil=$bunga*100;
	$pokok=$rk[pinjaman_primer]-$rk[jumlah_dp];
	$jumlahbunga=$pokok*$bunga;
	$totalpinjaman=$pokok+$jumlahbunga;
	$angsuran=$totalpinjaman/$rk[tenor_primer];

	$tampil0=mysql_query("SELECT * FROM anggota where nik='$rk[nik]' ");
	$r0=mysql_fetch_array($tampil0);
	echo "
	<img src=../../images/logo.png width='300'><br>
	<center>
		<h2>Surat Permohonan Pinjaman Koperasi</h2>
		No. Surat Pinjaman / SP-KKI / $rk[id_pinjaman]
	</center>
	<br><br><br><br>
	Yang bertanda tangan dibawah ini: <br><br>
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
   <br><br>     
	Mengajukan pinjaman koperasi dengan ketentuan sebagai berikut:<br><br>
	<table width=100% border=1 cellspadding=0 cellspacing=0>
		<tr>
			<td>Jenis Pinjaman</td><td align=right>$rk[kd_pinjaman]</td>
		</tr>
		<tr>
			<td>Jumlah Pinjaman</td><td align=right>".number_format($rk[pinjaman_primer])."</td>
		</tr>
		<tr>
			<td>Lama Pinjaman</td><td align=right>$rk[tenor_primer] Bulan</td>
		</tr>		
			<tr>
			<td>Bunga Pinjaman</td><td align=right>$bungatampil %</td>
		</tr>	
		<tr>
			<td>Bunga Pinjaman</td><td align=right>".number_format($jumlahbunga)."</td>
		</tr>	
		<tr>
			<td>Pokok + Bunga Pinjaman</td><td align=right>".number_format($totalpinjaman)."</td>
		</tr>	
		<tr>
			<td>Angsuran per Bulan</td><td align=right>".number_format($angsuran)."</td>
		</tr>			
	</table>
	  <br><br> 
		Detail Pinjaman Kendaraan<br>		
		<table width=100% border=1 cellspadding=0 cellspacing=0>
			<tr>
				<th>No</th>
				<th>Merk</th>
				<th>Model</th>
				<th>Varian</th>
				<th>Transmisi</th>
				<th>Warna</th>
				<th>Tahun</th>
				<th>Harga Kendaraan</th>	
				<th>Jumlah DP</th>							
				<th>Total</th>				
			</tr>"; 
		$no=1;
    $tampil1=mysql_query("SELECT * FROM pinjamanmbldetail where id_pinjaman='$_GET[id]' ");

		while ($r1=mysql_fetch_array($tampil1)){
				$carimerk=$r1[id_merk];
				$carimodel=$r1[id_model];
				$carivarian=$r1[id_varian];
				$tampil_merk=mysql_query("SELECT * FROM merk where id_merk='$carimerk' ");  
				$tampil_model=mysql_query("SELECT * FROM model where id_model='$carimodel' ");  
				$tampil_varian=mysql_query("SELECT * FROM varian where id_varian='$carivarian' ");  
				$r10=mysql_fetch_array($tampil_merk);
				$r11=mysql_fetch_array($tampil_model);
				$r12=mysql_fetch_array($tampil_varian);
				$jumlah=$r1[harga_beli]-$r1[harga_dp];
				echo "
				<tr>
					<td>$no </td>
					<td>$r10[nama_merk]</td>
					<td>$r11[nama_model] </td>
					<td>$r12[nama_varian] </td>
					<td align=center>$r1[transmisi]</td>
					<td>$r1[warna]</td>
					<td align=center>$r1[tahun]</td>				
					<td align=right>".number_format($r1[harga_beli])."</td>
					<td align=right>".number_format($r1[harga_dp])."</td>
					<td align=right>".number_format($jumlah)."</td>";
				echo "</tr>";
				$totalqty=$totalqty+$r1[qty];
				$no++;
				if ($rk[s4]=='N') {
										mysql_query("insert into pinjamanmbldetailalokasi (id_pinjamanmbldetail, 
																							id_pinjaman, 
																							id_merk, 
																							id_model, 
																							id_varian, 
																							transmisi, 
																							warna, 
																							tahun, 
																							harga_sewa,
																							harga_driver,
																							komisi,
																							nopol,
																							nopol_pengganti) 
																		values ('$r1[id_pinjamanmbldetail]',
																						'$r1[id_pinjaman]',
																						'$r1[id_merk]',
																						'$r1[id_model]',
																						'$r1[id_varian]',	
																						'$r1[transmisi]',
																						'$r1[warna]',
																						'$r1[tahun]',
																						'$r1[harga_sewa]',
																						'$r1[harga_driver]',
																						'$r1[komisi]',
																						'NONE',
																						'NONE',
																						'$lama_sewa') ");																					
				
				}	
		}
    echo "	
		</table>";
		echo "	
	  <br><br> 
		Detail Pinjaman Perumahan<br>		
		<table width=100% border=1 cellspadding=0 cellspacing=0>
			<tr>
				<th>No</th>
				<th>Luas Tanah</th>
				<th>Luas Bangunan</th>
				<th>Harga Beli</th>	
				<th>Jumlah DP</th>							
				<th>Total</th>				
			</tr>"; 
		$no=1;
    $tampil1=mysql_query("SELECT * FROM pinjamankprdetail where id_pinjaman='$_GET[id]' ");

		while ($r1=mysql_fetch_array($tampil1)){
				$jumlah=$r1[harga_beli]-$r1[harga_dp];
				echo "
				<tr>
					<td>$no </td>
					<td>$r1[luas_tanah]</td>
					<td>$r1[luas_bangunan] </td>			
					<td align=right>".number_format($r1[harga_beli])."</td>
					<td align=right>".number_format($r1[harga_dp])."</td>
					<td align=right>".number_format($jumlah)."</td>";
				echo "</tr>";
				$totalqty=$totalqty+$r1[qty];
				$no++;
		}
    echo "	
		</table>";		
echo "
<br><br>
<b>PERJANJIAN:</b>
<br>

a. Bersedia membayar angsuran pinjaman sebesar ".number_format($angsuran)." sebulan<br>
b. Lama pinjaman $rk[tenor_primer] bulan<br>
c. Bunga pinjaman $rk[bunga] % x sisa pinjaman<br><br><br>

<b>PERNYATAAN:</b>
<br>

a. Angsuran pinjaman tersebut poin II tidak melebihi dari 30% x gaji sebulan<br>
b. Bersedia dipotong gaji dan pembayaran lain yang diterima dari perusahaan sebagai angsuran/pelunasan pinjaman<br>
c. Bersedia memberikan jaminan/angunan sesuai yang diminta oleh KKI sebagai persyaratan<br>
d. Pinjaman ini saya gunakan sesuai keperluan yang tercantum pada poin I<br>

<br><b>Ketentuan Tambahan :</b> </br>
".nl2br($keterangan)." <br><br>	
Demikian Surat Permohonan ini saya ajukan, atas perhatiannya diucapkan terimakasih.
		
<br><br>		
Tanggal: $tanggal <br>
<table border=0 width=800>
	<tr>
		<td>Hormat kami,</td>
		<td>Persetujuan Anggota</td>
	</tr>		
  <tr height=150>
		<td valign=bottom>Nama: $_SESSION[namalengkap]<br>Jabatan: Staff Koperasi</td>
		<td valign=bottom>Nama: $r0[nama] <br>Telp:$r0[telp]</td>
	</tr>	
</table>"; 
 mysql_query("UPDATE pinjaman SET s4='Y' WHERE id_pinjaman = '$_GET[id]'");
?>
