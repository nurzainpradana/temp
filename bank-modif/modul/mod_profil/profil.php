<?php
$aksi="modul/mod_profil/aksi_profil.php";
$edit=mysqli_query($koneksi, "SELECT * FROM anggota WHERE nik='$_SESSION[namauser]'");
$r=mysqli_fetch_array($edit);
$edit1=mysqli_query($koneksi, "SELECT * FROM users WHERE username='$_SESSION[namauser]'");
$r1=mysqli_fetch_array($edit1);		
echo "
<h2>Update Anggota</h2>
<center><img src=foto_banner/$r1[foto] width='400' /></center><br>
<form method=POST action=$aksi?module=profil&act=update enctype='multipart/form-data'>
	<input type=hidden name=nik value='$r[nik]'>
	<table id='example1' class='table table-bordered table-hover'>
		<tr><td>Username</td>     <td><input type=hidden='username' value='$r[nik]' readonly></td></tr>
		<tr><td>Nama Anggota</td> <td><input type=text name='nama' value='$r[nama]' size='40' readonly></td></tr>					
		<tr><td>E-mail</td>       <td><input type=text name='email' value='$r[email]' size='35'></td></tr>
		<tr><td>No.HP</td>   <td><input type=text name='telp' value='$r[telp]'></td></tr>
		<tr><td>Ganti Foto </td><td> <input type=file name='fupload'> <br>Mohon maaf..., fotonya gak bisa yg ukurannya besar ya</td></tr>				
		<tr><td colspan=2>
					<input type=submit value='Update' class='btn btn-primary btn'>
					<input type=button value='Cancel' class='btn btn-primary btn' onclick=self.history.back()>
				</td>
		</tr>
	</table>
</form>"; 
?>
