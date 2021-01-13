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
	if ($_SESSION[leveluser]=='anggota'){
    echo "
		<h2>Data Pinjaman Reguler</h2>
			<a href='?module=pinjaman&act=tambahpinjaman' >Mengajukan Pinjaman Baru</a>
		<br>
		<br>
		Keterangan = A1: Counter, A2: Ka. Unit, A3: GM, A4: Ka. Bidang, A5: Bendahara, A6: Wakil/Ketua
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
		<th>No</th><th>NIK</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Tenor</th>
		<th>Jumlah<br>Pengajuan</th><th>Jumlah<br>Disetujui</th><th colspan=2>KD</th><th>P1</th><th>P2</th><th>P3</th><th>P4</th><th>P5</th><th>P6</th><th>Proses</th></tr>"; 		

		$tampil=mysql_query("SELECT * FROM pinjaman where nik='$_SESSION[namauser]' order by tgl_pengajuan desc");
		
		$no =1;
		while ($r=mysql_fetch_array($tampil)){
			$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
			$r2=mysql_fetch_array($tampil2);
			
			$tampil3=mysql_query("SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
			$r3=mysql_fetch_array($tampil3);
			echo "
			<tr><td>$no</td>
			<td><a href='?module=angsuran&id=$r[no_bukti]'>$r[no_bukti]</a></td>
			<td>$r[tgl_mulai]</td>
			<td>$r[tgl_selesai]</td>
			<td>$r[tenor]</td>
			<td align=right>".number_format($r[pinjaman])."</td>
			<td align=right>".number_format($r[pinjamandisetujui])."</td>		
			<td align=center>$r[jn_pinjaman]</td>	
			<td align=center>$r3[singkatan]</td>
			<td align=center>$r[s1]</td>
			<td align=center>$r[s2]</td>
			<td align=center>$r[s3]</td>
			<td align=center>$r[s4]</td>
			<td align=center>$r[s5]</td>
			<td align=center>$r[s6]</td>
			";
			echo "
			<td align=center nowrap>
				<a href=modul/mod_pinjaman/pinjamancetak.php?id=$r[id_pinjaman] target=_blank><i class='fa fa-print'></i></a>
			</td>
			</tr>";
			$no++;
		}
		echo "
		</table><br><br>";
    echo "
		<h3>Pinjaman Non Reguler</h3>
   <table id='example1' class='table table-bordered table-striped'>
			<tr>
			<th>No</th><th>NIK</th>
			<th>Nama</th><th>Tenor</th><th>Jumlah Pinjaman</th><th>Angsuran</th>
			<th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Lunas</th>
			<th>Proses</th>
	</tr>"; 		

	$tampil=mysql_query("SELECT * FROM pinjamannr where nik='$_SESSION[namauser]' order by tgl_pengajuan desc ");
	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysql_fetch_array($tampil2);
		
		$tampil3=mysql_query("SELECT * FROM pinjamannrkategori WHERE kd_pinjamannr='$r[kode_pinjamannr]' ");
		//$r3=mysql_fetch_array($tampil3);
		echo "
		<tr><td>$no</td>
		<td>$r[nik]</td>
		<td>$r2[nama]</td>
		<td>$r[tenor]</td>	
		<td align=right>".number_format($r[pinjamandisetujui])."</td>
		<td align=right>".number_format($r[angsuran])."</td>		
		<td>$r[tgl_awal]</td>
		<td>$r[tgl_akhir]</td>
		<td>$r[lunas]</td>
		</tr>";
		$no++;
	}
	echo "
	</table><br><br>";
	}	
	else {
		
    echo "
		<h2>Pinjaman Reguler</h2>
		<table id='example1' class='table table-bordered table-striped' border=0>
			<form method=POST action='?module=pinjaman&act=tambahpinjaman' >
			<tr>
				<td>PINJAMAN BARU >>>> Masukkan NIK <input type='text' name='nik'/>
				<input type='submit' name='Submit' value='Search' />
				</td>
			</tr>
			</form>
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
				<td>
			<form method=POST action='?module=pinjaman&act=tambahpinjaman' >
			Tanggal <input type='text' name='tgl1' size='10'/> s/d <input type='text' name='tgl2' size='10'/>
			<input type='submit' name='Submit' value='Search' />
			</td>
			</form>
			</tr>
		</table>	
		<br>
		Keterangan = A1: Counter, A2: Ka. Unit, A3: GM, A4: Ka. Bidang, A5: Bendahara, A6: Wakil/Ketua
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
		<th>No</th><th>ID Pinjaman</th><th>NIK</th><th>Nama Anggota</th><th>Tanggal<br>Pengajuan</th><th>Tenor</th>
		<th>Jumlah<br>Pengajuan</th><th>Jumlah<br>Disetujui</th><th colspan=2>KD</th><th>P1</th><th>P2</th><th>P3</th><th>P4</th><th>P5</th><th>P6</th><th>Proses</th></tr>"; 
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

		$tampil=mysql_query("SELECT * FROM pinjaman order by tgl_pengajuan desc LIMIT $posisi,$batas");
		
		$no = $posisi+1;
		while ($r=mysql_fetch_array($tampil)){
			$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
			$r2=mysql_fetch_array($tampil2);
			
			$tampil3=mysql_query("SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
			$r3=mysql_fetch_array($tampil3);
			
			echo "
			<tr><td>$no</td>
			<td>$r[id_pinjaman]</td>
			<td>$r[nik]</td>
			<td>$r2[nama]</td>
			<td>$r[tgl_pengajuan]</td>
			<td>$r[tenor]</td>
			<td align=right>".number_format($r[pinjaman])."</td>
			<td align=right>".number_format($r[pinjamandisetujui])."</td>	
			<td align=center>$r[jn_pinjaman]</td>			
			<td align=center>$r3[singkatan]</td>
			<td align=center>$r[s1]</td>
			<td align=center>$r[s2]</td>
			<td align=center>$r[s3]</td>
			<td align=center>$r[s4]</td>
			<td align=center>$r[s5]</td>
			<td align=center>$r[s6]</td>
			";
			echo "
			<td align=center nowrap>";
			//if ($r[s5]=='Y'){
				echo "
				<a href=modul/mod_pinjaman/pinjamancetak.php?id=$r[id_pinjaman] target=_blank><i class='fa fa-print'></i></a> &nbsp;";
			//}
			//if ($r[s6]=='N'){
				echo "
				<a href=?module=pinjaman&act=editpinjaman&id=$r[id_pinjaman]><i class='fa fa-pencil'></i></a> &nbsp; 	
				<a href=?module=pinjamandetail&nik=$r[nik]&pinjaman=$r[id_pinjaman]><i class='fa fa-check'></i></a> &nbsp;			
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
			$tampil2="SELECT * FROM pinjaman order by tgl_pengajuan desc";
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
		echo "Total Pengajuan Pinjaman: <b>$jmldata</b><br> ";	
		echo "<a href=modul/mod_pinjaman/pinjamancetakall.php target=_blank>Print All</a> &nbsp;";	
	}	
	break;

	case "carianggota":
	  echo "
		<h2>Pinjaman Koperasi</h2>
		<table id='example1' class='table table-bordered table-striped' border=0>
		<form method=POST action='?module=pinjaman&act=tambahpinjaman' >
		<tr><td>PINJAMAN BARU >>>>  Masukkan NIK <input type='text' name='nik'/>
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
	case "tambahpinjaman":
		$tampil=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[nik]' ");
		$r=mysql_fetch_array($tampil);
		$ketemu=mysql_num_rows($tampil);		
		if ($ketemu == 0){
			echo "<h2>Nomor nik tidak ditemukan</h2><br><br>
			<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>";
			return;
		}
		
	$tampil1=mysql_query("SELECT * FROM saldoawaldetail where kode_trans ='01' and nik ='$_POST[nik]' ");
	$r1=mysql_fetch_array($tampil1);
	$tampil2=mysql_query("SELECT * FROM saldoawaldetail where kode_trans ='02' and nik ='$_POST[nik]' ");
	$r2=mysql_fetch_array($tampil2);
	$tampil3=mysql_query("SELECT * FROM saldoawaldetail where kode_trans ='03' and nik ='$_POST[nik]' ");
	$r3=mysql_fetch_array($tampil3);	
	$tampil4=mysql_query("SELECT * FROM saldoawaldetail where kode_trans ='04' and nik ='$_POST[nik]' ");
	$r4=mysql_fetch_array($tampil4);		
		

	$tampil5=mysql_query("SELECT * FROM transaksi102detail where nik ='$_POST[nik]' order by tanggal");
	$no = $posisi+1;
	while ($r5=mysql_fetch_array($tampil5)){
		$totalsw=$totalsw+$r5[nilai];
	}
			
	$tampil6=mysql_query("SELECT * FROM transaksi104detail where nik ='$_POST[nik]' order by tanggal");
	while ($r6=mysql_fetch_array($tampil6)){
			$totalsk=$totalsk+$r6[nilai];
	}
		
	$tampil7=mysql_query("SELECT * FROM transaksi103detail where nik ='$_POST[nik]' order by tanggal");
	$no = $posisi+1;
	while ($r7=mysql_fetch_array($tampil7)){
			$totalss=$totalss+$r7[nilai];
	}
		
	$tampil8=mysql_query("SELECT * FROM penarikandetail where nik ='$_POST[nik]' order by tanggal");
	while ($r8=mysql_fetch_array($tampil8)){
			$totaltarik=$totaltarik+$r8[total_tarik];
	}

	$totalswnya=$totalsw+$r2[saldo];
	$totalsknya=$totalsk+$r4[saldo];
	$sisasimpananss=$totalss-$totaltarik+$r3[saldo];
	
		$tampil12=mysql_query("SELECT * FROM divisi where id_divisi='$r[id_divisi]' ");
		$r12=mysql_fetch_array($tampil12);
		$tampil13=mysql_query("SELECT * FROM seksi where id_seksi='$r[id_seksi]' ");
		$r13=mysql_fetch_array($tampil13);
		echo "
		<h2>Data Anggota</h2>
		<form method=POST action='?module=pinjaman&act=tambahpinjamannya'>
		<table id='example1' class='table table-bordered table-striped'>
			<tr><td colspan=2><b>Data Anggota</b></td></tr>
			<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nama_mediator' value='$r[nik]' size=10 ></td></tr>
			<tr><td>Nama Karyawan</td> <td> <input type=text name='ktp_mediator' value='$r[nama]' size=40 ></td></tr>
			<tr><td>Divisi</td> <td> <input type=text name='bank_mediator' value='$r[id_divisi]' size=40 > $r12[nama_divisi]</td></tr>
			<tr><td>Seksi</td> <td> <input type=text name='norek_mediator' value='$r[id_seksi]' size=30> $r13[nama_seksi] </td></tr>
			<tr><td>Eselon</td> <td> <input type=text name='telp_mediator' value='$r[eselon]' size=30></td></tr>
			<tr><td>Jenis Anggota</td> <td> <input type=text name='jenis_anggota' value='$r[jenis_anggota]' size=30></td></tr>		
			<tr><td>Tanggal Lahir</td> <td> <input type=text name='jenis_anggota' value='$r[tgl_lahir]' size=30></td></tr>	
			<tr><td>Simpanan Wajib</td> <td> <input type=text name='totalswnya' value='$totalswnya' size=30></td></tr>	
			<tr><td>Sisa Simpanan Sukarela</td> <td> <input type=text name='sisasimpananss' value='$sisasimpananss' size=30></td></tr>	
			<tr><td>Simpanan Khusus</td> <td> <input type=text name='totalsknya' value='$totalsknya' size=30></td></tr>	
			<tr><td>Angsuran per Bulan yg Masih Berjalan </td> <td> <input type=text name='angsuranberjalan' size=30></td></tr>				
		   <form method=POST action='$aksi?module=pinjaman&act=input'>
			<input type=hidden name=id value='$r[nik]'>		

		<tr>
			<td>&nbsp;</td>
			<td>
				<input class='btn btn-info btn-flat' type=submit name=submit value=Lanjut>
				<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>
			</td>
		</tr>
	</table>
	</form>";
	echo "
	<hr>
	<h4>Pinjaman Reguler</h4>
	<table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>ID</th><th>Nik</th><th>Tanggal Pinjaman</th><th>Tanggal Selesai</th><th>Tenor</th>
	<th>Jumlah Disetujui</th><th>Angsuran</th><th>Kode Pinjaman</th></tr>"; 	
	$tampil=mysql_query("SELECT * FROM pinjaman where nik ='$_POST[nik]' order by tgl_pengajuan desc");	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		
		$tampil3=mysql_query("SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
		$r3=mysql_fetch_array($tampil3);
		echo "
		<tr><td>$no</td>
			<td>$r[no_bukti]</td>
			<td>$r[nik]</td>
			<td>$r[tgl_mulai]</td>
			<td>$r[tgl_selesai]</td>
			<td>$r[tenor]</td>
			<td align=right>".number_format($r[pinjamandisetujui])."</td>
			<td align=right>".number_format($r[angsuran_perbulan])."</td>			
			<td>$r[kode_pinjaman] | $r3[nama_pinjaman]</td>
		</tr>";
		$no++;
	}
	echo "
	</table><br><br>";
	echo "
	<h4>Pinjaman Non Reguler</h4>
	<table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>NIK</th>
	<th>Tenor</th><th>Jumlah Pinjaman</th>
	<th>Jumlah Angsuran</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th>
	<th>Lunas</th>

	</tr>"; 		
	$tampil=mysql_query("SELECT * FROM pinjamannr where nik ='$_POST[nik]' order by tgl_pengajuan desc");
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		echo "
		<tr><td>$no</td>
		<td>$r[nik]</td>
		<td>$r[tenor]</td>	
		<td align=right>".number_format($r[pinjamandisetujui])."</td>
		<td align=right>".number_format($r[angsuran])."</td>		
		<td>$r[tgl_awal]</td>
		<td>$r[tgl_akhir]</td>
		<td>$r[lunas]</td>";
		$no++;
	}
	echo "
	</table><br><br>";
	echo "
	<h4>Pinjaman THR</h4>
	<table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>ID</th><th>Nik</th><th>Tanggal Pinjaman</th><th>Tanggal Selesai</th><th>Tenor</th>
	<th>Jumlah Disetujui</th><th>Kode Pinjaman</th></tr>"; 	
	$tampil=mysql_query("SELECT * FROM pinjamanthr where nik ='$_POST[nik]' order by tgl_pengajuan desc");	
	$no = $posisi+1;
	while ($r=mysql_fetch_array($tampil)){
		
		$tampil3=mysql_query("SELECT * FROM pinjamankategori WHERE kd_pinjaman='$r[kode_pinjaman]' ");
		$r3=mysql_fetch_array($tampil3);
		echo "
		<tr><td>$no</td>
			<td>$r[no_bukti]</td>
			<td>$r[nik]</td>
			<td>$r[tgl_mulai]</td>
			<td>$r[tgl_selesai]</td>
			<td>$r[tenor]</td>
			<td align=right>".number_format($r[pinjamandisetujui])."</td>
			<td>$r[kode_pinjaman] | $r3[nama_pinjaman]</td>
		</tr>";
		$no++;
	}
	echo "
	</table><br><br>";	
	
	
	break;
	
	case "tambahpinjamannya":

		// Form Tambah spk
		$tampil1=mysql_query("SELECT * FROM anggota WHERE nik ='$_POST[id]' ");
		$r1=mysql_fetch_array($tampil1);
		$totalsimpanan=$_POST[totalswnya]+$_POST[sisasimpananss]+$_POST[totalsknya];
		echo "
		<h2>Tambah Pinjaman</h2>
		 <form method=POST action='$aksi?module=pinjaman&act=input' enctype='multipart/form-data'>
		 <input type=hidden name=id value='$_POST[id_pinjaman]'>
		 <table id='example1' class='table table-bordered table-striped'>	
			<tr><td colspan=2><b>Data Anggota</b></td></tr>
			<tr><td>Nomor Bukti</td> <td> <input type=text name='no_bukti' size=10 ></td></tr>		
			<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nik' value='$r1[nik]' size=10 ></td></tr>
			<tr><td>Nama Karyawan</td> <td> <input type=text name='nama' value='$r1[nama]' size=40 ></td></tr>
			<tr><td>Divisi</td> <td> <input type=text name='id_divisi' value='$r1[id_divisi]' size=40 >$r2[nama_divisi]</td></tr>
			<tr><td>Seksi</td> <td> <input type=text name='id_seksi' value='$r1[id_seksi]' size=30></td></tr>
			<tr><td>Eselon</td> <td> <input type=text name='eselon' value='$r1[eselon]' size=30></td></tr>	
			<tr><td>Jenis Anggota</td> <td> <input type=text name='jenis_anggota' value='$r1[jenis_anggota]' size=30></td></tr>		
			<tr><td>Simpanan Wajib</td> <td> <input type=text name='simpanan_wajib' value='$_POST[totalswnya]' readonly size=30> ".number_format($_POST[totalswnya])."</td></tr>	
			<tr><td>Sisa Simpanan Sukarela</td> <td> <input type=text name='simpanan_ss' value='$_POST[sisasimpananss]' readonly size=30> ".number_format($_POST[sisasimpananss])."</td></tr>	
			<tr><td>Simpanan Khusus</td> <td> <input type=text name='simpanan_khusus' value='$_POST[totalsknya]' readonly size=30> ".number_format($_POST[totalsknya])."</td></tr>		
			<tr><td>Total Simpanan</td> <td> <input type=text name='saldo_simpanan' value='$totalsimpanan' readonly size=30> ".number_format($totalsimpanan)."</td></tr>
			<tr><td>Angsuran per bulan yg masih berjalan</td> <td> <input type=text name='angsuranberjalan' value='$_POST[angsuranberjalan]' readonly size=30> ".number_format($_POST[angsuranberjalan])."</td></tr>	
			<tr><td colspan=2><b>Data Pengajuan Pinjaman</b></td></tr>	
			<tr>
				<td>Kategori Pinjaman</td>  
						<td>  
				  <select name='jn_pinjaman'>
					<option value=0 selected>- Pilih Jenis Pinjaman -</option>";
					$tampil2=mysql_query("SELECT * FROM pinjamanjenis ");
					while($r2=mysql_fetch_array($tampil2)){
					  echo "<option value=$r2[singkatan]>$r2[jn_pinjaman] | $r2[nama_jenis]</option>";
					}
				  echo "</select>
				</td>
			</tr>			
			<tr>
				<td>Keperluan Pinjaman</td>  
						<td>  
				  <select name='kode_pinjaman'>
					<option value=0 selected>- Pilih Keperluan Pinjaman -</option>";
					$tampil3=mysql_query("SELECT * FROM pinjamankategori ");
					while($r3=mysql_fetch_array($tampil3)){
					  echo "<option value=$r3[kode_pinjaman]>$r3[kode_pinjaman] | $r3[nama_pinjaman]</option>";
					}
				  echo "</select>
				</td>
			</tr>	
			<tr><td>Tanggal Pengajuan Pinjaman</td><td><input type=text name='tgl_pengajuan' value='$tanggal' size=15></td></tr>
			<tr><td>Tanggal Awal Pinjaman</td> <td><input type='text' id='date1' name='tgl_mulai' size=15> YYYY-MM-DD</td></tr>
			<tr><td>Tanggal Akhir Pinjaman</td> <td><input type='text' id='date2' name='tgl_selesai' size=15> YYYY-MM-DD</td></tr>
			<tr><td>Jumlah Pengajuan Pinjaman</td> <td><input type=text name='pinjaman' size=30></td></tr>
			<tr><td>Bunga Pinjaman</td><td><input type=text name='bunga' value='1.5' size=10> / Bulan</td></tr>		
			<tr><td>Tenor Pinjaman</td><td><input type=text name='tenor' size=10> Bulan / THR</td></tr>		
			<tr><td>Cabang</td> <td> <input type=hidden name='id_cabang' size=10 value='1'> 1</td></tr>	
			<tr><td>Counter</td> <td> <input type=hidden name='id_user' size=10 value='$_SESSION[id_user]'> $_SESSION[id_user]</td></tr>				
			<tr><td valign=top>Keterangan</td> <td> <textarea name='keterangan' rows='5' cols='60'></textarea></td></tr>
			<tr><td>Jumlah Gaji Terakhir</td> <td><input type=text name='gajiterakhir' size=30></td></tr>		
      <tr><td>File</td><td> <input type=file name='fupload' size=40></td></tr>			
			<tr><td>Nomor HP</td> <td><input type=text name='nohp' size=30></td></tr>	
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
		<form method=POST action=$aksi?module=pinjaman&act=update enctype='multipart/form-data'>
			<input type=hidden name=id value='$r[id_pinjaman]'>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td>Nomor Pinjaman</td> <td>  $r[id_pinjaman]</td></tr>
				<tr><td>Kode Pinjaman</td> <td> <input type=text name='kode_pinjaman' size=40 value='$r[kode_pinjaman]'></td></tr>
				<tr><td>NIK</td> <td> <input type=text name='nik' size=20 value='$r[nik]' readonly></td></tr>      
				<tr><td>Nama Anggota</td> <td><input type=text name='nama' size=70 value='$r2[nama]' readonly></td></tr>
				<tr><td>Tanggal Pengajuan Pinjaman</td> <td><input type=text name='tgl_pengajuan' size=30 value='$r[tgl_pengajuan]' readonly></td></tr>
				<tr><td>Tanggal Awal Pinjaman</td> <td><input type=text name='tgl_mulai' size=30 value='$r[tgl_mulai]'></td></tr>
				<tr><td>Tanggal Akhir Pinjaman</td> <td><input type=text name='tgl_selesai' size=30 value='$r[tgl_selesai]'></td></tr>
				<tr><td>Saldo Simpanan</td> <td><input type=date name='saldo_simpanan' size=30 value='$r[saldo_simpanan]' readonly></td></tr>
				<tr><td>Jumlah Pengajuan Pinjaman</td> <td> <input type=text name='pinjaman' size=40 value='$r[pinjaman]' readonly></td></tr>
				<tr><td>Pinjaman Disetujui</td> <td> <input type=text name='pinjamandisetujui' size=40 value='$r[pinjamandisetujui]'></td></tr>
				<tr><td>Tenor Pinjaman</td> <td><input type=text name='tenor' size=10 value='$r[tenor]'> Bulan </td></tr>	
				<tr><td>Bunga Pinjaman Flat</td> <td><input type=text name='bunga' size=10 value='$r[bunga]'> Bulan </td></tr>				
				<tr><td>Cabang</td> <td> <input type=text name='id_cabang' size=10 value='$r[id_cabang]' readonly></td></tr>	
				<tr><td>Counter</td> <td> <input type=text name='id_user' size=10 value='$r[id_user]' readonly></td></tr>		
				<tr><td>Keterangan<td> <textarea name='keterangan' rows='5' cols='60'>$r[keterangan]</textarea></td></tr>					
				<tr><td>Jumlah Slip Gaji</td> <td><input type=text name='gajiterakhir' size=10 value='$r[gajiterakhir]'></td></tr>
				<tr><td>Slip Gaji</td><td><a href='slip/m_$r[slipgaji]' target=_blank>$r[slipgaji]</a><td></tr>	
				<tr><td>Ganti File Gaji</td><td> <input type=file name='fupload' size=40></td></tr>	
				<tr><td>Nomor HP</td> <td><input type=text name='nohp' size=30 value='$r[nohp]'></td></tr>				
				<tr><td>Angsuran per Bulan</td> <td><input type=text name='angsuran_perbulan' size=10 value='$r[angsuran_perbulan]' readonly></td></tr>
				";				
				$tampil20 = mysql_query("SELECT * FROM dokumen WHERE id_pinjaman='$r[id_pinjaman]' ");				
				while ($r20=mysql_fetch_array($tampil20)){
					echo "<tr><td>$r20[keterangan]</td><td><a href='slip/$r20[nama_file]' target=_blank>$r20[nama_file]</a><td>";
				}
				if ($_SESSION[leveluser]=='konter'){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> S1 <input type=text name='s1' size=5 value='$r[s1]'> Y / N</td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> S1 <input type=text name='s2' size=5 value='$r[s2]' readonly> Y / N / R</td></tr>
				<tr><td>Approval General Manager </td> <td> S2 <input type=text name='s3' size=5 value='$r[s3]' readonly> Y / N </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> S3 <input type=text name='s4' size=5 value='$r[s4]' readonly> Y / N </td></tr>
				<tr><td>Approval Bendahara </td> <td> S4 <input type=text name='s5' size=5 value='$r[s5]' readonly> Y / N </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> S6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Y / N </td></tr>
				";
				}
				if ($_SESSION[leveluser]=='kaunit'){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> S1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Y / N</td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> S1 <input type=text name='s2' size=5 value='$r[s2]'> Y / N / R</td></tr>
				<tr><td>Approval General Manager </td> <td> S2 <input type=text name='s3' size=5 value='$r[s3]' readonly> Y / N </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> S3 <input type=text name='s4' size=5 value='$r[s4]' readonly> Y / N </td></tr>
				<tr><td>Approval Bendahara </td> <td> S4 <input type=text name='s5' size=5 value='$r[s5]' readonly> Y / N </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> S6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Y / N </td></tr>
				";
				}
				if ($_SESSION[leveluser]=='gm' ){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> S1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Y / N</td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> S1 <input type=text name='s2' size=5 value='$r[s2]' readonly> Y / N / R</td></tr>
				<tr><td>Approval General Manager </td> <td> S2 <input type=text name='s3' size=5 value='$r[s3]'> Y / N </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> S3 <input type=text name='s4' size=5 value='$r[s4]' readonly> Y / N </td></tr>
				<tr><td>Approval Bendahara </td> <td> S4 <input type=text name='s5' size=5 value='$r[s5]' readonly> Y / N </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> S6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Y / N </td></tr>
				";
				}
				if ($_SESSION[leveluser]=='kabid' ){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> S1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Y / N</td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> S1 <input type=text name='s2' size=5 value='$r[s2]' readonly> Y / N / R</td></tr>
				<tr><td>Approval General Manager </td> <td> S2 <input type=text name='s3' size=5 value='$r[s3]' readonly> Y / N </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> S3 <input type=text name='s4' size=5 value='$r[s4]'> Y / N </td></tr>
				<tr><td>Approval Bendahara </td> <td> S4 <input type=text name='s5' size=5 value='$r[s5]' readonly> Y / N </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> S6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Y / N </td></tr>
				";
				}		
				if ($_SESSION[leveluser]=='bendahara' ){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> S1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Y / N</td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> S1 <input type=text name='s2' size=5 value='$r[s2]' readonly> Y / N / R</td></tr>
				<tr><td>Approval General Manager </td> <td> S2 <input type=text name='s3' size=5 value='$r[s3]' readonly> Y / N </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> S3 <input type=text name='s4' size=5 value='$r[s4]' readonly> Y / N </td></tr>
				<tr><td>Approval Bendahara </td> <td> S4 <input type=text name='s5' size=5 value='$r[s5]'> Y / N </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> S6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Y / N </td></tr>
				";
				}				
				if ($_SESSION[leveluser]=='ketua' or $_SESSION[leveluser]=='admin'){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> S1 <input type=text name='s1' size=5 value='$r[s1]'> Y / N</td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> S1 <input type=text name='s2' size=5 value='$r[s2]'> Y / N / R</td></tr>
				<tr><td>Approval General Manager </td> <td> S2 <input type=text name='s3' size=5 value='$r[s3]'> Y / N </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> S3 <input type=text name='s4' size=5 value='$r[s4]'> Y / N </td></tr>
				<tr><td>Approval Bendahara </td> <td> S4 <input type=text name='s5' size=5 value='$r[s5]'> Y / N </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> S6 <input type=text name='s6' size=5 value='$r[s6]'> Y / N </td></tr>
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
				<td>$r[tenor_sewa]</td>
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
				<td>$r[tenor_sewa]</td>
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
	case "listpinjaman":
    echo "
		<h2>Data Pinjaman Reguler</h2>
			<a href='?module=pinjaman&act=tambahpinjaman' >Mengajukan Pinjaman Baru</a>
		<br>
		<br>
		Keterangan = A1: Counter, A2: Ka. Unit, A3: GM, A4: Ka. Bidang, A5: Bendahara, A6: Wakil/Ketua
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
		<th>No</th><th>NIK</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Tenor</th>
		<th>Jumlah<br>Pengajuan</th><th>Jumlah<br>Disetujui</th><th colspan=2>KD</th><th>P1</th><th>P2</th><th>P3</th><th>P4</th><th>P5</th><th>P6</th><th>Proses</th></tr>"; 		

		$tampil=mysql_query("SELECT * FROM pinjaman where nik='$_GET[id]' order by tgl_pengajuan desc");
		
		$no =1;
		while ($r=mysql_fetch_array($tampil)){
			$tampil2=mysql_query("SELECT * FROM anggota WHERE nik='$r[nik]' ");
			$r2=mysql_fetch_array($tampil2);
			
			$tampil3=mysql_query("SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
			$r3=mysql_fetch_array($tampil3);
			echo "
			<tr><td>$no</td>
			<td><a href='?module=angsuran&act=detailangsuran&id=$r[no_bukti]'>$r[no_bukti]</a></td>
			<td>$r[tgl_mulai]</td>
			<td>$r[tgl_selesai]</td>
			<td>$r[tenor]</td>
			<td align=right>".number_format($r[pinjaman])."</td>
			<td align=right>".number_format($r[pinjamandisetujui])."</td>		
			<td align=center>$r[jn_pinjaman]</td>	
			<td align=center>$r3[singkatan]</td>
			<td align=center>$r[s1]</td>
			<td align=center>$r[s2]</td>
			<td align=center>$r[s3]</td>
			<td align=center>$r[s4]</td>
			<td align=center>$r[s5]</td>
			<td align=center>$r[s6]</td>
			";
			echo "
			<td align=center nowrap>
				<a href=modul/mod_pinjaman/pinjamancetak.php?id=$r[id_pinjaman] target=_blank><i class='fa fa-print'></i></a>
			</td>
			</tr>";
			$no++;
		}
		echo "
		</table><br><br>";
	break;	
}
}
?>
