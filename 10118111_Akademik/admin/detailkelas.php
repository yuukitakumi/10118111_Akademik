<?php
// Include config file
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik | Detail Kelas</title>    
    <link rel="stylesheet" href="style.css">
    <link href="IMAGES/unikomlogo.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="IMAGES/unikomlogo.png" alt="logo" width="100px" height="200px">
    
        <a class="cta" href="#"><button class="button button1">Admin</button></a>
    </header>
     
    <div class="fcustomer"><img style='vertical-align:middle;' src='IMAGES/calendar.png'>
      <div style='vertical-align:middle; display:inline; padding: 10px;'>Detail Kelas</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","ganteng789","kampus")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $Id_kelas=$_POST['Id_kelas'];
        $NIM=$_POST['NIM'];
        
        if(!empty($Id_kelas) || !empty($NIM)){
            $sql = "insert into detailkelas ( Id_kelas, NIM)" . 
              "values ( '$Id_kelas','$NIM')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: detailkelas.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="detailkelas.php">
<table>
    <td>ID kelas<td>
		<select name="Id_kelas" id="Id_kelas">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM kelas";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['Id_kelas']?>"><?php echo $data2['Id_kelas']?></option> 
		 <?php
		  }
		 ?>
		</select>     
  </td><td>NIM<td>
		<select name="NIM" id="NIM">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql3 = "SELECT * FROM mahasiswa";
			  $query3 = mysqli_query($conn, $sql3);
			  while($data3 = mysqli_fetch_array($query3)){
		 ?>
			  <option value="<?php echo $data3['NIM']?>"><?php echo $data3['NIM']?></option> 
		 <?php
		  }
		 ?>
		</select>  
    <tr> 
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="detailkelas.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM detailkelas";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>Id Kelas</th>
        <th>NIM</th>
		<th>aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['Id_kelas']; ?></td>
                <td><?php echo $data['NIM']; ?></td>
                <td>
                    <a href="detailkelas.php?aksi=delete&Id_kelas=<?php echo $data['Id_kelas']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
}
// --- Tutup Fungsi Baca Data (Read)
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['Id_kelas']) && isset($_GET['aksi'])){
        $Id_kelas = $_GET['Id_kelas'];
        $sql_hapus = "DELETE FROM detailkelas WHERE Id_kelas='$Id_kelas'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: detailkelas.php');
                
            }
        }
    }
    
}
// --- Tutup Fungsi Hapus
// ===================================================================
// --- Program Utama
if (isset($_GET['aksi'])){
    switch($_GET['aksi']){
        case "create":
            echo '<a href="detailkelas.php"> &laquo; Home</a>';
            tambah($conn); 
            break;
        case "read":
            tampil_data($conn);
            break;
        case "update":
            ubah($conn);
            tampil_data($conn);
            break;
        case "delete":
            hapus($conn);
            tambah($conn);
            tampil_data($conn); 
            break;
        default:
            echo "<h3>Aksi<i>".$_GET['aksi']."</i> tidak ada!</h3>";
            tambah($conn);
            tampil_data($conn);
    }
} else {
    tambah($conn);
    tampil_data($conn);
    
}
?>
</body>
</html>