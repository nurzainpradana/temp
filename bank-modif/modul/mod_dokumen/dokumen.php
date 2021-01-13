<?php
$aksi="modul/mod_dokumen/aksi_dokumen.php";
echo "
	<section class='products py-2'>
	<div class='container'>
                   
<div class='box'>";
if (!isset($_GET['act'])) {
    echo " <div class='box-diruter'>
<h3 class='box-title'>";
echo "
	</div><!-- /.box-diruter -->
	<div class='box-body table-responsive'>
	<h2>Surat Masuk</h2>";
	echo "
    <table id='example1' class='table table-bordered'>
			<tdirut>
          <tr>
					<td class='left'>No</td>
          <td class='left'>Nama Dokumen</td>
          <td class='center'>Tgl Dokumen</td>
					</tr></tdirut><tbody>"; 
    $tampil=mysqli_query($koneksi,"SELECT * FROM dokumen ORDER BY id_dokumen DESC");
    $no=1;
    while ($r=mysqli_fetch_array($tampil)){

      $kategori = mysqli_query($koneksi,"SELECT * FROM kategori WHERE id_kategori = '$r[id_kategori]'");
      $k = mysqli_fetch_array($kategori);

       echo "<tr><td>$no</td>
             <td class='left'><a href='?module=dokumen&act=distribusi&id=$r[id_dokumen]'>$r[nama_dokumen]</a></td>
             <td class='center'>$r[tgl_dokumen]</td>
             </tr>";
      $no++;
    }
    echo "</tbody></table>
		</section>
		</div>";
    
}
else {
	switch($_GET['act']){
  
  // Form Tambah dokumen
  case "tambahdokumen":
    echo "
		<section class='content'>
		<div class='row'>
			<div class='col-md-12'>
				<div class='box box-info'>
					<div class='box-diruter'>
						<h3 class='box-title'>Tambah Dokumen</h3>
						<!-- tools box -->
						<div class='pull-right box-tools'>
						</div><!-- /. tools -->
					</div><!-- /.box-diruter -->
					<div class='box-body pad'>
						<form method=POST action='$aksi?module=dokumen&act=input'>
							<div class='form-group'>
								<label>Nomor Dokumen</label>
									<input type='text' class='form-control' name='nomor_dokumen' placeholder='Nomor Dokumen ...'/>
							</div>                                       
							<div class='form-group'>
								<label>Nama Dokumen</label>
								<input type='text' class='form-control' name='nama_dokumen' placeholder='Nama Dokumen ...'/>
							</div>
							<div class='form-group'>
								<label>Tanggal Dokumen</label>
								<input type='date' class='form-control' name='tgl_dokumen'/>
							</div>

							<div class='form-group'>
								<label>Kategori</label>
								<select name='id_kategori' class='form-control'>
									<option value=0 selected>- Pilih Kategori -</option>";
									$tampil=mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY nama_kategori");
									while($r=mysqli_fetch_array($tampil)){
										echo "<option value=$r[id_kategori]>$r[nama_kategori]</option>";
									}
									echo "
								</select>
							</div>
							<div class='form-group'>
								<label>Sifat Dokumen</label>
								<select name='id_sifatdokumen' class='form-control'>
									<option value=0 selected>- Pilih Sifat Dokumen -</option>";
									$tampil=mysqli_query($koneksi,"SELECT * FROM sifatdokumen ORDER BY nama_sifatdokumen");
									while($r=mysqli_fetch_array($tampil)){
										echo "<option value=$r[id_sifatdokumen]>$r[nama_sifatdokumen]</option>";
									}
									echo "
								</select>
							</div>
							<div class='form-group'>
								<label>Keterangan</label>
								<textarea class='form-control' name='keterangan' rows='5' placeholder='Keterangan ...'/></textarea>
							</div>

							<div class='form-group'>
								<input type=submit class='btn btn-primary btn-lg' value=Simpan>
								<input type=button class='btn btn-warning btn-lg' value=Batal onclick=self.history.back()>
							</div>
						</form>
					</div>
				</div><!-- /.box -->                           
			</div><!-- /.col-->
		</div><!-- ./row -->
		</section>";
	break;
  
  // Form Edit label  
  case "editdokumen":
    $edit=mysqli_query($koneksi,"SELECT * FROM dokumen WHERE id_dokumen='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    echo "
		<section class='content'>
			<div class='row'>
				<div class='col-md-12'>
					<div class='box box-info'>
						<div class='box-diruter'>
							<h3 class='box-title'>Edit Dokumen</h3>
							<!-- tools box -->
							<div class='pull-right box-tools'>
							</div><!-- /. tools -->
						</div><!-- /.box-diruter -->
						<div class='box-body pad'>
							<form method=POST action=$aksi?module=dokumen&act=update>
								<input type=hidden name=id value='$r[id_dokumen]'>
								<div class='form-group'>
									<label>Nomor Dokumen</label>
									<input type='text' class='form-control' name='nomor_dokumen' value='$r[nomor_dokumen]'/>
								</div>
								<div class='form-group'>
									<label>Nama Dokumen</label>
									<input type='text' class='form-control' name='nama_dokumen' value='$r[nama_dokumen]'/>
								</div>

								<div class='form-group'>
									<label>Tanggal Dokumen</label>
									<input type='date' class='form-control' name='tgl_dokumen' value='$r[tgl_dokumen]'/>
								</div>

								<div class='form-group'>
									<label>Tanggal Diterima</label>
									<input type='date' class='form-control' name='tgl_diterima' value='$r[tgl_diterima]'/>
								</div>

								<div class='form-group'>
									<label>Kategori</label>
									<input type='text' class='form-control' name='id_kategori' value='$r[id_kategori]'/>
								</div>
								<div class='form-group'>
									<label>Sifat Dokumen</label>
									<select name='id_sifatdokumen' class='form-control'>
										<option value=0 selected>- Pilih Sifat Dokumen -</option>";
										$tampil=mysqli_query($koneksi,"SELECT * FROM sifatdokumen ORDER BY nama_sifatdokumen");
										if ($r[id_sifatdokumen]==0){
											echo "
											<option value=0 selected>- Pilih Sifat Dokumen -</option>";
										}   

										while($w=mysqli_fetch_array($tampil)){
											if ($r[id_sifatdokumen]==$w[id_sifatdokumen]){
												echo "<option value=$w[id_sifatdokumen] selected>$w[nama_sifatdokumen]</option>";
											}
											else{
												echo "<option value=$w[id_sifatdokumen]>$w[nama_sifatdokumen]</option>";
											}
										}
										echo "
									</select>
								</div>
								<div class='form-group'>
									<label>Keterangan</label>
									<textarea class='form-control' name='keterangan'>$r[keterangan]</textarea>
								</div>
								<div class='form-group'>
									<label>Disposisi</label>
									<textarea class='form-control' name='disposisi' readonly>$r[disposisi]</textarea>
								</div>
								<div class='form-group'>
									<input type=submit class='btn btn-primary btn-lg' value=Update>
									<input type=button class='btn btn-warning btn-lg' value=Batal onclick=self.history.back()>
								</div>
							</form>
						</div>
					</div><!-- /.box -->

                            
				</div><!-- /.col-->
			</div><!-- ./row -->
		</section>";
	break;  
  // Form Edit label  
  case "distribusi":
    $edit=mysqli_query($koneksi,"SELECT * FROM dokumen WHERE id_dokumen='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
		$tampil2=mysqli_query($koneksi,"SELECT * FROM kategori where id_kategori='$r[id_kategori]' ");
		$r2=mysqli_fetch_array($tampil2);
		$tampil3=mysqli_query($koneksi,"SELECT * FROM sifatdokumen where id_sifatdokumen='$r[id_sifatdokumen]' ");
		$r3=mysqli_fetch_array($tampil3);	
		if ($_SESSION['leveluser'] == 'dirut' AND $r['tgl_dibaca'] == '0000-00-00' ){
			mysqli_query($koneksi,"UPDATE dokumen SET tgl_dibaca=sysdate() WHERE id_dokumen = '$_GET[id]'");	
			$tampil=mysqli_query($koneksi,"SELECT * FROM departemen ORDER BY id_departemen");
			while($r=mysqli_fetch_array($tampil)){
					mysqli_query($koneksi,"INSERT INTO disposisi(id_dokumen,
																		id_departemen,
																		id_seksi,
																		tgl_disposisi,
																		view)
                              VALUES('$_GET[id]',
																		'$r[id_departemen]',
																		'0',
																		sysdate(),
																		'0'
																		)");
			}		
			$tampil2=mysqli_query($koneksi,"SELECT * FROM lajur ORDER BY id_lajur");
			while($r2=mysqli_fetch_array($tampil2)){
				mysqli_query($koneksi,"INSERT INTO lajurdetail(id_dokumen,
																		id_lajur)
                              VALUES('$_GET[id]',
																		'$r2[id_lajur]'
																		)");				
			}					
			
		}		
		$cari1=mysqli_query($koneksi,"SELECT * FROM disposisi WHERE id_dokumen='$_GET[id]'");
    $rc=mysqli_fetch_array($cari1);
		if ($_SESSION['leveluser'] == 'manager' AND $rc['tgl_diterima'] == '0000-00-00' ){
			mysqli_query($koneksi,"UPDATE disposisi SET tgl_diterima=sysdate() 
			WHERE id_dokumen = '$_GET[id]' and id_departemen='$_SESSION[iddept]' ");		
		}	
    echo "
		<section class='content'>
			<div class='row'>
				<div class='col-md-12'>
					<div class='box box-info'>
						<div class='box-diruter'>
							
							<!-- tools box -->
							<div class='pull-right box-tools'>
							</div><!-- /. tools -->
						</div><!-- /.box-diruter -->
						<div class='box-body pad'>
							<h3 class='box-title'>Disposisi Dokumen</h3>
							<table id='example1' class='table table-bordered'>
								<tr><td>Nomor Dokumen</td><td>$r[nomor_dokumen]</td></tr>
								<tr><td>Nama Dokumen</td><td>$r[nama_dokumen]</td></tr>
								<tr><td>Tgl Dokumen</td><td>$r[tgl_dokumen]</td></tr>
								<tr><td>Tgl Diterima</td><td>$r[tgl_diterima]</td></tr>
								<tr><td>Kategori Dokumen</td><td>$r2[nama_kategori]</td></tr>
								<tr><td>Sifat Dokumen </td><td>$r3[nama_sifatdokumen]</td></tr>
								<tr><td>Input Oleh </td><td>$r[username]</td></tr>
							</table>	
								<div class='form-group'>
									<label>Keterangan</label>
									<textarea class='form-control' name='keterangan' readonly>$r[keterangan]</textarea>
								</div>	";
						if ($_SESSION['leveluser']=='dirut'){	 // tambah distribusi untuk departemen
							echo "							
							<form method=POST action=$aksi?module=dokumen&act=disposisi>
								<input type=hidden name=id value='$_GET[id]'>
								<div class='form-group'>
									<label>Disposisi</label>
									<textarea class='form-control' name='disposisi'>$r[disposisi]</textarea>
								</div>
							<div class='form-group'>
								<label>Diteruskan Kepada</label>
									<table id='example1' class='table table-bordered'>
									<tr><th>Bagian</td><td>Status</td></tr>";
									
									$tampil=mysqli_query($koneksi,"SELECT * FROM departemen ORDER BY nama_departemen");
									while($r=mysqli_fetch_array($tampil)){
										$cek=mysqli_query($koneksi,"select * from disposisi where id_dokumen='$_GET[id]' and id_departemen='$r[id_departemen]' ");
										$r2=mysqli_fetch_array($cek);
										$ketemu=mysqli_num_rows($cek);
										//if($ketemu) {
											echo "
											<tr>
												<td>$r[nama_departemen]</td>";
													if ($r2['view']=='1'){	
														echo "
														<td align=center><input type=checkbox name='chk[]' value='$r2[id_disposisi]' checked /></td>";
													}
													else {
														echo "
														<td align=center><input type=checkbox name='chk[]' value='$r2[id_disposisi]' /></td>";
													}	
													echo "												
											</tr>";
									}
									echo "
								</table>
							</div>								
								<div class='form-group'>
									<input type=submit class='btn btn-primary btn-lg' value=Teruskan>
								</div>
							</form>";
						}
						
						elseif ($_SESSION['leveluser']=='manager'){	// tambah distribusi untuk seksi
							echo "							
							<form method=POST action=$aksi?module=dokumen&act=disposisi2>
								<input type=hidden name=id value='$_GET[id]'>
								<div class='form-group'>
									<label>Disposisi</label>
									<textarea class='form-control' name='disposisi'>$r[disposisi]</textarea>
								</div>
							<div class='form-group'>
								<label>Diteruskan Kepada</label>
								<select name='id_seksi' class='form-control'>
									<option value=0 selected>-- Pilih Seksi --</option>";
									$tampil2=mysqli_query($koneksi,"SELECT * FROM seksi where id_departemen='$_SESSION[iddept]' ");
									while($r2=mysqli_fetch_array($tampil2)){
										echo "<option value=$r2[id_seksi]>$r2[nama_seksi]</option>";
									}
									echo "
								</select>
							</div>								
								<div class='form-group'>
									<input type=submit class='btn btn-primary btn-lg' value=Teruskan>
								</div>
							</form>";
							
						}					
						
						echo "
							<hr>
							DISPOSISI DEPARTEMEN
							<table id='example1' class='table table-bordered'>
								<tr>
									<td class='left'>No</td>
									<td class='left'>Nama Bagian</td>
									<td class='center'>Tgl Diteruskan</td>
									<td class='center'>Tgl Dibaca</td>
								</tr>"; 
    $tampil=mysqli_query($koneksi,"SELECT * FROM disposisi where id_dokumen = '$_GET[id]' and id_seksi='0' and view='1' ORDER BY id_departemen");
    $no=1;
    while ($r=mysqli_fetch_array($tampil)){
      $tampil2 = mysqli_query($koneksi,"SELECT * FROM departemen WHERE id_departemen = '$r[id_departemen]'");
      $r2 = mysqli_fetch_array($tampil2);
      //$tampil3 = mysqli_query($koneksi,"SELECT * FROM users WHERE id_user = '$r2[id_user]'");
      //$r3 = mysqli_fetch_array($tampil3);			
       echo "<tr><td class='left' width='25'>$no</td>
             <td class='left'>$r2[nama_departemen]</td>
             <td class='center'>$r[tgl_disposisi]</td>
             <td class='center'>$r[tgl_diterima]</td> 
             </tr>";
      $no++;
    }
    echo "</tbody></table>							
		<hr>";	
						echo "
							<hr>
							DISPOSISI SEKSI
							<table id='example1' class='table table-bordered'>
								<tr>
									<td class='left'>No</td>
									<td class='left'>Nama Bagian</td>
									<td class='center'>Tgl Diteruskan</td>
									<td class='center'>Tgl Dibaca</td>
								</tr>"; 
    $tampil=mysqli_query($koneksi,"SELECT * FROM disposisi where id_dokumen = '$_GET[id]' and id_departemen='0' ORDER BY id_seksi");
    $no=1;
    while ($r=mysqli_fetch_array($tampil)){
      $tampil2 = mysqli_query($koneksi,"SELECT * FROM seksi WHERE id_seksi = '$r[id_seksi]'");
      $r2 = mysqli_fetch_array($tampil2);
     // $tampil3 = mysqli_query($koneksi,"SELECT * FROM users WHERE id_user = '$r2[id_user]'");
     // $r3 = mysqli_fetch_array($tampil3);			
       echo "<tr><td class='left' width='25'>$no</td>
             <td class='left'>$r2[nama_seksi]</td>
             <td class='center'>$r[tgl_disposisi]</td>
             <td class='center'>$r[tgl_diterima]</td> 
             </tr>";
      $no++;
    }
    echo "</tbody></table><hr>";				
		if ($_SESSION['leveluser']=='dirut'){
			echo "
							<form method=POST action=$aksi?module=dokumen&act=lajur>
								<input type=hidden name=id value='$_GET[id]'>
							<div class='form-group'>
								<label>Lajur Disposisi</label>
									<table id='example1' class='table table-bordered'>
									<tr><th>Bagian</td><td>Status</td></tr>";
									
									$tampila=mysqli_query($koneksi,"SELECT * FROM lajur ORDER BY id_lajur");
									while($ra=mysqli_fetch_array($tampila)){
										$ceka=mysqli_query($koneksi,"select * from lajurdetail where id_dokumen='$_GET[id]' and id_lajur='$ra[id_lajur]' ");
										$ra2=mysqli_fetch_array($ceka);
											echo "
											<tr>
												<td>$ra[nama_lajur]</td>";
													if ($ra2['view']=='1'){	
														echo "
														<td align=center><input type=checkbox name='lajur[]' value='$ra2[id_lajurdetail]' checked /></td>";
													}
													else {
														echo "
														<td align=center><input type=checkbox name='lajur[]' value='$ra2[id_lajurdetail]' /></td>";
													}	
													echo "												
											</tr>";
									}
									echo "
								</table>
							</div>								
								<div class='form-group'>
									<input type=submit class='btn btn-primary btn-lg' value=AddLajur>
								</div>
							</form>";
		}
		echo "		
							<hr>	
							<table id='example1' class='table table-bordered'>
								<tr>
									<td class='left'>No</td>
									<td class='center'>Nama Lajur</td>
								</tr>"; 
    $tampil1a=mysqli_query($koneksi,"SELECT * FROM lajurdetail where id_dokumen ='$_GET[id]' and view= '1' ORDER BY id_lajur DESC");
    $no=1;
    while ($r1a=mysqli_fetch_array($tampil1a)){
      $tampil2a = mysqli_query($koneksi,"SELECT * FROM lajur WHERE id_lajur = '$r1a[id_lajur]'");
      $r2a = mysqli_fetch_array($tampil2a);		
       echo "<tr><td class='left' width='25'>$no</td>
						 <td class='left'>$r2a[nama_lajur]</td> 
             </tr>";
      $no++;
    }
    echo "</tbody></table>									
						</div>

						
					</div><!-- /.box -->
			Foto Dokumen<br>";
			$cari=mysqli_query($koneksi,"SELECT * FROM fotodokumen where id_dokumen='$_GET[id]' ORDER BY id_dokumen");
			while($r11=mysqli_fetch_array($cari)){
				echo "<a href=foto_dokumen/$r11[nama_file] target=_blank><img src=foto_dokumen/$r11[nama_file] width=100%></a></br></br>";
			}
			echo "
			<hr>	
			<form method=POST action=$aksi?module=dokumen&act=komentar>
				<input type=hidden name=id value='$_GET[id]'>
								<div class='form-group'>
									<label>Komentar : $_GET[id]</label>
									<textarea class='form-control' name='komentar'></textarea>
								</div>
								<div class='form-group'>
									<input type=submit class='btn btn-primary btn-lg' value=Save>
								</div>								
			</form>					
			<table id='example1' class='table table-bordered'>
				<tr>
					<td class='left'>No</td>
					<td class='left'>ID User</td>
					<td class='center'>Tanggal</td>
					<td class='center'>Komentar</td>
				</tr>"; 
    $tampil1b=mysqli_query($koneksi,"SELECT * FROM komentar where id_dokumen ='$_GET[id]' ORDER BY id_komentar");
    $no=1;
    while ($r1b=mysqli_fetch_array($tampil1b)){
      $tampil2b = mysqli_query($koneksi,"SELECT * FROM users WHERE id_user = '$r1b[id_user]'");
      $r2b = mysqli_fetch_array($tampil2b);		
       echo "
			 <tr>
				<td class='left' width='25'>$no</td>
				<td class='left'>$r2b[username]</td>   
				<td class='left'>$r1b[tgl_komentar]</td>				
				<td class='left'>$r1b[komentar]</td> 						 
			</tr>";
      $no++;
    }
    echo "</tbody></table>		                           
				</div><!-- /.col-->
			</div><!-- ./row -->

		</section>";
	break;  	
	}
}
?>
