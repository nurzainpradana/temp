<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
?>
<?php
error_reporting(0);
$aksi="modul/mod_simpanan/aksi_simpanan.php";
$tanggal=date('Y-m-d');
switch($_GET[act]){
  // Tampil spk
  default:
			$tampil=mysql_query("SELECT * FROM anggota WHERE nik ='$_SESSION[namauser]' ");
			$r1=mysql_fetch_array($tampil);
			echo "
			<h2>Data Anggota</h2>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td colspan=2><b>Data Anggota</b></td></tr>
				<tr><td>NIK</td> <td> <input type=text name='nama_mediator' value='$r1[nik]' size=10 readonly></td></tr>
				<tr><td>Nama</td> <td> <input type=text name='ktp_mediator' value='$r1[nama]' size=25  readonly></td></tr>			
		</table>";
	
		echo "
	
		<h4>Point Rewards</h4>
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
			<th>No</th><th>Tanggal</th><th>D</th><th>K</th><th>P</th>
		</tr>"; 		
		$tampil=mysql_query("SELECT * FROM poinrewards where nik ='$_SESSION[namauser]' order by tanggal");
		$no = $posisi+1;
		while ($r=mysql_fetch_array($tampil)){
			echo "
			<tr>
				<td>$no</td>
				<td>$r[tanggal]</td>
				<td align=right>".number_format($r[debet])."</td>
				<td align=right>".number_format($r[kredit])."</td>
				<td align=right>".floor($r[poin])."</td>";
				$no++;
				$totalss=$totalss+$r[nilai];
		}
		echo "
		</tr>
		<tr><td colspan=2>Total</td><td align=right>".number_format($totalss)."</td></tr>
		</table>";		

	break;	
}
}
?>
