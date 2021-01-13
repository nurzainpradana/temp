<?php    
$aksi="modul/mod_berita/aksi_berita.php";
if (!isset($_GET['act'])) {
	echo "
	<section class='products py-2'>
	<div class='container'>
		<h3>Detail Berita</h3>";
    echo "
		<table id='example1' class='table table-bordered'>  
			<tr><th>No</th><th>Judul</th><th>Tanggal</th></tr>";
			$tampil = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id_berita DESC"); 
			$no = 1;
			while($r=mysqli_fetch_array($tampil)){
				echo "
			<tr>
				<td>$no</td>
					 <td><a href=?module=berita&act=detailberita&id=$r[id_berita]>$r[judul]</a></td>
					 <td>$r[tanggal]</td>
			</tr>";
				$no++;
			}
			echo "
			</table>";
		echo "
	</div>
	</section>";	
}
else {
	switch($_GET['act']){
	case "detailberita":
		$edit = mysqli_query($koneksi, "SELECT * FROM berita WHERE id_berita='$_GET[id]'");
    $r    = mysqli_fetch_array($edit);
		echo "
		<section class='products py-2'>
		<div class='container'>
		<h2>Detail Berita</h2>
    <table id='example1' class='table table-bordered'>
			<tr><td>Judul</td><td>$r[judul]</td></tr>
			<tr><td>Isi Berita</td><td>".nl2br($r['isi_berita'])."</td></tr>
			<tr><td>Gambar</td>
					<td>";
							if ($r['gambar']!=''){
								echo "<img src='foto_berita/$r[gambar]' width=100%>";  
							}
							echo "
					</td>
			</tr>
			<tr>
				<td colspan=2><input type='button' class='btn btn-primary' value='Back to News' onclick=self.history.back()></td>
			</tr>
		</table>";
		echo "
		</div>
		</section>";			
	break;  	 
}
}
?>
