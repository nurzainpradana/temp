<?php
echo "<link href='style.css' rel='stylesheet' type='text/css'>";
include('../../../config/koneksi.php');
echo "
	<h2>Pinjaman Non Reguler</h2>
	<br>
	<br>
   <table width=100% border=1 cellspadding=0 cellspacing=0>
	<tr>
	<th>No</th><th>NIK</th>
	<th>Tanggal<br>Pengajuan</th><th>Tanggal<br>Selesai</th>
	<th>Jenis Pinjaman</th><th>Jenis Kendaraan</th>
	<th>Tenor</th><th>UM THR</th><th>UM Tambahan</th>
	<th>Jumlah<br>pinjamannr</th><th>Total Bunga</th>
	<th>Jumlah Angsuran</th><th>Bunga Anuitas</th><th>Bunga Flat</th>
	<th>Bunga Bulanan</th>
	</tr>"; 			

	$tampil=mysql_query("SELECT * FROM pinjamannr where tgl_berakhir > '2015-08-30' order by tgl_berakhir");
	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		//$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		//$r2=mysql_fetch_array($tampil2);
		//$tampil3=mysql_query("SELECT * FROM pinjamannrkategori WHERE kd_pinjamannr='$r[kode_pinjamannr]' ");
		//$r3=mysql_fetch_array($tampil3);
		//$keuntunganbunga=$r[total_angsuran]-$r[total_pinjamannr];
		//$bungaflat=$keuntunganbunga/$r[total_pinjamannr]*100;
		//$bungaflatnya=$bungaflat/$r[lama];
		//$bungaflattahun=$bungaflatnya*12;
		echo "
		<tr><td>$no</td>
		<td>$r[nik]</td>
		<td>$r[tgl_pengajuan]</td>
		<td>$r[tgl_berakhir]</td>
		<td>$r[jenis_pinjaman]</td>
		<td>$r[jenis_kendaraan]&nbsp;</td>
		<td>$r[lama]</td>
		<td align=right>".number_format($r[um_thr])."</td>
		<td align=right>".number_format($r[um_tambahan])."</td>
		<td align=right>".number_format($r[pokok])."</td>
		<td align=right>".number_format($r[total_bunga])."</td>
		<td align=right>".number_format($r[total_angsuran])."</td>
		<td>".round($r[bunga_persen],2)."</td>
		<td>".round($r[bunga_flat],2)."</td>
		<td>".round($r[bunga_per_bulan],2)."</td>";
		$no++;
	}
	echo "
	</table><br><br>";
?>
