<!DOCTYPE html>
<html>
<head>
	<title>Giriş Yap</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <form action="login.php" method="post">
     	<h2>Giriş Yap</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
     	<input type="text" name="uname" placeholder="Kullanıcı Adı"><br>

     	<input type="password" name="password" placeholder="Şifre"><br>

     	<button type="submit">Giriş Yap</button>
          <a href="signup.php" class="ca">Hesap Oluştur</a>
     </form>
</body>
</html>