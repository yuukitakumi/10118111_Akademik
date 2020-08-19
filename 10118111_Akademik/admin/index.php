<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademik | Dashboard</title>
    <link rel="stylesheet" href="style.css">
    
    <link href="IMAGES/unikomlogo.png" rel="icon">
</head>
<body>
    <!-- cek apakah sudah login -->
	<?php 
	session_start();
	if($_SESSION['status']!="login"){
		header("location:../index.php?pesan=belum_login");
	}
	?>
    <header>
        <img class="logo" src="IMAGES/unikomlogo.png" alt="logo" width="100px" height="200px">
        <a class="cta" href="#"><button class="button button1"><?php echo $_SESSION['username']; ?></button></a>
    </header>
    <p>Dashboard</p>
    <div class="grid-container">
        <div><a class="cta" href="mahasiswa.php"><button class="button button3">Mahasiswa</button></a></div>
		<div><a class="cta" href="kelas.php"><button class="button button4">Kelas</button></a></div>
		<div><a class="cta" href="detailkelas.php"><button class="button button4">Detail Kelas</button></a></div>
		<div><a class="cta" href="matkul.php"><button class="button button6">Mata Kuliah</button></a></div>
		<div><a class="cta" href="mengajar.php"><button class="button button6">Detail Mata Kuliah</button></a></div>
		<div><a class="cta" href="dosen.php"><button class="button button5">Dosen</button></a></div>
        <div><a class="cta" href="logout.php"><button class="button button7">Logout</button></a></div> 
    </div>
</body>
</html>