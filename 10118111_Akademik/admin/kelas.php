<?php
// Include config file
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik | Kelas</title>    
    <link rel="stylesheet" href="style.css">
    <link href="IMAGES/unikomlogo.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="IMAGES/unikomlogo.png" alt="logo" width="100px" height="200px">
    
        <a class="cta" href="#"><button class="button button1">Admin</button></a>
    </header>
     
    <div class="fcustomer"><img style='vertical-align:middle;' src='IMAGES/calendar.png'>
      <div style='vertical-align:middle; display:inline; padding: 10px;'>Kelas</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","ganteng789","kampus")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $Id_kelas=$_POST['Id_kelas'];
        $NIP=$_POST['NIP'];
        $Gedung=$_POST['Gedung'];
        
        if(!empty($Id_kelas) || !empty($NIP)|| !empty($Gedung)){
            $sql = "insert into kelas ( Id_kelas, NIP,Gedung)" . 
              "values ( '$Id_kelas','$NIP' ,'$Gedung')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: Kelas.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="Kelas.php">
<table>
    <td>ID Kelas<input type="text" name="Id_kelas" placeholder="Id_kelas"  required autocomplete="off" ></td><td>Gedung<input type="text" id="Gedung" name="Gedung"  placeholder="Gedung" required></td>
		<tr><td>NIP dosen
		<tr><td>
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
    <tr> 
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="kelas.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM kelas";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>Id Kelas</th>
        <th>NIP dosen</th>
        <th>Gedung</th>
		<th>aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['Id_kelas']; ?></td>
                <td><?php echo $data['NIP']; ?></td>
                <td><?php echo $data['Gedung']; ?></td>
                <td>
                    <a href="kelas.php?aksi=update&Id_kelas=<?php echo $data['Id_kelas']; ?>&NIP=<?php echo $data['NIP']; ?>&Gedung=<?php echo $data['Gedung']; ?>">Edit</a> |
                    <a href="kelas.php?aksi=delete&Id_kelas=<?php echo $data['Id_kelas']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
                </td>
            </tr>
        <?php
    }
    echo "</table>";
}
// --- Tutup Fungsi Baca Data (Read)
// --- Fungsi Ubah Data (Update)
function ubah($conn){
    // ubah data
    if(isset($_POST['btn_ubah'])){
		$Id_kelas=$_POST['Id_kelas'];
        $NIP=$_POST['NIP'];
        $Gedung=$_POST['Gedung'];
        
      if(!empty($Id_kelas) || !empty($NIP)|| !empty($Gedung)){
        $sql_update = "UPDATE kelas SET NIP='$_POST[NIP]',Gedung='$_POST[Gedung]' WHERE Id_kelas='$Id_kelas';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: kelas.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['Id_kelas'])){
        ?>  
         <div class="btn-paket"><button id="myBtn" class="button button12">Transaction Made</button></div>
            <form action="" method="POST"  >
			<table>
		<td>ID Kelas<input type="text" name="Id_kelas" required readonly value="<?php echo $_GET['Id_kelas']?>"></td>
		<td>Gedung<input type="text" id="Gedung" autocomplete="off" name="Gedung"  placeholder="Gedung" required value="<?php echo $_GET['Gedung'] ?>"></td>
		<tr><td>NIP dosen
		<tr><td>
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
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="kelas.php" class="button button10">Refresh</a> <a href="kelas.php?aksi=delete&kelas=<?php echo $_GET['Id_kelas'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['Id_kelas']) && isset($_GET['aksi'])){
        $Id_kelas = $_GET['Id_kelas'];
        $sql_hapus = "DELETE FROM kelas WHERE Id_kelas='$Id_kelas'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: kelas.php');
                
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
            echo '<a href="kelas.php"> &laquo; Home</a>';
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