<?php
// Include config file
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik | Mata Kuliah</title>    
    <link rel="stylesheet" href="style.css">
    <link href="IMAGES/unikomlogo.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="IMAGES/unikomlogo.png" alt="logo" width="100px" height="200px">
    
        <a class="cta" href="#"><button class="button button1">admin</button></a>
    </header>
     
    <div class="fcustomer"><img style='vertical-align:middle;' src='IMAGES/report.png'>
      <div style='vertical-align:middle; display:inline; padding: 10px;'>Mata Kuliah</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","ganteng789","kampus")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $Id_Matkul=$_POST['Id_Matkul'];
        $Nama_Matkul=$_POST['Nama_Matkul'];
        
        if(!empty($Id_Matkul) || !empty($Nama_Matkul)){
            $sql = "insert into matkul ( Id_Matkul, Nama_Matkul)" . 
              "values ( '$Id_Matkul','$Nama_Matkul')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: matkul.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="matkul.php">
<table>
    <td>ID Matkul<input type="text" name="Id_Matkul" placeholder="Id_Matkul"  required autocomplete="off" ></td><td>Nama_Matkul<input type="text" id="Nama_Matkul" name="Nama_Matkul"  placeholder="Nama_Matkul" required></td>		         
    <tr> 
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="matkul.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM matkul";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>Id Matkul</th>
        <th>Nama_Matkul</th>
		<th>aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['Id_Matkul']; ?></td>
                <td><?php echo $data['Nama_Matkul']; ?></td>
                <td>
                    <a href="matkul.php?aksi=update&Id_Matkul=<?php echo $data['Id_Matkul']; ?>&Nama_Matkul=<?php echo $data['Nama_Matkul']; ?>">Edit</a> |
                    <a href="matkul.php?aksi=delete&Id_Matkul=<?php echo $data['Id_Matkul']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$Id_Matkul=$_POST['Id_Matkul'];
        $Nama_Matkul=$_POST['Nama_Matkul'];
        
      if(!empty($Id_Matkul) || !empty($NIP)|| !empty($Nama_Matkul)){
        $sql_update = "UPDATE matkul SET Nama_Matkul='$_POST[Nama_Matkul]' WHERE Id_Matkul='$Id_Matkul';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: matkul.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['Id_Matkul'])){
        ?>  
         <div class="btn-paket"><button id="myBtn" class="button button12">Transaction Made</button></div>
            <form action="" method="POST"  >
			<table>
		<td>ID Matkul<input type="text" name="Id_Matkul" required readonly value="<?php echo $_GET['Id_Matkul']?>"></td>
		<td>Nama_Matkul<input type="text" id="Nama_Matkul" autocomplete="off" name="Nama_Matkul"  placeholder="Nama_Matkul" required value="<?php echo $_GET['Nama_Matkul'] ?>"></td>
		                
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="Matkul.php" class="button button10">Refresh</a> <a href="Matkul.php?aksi=delete&Matkul=<?php echo $_GET['Id_Matkul'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['Id_Matkul']) && isset($_GET['aksi'])){
        $Id_Matkul = $_GET['Id_Matkul'];
        $sql_hapus = "DELETE FROM matkul WHERE Id_Matkul='$Id_Matkul'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: matkul.php');
                
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
            echo '<a href="matkul.php"> &laquo; Home</a>';
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