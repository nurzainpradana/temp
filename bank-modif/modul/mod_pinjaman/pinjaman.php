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
if (!isset($_GET['act'])) {
	if ($_SESSION['leveluser']=='anggota'){
		// <a href='?module=pinjaman&act=tambahpinjaman2' > Form Mengajukan Pinjaman Baru</a>
    echo "
		<h2>Pinjaman Reguler</h2>
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
		<th>No.</th><th>Keterangan</th></tr>"; 		

		$tampil=mysqli_query($koneksi, "SELECT * FROM pinjaman where nik='$_SESSION[namauser]' order by tgl_pengajuan desc");
		
		$no =1;
		while ($r=mysqli_fetch_array($tampil)){
			$tampil2=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik='$r[nik]' ");
			$r2=mysqli_fetch_array($tampil2);
			
			if ($r['s5']=='Y'){
				$status='Disetujui';
			}	
			else if ($r['s5']=='N'){
				$status='Ditolak';
			}				
			else {
				$status='Diproses';
			}	
			echo "
			<tr>
				<td width=5>$no</td>
				<td>
					No.Pinjaman: $r[id_pinjaman]
					<br>Tanggal Pengajuan: $r[tgl_pengajuan]
					<br>Keterangan: $r[keterangan]
					<br>Status Pinjaman: $status
					<br>Jumlah Pengajuan: ".number_format($r['pinjaman'])."	
					<br>Jumlah Disetujui: ".number_format($r['pinjamandisetujui'])."	
					<br>Tenor: $r[tenor]
					<br>Tanggal Mulai: $r[tgl_mulai]
					<br>Tanggal Selesai: $r[tgl_selesai]
					<br>Tanggal Lunas: $r[cutoff_pinjaman]";
					if ($status=='Disetujui') {
						echo "
						<hr><a href=?module=pinjaman&act=angsuran&id=$r[id_pinjaman]><h3>RIWAYAT PEMBAYARAN</h3></a>
						";
					}
					echo "
				</td>";
			echo "
			</tr>";
			$no++;
		}
		echo "
		</table>";

	}	
	else {
		
    echo "
		<h2>Data Pinjaman Reguler</h2>
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
			<form method=POST action='?module=pinjaman&act=caritanggal' >
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
		<th>No</th><th>No Pinjaman</th><th>NIK</th><th>Nama Anggota</th><th>Tanggal<br>Pengajuan</th><th>Tanggal<br>Cair</th><th>Tenor</th>
		<th>Jumlah<br>Pengajuan</th><th>Jumlah<br>Disetujui</th><th colspan=2>KD</th><th>A1</th><th>A2</th><th>A3</th><th>A4</th><th>A5</th><th>A6</th><th>Proses</th></tr>"; 		

		$tampil=mysqli_query($koneksi, "SELECT * FROM pinjaman order by tgl_pengajuan desc");
		
		$no = 1;
		while ($r=mysqli_fetch_array($tampil)){
			$tampil2=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik='$r[nik]' ");
			$r2=mysqli_fetch_array($tampil2);
			
			$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
			$r3=mysqli_fetch_array($tampil3);
			
			echo "
			<tr><td>$no</td>
			<td>$r[no_bukti]</td>
			<td>$r[nik]</td>
			<td>".substr($r2['nama'],0,15)."</td>
			<td>$r[tgl_pengajuan] </td>
			<td> $r[tgl_mulai] </td>
			<td>$r[tenor]</td>
			<td align=right>".number_format($r['pinjaman'])."</td>
			<td align=right>".number_format($r['pinjamandisetujui'])."</td>	
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
				<a href=?module=pinjaman&act=editpinjaman&id=$r[id_pinjaman]><i class='fa fa-pencil'></i></a> &nbsp;";
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
	}	
}
else {
	switch($_GET['act']){

	case "angsuran":
			$tampil=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik ='$_SESSION[namauser]' ");
			$r1=mysqli_fetch_array($tampil);
			$ketemu=mysqli_num_rows($tampil);		
			if ($ketemu == 0){
				echo "<h2>Nomor nik tidak ditemukan</h2><br><br>
				<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>";
				return;
			}
			$tampil2=mysqli_query($koneksi, "SELECT * FROM divisi where id_divisi='$r1[id_divisi]' ");
			$r2=mysqli_fetch_array($tampil2);
			$tampil3=mysqli_query($koneksi, "SELECT * FROM seksi where id_seksi='$r1[id_seksi]' ");
			$r3=mysqli_fetch_array($tampil3);
			
			$edit=mysqli_query($koneksi, "SELECT * FROM pinjaman WHERE id_pinjaman='$_GET[id]' and nik='$_SESSION[namauser]' ");
			$r4=mysqli_fetch_array($edit);
			
			echo "
			<h4>Data Anggota</h4>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td colspan=2><b>Data Anggota</b></td></tr>
				<tr><td>Nomor Pinjaman</td> <td> $_GET[id]</td></tr>				
				<tr><td>Nomor Induk Karyawan</td> <td> $r1[nik]</td></tr>
				<tr><td>Nama Karyawan</td> <td> $r1[nama]</td></tr>		
		</table>";
		echo "<h4>Data Pinjaman</h4>
				<table id='example1' class='table table-bordered table-striped'>
				<tr><td>Nomor Pinjaman</td> <td>  $r4[id_pinjaman]</td></tr>
				<tr><td>Tanggal Pengajuan Pinjaman</td> <td>$r4[tgl_pengajuan]</td></tr>
				<tr><td>Tanggal Mulai - Selesai</td> <td>$r4[tgl_mulai] - $r4[tgl_selesai]</td></tr>
				<tr><td>Pinjaman Disetujui</td> <td> ".number_format($r4['pinjamandisetujui'])."</td></tr>
				<tr><td>Tenor Pinjaman</td> <td>$r4[tenor] Bulan </td></tr>	
				<tr><td>Jasa Pinjaman </td><td>$r4[bunga] Bulan </td></tr>
		</table>";
		echo "
		<h4>Data Angsuran Pinjaman</h4>
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
			<th>No</th><th>Tanggal Bayar</th><th>Jumlah Angsuran</th>
		</tr>"; 		
		$tampil=mysqli_query($koneksi, "SELECT * FROM angsurandetail where No_Pengajuan ='$_GET[id]'");
		$no = 1;
		$i=0;
		$sisapokokpinjaman=0;
		$totalpokok=0;
		$totalangsuran=0;
		$totalbunga=0;
		while ($r=mysqli_fetch_array($tampil)){
			echo "
			<tr>
				<td>$no</td>
				<td>$r[Tgl_Bayar]</td>				
				<td align=right>".number_format($r['Bayar_Angsuran'])."</td>";
				$no++;
				$i=$i+1;
				$totalpokok=$totalpokok+$r['Bayar_Pokok'];
				$totalbunga=$totalbunga+$r['Bayar_Bunga'];
				$totalangsuran=$totalangsuran+$r['Bayar_Angsuran'];
		}
		$sisa=$r4['tenor']-$i;
		$sisapokokpinjaman=$r4['pinjamandisetujui']-$totalpokok;
		echo "
		</tr>
		<tr>
			<td colspan=2>Total angsuran telah dibayar</td>
			<td align=right>".number_format($totalangsuran)."</td>
		</tr>
		<tr>
			<td>Sisa ansuran / pokok</td>
			<td> $sisa x lagi</td>
			<td align=right>".number_format($sisapokokpinjaman)."</td>
		</tr>
	</table>";
	
	break;	
	case "tambahpinjaman":
		$tampil=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik ='$_POST[nik]' ");
		$r=mysqli_fetch_array($tampil);
		$ketemu=mysqli_num_rows($tampil);		
		if ($ketemu == 0){
			echo "<h2>Nomor nik tidak ditemukan</h2><br><br>
			<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>";
			return;
		}
		//date_default_timezone_get('Asia/Jakarta');
		/*
		$tanggal_now = date('Y-m-d');
		$tambah_tanggal = mktime(0,0,0,date('m')+0,date('d')+0,date('Y')+30); // angka 2,7,1 yang dicetak tebal bisa dirubah rubah
		$tambah = date('Y-m-d',$tambah_tanggal);
		echo "Tanggal Sekarang : ".$tanggal_now."<br>";
		echo "Tanggal Pensiun  :".$tambah;
		*/

	$tgl1 = "$r[tgl_lahir]";// pendefinisian tanggal awal
	$tgl2 = date('Y-m-d', strtotime('+55 years', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 6 hari
	//echo "Tanggal Lahir:   $tgl1<br>";
	//echo "Tanggal Pensiun: $tgl2"; 	
		
	$tampil1=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='01' and nik ='$_POST[nik]' ");
	$r1=mysqli_fetch_array($tampil1);
	$tampil2=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='02' and nik ='$_POST[nik]' ");
	$r2=mysqli_fetch_array($tampil2);
	$tampil3=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='03' and nik ='$_POST[nik]' ");
	$r3=mysqli_fetch_array($tampil3);	
	$tampil4=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='04' and nik ='$_POST[nik]' ");
	$r4=mysqli_fetch_array($tampil4);		
		

	$tampil5=mysqli_query($koneksi, "SELECT * FROM transaksi102detail where nik ='$_POST[nik]' order by tanggal");
	$no = $posisi+1;
	while ($r5=mysqli_fetch_array($tampil5)){
		$totalsw=$totalsw+$r5[nilai];
	}
			
	$tampil6=mysqli_query($koneksi, "SELECT * FROM transaksi104detail where nik ='$_POST[nik]' order by tanggal");
	while ($r6=mysqli_fetch_array($tampil6)){
			$totalsk=$totalsk+$r6[nilai];
	}
		
	$tampil7=mysqli_query($koneksi, "SELECT * FROM transaksi103detail where nik ='$_POST[nik]' order by tanggal");
	$no = $posisi+1;
	while ($r7=mysqli_fetch_array($tampil7)){
			$totalss=$totalss+$r7[nilai];
	}
		
	$tampil8=mysqli_query($koneksi, "SELECT * FROM penarikandetail where nik ='$_POST[nik]' order by tanggal");
	while ($r8=mysqli_fetch_array($tampil8)){
			$totaltarik=$totaltarik+$r8[total_tarik];
	}

	$totalswnya=$totalsw+$r2[saldo];
	$totalsknya=$totalsk+$r4[saldo];
	$sisasimpananss=$totalss-$totaltarik+$r3[saldo];
	
		$tampil12=mysqli_query($koneksi, "SELECT * FROM divisi where id_divisi='$r[id_divisi]' ");
		$r12=mysqli_fetch_array($tampil12);
		$tampil13=mysqli_query($koneksi, "SELECT * FROM seksi where id_seksi='$r[id_seksi]' ");
		$r13=mysqli_fetch_array($tampil13);
		echo "
		<h2>Data Anggota</h2>
		<form method=POST action='?module=pinjaman&act=tambahpinjamannya'>
		<table id='example1' class='table table-bordered table-striped'>
			<tr><td colspan=2><b>Data Anggota</b></td></tr>
			<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nama_mediator' value='$r[nik]' size=10 ></td></tr>
			<tr><td>Nama Karyawan</td> <td> <input type=text name='ktp_mediator' value='$r[nama]' size=40 ></td></tr>
			<tr><td>Jenis Anggota</td> <td> <input type=text name='jenis_anggota' value='$r[jenis_anggota]' size=30></td></tr>		
			<tr><td>Tanggal Lahir</td> <td> <input type=text name='jenis_anggota' value='$r[tgl_lahir]' size=30></td></tr>	
			<tr><td>Tanggal Pensiun</td> <td> <input type=text name='tanggal_pensiun' value='$tgl2' size=30></td></tr>			
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
	<th>Jumlah Disetujui</th><th>Angsuran</th><th>Tanggal Pelunasan</th></tr>"; 	
	$tampil=mysqli_query($koneksi, "SELECT * FROM pinjaman where nik ='$_POST[nik]' order by tgl_pengajuan desc");	
	$no = $posisi+1;
	while ($r=mysqli_fetch_array($tampil)){
		
		$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
		$r3=mysqli_fetch_array($tampil3);
		echo "
		<tr><td>$no</td>
			<td><a href='?module=angsuran&id=$r[no_bukti]'>$r[no_bukti]</a></td>
			<td>$r[nik]</td>
			<td>$r[tgl_mulai]</td>
			<td>$r[tgl_selesai]</td>
			
			<td>$r[tenor]</td>
			<td align=right>".number_format($r[pinjamandisetujui])."</td>
			<td align=right>".number_format($r[angsuran_perbulan])."</td>			
			<td>$r[cutoff_pinjaman]</td>
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
	$tampil=mysqli_query($koneksi, "SELECT * FROM pinjamannr where nik ='$_POST[nik]' order by tgl_pengajuan desc");
	$no = $posisi+1;
	while ($r=mysqli_fetch_array($tampil)){
		echo "
		<tr><td>$no</td>
		<td>$r[nik]</td>
		<td>$r[tenor]</td>	
		<td align=right>".number_format($r[pinjamandisetujui])."</td>
		<td align=right>".number_format($r[angsuran])."</td>		
		<td>$r[tgl_mulai]</td>
		<td>$r[tgl_selesai]</td>
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
	$tampil=mysqli_query($koneksi, "SELECT * FROM pinjamanthr where nik ='$_POST[nik]' order by tgl_pengajuan desc");	
	$no = $posisi+1;
	while ($r=mysqli_fetch_array($tampil)){
		
		$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori WHERE kd_pinjaman='$r[kode_pinjaman]' ");
		$r3=mysqli_fetch_array($tampil3);
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
		$tampil1=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik ='$_POST[id]' ");
		$r1=mysqli_fetch_array($tampil1);
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
					$tampil2=mysqli_query($koneksi, "SELECT * FROM pinjamanjenis ");
					while($r2=mysqli_fetch_array($tampil2)){
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
					$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori ");
					while($r3=mysqli_fetch_array($tampil3)){
					  echo "<option value=$r3[kode_pinjaman]>$r3[kode_pinjaman] | $r3[nama_pinjaman]</option>";
					}
				  echo "</select>
				</td>
			</tr>	
			<tr><td>Tanggal Pengajuan Pinjaman</td><td><input type=text name='tgl_pengajuan' value='$tanggal' size=15></td></tr>
			<tr><td>Tanggal Perkiraan Pinjaman Cair</td> <td><input type='text' id='date1' name='tgl_mulai' size=15> YYYY-MM-DD</td></tr>
			<tr><td>Tanggal Akhir Pinjaman</td> <td><input type='text' id='date2' name='tgl_selesai' size=15 readonly> [dikosongkan], Tanggal Pensiun: $_POST[tanggal_pensiun]</td></tr>
			<tr><td>Jumlah Pengajuan Pinjaman</td> <td><input type=text name='pinjaman' size=30></td></tr>
			<tr><td>Bunga Pinjaman</td><td><input type=text name='bunga' value='1.5' size=10> / Bulan</td></tr>		
			<tr><td>Tenor Pinjaman</td><td><input type=text name='tenor' size=10> Bulan / THR</td></tr>		
			<tr><td>Cabang</td> <td> <input type=hidden name='id_cabang' size=10 value='1'> 1</td></tr>	
			<tr><td>Counter</td> <td> <input type=hidden name='id_user' size=10 value='$_SESSION[id_user]'> $_SESSION[id_user]</td></tr>				
			<tr><td valign=top>Keterangan</td> <td> <textarea name='keterangan' rows='5' cols='60'></textarea></td></tr>
			<tr><td>Plafon Angsuran per Bulan 40%</td> <td><input type=text name='gajiterakhir' size=30></td></tr>		
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

	case "tambahpinjaman2":
		$tampil=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik ='$_SESSION[namauser]' ");
		$r=mysqli_fetch_array($tampil);
		$ketemu=mysqli_num_rows($tampil);		
		if ($ketemu == 0){
			echo "<h2>Nomor nik tidak ditemukan</h2><br><br>
			<input class='btn btn-danger btn-flat' type=button value=Batal onclick=self.history.back()>";
			return;
		}
	$totalswnya=0;	
	$totalsknya=0;
	$sisasimpananss=0;
	$totalsw=0;
	$totalss=0;
	$totaltarik=0;
	$tampil1=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='01' and nik ='$_SESSION[namauser]' ");
	$r1=mysqli_fetch_array($tampil1);
	$tampil2=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='02' and nik ='$_SESSION[namauser]' ");
	$r2=mysqli_fetch_array($tampil2);
	$tampil3=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='03' and nik ='$_SESSION[namauser]' ");
	$r3=mysqli_fetch_array($tampil3);	
	$tampil4=mysqli_query($koneksi, "SELECT * FROM saldoawaldetail where kode_trans ='04' and nik ='$_SESSION[namauser]' ");
	$r4=mysqli_fetch_array($tampil4);		
		

	$tampil5=mysqli_query($koneksi, "SELECT * FROM transaksi102detail where nik ='$_SESSION[namauser]' order by tanggal");
	$no = 1;
	while ($r5=mysqli_fetch_array($tampil5)){
		$totalsw=$totalsw+$r5['nilai'];
	}
			
		
	$tampil7=mysqli_query($koneksi, "SELECT * FROM transaksi103detail where nik ='$_SESSION[namauser]' order by tanggal");
	$no = 1;
	while ($r7=mysqli_fetch_array($tampil7)){
			$totalss=$totalss+$r7[nilai];
	}

	$totalswnya=$totalsw+$r2['saldo'];
	$sisasimpananss=$totalss-$totaltarik+$r3['saldo'];
	
		$tampil12=mysqli_query($koneksi, "SELECT * FROM divisi where id_divisi='$r[id_divisi]' ");
		$r12=mysqli_fetch_array($tampil12);
		$tampil13=mysqli_query($koneksi, "SELECT * FROM seksi where id_seksi='$r[id_seksi]' ");
		$r13=mysqli_fetch_array($tampil13);
		echo "
		<h2>Data Anggota</h2>
		<form method=POST action='?module=pinjaman&act=tambahpinjamannya2'>
		<table id='example1' class='table table-bordered table-striped'>
			<tr><td colspan=2><b>Data Anggota</b></td></tr>
			<tr><td>Nomor Induk Karyawan</td> <td> <input type=text name='nama_mediator' value='$r[nik]' size=10 ></td></tr>
			<tr><td>Nama Karyawan</td> <td> <input type=text name='ktp_mediator' value='$r[nama]' size=40 ></td></tr>
			<tr><td>Divisi</td> <td> <input type=text name='bank_mediator' value='$r[id_divisi]' size=40 > $r12[nama_divisi]</td></tr>	
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
	$tampil=mysqli_query($koneksi, "SELECT * FROM pinjaman where nik ='$_SESSION[namauser]' order by tgl_pengajuan desc");	
	$no = 1;
	while ($r=mysqli_fetch_array($tampil)){
		
		$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
		$r3=mysqli_fetch_array($tampil3);
		echo "
		<tr><td>$no</td>
			<td><a href='?module=angsuran&id=$r[no_bukti]'>$r[no_bukti]</a></td>
			<td>$r[nik]</td>
			<td>$r[tgl_mulai]</td>
			<td>$r[tgl_selesai]</td>
			<td>$r[tenor]</td>
			<td align=right>".number_format($r['pinjamandisetujui'])."</td>
			<td align=right>".number_format($r['angsuran_perbulan'])."</td>			
			<td align=center>$r[cutoff_pinjaman]</td>
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
	$tampil=mysqli_query($koneksi, "SELECT * FROM pinjamannr where nik ='$_SESSION[namauser]' order by tgl_pengajuan desc");
	$no = 1;
	while ($r=mysqli_fetch_array($tampil)){
		echo "
		<tr><td>$no</td>
		<td>$r[nik]</td>
		<td>$r[tenor]</td>	
		<td align=right>".number_format($r['pinjamandisetujui'])."</td>
		<td align=right>".number_format($r['angsuran'])."</td>		
		<td>$r[tgl_awal]</td>
		<td>$r[tgl_akhir]</td>
		<td>$r[lunas]</td>";
		$no++;
	}
	echo "
	</table>";
	break;		
		
	case "tambahpinjamannya2":

		// Form Tambah spk
		$tampil1=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik ='$_SESSION[namauser]' ");
		$r1=mysqli_fetch_array($tampil1);
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
					$tampil2=mysqli_query($koneksi, "SELECT * FROM pinjamanjenis ");
					while($r2=mysqli_fetch_array($tampil2)){
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
					$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori ");
					while($r3=mysqli_fetch_array($tampil3)){
					  echo "<option value=$r3[kode_pinjaman]>$r3[kode_pinjaman] | $r3[nama_pinjaman]</option>";
					}
				  echo "</select>
				</td>
			</tr>	
			<tr><td>Tanggal Pengajuan Pinjaman</td><td><input type=text name='tgl_pengajuan' value='$tanggal' size=15></td></tr>
			<tr><td>Tanggal Awal Pinjaman</td> <td><input type='text' id='date1' name='tgl_mulai' size=15> YYYY-MM-DD</td></tr>
			<tr><td>Tanggal Akhir Pinjaman</td> <td><input type='text' id='date2' name='tgl_selesai' size=15 readonly> YYYY-MM-DD</td></tr>
			<tr><td>Jumlah Pengajuan Pinjaman</td> <td><input type=text name='pinjaman' size=30></td></tr>
			<tr><td>Bunga Pinjaman</td><td><input type=text name='bunga' value='1.5' size=10> / Bulan</td></tr>		
			<tr><td>Tenor Pinjaman</td><td><input type=text name='tenor' size=10> Bulan / THR</td></tr>		
			<tr><td>Cabang</td> <td> <input type=hidden name='id_cabang' size=10 value='1'> 1</td></tr>	
			<tr><td>Counter</td> <td> <input type=hidden name='id_user' size=10 value='$_SESSION[id_user]'> $_SESSION[id_user]</td></tr>				
			<tr><td valign=top>Keterangan</td> <td> <textarea name='keterangan' rows='5' cols='60'></textarea></td></tr>
			<tr><td>Plafon Angsuran per Bulan 40%</td> <td><input type=text name='gajiterakhir' size=30></td></tr>		
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
		$edit=mysqli_query($koneksi, "SELECT * FROM pinjaman WHERE id_pinjaman='$_GET[id]' ");
		$r=mysqli_fetch_array($edit);
		$edit2=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik='$r[nik]' ");
		$r2=mysqli_fetch_array($edit2);
		$query = mysqli_query($koneksi, "SELECT nik, MONTH(curdate()) - MONTH(tgl_lahir) AS bulan, YEAR(curdate()) - YEAR(tgl_lahir) AS usia FROM anggota WHERE nik='$r[nik]'");	
		$r3=mysqli_fetch_array($query);
		$tgl1 = "$r2[tgl_lahir]";
		$tgl2 = date('Y-m-d', strtotime('+55 years', strtotime($tgl1)));	
		$tglsekarang = date("Y-m-d");		
		$tgl3 = date('Y-m-d', strtotime('-55 years', strtotime($tglsekarang)));			
		echo "
		<h2>Edit Pinjaman</h2>
		<form method=POST action=$aksi?module=pinjaman&act=update enctype='multipart/form-data'>
			<input type=hidden name=id value='$r[id_pinjaman]'>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><td>Nomor Pinjaman</td> <td>  $r[id_pinjaman]</td></tr>
				<tr><td>Kode Pinjaman</td> <td> <input type=text name='kode_pinjaman' size=40 value='$r[kode_pinjaman]'></td></tr>
				<tr><td>NIK</td> <td> <input type=text name='nik' size=20 value='$r[nik]' readonly></td></tr>      
				<tr><td>Nama Anggota</td> <td><input type=text name='nama' size=70 value='$r2[nama]' readonly></td></tr>
				<tr><td>Tanggal Lahir</td> <td><input type=text name='tgl_lahir' size=30 value='$r2[tgl_lahir]' readonly> 
				Tanggal Pensiun <input type=text name='tgl_lahir' size=30 value='$tgl2' readonly>  Usia: $r3[usia] tahun $r3[bulan] bulan
				</td></tr>			
				<tr><td>Tanggal Pengajuan Pinjaman</td> <td><input type=text name='tgl_pengajuan' size=30 value='$r[tgl_pengajuan]' readonly></td></tr>
				<tr><td>Tanggal Perkiraan Pinjaman Cair</td> <td><input type=text name='tgl_mulai' size=30 value='$r[tgl_mulai]'>
				Tanggal Akhir Pinjaman <input type=text name='tgl_selesai' size=30 value='$r[tgl_selesai]'>
				</td></tr>
				<tr><td>Saldo Simpanan</td> <td><input type=text name='saldo_simpanan' size=30 value='$r[saldo_simpanan]' readonly></td></tr>
				<tr><td>Jumlah Pengajuan Pinjaman</td> <td> <input type=text name='pinjaman' size=40 value='$r[pinjaman]' readonly></td></tr>
				<tr><td>Pinjaman Disetujui</td> <td> <input type=text name='pinjamandisetujui' size=40 value='$r[pinjamandisetujui]'></td></tr>
				<tr><td>Tenor Pinjaman</td> <td><input type=text name='tenor' size=10 value='$r[tenor]'> Bulan </td></tr>	
				<tr><td>Bunga Pinjaman Flat</td> <td><input type=text name='bunga' size=10 value='$r[bunga]'> Bulan </td></tr>				
				<input type=hidden name='id_cabang' size=10 value='$r[id_cabang]'>
				<tr><td>Teller</td> <td> <input type=text name='id_user' size=10 value='$r[id_user]' readonly></td></tr>		
				<tr><td>Keterangan & Catatan<td> <textarea name='keterangan' rows='3' cols='90'>$r[keterangan]</textarea></td></tr>					
				<tr><td>Plafon Angsuran per Bulan 40%</td> <td><input type=text name='gajiterakhir' size=10 value='$r[gajiterakhir]'></td></tr>
				<tr><td>Slip Gaji</td><td><a href='slip/m_$r[slipgaji]' target=_blank>$r[slipgaji]</a><td></tr>	
				<tr><td>Ganti File Gaji</td><td> <input type=file name='fupload' size=40></td></tr>	
				<tr><td>Nomor HP</td> <td><input type=text name='nohp' size=30 value='$r[nohp]'></td></tr>				
				<tr><td>Angsuran per Bulan</td> <td><input type=text name='angsuran_perbulan' size=10 value='$r[angsuran_perbulan]' readonly></td></tr>
				";				
				$tampil20 = mysqli_query($koneksi, "SELECT * FROM dokumen WHERE id_pinjaman='$r[id_pinjaman]' ");				
				while ($r20=mysqli_fetch_array($tampil20)){
					echo "<tr><td>$r20[keterangan]</td><td><a href='slip/$r20[nama_file]' target=_blank>$r20[nama_file]</a><td>";
				}	
				echo "<tr><td>Komen pengurus dan pengelola</td> <td>
				<a href='modul/mod_komentar/komentar.php?id=$r[id_pinjaman]' onclick='window.open(this.href,&quot;popupwindow&quot;,&quot;status=0, height=500, width=650, scrollbars=yes, resizable=0, top=0, left=0&quot;); return false;' target='_blank'>
				Lihat & Isi Komentar Disini</a>
				</td></tr>
				<tr><td colspan=2>KETERANGAN APROVAL Y:Setuju, N:Ditolak, C:Komentar</td></tr>	";										
				if ($_SESSION[leveluser]=='konter'){
				echo "			
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> A1 <input type=text name='s1' size=5 value='$r[s1]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> A2 <input type=text name='s2' size=5 value='$r[s2]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval General Manager </td> <td> A3 <input type=text name='s3' size=5 value='$r[s3]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> A4 <input type=text name='s4' size=5 value='$r[s4]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Bendahara </td> <td> A5 <input type=text name='s5' size=5 value='$r[s5]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> A6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				";
				}
				if ($_SESSION[leveluser]=='kaunit'){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> A1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> A2 <input type=text name='s2' size=5 value='$r[s2]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval General Manager </td> <td> A3 <input type=text name='s3' size=5 value='$r[s3]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> A4 <input type=text name='s4' size=5 value='$r[s4]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Bendahara </td> <td> A5 <input type=text name='s5' size=5 value='$r[s5]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> A6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				";
				}
				if ($_SESSION[leveluser]=='gm' ){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> A1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> A2 <input type=text name='s2' size=5 value='$r[s2]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval General Manager </td> <td> A3 <input type=text name='s3' size=5 value='$r[s3]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> A4 <input type=text name='s4' size=5 value='$r[s4]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Bendahara </td> <td> A5 <input type=text name='s5' size=5 value='$r[s5]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> A6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				";
				}
				if ($_SESSION[leveluser]=='kabid' ){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> A1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> A2 <input type=text name='s2' size=5 value='$r[s2]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval General Manager </td> <td> A3 <input type=text name='s3' size=5 value='$r[s3]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> A4 <input type=text name='s4' size=5 value='$r[s4]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Bendahara </td> <td> A5 <input type=text name='s5' size=5 value='$r[s5]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> A6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				";
				}		
				if ($_SESSION[leveluser]=='bendahara' ){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> A1 <input type=text name='s1' size=5 value='$r[s1]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> A2 <input type=text name='s2' size=5 value='$r[s2]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval General Manager </td> <td> A3 <input type=text name='s3' size=5 value='$r[s3]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> A4 <input type=text name='s4' size=5 value='$r[s4]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Bendahara </td> <td> A5 <input type=text name='s5' size=5 value='$r[s5]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> A6 <input type=text name='s6' size=5 value='$r[s6]' readonly> Mohon diisi dengan: Y / N / C </td></tr>
				";
				}				
				if ($_SESSION[leveluser]=='ketua' or $_SESSION[leveluser]=='admin'){
				echo "
				<tr><td>Pemeriksaan awal oleh Konter </td> <td> A1 <input type=text name='s1' size=5 value='$r[s1]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Pemeriksaan oleh Kepala Unit </td> <td> A2 <input type=text name='s2' size=5 value='$r[s2]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval General Manager </td> <td> A3 <input type=text name='s3' size=5 value='$r[s3]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Pengurus Bidang </td> <td> A4 <input type=text name='s4' size=5 value='$r[s4]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Bendahara </td> <td> A5 <input type=text name='s5' size=5 value='$r[s5]'> Mohon diisi dengan: Y / N / C </td></tr>
				<tr><td>Approval Ketua/Wakil Pengurus </td> <td> A6 <input type=text name='s6' size=5 value='$r[s6]'> Mohon diisi dengan: Y / N / C </td></tr>
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

	$tampil = mysqli_query($koneksi, "SELECT * FROM pinjaman WHERE $field LIKE '%$keyword%' ORDER BY id_pinjaman DESC");
	echo "
	<h2>Cari Pelanggan SPB</h2>
	$field | $keyword <br><br>";
	echo "
	<table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>No.SPB</th><th>CB</th><th>Pelanggan</th><th>Tgl.Mulai</th><th>Tgl.Selesai</th>
	<th>Term</th><th>J<br>U</th><th>Sales</th><th>Fee</th><th>Nopol</th></tr>"; 
	$no=1;
	while ($r=mysqli_fetch_array($tampil)){
		$namapel=mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$r[id_pelanggan]'");
		$b1=mysqli_fetch_array($namapel);
		$namauser=mysqli_query($koneksi, "SELECT * FROM users WHERE id_user='$r[id_user]'");
		$b2=mysqli_fetch_array($namauser);
		$detail=mysqli_query($koneksi, "SELECT * FROM pinjamandetailalokasi WHERE id_pinjaman='$r[id_pinjaman]'");
		
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
				while ($b3=mysqli_fetch_array($detail)){
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

	$tampil = mysqli_query($koneksi, "SELECT * FROM pinjaman WHERE $field LIKE '%$keyword%' ORDER BY id_pinjaman DESC");
	echo "
	<h2>Cari Sales SPB</h2>
	$field | $keyword <br><br>";
	echo "
	<table id='example1' class='table table-bordered table-striped'>
	<tr>
	<th>No</th><th>No.SPB</th><th>CB</th><th>Pelanggan</th><th>Tgl.Mulai</th>
	<th>Term</th><th>J<br>U</th><th>Sales</th><th>Fee</th><th>S1</th><th>S2</th><th>S3</th><th>S4</th></tr>"; 
	$no=1;
	while ($r=mysqli_fetch_array($tampil)){
		$namapel=mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan='$r[id_pelanggan]'");
		$b1=mysqli_fetch_array($namapel);
		$namauser=mysqli_query($koneksi, "SELECT * FROM users WHERE id_user='$r[id_user]'");
		$b2=mysqli_fetch_array($namauser);
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

		$tampil=mysqli_query($koneksi, "SELECT * FROM pinjaman where nik='$_GET[id]' order by tgl_pengajuan desc");
		
		$no =1;
		while ($r=mysqli_fetch_array($tampil)){
			$tampil2=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik='$r[nik]' ");
			$r2=mysqli_fetch_array($tampil2);
			
			$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
			$r3=mysqli_fetch_array($tampil3);
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
	case "caritanggal":
		$tgl1=$_POST[tgl1];
		$tgl2=$_POST[tgl2];
		echo "Tanggal :$tgl1 s/d $tgl2 <br>";
		echo "
		<table id='example1' class='table table-bordered table-striped'>
		<form method=POST action='?module=pinjaman&act=caritanggal' >
		<tr>
			<td>Tanggal </td>
			<td><input type='text' name='tgl1' size='20'/> s/d <input type='text' name='tgl2' size='20'/>
				<input type='submit' name='Submit' value='Search' />
			</td>
		</tr>
		</form>
		</table><br>";
		$tampil=mysqli_query($koneksi, "SELECT * FROM pinjaman where tgl_pengajuan >= '$tgl1' and tgl_pengajuan <= '$tgl2'	");
		$no = $posisi+1;
		echo "
		<table id='example1' class='table table-bordered table-striped'>
		<tr>
		<th>No</th><th>No Pinjaman</th><th>NIK</th><th>Nama Anggota</th><th>Tanggal<br>Pengajuan</th><th>Tenor</th>
		<th>Jumlah<br>Pengajuan</th><th>Jumlah<br>Disetujui</th><th colspan=2>KD</th><th>A1</th><th>A2</th><th>A3</th><th>A4</th><th>A5</th><th>A6</th><th>Proses</th></tr>"; 
		while ($r=mysqli_fetch_array($tampil)){
			$tampil2=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik='$r[nik]' ");
			$r2=mysqli_fetch_array($tampil2);
			
			$tampil3=mysqli_query($koneksi, "SELECT * FROM pinjamankategori WHERE kode_pinjaman='$r[kode_pinjaman]' ");
			$r3=mysqli_fetch_array($tampil3);
			
			echo "
			<tr><td>$no</td>
			<td>$r[no_bukti]</td>
			<td>$r[nik]</td>
			<td>".substr($r2[nama],0,15)."</td>
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
				<a href=?module=pinjaman&act=editpinjaman&id=$r[id_pinjaman]><i class='fa fa-pencil'></i></a> &nbsp;";
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
		break;		
}
}
?>
