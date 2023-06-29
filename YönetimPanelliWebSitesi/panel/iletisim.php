<?php 

require_once '../ınc/ayar.php';

if ( $_SESSION["ynt"] != yonetici($_COOKIE["tkp"])){
    header("Location: cikis.php");
    die("Yetkisiz Erişim!");
    }
if($_GET["islem"]=="sil"){
  $sorgu = $baglan->prepare("delete from iletisim where no=?");
  $sil=$sorgu->execute(array($_GET["no"]));
if($sil){
  
 echo "<script>
    alert('Kayıt Başarıyla Silindi!');
    window.location.href = 'iletisim.php';
    </script>";
    die("JavaScript Yönlendirme Hatası! Tarayıcı Desteği Yok.");
}else{ 
  echo "<script>
    alert('Silme İşleminde Hata Oluştu!');
    window.location.href = 'hakkimizda.php';
    </script>";
    die("JavaScript Yönlendirme Hatası! Tarayıcı Desteği Yok.");

}



}

 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>İletişim</title>
</head>
<body>
  
  <?php include_once 'ustalan.php'; ?>
  <h3 style="text-align:center">İLETİŞİM</h3>
  
  <table border="1" width="90%" align="center">
    <tr style="font-weight:bold">
      <td align="center">S.No</td>
      <td>Ad Soyad</td>
      <td>Mesaj</td>
      <td align="center">Tarih</td>
      <td align="center">İşlem</td>
    </tr>
  <?php
     $sirano = 0;
     $sorgu=$baglan->prepare("select * from iletisim order by tarih desc, no desc");
     $sorgu->execute();
     foreach($sorgu as $satir){
       $sirano++;
      echo"<tr>
        <td align='center'>$sirano</td>
        <td><a href='mailto:$satir->eposta'>$satir->adsoyad</a></td>
        <td>$satir->mesaj</td>
        <td align='center'>$satir->tarih</td>
        <td align='center'><a href='iletisim.php?islem=sil&no=$satir->no' onclick=\"if (!confirm('Silmek istediğinize emin misiniz?')) return false\">Sil</a></td>
        </tr>";
     }

      $sorgu->closeCursor(); unset($sorgu,$sonuc);

        ?>
</table>

</body>
</html>