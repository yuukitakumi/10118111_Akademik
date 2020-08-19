<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Akademik | Login</title>
    <link rel="stylesheet" href="style2.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="unikomlogo.png">
  </head>
  <body>
  <?php 
	if(isset($_GET['pesan'])){
		if($_GET['pesan'] == "gagal"){
			echo "<div class='p1'>Login gagal! username dan password salah!</div>";
		}else if($_GET['pesan'] == "belum_login"){
			echo "<p>Anda harus login untuk mengakses halaman admin</p>";
		}
	}
	?>
    <div class="center">

      <div class="container">

        <div class="text">
            <img src="unikomlogo.png" width=300px alt=""></div>
<form action="cek_login.php" method="POST">
          <div class="data">
            <label>Username</label>
            <input type="text" name="username" id="username" required autocomplete="off">
          </div>
<div class="data">
            <label>Password</label>
            <input type="password" name="password" id="password" required autocomplete="off">
          </div>
<div class="btn">
  <div class="inner"></div>
<button type="submit" name="btn-login">login</button></div>
</form>
</div>
</div>
</body>
</html>
