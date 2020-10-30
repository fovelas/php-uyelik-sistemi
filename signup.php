<!DOCTYPE html>
<html>
<head>
	<title>Kayıt Ol</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
     <form action="signup-check.php" method="post">
     	<h2>Kayıt Ol</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>

          <?php if (isset($_GET['success'])) { ?>
               <p class="success"><?php echo $_GET['success']; ?></p>
          <?php } ?>

          <?php if (isset($_GET['name'])) { ?>
               <input type="text" 
                      name="name" 
                      placeholder="Ad Soyad"
                      value="<?php echo $_GET['name']; ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="name" 
                      placeholder="Ad Soyad"><br>
          <?php }?>

          <?php if (isset($_GET['uname'])) { ?>
               <input type="text" 
                      name="uname" 
                      placeholder="Kullanıcı Adı"
                      value="<?php echo $_GET['uname']; ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="uname" 
                      placeholder="Kullanıcı Adı"><br>
          <?php }?>

     	<input type="password" 
                 name="password" 
                 placeholder="Şifre"><br>

          <input type="password" 
                 name="re_password" 
                 placeholder="Şifre Terkar"><br>

     	<button type="submit">Kayıt Ol</button>
          <a href="index.php" class="ca">Zaten hesabın var mı?</a>
     </form>
</body>
</html>