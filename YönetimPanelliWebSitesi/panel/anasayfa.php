<?php 

require_once '../ınc/ayar.php';

if ( $_SESSION["ynt"] != yonetici($_COOKIE["tkp"])){
    header("Location: cikis.php");
    die("Yetkisiz Erişim!");
    }

 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ana Sayfa</title>
</head>
<body>
  
  <?php include_once 'ustalan.php'; ?>
<?php
    $sorgu = $baglan->prepare("select count(no) as toplam from istatistik");
    $sorgu->execute();
    $kayitsay = $sorgu->fetch()->toplam;
    echo "<div style='text-align:center'>Bu web sitesi şu ana kadar toplam <b>$kayitsay</b> defa ziyaret edildi.</div>"
  ?>
  <h3 style="text-align:center">ANA SAYFA</h3>

</body>
</html>