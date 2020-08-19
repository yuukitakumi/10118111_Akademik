<?php
// Include config file
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik | Dosen</title>    
    <link rel="stylesheet" href="style.css">
    <link href="IMAGES/unikomlogo.png" rel="icon">
</head>
<body>
    <header>
    <img class="logo" src="IMAGES/unikomlogo.png" alt="logo" width="100px" height="200px">
    
        <a class="cta" href="#"><button class="button button1">Admin</button></a>
    </header>
     
    <div class="fcustomer"><img style='vertical-align:middle;' src='IMAGES/pegawai.png'>
      <div style='vertical-align:middle; display:inline; padding: 10px;'>Dosen</div>
     
</div>
<?php
// --- koneksi ke database
$conn=mysqli_connect("localhost","root","ganteng789","kampus")or die(mysqli_error());
// --- Fngsi tambah data (Create)
function tambah($conn){
    if (isset($_POST['simpan'])){
        $NIP=$_POST['NIP'];
        $Nama=$_POST['Nama'];
        $Tanggal_Lahir=$_POST['Tanggal_Lahir'];
        $Email=$_POST['Email'];
        
        if(!empty($NIP) || !empty($Nama)|| !empty($Tanggal_Lahir)|| !empty($Email)){
            $sql = "insert into dosen ( NIP, Nama,Tanggal_Lahir, Email)" . 
              "values ( '$NIP','$Nama' ,'$Tanggal_Lahir','$Email')";
            $simpan = mysqli_query($conn, $sql);
            if($simpan && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'create'){
                    header('location: dosen.php');
                   
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?> 
       <form method="POST" action="dosen.php">
<table>
    <td>NIP<input type="text" name="NIP" placeholder="NIP"  required autocomplete="off" ></td><td>Tanggal_Lahir<input type="date" id="Tanggal_Lahir" name="Tanggal_Lahir"  placeholder="Tanggal Lahir" required></td>
		<tr><td>Nama dosen<input type="text" name="Nama" placeholder="Nama dosen" required autocomplete="off"></td>       
		<td>Email<input type="text" name="Email" id="Email" placeholder="Email" required autocomplete="off"></td></tr></td>            
    <tr> 
</table>
<div class="btn-customer">
    <button class="button button10" type="submit" name="simpan">Save</button><button class="button button10" type="reset">Reset</button><a href="dosen.php" class="button button10">Refresh</a>
</div>
                
        </form>
    <?php
}
// --- Tutup Fungsi tambah data
// --- Fungsi Baca Data (Read)
function tampil_data($conn){
    $sql = "SELECT * FROM dosen";
    $query = mysqli_query($conn, $sql);
       
    echo "<table id='customers'>";
    echo "<tr>
        <th>NIP</th>
        <th>Nama dosen</th>
        <th>Tanggal_Lahir</th>
        <th>Email</th>
        <th>Aksi</th>
        </tr>";
    
    while($data = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $data['NIP']; ?></td>
                <td><?php echo $data['Nama']; ?></td>
                <td><?php echo $data['Tanggal_Lahir']; ?></td>
                <td><?php echo $data['Email']; ?> </td>
                <td>
                    <a href="dosen.php?aksi=update&NIP=<?php echo $data['NIP']; ?>&Nama=<?php echo $data['Nama']; ?>&Tanggal_Lahir=<?php echo $data['Tanggal_Lahir']; ?>&Email=<?php echo $data['Email']; ?>">Edit</a> |
                    <a href="dosen.php?aksi=delete&NIP=<?php echo $data['NIP']; ?>"onclick="return confirm('Yakin ingin di Hapus?')">Hapus</a>
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
		$NIP=$_POST['NIP'];
        $Nama=$_POST['Nama'];
        $Tanggal_Lahir=$_POST['Tanggal_Lahir'];
        $Email=$_POST['Email'];
        
      if(!empty($Nama)&& !empty($Tanggal_Lahir)&& !empty($Email)){
        $sql_update = "UPDATE dosen SET Nama='$_POST[Nama]',Tanggal_Lahir='$_POST[Tanggal_Lahir]',Email='$_POST[Email]' WHERE NIP='$NIP';";
        $update = mysqli_query($conn, $sql_update);
            if($update && isset($_GET['aksi'])){
                if($_GET['aksi'] == 'update'){
                    header('location: dosen.php');
                }
            }
        } else {
            $pesan = "Data tidak lengkap!";
        }
    }
    
    // tampilkan form ubah
    if(isset($_GET['NIP'])){
        ?>  
         <div class="btn-paket"><button id="myBtn" class="button button12">Transaction Made</button></div>
            <form action="" method="POST"  >
			<table>
		<td>NIP<input type="text" name="NIP" required readonly value="<?php echo $_GET['NIP']?>"></td>
		<td>Tanggal_Lahir<input type="date" id="Tanggal_Lahir" autocomplete="off" name="Tanggal_Lahir"  placeholder="Tanggal Lahir" required value="<?php echo $_GET['Tanggal_Lahir'] ?>"></td>
		<tr><td>Nama dosen<input type="text" name="Nama" placeholder="Nama dosen" required value="<?php echo $_GET['Nama'] ?>"></td>       
		<td>Email<input type="text" name="Email" id="Email" autocomplete="off" placeholder="Email" required value="<?php echo $_GET['Email'] ?>"></td></tr></td>            
    <tr> 
<div class="btn-customer">
    <button class="button button10" type="submit" name="btn_ubah" id="btn_ubah">Update</button><a href="dosen.php" class="button button10">Refresh</a> <a href="dosen.php?aksi=delete&dosen=<?php echo $_GET['NIP'] ?>" class="button button10">Hapus data ini</a>
</div>
                
            </form>
<?php
    }
    
}
// --- Tutup Fungsi Update
// --- Fungsi Delete
function hapus($conn){
    if(isset($_GET['NIP']) && isset($_GET['aksi'])){
        $NIP = $_GET['NIP'];
        $sql_hapus = "DELETE FROM dosen WHERE NIP='$NIP'";
        $hapus = mysqli_query($conn, $sql_hapus);
        
        if($hapus){
            if($_GET['aksi'] == 'delete'){
                 
                header('location: dosen.php');
                
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
            echo '<a href="dosen.php"> &laquo; Home</a>';
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