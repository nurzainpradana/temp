<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_pesan/aksi_pesan.php";
//pemanggilan database
switch($_GET[act]){
  // Tampil User
  default:
    echo "
    <h2>Tambah pesan</h2>
    <form method=POST action='$aksi?module=pesan&act=input'>
    <table id='example1' class='table table-bordered table-striped'>
      <tr> 
        <td>Nama</td>
        <td><input name='nama' type='text' id='nama' size='30' value='$_SESSION[namauser]' readonly></td>
      </tr>
      <tr> 
        <td valign='top'>Pesan</td>
        <td><textarea name='pesan' cols='60' rows='3' id='pesan'></textarea></td>
      </tr>
      <tr>
        <td colspan=2>
        <input type=submit value=Simpan>
        <input type=button value=Batal onclick=self.history.back()>
        </td>
      </tr>
    </table>
    </form>";
    break;
    
    case "editpesan":
    $edit=mysql_query("SELECT * FROM pesan WHERE id_pesan='$_GET[id]'");
    $r=mysql_fetch_array($edit);
    echo "
    <h2>Edit pesan</h2>
    <form method=POST action=$aksi?module=pesan&act=update>
    <input type=hidden name=id value='$r[0]'>
    <table id='example1' class='table table-bordered table-striped'>
      <tr> 
        <td>Nama</td>
        <td><input name='nama' type='text' id='nama' size='30' value='$r[2]'></td>
      </tr>
      <tr> 
        <td>Waktu</td>
        <td><input name='waktu' type='text' id='waktu' size='15' value='$r[3]'></td>
      </tr>
      <tr> 
        <td>Pesan</td>
        <td><textarea name='pesan' cols='60' rows='3' id='pesan'>$r[4]</textarea></td>
      </tr>
      <tr>
        <td colspan=2>
        <input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()>
        </td>
      </tr>
    </table>
    </form>";     
    break;  
}
}
?>
