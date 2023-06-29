<?php 
require_once 'ınc/ayar.php';

if ($_POST) {
  $adsoyad = guvenlik($_POST["adsoyad"]);
  $eposta = guvenlik($_POST["eposta"]);
  $mesaj = guvenlik($_POST["mesaj"]);

  

  if (strlen($adsoyad) <= 5 || empty($eposta) || $mesaj == ""){
    echo "<script>
    alert('Tüm Alanları Doldurun!');
    window.location.href = 'index.php';
    </script>";
    die("JavaScript Yönlendirme Hatası! Tarayıcı Desteği Yok.");
  	}

 
  $sorgu = $baglan->prepare("insert into iletisim values(?,?,?,?,?)");
  $sorgu->execute(array(NULL, $adsoyad, $eposta, $mesaj, date("Y-m-d H:i:s")));

  
  if ($sorgu->rowCount() > 0) {
    echo "<script>
    alert('Mesajınız Gönderildi, Teşekkür Ederiz!');
    window.location.href = 'index.php';
    </script>";
    exit;
  }

}else {
  header("Location: index.php");
	}




 ?>