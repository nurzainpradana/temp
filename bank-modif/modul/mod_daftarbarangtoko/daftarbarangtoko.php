<?php
if (!isset($_GET['act'])) {
	echo "
	<h3>Daftar stock</h3>";  
	echo "
	<table id='example1' class='table table-bordered table-striped'>
		<tr><th>No.</th><th>Nama Barang</th><th>Harga</th></tr>"; 
      $no=1;
      $tampil = mysqli_query($koneksi,"SELECT * FROM stock ");		 
      while ($r=mysqli_fetch_array($tampil)){
				echo "
				<tr>
					<td>$no</td>
					<td><a href=?module=daftarbarangtoko&act=detail&id=$r[id_stock]>$r[nama_barang]</a></td>
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
				$tampil = mysqli_query($koneksi,"SELECT * FROM stock where id_stock='$_GET[id]' ");		 
				$r=mysqli_fetch_array($tampil);
				echo "
				<tr><td>Kode Barang</td><td>$r[kd_barang]</td></tr>
				<tr><td>Nama Barang</td><td>$r[nama_barang]</td></tr>
				<tr><td>Harga</td><td align=right>".number_format($r['harga_tunai'])."</td></tr>		
			</table>";
			echo "<input type=button class='btn btn-primary btn' value=Back onclick=self.history.back()>";
    break;  
}
}
?>
