<?php
echo "
<h2>Ganti Password</h2>
<form method=POST action=modul/mod_password/aksi_password.php>
	<div class='form-group'>
		<label>Nomor Anggota</label>
		<input type=text class='form-control' name='username' value='$_SESSION[namauser]' disabled>
	</div>
	<div class='form-group'>
		<label>Masukkan Password Baru, Tidak boleh ada spasi	</label>
		<input type='text' class='form-control' name='pass_baru'>
		<br> Tidak boleh ada spasi	
	</div>	
	<div class='form-group'>
		<label>Masukkan Lagi Password Baru, Tidak boleh ada spasi	</label>
		<input type='text' class='form-control' name='pass_ulangi'>
	</div>		
	<div class='form-group'>
			<input type=submit value='Proses' class='btn btn-primary btn'>
			<input type=button value='Cancel' class='btn btn-primary btn' onclick=self.history.back()>
	</div>
</form>";
?>
