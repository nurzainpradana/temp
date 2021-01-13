<?php
echo "<link href='style.css' rel='stylesheet' type='text/css'>";
include('../../../config/koneksi.php');
echo "
	<h2>Pinjaman Koperasi</h2>
	<br>
	<br>
   <table width=100% border=1 cellspadding=0 cellspacing=0>
	<tr>
	<th>No</th><th>NIK</th>
	<th>Tanggal<br>Pencairan</th><th>Tanggal<br>Selesai</th>
	<th>Jumlah<br>Pinjaman</th><th>Tenor</th><th>Bunga</th>
	<th>B.Tambahan</th><th>Total Bunga</th>
	<th>Angsuran<br>/Bulan</th>
	<th>Pokok<br>/Bulan</th>
	<th>Bunga<br>/Bulan</th>
	<th>Total Angsuran</th>
	<th>Margin Koperasi</th>
	<th>Bunga Flat</th>
	</tr>"; 			
	//SELECT * FROM nama_tabel WHERE field_tgl < '2014-10-10';
	$tampil=mysql_query("SELECT * FROM pinjaman where tgl_akhir_angsur >= '2015-01-01' order by tgl_pengajuan desc");
	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		//$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		//$r2=mysql_fetch_array($tampil2);
		
		//$tampil3=mysql_query("SELECT * FROM pinjamankategori WHERE kd_pinjaman='$r[kode_pinjaman]' ");
		//$r3=mysql_fetch_array($tampil3);
		$keuntunganbunga=$r[total_angsuran]-$r[total_pinjaman];
		$bungaflat=$keuntunganbunga/$r[total_pinjaman]*100;
		$bungaflatnya=$bungaflat/$r[lama];
		$bungaflattahun=$bungaflatnya*12;
		echo "
		<tr><td>$no</td>
		<td>$r[nik]</td>
		<td>$r[tgl_cair]</td>
		<td>$r[tgl_akhir_angsur]</td>
		<td align=right>".number_format($r[total_pinjaman])."</td>
		<td>$r[lama]</td>
		<td>".round($r[jasa_bunga],2)."</td>
		<td>".round($r[tambah_bunga],2)."</td>
		<td>".round($r[total_bunga],2)."</td>
		<td align=right>".number_format($r[angsuran_perbulan])."</td>
		<td align=right>".number_format($r[pokok_perbulan])."</td>
		<td align=right>".number_format($r[bunga_perbulan])."</td>
		<td align=right>".number_format($r[total_angsuran])."</td>
		<td align=right>".number_format($keuntunganbunga)."</td>
		<td>".number_format($bungaflatnya,2)." | ".number_format($bungaflattahun,2)."</td>";
		$no++;
	}
	echo "
	</table><br><br>";
?>
