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
$aksi="modul/mod_pinjaman/aksi_pinjaman.php";
$tanggal=date('Y-m-d');
switch($_GET[act]){
  // Tampil spk
  default:
    echo "
	<h2>Pinjaman Koperasi</h2>
	<table id='example1' class='table table-bordered table-striped' border=0>
	<form method=POST action='?module=pinjaman&act=tambahpinjaman' >
	<tr><td>Masukkan NIK <input type='text' name='nik'/>
		<input type='submit' name='Submit' value='Search' /></td>
	</tr></form>
	</table>
	<br>
   <table id='example1' class='table table-bordered table-striped'>
			<tr>
				<td>
					<form method=POST action='?module=pinjaman&act=carianggota' enctype='multipart/form-data'>
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
	</table>
	<br>
   <table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>ID</th><th>NIK</th><th>Nama Anggota</th><th>Tanggal<br>Pengajuan</th><th>Tenor</th>
	<th>Pinjaman<br>Primer</th><th>Pinjaman<br>Sekunder</th><th>KD</th><th><center>Proses</center></th></tr>"; 
	$batas=25;
    $halaman=$_GET['halaman'];
	if(empty($halaman))
	{
		$posisi=0;
		$halaman=1;
	}
	else
	{
		$posisi = ($halaman-1) * $batas;
	}				

	$tampil=mysql_query("SELECT * FROM pinjaman ORDER BY id_pinjaman DESC LIMIT $posisi,$batas");
	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysql_fetch_array($tampil2);
		
		$tampil3=mysql_query("SELECT * FROM pinjamankategori WHERE kd_pinjaman='$r[kd_pinjaman]' ");
		//$r3=mysql_fetch_array($tampil3);
		echo "
		<tr><td>$no</td>
		<td>$r[id_pinjaman]</td>
		<td>$r[nik]</td>
		<td>$r2[nama]</td>
		<td>$r[tgl_pengajuan] | $r[jam_pengajuan]</td>
		<td>$r[tenor_primer]</td>
		<td align=right>".number_format($r[pinjaman_primer])."</td>
		<td align=right>".number_format($r[pinjaman_sekunder])."</td>
		<td align=center>$r[kd_pinjaman] | $r3[nama_pinjaman]</td>";
		echo "
		<td align=center nowrap>";
		//if ($r[s5]=='Y'){
			echo "
			<a href=modul/mod_pinjaman/pinjamancetak.php?id=$r[id_pinjaman] target=_blank><i class='fa fa-print'></i></a> &nbsp;";
		//}
		//if ($r[s6]=='N'){
			echo "
			<a href=?module=pinjaman&act=editpinjaman&id=$r[id_pinjaman]><i class='fa fa-pencil'></i></a> &nbsp; 			 
			<a href=\"$aksi?module=pinjaman&act=hapus&id=$r[id_pinjaman]\" onclick=\"return confirm('Are you sure want to delete?')\"><i class='fa fa-close'></i></a> &nbsp;";
		//}
		echo "
		</td>
		</tr>";
		//<a href=?module=pinjamandetail&nik=$r[nik]&pinjaman=$r[id_pinjaman]><i class='fa fa-check'></i></a> &nbsp;
		//<a href=?module=pinjamankprdetail&nik=$r[nik]&pinjaman=$r[id_pinjaman]><i class='fa fa-check'></i></a> &nbsp;
		$no++;
	}
	echo "
	</table><br><br>";
	$file="?module=pinjaman";
	if ($_SESSION[leveluser]=='sales'){
		$tampil2="SELECT * FROM pinjaman WHERE id_user='$_SESSION[id_user]' ORDER BY id_pinjaman DESC";
	}
	else {
		$tampil2="SELECT * FROM pinjaman ORDER BY id_pinjaman DESC";
	}
	$hasil2=mysql_query($tampil2);
	$jmldata=mysql_num_rows($hasil2);

	$jmlhalaman=ceil($jmldata/$batas);

	//link ke halaman sebelumnya (previous)
	if($halaman > 1)
	{
		$previous=$halaman-1;
		echo "<A HREF=$file&halaman=1><< First</A> |
		<A HREF=$file&halaman=$previous>< Previous</A> | ";
	} 
	else
	{
		echo "<< First | < Previous | ";
	}

	$angka=($halaman > 5 ? " ... " : " ");
	for($i=$halaman-2;$i<$halaman;$i++)
	{
		if ($i < 1)
		continue;
		$angka .= "<a href=$file&halaman=$i>$i</A> ";
	}

	$angka .= " <b>$halaman</b> ";
	for($i=$halaman+1;$i<($halaman+5);$i++)
	{
		if ($i > $jmlhalaman)
		break;
		$angka .= "<a href=$file&halaman=$i>$i</A> ";
	}

	$angka .= ($halaman+2<$jmlhalaman ? " ...
	<a href=$file&halaman=$jmlhalaman>$jmlhalaman</A> " : " ");

	echo "$angka";

	//link kehalaman berikutnya (Next)
	if($halaman < $jmlhalaman)
	{
		$next=$halaman+1;
		echo " | <A HREF=$file&halaman=$next>Next ></A> | <A HREF=$file&halaman=$jmlhalaman>Last >></A> ";
	}
	else
	{
		echo " | Next > | Last >>";
	}
	echo "Total Pengajuan Pinjaman: <b>$jmldata</b> ";			
	break;
	case "carianggota":
	    echo "
		<h2>Pinjaman Koperasi</h2>
		<table id='example1' class='table table-bordered table-striped' border=0>
		<form method=POST action='?module=pinjaman&act=tambahpinjaman' >
		<tr><td>Masukkan NIK <input type='text' name='nik'/>
			<input type='submit' name='Submit' value='Search' /></td>
		</tr></form>
		</table>
		<br>
		<table id='example1' class='table table-bordered table-striped'>
				<tr>
					<td>
						<form method=POST action='?module=pinjaman&act=carianggota' enctype='multipart/form-data'>
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
				<th>No</th><th>NIK</th><th>Nama</th><th>DIV</th><th>SEKSI</th><th>ESELON</th><th>Tanggal Masuk</th>
				<th>Status</th>
			</tr>";
			$tampil=mysql_query("SELECT * FROM anggota where $field like '%$kata%' ORDER BY nama");
			$no = $posisi+1;
			while ($r=mysql_fetch_array($tampil)){
			  // $divisi=mysql_query("SELECT * FROM divisi where kd_divisi='$r[divisi]' ");
			  // $r1=mysql_fetch_array($divisi);
				echo "
				<tr>
					<td>$no</td>
					<td>$r[nik]</td>
					<td><a href=?module=anggota&act=detailanggota&id=$r[id_anggota]>$r[nama]</a></td>
					<td>$r[id_divisi]</td>
					<td align=center>$r[id_seksi]</td>
					<td align=center>$r[eselon]</td>
					<td align=center>$r[tgl_masuk]</td>
					<td>$r[status]</td>
				</tr>";
			 $no++;
			}
			echo "
		</table>";	
	
	break;	
	case "tambahpinjaman":
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
		<form method=POST action='?module=pinjaman&act=tambahpinjamannya'>
		<table id='example1' class='table table-bordered table-striped'>
			<tr><td colspan=2><b>Data Anggota</b></td></tr>
			<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nama_mediator' value='$r1[nik]' size=10 ></td></tr>
			<tr><td>Nama Karyawan</td> <td> <input type=text name='ktp_mediator' value='$r1[nama]' size=40 ></td></tr>
			<tr><td>Divisi</td> <td> <input type=text name='bank_mediator' value='$r1[id_divisi]' size=40 > $r2[nama_divisi]</td></tr>
			<tr><td>Seksi</td> <td> <input type=text name='norek_mediator' value='$r1[id_seksi]' size=30> $r3[nama_seksi] </td></tr>
			<tr><td>Eselon</td> <td> <input type=text name='telp_mediator' value='$r1[eselon]' size=30></td></tr>
			<tr><td>Jenis Anggota</td> <td> <input type=text name='jenis_anggota' value='$r1[jenis_anggota]' size=30></td></tr>
		   <form method=POST action='$aksi?module=pinjaman&act=input'>
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
	
	case "tambahpinjamannya":

		// Form Tambah spk
		$tampil1=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[id]' ");
		$r1=mysql_fetch_array($tampil1);
		$tampil2=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[id]' ");
		$r2=mysql_fetch_array($tampil2);
    echo "
	<h2>Tambah Pinjaman</h2>
    <form method=POST action='$aksi?module=pinjaman&act=input'>
    <input type=hidden name=id value='$_POST[id_pinjaman]'>
    <table id='example1' class='table table-bordered table-striped'>	
		<tr><td colspan=2><b>Data Anggota</b></td></tr>
		<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nik' value='$r1[nik]' size=10 ></td></tr>
		<tr><td>Nama Karyawan</td> <td> <input type=text name='nama' value='$r1[nama]' size=40 ></td></tr>
		<tr><td>Divisi</td> <td> <input type=text name='id_divisi' value='$r1[id_divisi]' size=40 >$r2[nama_divisi]</td></tr>
		<tr><td>Seksi</td> <td> <input type=text name='id_seksi' value='$r1[id_seksi]' size=30></td></tr>
		<tr><td>Eselon</td> <td> <input type=text name='eselon' value='$r1[eselon]' size=30></td></tr>	
		<tr><td colspan=2><b>Data Pengajuan Pinjaman</b></td></tr>	
		<tr>
			<td>Kategori Pinjaman</td>
			<td>
			<select name='kd_pinjaman' class='combobox'>
				<option value='kosong'>- Pilih Kategori Pinjaman -</option>
				<option value='11'> Dana Reguler </option>
				<option value='12'> Dana Non Reguler </option>
				<option value='14'> Kendaraan Motor </option>
				<option value='15''> Kendaraan Mobil </option>
				<option value='16'> Perumahan </option>
				<option value='17'> Multiguna </option>
			</select>
			</td>
		</tr>			
		<tr><td>Tanggal Pengajuan Pinjaman</td><td><input type=text name='tgl_pengajuan' value='$tanggal' size=15></td></tr>
		<tr><td>Tanggal Awal Pinjaman</td> <td><input type='text' id='date1' name='tgl_mulai' size=15></td></tr>
		<tr><td>Tanggal Akhir Pinjaman</td> <td><input type='text' id='date2' name='tgl_selesai' size=15></td></tr>
		<tr><td>Pinjaman Primer</td> <td><input type=text name='pinjaman_primer' size=30></td></tr>
		<tr><td>Bunga Pinjaman Primer </td><td><input type=text name='bunga_primer' size=10> / Bulan [Gunakan titik sebagai koma]</td></tr>			
		<tr><td>Tenor Pinjaman Primer</td><td><input type=text name='tenor_primer' size=10> Bulan</td></tr>
		<tr><td>Pinjaman Sekunder</td> <td><input type=text name='pinjaman_sekunder' size=30></td></tr>
		<tr><td>Bunga Pinjaman Sekunder </td><td><input type=text name='bunga_sekunder' size=10> / Bulan [Gunakan titik sebagai koma]</td></tr>
		<tr>
			<td>Kategori Pinjaman</td>
			<td>
			<select name='kd_pp' class='combobox'>
				<option value='kosong'>- Pilih Jenis Potongan Sekunder -</option>
				<option value='THR'> THR </option>
			</select>
			</td>
		</tr>
		<tr>
			<td>Kategori Pinjaman</td>
			<td>
		</tr>	
		<tr>
			<td>Usia</td>
			<td>
			<select name='age' id='age'>
				<option value='kosong'>- Pilih Jenis Potongan Sekunder -</option>
				<option value='1'> Potongan THR </option>
			</select>
			</td>
		</tr>
		<tr>		
		<td></td>
			<td>
			  <div id='parentPermission'>
						 <p>Jumlah Pinjaman THR <input type='text' name='parent_name' /></p>
						 <p>Tenor Pembayaran <input type='text' name='parent_email' /></p>
			  </div>
		</td>
		</tr>	
		
		<tr><td>Tenor Pinjaman Sekunder </td><td><input type=text name='tenor_sekunder' size=10> Kali potongan</td></tr>		
		<tr><td>Cabang</td> <td> <input type=hidden name='id_cabang' size=10 value='1'> 1</td></tr>	
		<tr><td>Counter</td> <td> <input type=hidden name='id_user' size=10 value='$_SESSION[id_user]'> $_SESSION[id_user]</td></tr>				
		<tr><td>Tujuan Pinjaman</td> <td><input type=text name='tujuan' size=50></td></tr>
		<tr><td valign=top>Keterangan rinci <br>mengenai benda yang dibeli</td> <td> <textarea name='keterangan' rows='5' cols='60'></textarea></td></tr>
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
  	case "editpinjaman":
		$edit=mysql_query("SELECT * FROM pinjaman WHERE id_pinjaman='$_GET[id]' ");
		$r=mysql_fetch_array($edit);
		$edit2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysql_fetch_array($edit2);
		echo "
		<h2>Edit Pinjaman</h2>
		<form method=POST action=$aksi?module=pinjaman&act=update>
			<input type=hidden name=id value='$r[id_pinjaman]'>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td>Nomor Pinjaman</td> <td>  $r[id_pinjaman]</td></tr>
				<tr><td>Kode Pinjaman</td> <td> <input type=text name='kd_pinjaman' size=40 value='$r[kd_pinjaman]'></td></tr>
				<tr><td>NIK</td> <td> <input type=text name='nik' size=20 value='$r[nik]'></td></tr>      
				<tr><td>Nama Anggota</td> <td><input type=text name='nama' size=70 value='$r2[nama]'></td></tr>
				<tr><td>Tanggal Pengajuan Pinjaman</td> <td><input type=hidden name='tgl_pengajuan' size=30 value='$r[tgl_pengajuan]'> $r[tgl_pengajuan] - $r[jam_pengajuan]</td></tr>
				<tr><td>Tanggal Awal Pinjaman</td> <td><input type=date name='tgl_mulai' size=30 value='$r[tgl_mulai]'></td></tr>
				<tr><td>Tanggal Akhir Pinjaman</td> <td><input type=date name='tgl_selesai' size=30 value='$r[tgl_selesai]'></td></tr>
				<tr><td>Jumlah Pengajuan Pinjaman Primer</td> <td> <input type=text name='pinjaman_primer' size=40 value='$r[pinjaman_primer]'></td></tr>
				<tr><td>Jumlah Pengajuan Pinjaman Sekunder</td> <td> <input type=text name='pinjaman_sekunder' size=40 value='$r[pinjaman_sekunder]'></td></tr>
				<tr><td>Pinjaman Primer Disetujui</td> <td> <input type=text name='pinjaman_primerdisetujui' size=40 value='$r[pinjaman_primerdisetujui]'></td></tr>
				<tr><td>Tenor Pinjaman Primer</td> <td><input type=text name='tenor_primer' size=10 value='$r[tenor_primer]'> Bulan </td></tr>	
				<tr><td>Bunga Pinjaman Primer</td> <td><input type=text name='bunga_primer' size=10 value='$r[bunga_primer]'> Bulan </td></tr>				
				<tr><td>Pinjaman Sekunder Disetujui</td> <td> <input type=text name='pinjaman_sekunderdisetujui' size=40 value='$r[pinjaman_sekunderdisetujui]'></td></tr>
				<tr><td>Tenor Pinjaman Sekunder</td> <td><input type=text name='tenor_sekunder' size=10 value='$r[tenor_sekunder]'> Kali potongan </td></tr>	
				<tr><td>Bunga Pinjaman Sekunder</td> <td><input type=text name='bunga_sekunder' size=10 value='$r[bunga_sekunder]'> Bulan </td></tr>
				<tr><td>Kode Potongan Sekunder </td> <td> <input type=text name='kd_pp' size=10 value='$r[kd_pp]'></td></tr>
				<tr><td>Cabang</td> <td> <input type=text name='id_cabang' size=10 value='$_SESSION[id_cabang]'></td></tr>	
				<tr><td>Counter</td> <td> <input type=text name='id_user' size=10 value='$_SESSION[id_user]'></td></tr>
				<tr><td>Keperluan Pinjaman</td> <td> <input type=text name='tujuan' size=40 value='$r[tujuan]'></td></tr>				
				<tr><td>Keterangan rinci <br>mengenai benda yang dibeli</td> <td> <textarea name='keterangan' rows='5' cols='60'>$r[keterangan]</textarea></td></tr>";				
				if ($_SESSION[leveluser]=='sales'){
				echo "
				<tr><td>Approval Supervisor</td> <td> <input type=hidden name='s1' size=5 value='$r[s1]'> $r[s1] </td></tr>
				<tr><td>Approval Pengelola</td> <td> <input type=hidden name='s2' size=5 value='$r[s2]'> $r[s2] </td></tr>
				<tr><td>Approval Pengurus</td> <td> <input type=hidden name='s3' size=5 value='$r[s3]'> $r[s3] </td></tr>";
				}
				if ($_SESSION[leveluser]=='supervisor'){
				echo "
				<tr><td>Approval Supervisor</td> <td> <input type=text name='s1' size=5 value='$r[s1]'> Y / N </td></tr>
				<tr><td>Approval Pengelola</td> <td> <input type=hidden name='s2' size=5 value='$r[s2]'> $r[s2] </td></tr>
				<tr><td>Approval Pengurus</td> <td> <input type=hidden name='s3' size=5 value='$r[s3]'> $r[s3] </td></tr>";
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

	case "pinjamancari":
	$field=$_POST[field];
	$keyword=$_POST[keyword];

	$tampil = mysql_query("SELECT * FROM pinjaman WHERE $field LIKE '%$keyword%' ORDER BY id_pinjaman DESC");
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
		$detail=mysql_query("SELECT * FROM pinjamandetailalokasi WHERE id_pinjaman='$r[id_pinjaman]'");
		
		echo "
			<tr>
				<td>$no</td>
	      <td>$r[id_pinjaman]</td>
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

	case "pinjamanuser":
	$field=$_POST[field];
	$keyword=$_POST[keyword];

	$tampil = mysql_query("SELECT * FROM pinjaman WHERE $field LIKE '%$keyword%' ORDER BY id_pinjaman DESC");
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
	            <td>$r[id_pinjaman]</td>
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
