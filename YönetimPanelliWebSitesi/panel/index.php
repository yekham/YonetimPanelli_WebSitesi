<?php
require_once '../ınc/ayar.php';
if (isset($_SESSION["ynt"]) && !empty($_SESSION["ynt"])) {
  if ($_SESSION["ynt"] == yonetici($_COOKIE["tkp"])) {
    header("Location: anasayfa.php");
    die();
  }
}
istatistik();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Giriş</title>
</head>
<body style="text-align:center;padding-top:100px;font-size:18px">
  <form action="giris.php" method="post" autocomplete="off">
    <b>Kullanıcı Adı:</b><br><br>
    <input type="text" name="kullanici" maxlength="50" style="width:300px;height:30px" required>
    <br><br>
    <b>Sistem Parolası:</b><br><br>
    <input type="password" name="parola" maxlength="50" style="width:300px;height:30px" required>
    <br><br><br>
    <button type="submit">Giriş Yap</button>
  </form>
</body>
</html>