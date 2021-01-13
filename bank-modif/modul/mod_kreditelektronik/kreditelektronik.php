<?php
$aksi="modul/mod_kreditelektronik/aksi_kreditelektronik.php";
$tanggal=date('Y-m-d');
if (!isset($_GET['act'])) {
	echo "
	<h3>Daftar Kredit Elekronik</h3>";  
	echo "
	<table id='example1' class='table table-bordered table-striped'>
		<tr><th>No.</th><th>Nama Barang</th><th>Harga</th></tr>"; 
      $no=1;
      $tampil = mysqli_query($koneksi,"SELECT * FROM barangkredit ");		 
      while ($r=mysqli_fetch_array($tampil)){
				echo "
				<tr>
					<td>$no</td>
					<td><a href=?module=kreditelektronik&act=detail&id=$r[id_barangkredit]>$r[nama_barang]</a></td>
					<td align=right>".number_format($r['harga_tunai'])."</td>
				</tr>";
        $no++;
      }
	echo "</table>";
}
else {
	switch($_GET['act']){    
    case "detail":
     echo "
			<h3>Detail Barang</h3>
			<br><br>
			<table id='example1' class='table table-bordered table-striped'>
				<tr><th>No.</th><th>Type</th></tr>"; 
				$tampil = mysqli_query($koneksi,"SELECT * FROM barangkredit where id_barangkredit='$_GET[id]' ");		 
				$r=mysqli_fetch_array($tampil);
				$hargatunai=$r['harga_tunai'];
				$bungasebulan=0.01;
				$bunga6=$r['harga_tunai']*6*$bungasebulan;
				$bunga12=$r['harga_tunai']*12*$bungasebulan;
				$angsuran6=($bunga6+$r['harga_tunai'])/6;
				$angsuran12=($bunga12+$r['harga_tunai'])/12;
				echo "
				<tr><td>Kode Barang</td><td>$r[kd_barang]</td></tr>
				<tr><td>Nama Barang</td><td>$r[nama_barang]</td></tr>
				<tr><td>Harga</td><td align=right>".number_format($r['harga_tunai'])."</td></tr>		
				<tr><td valign=top>Deskripsi</td><td>".nl2br($r['deskripsi'])."</td></tr>
				<tr><td valign=top>Gambar</td><td><img src=foto_produk/$r[foto] width=100%></td></tr>
				<tr>
					<td>Cicilan 6 Kali</td>
					<td>".number_format($angsuran6)." 
					<a href='$aksi?module=kreditelektronik&act=input&kd_barang=$r[kd_barang]&tenor=6&pinjaman=$r[harga_tunai]&bunga=$bunga6&angsuran=$angsuran6&id=$r[kd_barang]'>Ajukan Sekarang</a>
					</td></tr>
				<tr>
					<td>Cicilan 12 Kali</td>
					<td>".number_format($angsuran12)."<input type=button class='btn btn-primary btn' value='Ajukan Kredit 12 Bulan' 
          onclick=\"window.location.href='$aksi?module=kreditelektronik&act=input&tenor=12&id=$r[kd_barang]';\"></td>
				</tr>
			</table>";
			echo "<input type=button class='btn btn-primary btn' value=Back onclick=self.history.back()>&nbsp;";
    break;  
}
}
?>
