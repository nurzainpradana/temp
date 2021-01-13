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
	<h2>Pinjaman THR</h2>
	<br>
   <table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No.</th><th>Keterangan</th>
	</tr>"; 			

	$tampil=mysql_query("SELECT * FROM pinjamanthr where nik='$_SESSION[namauser]' ");
	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysql_fetch_array($tampil2);
		
		echo "
		<tr>
			<td>$no</td>
			<td>
			<br>Tenor: $r[tenor]
			<br>Jumlah: ".number_format($r[pinjamandisetujui])."
			<br>Pot. THR 2016: ".number_format($r[pot_2016])."	
		</tr>";
		//<a href=?module=pinjamannrdetail&nik=$r[nik]&pinjamannr=$r[id_pinjamannr]><i class='fa fa-check'></i></a> &nbsp;
		//<a href=?module=pinjamannrkprdetail&nik=$r[nik]&pinjamannr=$r[id_pinjamannr]><i class='fa fa-check'></i></a> &nbsp;
		$no++;
	}
	echo "
	</table>";	
	break;
	case "carianggota":
	    echo "
		<h2>Pinjamannr THR</h2>
		<table id='example1' class='table table-bordered table-striped' border=0>
		<form method=POST action='?module=pinjamanthr&act=tambahpinjamanthr' >
		<tr><td>pinjamannr BARU >>>>  Masukkan NIK <input type='text' name='nik'/>
			<input type='submit' name='Submit' value='Search' /></td>
		</tr></form>
		</table>
		<br>
		<table id='example1' class='table table-bordered table-striped'>
				<tr>
					<td>
						<form method=POST action='?module=pinjamannr&act=carianggota' enctype='multipart/form-data'>
							Field: 
							<select name='field' id='field'>
							  <option value='nik'>NIK</option>
								<option value='nama'>Nama</option>
								<option value='id_anggota'>Nomor Anggota</option>
							</select>
							<input type=text name='kata'> 
							<input type=submit value=Cari>
							</form>
					</td>
				</tr>
		</table>	";
	   $kata=$_POST['kata'];
		$field=$_POST['field'];
		echo "
		<h3>Pencarian Anggota</h3>
		<br>
		<table id='example1' class='table table-bordered table-striped' id='example1' class='table table-bordered table-striped'>
			<tr>
				<th>No</th><th>NIK</th><th>Nama</th><th>DIV</th><th>SEKSI</th>
				<th>Status</th>
			</tr>";
			$tampil=mysql_query("SELECT * FROM anggota where $field like '%$kata%' ORDER BY nama");
			$no = $posisi+1;
			while ($r=mysql_fetch_array($tampil)){
			  $divisi=mysql_query("SELECT * FROM divisi where kd_divisi='$r[id_divisi]' ");
			  $r1=mysql_fetch_array($divisi);
			  $seksi=mysql_query("SELECT * FROM seksi where kd_seksi='$r[id_seksi]' ");
			  $r2=mysql_fetch_array($seksi);
				echo "
				<tr>
					<td>$no</td>
					<td>$r[nik]</td>
					<td><a href=?module=anggota&act=detailanggota&id=$r[id_anggota]>$r[nama]</a></td>
					<td>$r1[nama_divisi]</td>
					<td>$r2[nama_seksi]</td>
					<td>$r[status]</td>
				</tr>";
			 $no++;
			}
			echo "
		</table>";	
	
	break;	
	case "tambahpinjamanthr":
		$tampil=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[nik]' ");
		$r1=mysql_fetch_array($tampil);
		$ketemu=mysql_num_rows($tampil);		
		if ($ketemu == 0){
			echo "<h2>Nomor nik tidak ditemukan</h2><br><br>
			<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>";
			return;
		}
		$tampil2=mysql_query("SELECT * FROM divisi where id_divisi='$r1[id_divisi]' ");
		$r2=mysql_fetch_array($tampil2);
		$tampil3=mysql_query("SELECT * FROM seksi where id_seksi='$r1[id_seksi]' ");
		$r3=mysql_fetch_array($tampil3);
		echo "
		<h2>Data Anggota</h2>
		<form method=POST action='?module=pinjamanthr&act=tambahpinjamanthrnya'>
		<table id='example1' class='table table-bordered table-striped'>
			<tr><td colspan=2><b>Data Anggota</b></td></tr>
			<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nama_mediator' value='$r1[nik]' size=10 ></td></tr>
			<tr><td>Nama Karyawan</td> <td> <input type=text name='ktp_mediator' value='$r1[nama]' size=40 ></td></tr>
			<tr><td>Divisi</td> <td> <input type=text name='bank_mediator' value='$r1[id_divisi]' size=40 > $r2[nama_divisi]</td></tr>
			<tr><td>Seksi</td> <td> <input type=text name='norek_mediator' value='$r1[id_seksi]' size=30> $r3[nama_seksi] </td></tr>
			<tr><td>Eselon</td> <td> <input type=text name='telp_mediator' value='$r1[eselon]' size=30></td></tr>
			<tr><td>Jenis Anggota</td> <td> <input type=text name='jenis_anggota' value='$r1[jenis_anggota]' size=30></td></tr>
		   <form method=POST action='$aksi?module=pinjamanthr&act=input'>
			<input type=hidden name=id value='$r1[nik]'>		

		<tr>
			<td>&nbsp;</td>
			<td>
				<input class='btn btn-info btn-flat' type=submit name=submit value=Lanjut>
				<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>
			</td>
		</tr>
	</table>
	</form>";
	
	break;
	
	case "tambahpinjamanthrnya":

		// Form Tambah spk
		$tampil1=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[id]' ");
		$r1=mysql_fetch_array($tampil1);
		$tampil2=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[id]' ");
		$r2=mysql_fetch_array($tampil2);
    echo "
	<h2>Tambah pinjamanthr</h2>
    <form method=POST action='$aksi?module=pinjamanthr&act=input'>
    <input type=hidden name=id value='$_POST[id_pinjamanthr]'>
    <table id='example1' class='table table-bordered table-striped'>	
		<tr><td colspan=2><b>Data Anggota</b></td></tr>
		<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nik' value='$r1[nik]' size=10 ></td></tr>
		<tr><td>Nama Karyawan</td> <td> <input type=text name='nama' value='$r1[nama]' size=40 ></td></tr>
		<tr><td>Divisi</td> <td> <input type=text name='id_divisi' value='$r1[id_divisi]' size=40 >$r2[nama_divisi]</td></tr>
		<tr><td>Seksi</td> <td> <input type=text name='id_seksi' value='$r1[id_seksi]' size=30></td></tr>
		<tr><td>Eselon</td> <td> <input type=text name='eselon' value='$r1[eselon]' size=30></td></tr>	
		<tr><td colspan=2><b>Data Pengajuan pinjamanthr</b></td></tr>	
		<tr>
			<td>Kategori pinjamanthr</td>
			<td>
			<select name='kd_pinjamanthr' class='combobox'>
				<option value='kosong'>- Pilih Kategori pinjamanthr -</option>
				<option value='11'> Dana Reguler </option>
				<option value='12'> Dana Non Reguler </option>
				<option value='14'> Kendaraan Motor </option>
				<option value='15''>Kendaraan Mobil </option>
				<option value='16'> Perumahan </option>
				<option value='17'> Multiguna </option>
				<option value='17'> Potongan THR </option>
			</select>
			</td>
		</tr>			
		<tr><td>Tanggal Pengajuan pinjamanthr</td><td><input type=text name='tgl_pengajuan' value='$tanggal' size=15></td></tr>
		<tr><td>Tanggal Awal pinjamanthr</td> <td><input type='text' id='date1' name='tgl_mulai' size=15> YYYY-MM-DD</td></tr>
		<tr><td>Tanggal Akhir pinjamanthr</td> <td><input type='text' id='date2' name='tgl_selesai' size=15> YYYY-MM-DD</td></tr>
		<tr><td>Jumlah pinjamanthr</td> <td><input type=text name='pinjamanthr' size=30></td></tr>
		<tr><td>Bunga pinjamanthr</td><td><input type=text name='bunga' value='1.5' size=10> / Bulan</td></tr>		
		<tr><td>Tenor pinjamanthr</td><td><input type=text name='lama' size=10> Bulan / THR</td></tr>
		<tr><td>Jumlah pinjamanthr THR [jika ada]</td> <td><input type=text name='pinjamanthr_thr' size=30></td></tr>
		<tr><td>Tenor pinjamanthr THR [jika ada]</td><td><input type=text name='lama_thr' size=10> / Bulan</td></tr>		
		<tr><td>Cabang</td> <td> <input type=hidden name='id_cabang' size=10 value='1'> 1</td></tr>	
		<tr><td>Counter</td> <td> <input type=hidden name='id_user' size=10 value='$_SESSION[id_user]'> $_SESSION[id_user]</td></tr>				
		<tr><td>Tujuan pinjamanthr</td> <td><input type=text name='tujuan' size=50></td></tr>
		<tr><td valign=top>Keterangan</td> <td> <textarea name='keterangan' rows='5' cols='60'></textarea></td></tr>
		<tr>
			<td colspan=2>
				<input class='btn btn-info btn-flat' type=submit name=submit value=Simpan>
				<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>
			</td>
		</tr>
    </table>
	</form>";
    break;
  
  	// Form Edit spk  
  	case "editpinjamanthr":
		$edit=mysql_query("SELECT * FROM pinjamanthr WHERE id_pinjamanthr='$_GET[id]' ");
		$r=mysql_fetch_array($edit);
		$edit2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysql_fetch_array($edit2);
		echo "
		<h2>Edit pinjamanthr</h2>
		<form method=POST action=$aksi?module=pinjamanthr&act=update>
			<input type=hidden name=id value='$r[id_pinjamanthr]'>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td>Nomor pinjamanthr</td> <td>  $r[id_pinjamanthr]</td></tr>
				<tr><td>Kode pinjamanthr</td> <td> <input type=text name='kd_pinjamanthr' size=40 value='$r[kd_pinjamanthr]'></td></tr>
				<tr><td>NIK</td> <td> <input type=text name='nik' size=20 value='$r[nik]'></td></tr>      
				<tr><td>Nama Anggota</td> <td><input type=text name='nama' size=70 value='$r2[nama]'></td></tr>
				<tr><td>Tanggal Pengajuan pinjamanthr</td> <td><input type=hidden name='tgl_pengajuan' size=30 value='$r[tgl_pengajuan]'> $r[tgl_pengajuan] - $r[jam_pengajuan]</td></tr>
				<tr><td>Tanggal Awal pinjamanthr</td> <td><input type=date name='tgl_mulai' size=30 value='$r[tgl_mulai]'></td></tr>
				<tr><td>Tanggal Akhir pinjamanthr</td> <td><input type=date name='tgl_selesai' size=30 value='$r[tgl_selesai]'></td></tr>
				<tr><td>Jumlah Pengajuan pinjamanthr</td> <td> <input type=text name='pinjamanthr' size=40 value='$r[pinjamanthr]'></td></tr>
				<tr><td>pinjamanthr Disetujui</td> <td> <input type=text name='pinjamanthrdisetujui' size=40 value='$r[pinjamanthrdisetujui]'></td></tr>
				<tr><td>Tenor pinjamanthr</td> <td><input type=text name='lama' size=10 value='$r[lama]'> Bulan </td></tr>	
				<tr><td>Bunga pinjamanthr</td> <td><input type=text name='bunga' size=10 value='$r[bunga]'> Bulan </td></tr>				
				<tr><td>Cabang</td> <td> <input type=text name='id_cabang' size=10 value='$_SESSION[id_cabang]'></td></tr>	
				<tr><td>Counter</td> <td> <input type=text name='id_user' size=10 value='$_SESSION[id_user]'></td></tr>
				<tr><td>Keperluan pinjamanthr</td> <td> <input type=text name='tujuan' size=40 value='$r[tujuan]'></td></tr>				
				<tr><td>Keterangan<td> <textarea name='keterangan' rows='5' cols='60'>$r[keterangan]</textarea></td></tr>";				
				if ($_SESSION[leveluser]=='konter'){
				echo "
				<tr><td>Approval Staff Konter</td> <td> <input type=text name='s1' size=5 value='$r[s1]'></td></tr>";
				}
				if ($_SESSION[leveluser]=='supervisor'){
				echo "
				<tr><td>Approval Staff Counter</td> <td> <input type=hidden name='s1' size=5 value='$r[s1]'> $r[s1] </td></tr>
				<tr><td>Approval Supervisor</td> <td> <input type=text name='s2' size=5 value='$r[s2]'> Y / N </td></tr>";
				}
				if ($_SESSION[leveluser]=='pengurus' ){
				echo "
				<tr><td>Approval Supervisor</td> <td> <input type=text name='s1' size=5 value='$r[s1]'> Y / N </td></tr>
				<tr><td>Approval Pengelola</td> <td> <input type=text name='s2' size=5 value='$r[s2]'> Y / N </td></tr>
				<tr><td>Approval Pengurus</td> <td> <input type=hidden name='s3' size=5 value='$r[s3]'> $r[s3] </td></tr>
				";
				}
				if ($_SESSION[leveluser]=='pengelola' or $_SESSION[leveluser]=='admin'){
				echo "
				<tr><td>Approval Kepala Unit </td> <td> S1 <input type=text name='s1' size=5 value='$r[s1]'> Y / N </td></tr>
				<tr><td>Approval General Manager </td> <td> S2 <input type=text name='s2' size=5 value='$r[s2]'> Y / N </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> S3 <input type=text name='s3' size=5 value='$r[s3]'> Y / N </td></tr>
				<tr><td>Approval Bendahara </td> <td> S4 <input type=text name='s4' size=5 value='$r[s4]'> Y / N </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> S5 <input type=text name='s5' size=5 value='$r[s5]'> Y / N </td></tr>
				";
				}				
				echo "
				  <tr>
					<td colspan=2>
						<input class='btn btn-info btn-flat' type=submit value=Update>
							 <input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>
						</td>
				</tr>
    </table>
	</form>";  
	break;

	case "pinjamanthrcari":
	$field=$_POST[field];
	$keyword=$_POST[keyword];

	$tampil = mysql_query("SELECT * FROM pinjamanthr WHERE $field LIKE '%$keyword%' ORDER BY id_pinjamanthr DESC");
	echo "
	<h2>Cari Pelanggan SPB</h2>
	$field | $keyword <br><br>";
	echo "
	<table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>No.SPB</th><th>CB</th><th>Pelanggan</th><th>Tgl.Mulai</th><th>Tgl.Selesai</th>
	<th>Term</th><th>J<br>U</th><th>Sales</th><th>Fee</th><th>Nopol</th></tr>"; 
	$no=1;
	while ($r=mysql_fetch_array($tampil)){
		$namapel=mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan='$r[id_pelanggan]'");
		$b1=mysql_fetch_array($namapel);
		$namauser=mysql_query("SELECT * FROM users WHERE id_user='$r[id_user]'");
		$b2=mysql_fetch_array($namauser);
		$detail=mysql_query("SELECT * FROM pinjamanthrdetailalokasi WHERE id_pinjamanthr='$r[id_pinjamanthr]'");
		
		echo "
			<tr>
				<td>$no</td>
	      <td>$r[id_pinjamanthr]</td>
				<td>$r[id_dealer]</td>
				<td>$b1[nama]</td>
				<td>$r[tgl_mulai]</td>
				<td>$r[tgl_selesai]</td>
				<td>$r[lama_sewa]</td>
				<td>$r[jumlah_unit]</td>
				<td>$r[id_user]</td>
				<td align=center>$r[metode_fee]</td>
				<td>";
				while ($b3=mysql_fetch_array($detail)){
					echo "$b3[nopol] - $b3[nopol_pem]<br>";
				}
				echo "
				</td>				
			</tr>";
	      $no++;
	}
	echo "</table>";
	break;

	case "pinjamanthruser":
	$field=$_POST[field];
	$keyword=$_POST[keyword];

	$tampil = mysql_query("SELECT * FROM pinjamanthr WHERE $field LIKE '%$keyword%' ORDER BY id_pinjamanthr DESC");
	echo "
	<h2>Cari Sales SPB</h2>
	$field | $keyword <br><br>";
	echo "
	<table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>No.SPB</th><th>CB</th><th>Pelanggan</th><th>Tgl.Mulai</th>
	<th>Term</th><th>J<br>U</th><th>Sales</th><th>Fee</th><th>S1</th><th>S2</th><th>S3</th><th>S4</th></tr>"; 
	$no=1;
	while ($r=mysql_fetch_array($tampil)){
		$namapel=mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan='$r[id_pelanggan]'");
		$b1=mysql_fetch_array($namapel);
		$namauser=mysql_query("SELECT * FROM users WHERE id_user='$r[id_user]'");
		$b2=mysql_fetch_array($namauser);
		echo "
			<tr>
				<td>$no</td>
	            <td>$r[id_pinjamanthr]</td>
				<td>$r[id_dealer]</td>
				<td>$b1[nama]</td>
				<td>$r[tgl_mulai]</td>
				<td>$r[lama_sewa]</td>
				<td>$r[jumlah_unit]</td>
				<td>$r[id_user] | $b2[nama]</td>
				<td align=center>$r[metode_fee]</td>
				<td align=center>$r[s1]</td>
				<td align=center>$r[s2]</td>
				<td align=center>$r[s3]</td>
				<td align=center>$r[s4]</td>
			</tr>";
	      $no++;
	}
	echo "</table>";
	break;
}
}
?>
