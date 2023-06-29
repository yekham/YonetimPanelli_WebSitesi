<?php 
require_once 'ınc/ayar.php';

?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yönetim Panelli Web Sitesi</title>
  <link href="css/style.css" rel="stylesheet">
  <link href="css/jquery.fancybox-1.3.4.css" rel="stylesheet">
</head>
<body>
  <a href="https://wa.me/+90" target="_blank"><img src="img/whatsapp.jpg" class="whatsapp"></a>
  
  <aside>
    <div>
      MSB<br>Tasarım
    </div>
    <nav>
      <ul>
        <li><a href="index.html">Ana Sayfa</a></li>
        <li><a href="#portfolyo">Portfolyo</a></li>
        <li><a href="#hakkimizda">Hakkımızda</a></li>
        <li><a href="#hizmetlerimiz">Hizmetlerimiz</a></li>
        <li><a href="#iletisim">İletişim</a></li>
      </ul>
    </nav>
  </aside>

  <header>
    <h1>MSB Tasarım</h1>
  </header>

  <nav id="menu">
    <ul>
      <li><a href="#portfolyo">Portfolyo</a></li>
      <li><a href="#hakkimizda">Hakkımızda</a></li>
      <li><a href="#hizmetlerimiz">Hizmetlerimiz</a></li>
      <li><a href="#iletisim">İletişim</a></li>
    </ul>
  </nav>

  <main>
    <section id="portfolyo">
      <h2 class="baslik">Portfolyo</h2>
      <hr>
      <div id="resimler">
       <?php
          $sorgu = $baglan->prepare("select * from portfolyo order by sirano asc, no desc");
          $sorgu->execute();
          foreach ($sorgu as $satir) {
            $resim = substr($satir->resim, 3);
            echo "<div class='resim'>
            <a href='$resim' rel='fancybox' title='$satir->baslik'><img src='$resim' alt='$satir->baslik'></a>
            </div>";
          }
          $sorgu->closeCursor(); unset($sorgu);
        ?>
      
        
        
        <div class="temizle"></div>
      </div>
    </section>
    <section id="hakkimizda">
      <h2 class="baslik">Hakkımızda</h2>
      <hr>
     <?php
     $sorgu=$baglan->prepare("select icerik from hakkimizda order by no desc limit 1");
     $sorgu->execute();
     $sonuc=$sorgu->fetch();
     
     echo $sonuc->icerik; 

     $sorgu->closeCursor(); unset($sorgu,$sonuc); //fetch işlemini bufferdan kaldırmamızı sağlar, hafızayı temizler, değişkeni siler

     ?>
    </section>
    <section id="hizmetlerimiz">
      <h2 class="baslik">Hizmetlerimiz</h2>
      <hr>
     <?php
     
     $sorgu=$baglan->prepare("select icerik from hizmetlerimiz order by no desc limit 1");
     $sorgu->execute();
     $sonuc=$sorgu->fetch();
     
     echo $sonuc->icerik; 
     $sorgu->closeCursor(); unset($sorgu,$sonuc);

     ?>
    </section>
    <section id="iletisim">
      <h2 class="baslik">İletisim</h2>
      <hr>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum, blanditiis.</p>
      <form action="kontrol.php" method="post" autocomplete="off">
        <label for="adsoyad">Ad Soyad</label>
        <input type="text" name="adsoyad" maxlength="100" required>
        <label for="eposta">E-posta</label>
        <input type="email" name="eposta" maxlength="100" required>
        <label for="mesaj">Mesaj</label>
        <input type="text" name="mesaj" maxlength="500" required>
        <button type="submit">Mesaj Gönder</button>
      </form>
    </section>
  </main>

  <div class="temizle"></div>

  <footer>
    &copy; Tasarım <?php echo date("Y") ?> <span>&#x2665;</span> <a href="https://enstitu.ibb.istanbul" target="_blank">Enstitü İstanbul İsmek</a>
  </footer>
<script src="js/jquery-1.4.3.min.js"></script>
<script src="js/jquery.fancybox-1.3.4.js"></script>
<script>
$("a[rel=fancybox]").fancybox();
</script>
</body>
</html>