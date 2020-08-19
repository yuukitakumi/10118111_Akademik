<?php
// Include config file
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik | Detail Mata Kuliah</title>    
    <link rel="stylesheet" href="style.css">
    <link href="IMAGES/unikomlogo.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="IMAGES/unikomlogo.png" alt="logo" width="100px" height="200px">
    
        <a class="cta" href="#"><button class="button button1">Admin</button></a>
    </header>
     
    <div class="fcustomer"><img style='vertical-align:middle;' src='IMAGES/calendar.png'>
      <div style='vertical-align:middle; display:inline; padding: 10px;'>Detail Mata Kuliah</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","ganteng789","kampus")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $NIP=$_POST['NIP'];
        $Id_Matkul=$_POST['Id_Matkul'];
        
        if(!empty($NIP) || !empty($Id_Matkul)){
            $sql = "insert into mengajar ( NIP, Id_Matkul)" . 
              "values ( '$NIP','$Id_Matkul')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: mengajar.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="mengajar.php">
<table>
    <td>NIP<td>
		<select name="NIP" id="NIP">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql2 = "SELECT * FROM dosen";
			  $query2 = mysqli_query($conn, $sql2);
			  while($data2 = mysqli_fetch_array($query2)){
		 ?>
			  <option value="<?php echo $data2['NIP']?>"><?php echo $data2['NIP']?></option> 
		 <?php
		  }
		 ?>
		</select>     
  </td><td>ID Matkul<td>
		<select name="Id_Matkul" id="Id_Matkul">
		 <option disabled selected> Pilih </option>
		 <?php 
			  $sql3 = "SELECT * FROM matkul";
			  $query3 = mysqli_query($conn, $sql3);
			  while($data3 = mysqli_fetch_array($query3)){
		 ?>
			  <option value="<?php echo $data3['Id_Matkul']?>"><?php echo $data3['Id_Matkul']?></option> 
		 <?php
		  }
		 ?>
		</select>  
    <tr> 
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="mengajar.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM mengajar";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>NIP</th>
        <th>ID Matkul</th>
		<th>aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['NIP']; ?></td>
                <td><?php echo $data['Id_Matkul']; ?></td>
                <td>
                    <a href="mengajar.php?aksi=delete&NIP=<?php echo $data['NIP']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
}
// --- Tutup Fungsi Baca Data (Read)
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['NIP']) && isset($_GET['aksi'])){
        $NIP = $_GET['NIP'];
        $sql_hapus = "DELETE FROM mengajar WHERE NIP='$NIP'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: mengajar.php');
                
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
            echo '<a href="mengajar.php"> &laquo; Home</a>';
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