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
      <h2>Kesan & Pesan</h2>
      <input class='btn btn-info btn-flat' type=button value='Kirim Pesan' 
			onclick=\"window.location.href='?module=pesan&act=tambahpesan';\">";
      echo "
      <br><br>";  

      echo "
      <table id='example1' class='table table-bordered table-striped'>
      <tr><th>No.</th><th>Nama</th><th>Tanggal</th><th>Pesan</th></tr>"; 
  $no=1;
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
    $tampil = mysql_query("SELECT * FROM pesan ORDER BY id_pesan DESC limit $posisi,$batas");		 
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
							<td>$no</td>
							<td>$r[nama]</td>
              <td>$r[waktu]</td>
              <td>$r[pesan]</td>
							</tr>";
      $no++;
    }
    echo "</table>";

    $file="?module=pesan";

    $tampil2="select * from pesan order by id_pesan desc";
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
    echo "<p>Total Data : <b>$jmldata</b> </p>";			
    break;
  
    case "tambahpesan":
    echo "
    <h2>Tambah pesan</h2>
    <form method=POST action='$aksi?module=pesan&act=input'>
    <table id='example1' class='table table-bordered table-striped'>
      <tr> 
        <td>Nama</td>
        <td><input name='nama' type='text' id='nama' size='30' value='$_SESSION[namauser]'></td>
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
