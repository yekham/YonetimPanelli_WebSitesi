<?php
require_once '../ınc/ayar.php';

if ($_SESSION["ynt"] != yonetici($_COOKIE["tkp"])) {
  header("Location: cikis.php");
  die("Yetkisiz Erişim!");
}

$islem = $_GET["islem"];
$kayitno = $_GET["no"];

if ($islem == "sil") {
  //önce resimi siliyoruz
  $sorgu = $baglan->prepare("select resim from portfolyo where no=?");
  $sorgu->execute(array($kayitno));
  foreach ($sorgu as $satir) {
    unlink($satir->resim);
  }
  $sorgu->closeCursor(); unset($sorgu);  
  //sonra kayıtı siliyoruz
  $sorgu = $baglan->prepare("delete from portfolyo where no=?");
  $sil = $sorgu->execute(array($kayitno));
  $sorgu->closeCursor(); unset($sorgu);
  if ($sil) {
    echo "<script>
    alert('Kayıt Başarıyla Silindi!');
    window.location.href = 'portfolyo.php';
    </script>";
  } else {
    echo "<script>
    alert('Silme İşleminde Hata Oluştu!');
    window.location.href = 'portfolyo.php';
    </script>";
  }
}

if ($islem == "kaydet") {
  $baslik = tirnak($_POST["baslik"]);
  $sirano = tirnak($_POST["sirano"]);
  $verino = intval($_POST["verino"]);

  $isim = substr(sha1(rand(11111,99999)),0,10);
  $uzanti = end(explode(".", $_FILES["resim"]["name"]));

  if ($_FILES["resim"]["size"] > 0) {
    $resim = "../img/portfolyo/$isim.$uzanti";
    if (move_uploaded_file($_FILES["resim"]["tmp_name"], $resim)) {
      unlink($_POST["eskiresim"]);
    }
  } else {
    $resim = $_POST["eskiresim"];
  }

  if ($verino > 0) {
    $sorgu = $baglan->prepare("update portfolyo set baslik=?, resim=?, sirano=? where no=?");
    $sonuc = $sorgu->execute(array($baslik, $resim, $sirano, $verino));
    $sorgu->closeCursor(); unset($sorgu);
  } else {
    $sorgu = $baglan->prepare("insert into portfolyo values (?,?,?,?)");
    $sonuc = $sorgu->execute(array(NULL, $baslik, $resim, $sirano));
    $sorgu->closeCursor(); unset($sorgu);
  }

  if ($sonuc) {
    echo "<script>
    alert('Kayıt İşlemi Başarılı!');
    window.location.href = 'portfolyo.php';
    </script>";
  } else {
    echo "<script>
    alert('Kayıt İşleminde Hata Oluştu!');
    window.location.href = 'portfolyo.php';
    </script>";
  }
}

if ($islem == "duzenle" && $kayitno > 0) {
  $sorgu = $baglan->prepare("select * from portfolyo where no=?");
  $sorgu->execute(array($kayitno));
  foreach ($sorgu as $satir) {$satirlar = $satir;}
  $sorgu->closeCursor(); unset($sorgu);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolyo</title>
</head>
<body>
  
  <?php include_once 'ustalan.php'; ?>

  <h3 style="text-align:center">PORTFOLYO</h3>

  <?php if ($islem == "yeni" || $islem == "duzenle") { ?>
  <!-- Kayıt Ekleme / Düzenleme Ekranı -->

  <div style="text-align:center; margin-bottom:20px;">
    <button type="button" onclick="window.location.href='portfolyo.php';">Kayıt Listesi</button>
  </div>

  <form action="portfolyo.php?islem=kaydet" method="post" enctype="multipart/form-data" style="text-align:center">
    <b>Başlık</b><br><br>
    <input type="text" name="baslik" style="width:250px;padding:5px 5px;font-size:16px;" value="<?php echo $satirlar->baslik; ?>"><br><br>
    <b>Sıra No:</b><br><br>
    <input type="number" name="sirano" style="width:250px;padding:5px 5px;font-size:16px;" value="<?php echo $satirlar->sirano; ?>"><br><br>
    <b>Resim:</b> <a href="<?php echo $satirlar->resim; ?>" target="_blank"><img src="<?php echo $satirlar->resim; ?>" height="16"></a><br><br>
    <input type="file" name="resim" accept="image/*"><br><br><br>
    <input type="hidden" name="eskiresim" value="<?php echo $satirlar->resim; ?>">
    <input type="hidden" name="verino" value="<?php echo $satirlar->no; ?>">
    <button type="submit">Portfolyo Kaydet</button>
  </form>

  <?php } else { ?>
  <!-- Listeme Ekranı -->

  <div style="text-align:center; margin-bottom:20px;">
    <button type="button" onclick="window.location.href='portfolyo.php?islem=yeni';">Yeni Kayıt Ekle</button>
  </div>

  <table border="1" width="90%" align="center">
    <tr style="font-weight:bold">
      <td align="center" width="10%">S.No</td>
      <td align="center" width="15%">Resim</td>
      <td width="55%">Başlık</td>
      <td align="center" width="20%">İşlem</td>
    </tr>
    <?php
      $sirano = 0;
      $sorgu = $baglan->prepare("select * from portfolyo order by sirano asc, no asc");
      $sorgu->execute();
      foreach ($sorgu as $satir) {
        $sirano++;
        echo "<tr>
        <td align='center'>$sirano</td>
        <td align='center'><a href='$satir->resim' target='_blank'><img src='$satir->resim' width='50' height='35'></a></td>
        <td>$satir->baslik</td>
        <td align='center'><a href='portfolyo.php?islem=duzenle&no=$satir->no'>Düzenle</a> | <a href='portfolyo.php?islem=sil&no=$satir->no' onclick=\"if (!confirm('Silmek istediğinize emin misiniz?')) return false\">Sil</a></td>
        </tr>";
      }
      $sorgu->closeCursor(); unset($sorgu);
    ?>
  </table>

  <?php } ?>

</body>
</html>