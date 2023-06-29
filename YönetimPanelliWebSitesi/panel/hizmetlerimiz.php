<?php 

require_once '../ınc/ayar.php';

if ( $_SESSION["ynt"] != yonetici($_COOKIE["tkp"])){
    header("Location: cikis.php");
    die("Yetkisiz Erişim!");
    }

if($_POST){
$icerik=tirnak($_POST['icerik']);
$sorgu = $baglan->prepare("insert into hizmetlerimiz values (?,?)");
$ekle=$sorgu->execute(array(NULL,$icerik));


if($ekle){
  /*
    //son eklenen kayıt dışındakileri temizleme
    $sonkayit = $baglan->lastInsertId();
    $sorgu = $baglan->prepare("delete from hizmetlerimiz where no<>?");
    $sorgu->execute(array($sonkayit));
    */
 echo "<script>
    alert('Değişiklikler Başarıyla Kaydedildi!');
    window.location.href = 'hizmetlerimiz.php';
    </script>";
    die("JavaScript Yönlendirme Hatası! Tarayıcı Desteği Yok.");
}else{ 
  echo "<script>
    alert('Kayıt İşleminde Hata Oluştu!');
    window.location.href = 'hizmetlerimiz.php';
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
  <title>Hizmetlerimiz</title>
</head>
<body>
  
  <?php include_once 'ustalan.php'; ?>
  <h3 style="text-align:center">HİZMETLERİMİZ</h3>
  <?php
   
    $sorgu = $baglan->prepare("select icerik from hizmetlerimiz order by no desc limit 1");
    $sorgu->execute();
    
   ?>
<div style="text-align:center">
  <form action="" method="post">
    <textarea name="icerik" style="border:1px solid #999; width:90%; height:300px;"><?php echo $sorgu->fetch()->icerik; ?></textarea>
    <br><br><br>
    <button type="submit">Değişiklikleri Kaydet</button>
  </form>
</div>

</body>
</html>