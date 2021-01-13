<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
?>
<head>
    <script language="javascript" type="text/javascript" src="jquery.min.js"></script>
	 <script language="javascript" type="text/javascript" src="showhide.js"></script>
</head>
<script type="text/javascript">
	$(document).ready(function() {
		 toggleFields(); 
		 $("#age").change(function() { toggleFields(); });

	});
	function toggleFields()
	{
		 if ($("#age").val() == 1)
			  $("#parentPermission").show();
		 else
			  $("#parentPermission").hide();
	}
</script>
<?php
$aksi="modul/mod_pinjamannr/aksi_pinjamannr.php";
$tanggal=date('Y-m-d');
switch($_GET[act]){
  // Tampil spk
  default:
    echo "
	<h2>Pinjaman Non Reguler</h2>
	<br>
   <table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No.</th><th>Keterangan</th>
	</tr>"; 			

	$tampil=mysql_query("SELECT * FROM pinjamannr where nik='$_SESSION[namauser]' order by tgl_pengajuan desc");
	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysql_fetch_array($tampil2);
		
		$tampil3=mysql_query("SELECT * FROM pinjamannrkategori WHERE kode_pinjamannr='$r[kode_pinjamannr]' ");
		//$r3=mysql_fetch_array($tampil3);
		echo "
		<tr>
			<td>$no</td>
			<td>
			Tenor: $r[tenor]
			<br>Jumlah: ".number_format($r[pinjamandisetujui])."
			<br>Angsuran: ".number_format($r[angsuran])."	
			<br>Tgl Mulai / selesai : $r[tgl_mulai] / $r[tgl_selesai]
			<br>Lunas: $r[lunas]
			<br><a href=?module=pinjamannr&act=angsuran&nik=$r[nik]&pinjamannr=$r[id_pinjamannr]><h3>RIWAYAT PEMBAYARAN</a>
		</tr>";
		//<a href=?module=pinjamannrdetail&nik=$r[nik]&pinjamannr=$r[id_pinjamannr]><i class='fa fa-check'></i></a> &nbsp;
		//<a href=?module=pinjamannrkprdetail&nik=$r[nik]&pinjamannr=$r[id_pinjamannr]><i class='fa fa-check'></i></a> &nbsp;
		$no++;
	}
	echo "
	</table>";	
	break;
	case "angsuran":
	$tampil=mysql_query("SELECT * FROM pinjamannr where id_pinjamannr='$_GET[pinjamannr]'");
	$r=mysql_fetch_array($tampil);
 		$jumlah_pinjaman=0;
		$lama_pinjaman=0;
		$bunga_pinjaman=0;
		
		$jumlah_pinjaman=$r['pinjamandisetujui'];
		$lama_pinjaman=$r['tenor'];
		$bunga_pinjaman=18;		
		
		$bunga_pinjaman1=$bunga_pinjaman/100;
		$lamapertahun=$lama_pinjaman/12;
		$bungaperbulan=$bunga_pinjaman/12;
		
		$a=($jumlah_pinjaman*($bunga_pinjaman1/12));
		$d=(1+($bunga_pinjaman1/12));
		$c=pow($d,$lama_pinjaman);
		$b=(1-1/$c);
		$angsuranperbulan=$a/$b;

		?>
		<h2>Pinjaman Koperasi Anda</h2>
		<table id='example1' class='table table-bordered table-striped'>
				<td>Jumlah Pinjaman</td>
				<td><?php echo number_format($jumlah_pinjaman); ?> </td>
			</tr>
			<tr>
				<td>Lama Pinjaman</td>
				<td><?php echo $lama_pinjaman ?> Bulan - <?php echo round($lamapertahun,2) ?> Tahun</td>
			</tr>
			<tr>
				<td>Bunga PerTahun</td>
				<td><?php echo $bunga_pinjaman ?> %/Tahun (<?php echo number_format($bungaperbulan,2) ?> %/ Bulan)</td>
			</tr>
			<tr>
				<td>Perhitungan Bunga</td>
				<td>Anuitas</td>
			</tr>
				<tr>
				<td>Angsuran per Bulan</td>
				
				<td><?php echo number_format($angsuranperbulan,2) ?> </td>
			</tr>	
		</table>
				<h2>Tabel Angsuran</h2>
		<table id='example1' class='table table-bordered table-striped'>
			<tr>
				<th>Bulan</td>
				<th>Tanggal</td>
				<th>Total Angsuran</td>
				<th>Sisa Hutang Pokok</td>
			</tr>
			<tr>
				<td>0</td>
				<td>0</td>
				<td>0</td>
				<td align=right><?php echo number_format($jumlah_pinjaman) ?></td>
			</tr>
			<?php 
				$angsuran_pokok=0;
				$jumlah_angsuran_bunga=0;
				$jumlah_angsuran_pokok=0;
				$jumlah_total_angsuran=0;
				//while (strtotime($date) <= strtotime($end_date)) {	 
				$tanggal = "$r[tgl_mulai]";
				for ($i = 1; $i <= $lama_pinjaman; $i++) { 
					
					//Decision untuk angsuran bunga pertama kali
					if($i==1){
						$angsuran_bunga=$jumlah_pinjaman*($bunga_pinjaman1/12);
					}else{
						$angsuran_bunga=$sisa_uang*($bunga_pinjaman1/12);
					}
					
					$angsuran_pokok=$angsuranperbulan-$angsuran_bunga;
					
					//Decision untuk sisa pinjaman pokok yang pertama kali
					if($i==1){
						$sisa_uang=$jumlah_pinjaman-$angsuran_pokok;
					}else{
						$sisa_uang=$sisa_uang-$angsuran_pokok;
					}
					
					$jumlah_angsuran_bunga=$jumlah_angsuran_bunga+$angsuran_bunga;
					$jumlah_angsuran_pokok=$jumlah_angsuran_pokok+$angsuran_pokok;
					$jumlah_total_angsuran=$jumlah_total_angsuran+$angsuranperbulan;
					$bunga=($jumlah_total_angsuran-$jumlah_angsuran_pokok)/$jumlah_angsuran_pokok*100;
					$tanggal = date('Y-m-d', strtotime('+1 month', strtotime($tanggal))); 
					/*
					mysql_query("INSERT INTO angsurannrdetail VALUES('$_GET[nik]',
																													'03',
																													'$_GET[pinjamannr]',
																													'$i',
																													'$jumlah_angsuran_bunga',
																													'$jumlah_angsuran_pokok',
																													'$angsuranperbulan',
																													'$tanggal')");
																													*/
					 																								
			?>
				<tr>
					<td><?php echo $i ?></td>
					<td align=right><?php echo $tanggal ?></td>
					<td align=right><?php echo number_format($angsuranperbulan) ?></td>
					<td align=right><?php echo number_format($sisa_uang) ?></td>
				</tr>
			<?php	}//}	?>
			<tr>
				<td colspan=2>Total</td>
				<td align=right><?php echo number_format($jumlah_total_angsuran) ?></td><!--Jumlah total angsuran-->
				<td><?php echo round($bunga,2); ?> %</td>
			</tr>
		</table>
	<?php
	$pokokbunga=$jumlah_angsuran_bunga/$lama_pinjaman;
	$pokokhutang=$jumlah_angsuran_pokok/$lama_pinjaman;
	$angsuran=$pokokbunga+$pokokhutang;
	echo "
	Pokok bunga per bulan: ".number_format($pokokbunga)."<br>
	Pokok Pinjaman per bulan: ".number_format($pokokhutang)." <br>
	Total Angsuran per bulan: ".number_format($angsuran)." <br>
	";
	break;
}
}
?>
