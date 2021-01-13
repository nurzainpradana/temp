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
$aksi="modul/mod_penarikan/aksi_penarikan.php";
$tanggal=date('Y-m-d');
switch($_GET[act]){
  // Tampil spk
  default:
			$tampil=mysql_query("SELECT * FROM anggota WHERE nik ='$_SESSION[namauser]' ");
			$r1=mysql_fetch_array($tampil);
			echo "
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td colspan=2><b>Data Anggota</b></td></tr>
				<tr><td>NIK</td> <td> $r1[nik]</td></tr>
				<tr><td>Nama</td> <td> $r1[nama]</td></tr>			
		</table>";	
			
		echo "
		<hr>
		<h4>History Penarikan SS</h4>
					<input class='btn btn-info btn-flat' type=button value='Form Penarikan' 
			onclick=\"window.location.href='?module=penarikan&act=tambahpenarikan';\">
			<br><br>
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
			<th>No</th><th>Tanggal</th><th>Jumlah</th>
		</tr>"; 		
		$tampil=mysql_query("SELECT * FROM penarikandetail where nik ='$_SESSION[namauser]' order by tanggal desc");
		$no = $posisi+1;
		while ($r=mysql_fetch_array($tampil)){
			echo "
			<tr>
				<td>$no</td>
				<td><a href=?module=penarikan&act=detailpenarikan&id=$r[id_penarikandetail]>$r[tanggal]</a></td>
				<td align=right>".number_format($r[total_tarik])."</td>";
				$no++;
				$totalss=$totalss+$r[total_tarik];
		}
		echo "
		</tr>
		<tr><td colspan=2>Total</td><td align=right>".number_format($totalss)."</td></tr>
		</table></td>";		

	break;	
	case "tambahpenarikan":
		echo "
		<hr>
    <h2>Form Penarikan</h2>
    <form method=POST action='$aksi?module=penarikan&act=input'>
		<input name='nik' type='hidden' id='nik' size='30' value='$_SESSION[namauser]'>
    <table id='example1' class='table table-bordered table-striped'>
      <tr> 
        <td>Jumlah</td>
        <td>
					<input name='total_tarik' type='text' id='total_tarik' size='10'><hr>
					tanpa koma, contoh 25000
				</td>
      </tr>
      <tr> 
        <td valign='top'>Keperluan</td>
        <td><input name='keterangan' type='text' id='keterangan' size='40'></td>
      </tr>
      <tr>
        <td colspan=2>
        <input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
        </td>
      </tr>
    </table>";
	break;	
	  	// Form Edit spk  
  	case "detailpenarikan":
		$edit=mysql_query("SELECT * FROM penarikandetail WHERE id_penarikandetail='$_GET[id]' ");
		$r=mysql_fetch_array($edit);
		$edit2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysql_fetch_array($edit2);
		echo "
		<h2>Detail Penarikan SS</h2>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td>Nomor Penarikan SS</td> <td>  $r[id_penarikandetail]</td></tr>
				<tr><td>NIK</td> <td> $r[nik]</td></tr>      
				<tr><td>Nama Anggota</td> <td>$r2[nama]</td></tr>
				<tr><td>Tanggal Penarikan</td> <td>$r[tanggal]</td></tr>
				<tr><td>Tanggal Cair</td> <td>$r[tgl_cair]</td></tr>				
				<tr><td>Jumlah Penarikan</td> <td>$r[total_tarik]</td></tr>
				<tr><td>Keterangan</td> <td>$r[keterangan]</td></tr>
				<tr><td>Pengelola</td> <td> $r[s1]</td></tr>	
				<tr><td>Pengurus</td> <td>$r[s2]</td></tr>
				  <tr>
					<td colspan=2>
						<input class='btn btn-danger btn-flat' type=button value=Back onclick=self.history.back()>
					</td>
				</tr>
    </table>";  
	break;
}
}
?>
