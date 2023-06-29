<?php 

require_once '../ınc/ayar.php';

if ($_POST) {
  $kullanici = $_POST["kullanici"];
  $parola = $_POST["parola"];
 

  if ( empty($kullanici) || $parola == ""){
    echo "<script>
    alert('Tüm Alanları Doldurun!');
    window.location.href = 'index.php';
    </script>";
    die("JavaScript Yönlendirme Hatası! Tarayıcı Desteği Yok.");
  	}
//veri tabanındaki kullanıcı ve parola ile formdaki kul. ve parolayla eşleşiyor mu diye bir select çektik ve formdan aldığımız verileri select'te aktardık.Daha sonra no alanına erişmeye çalıştık eğer erişemezsek kul. bilgileri hatalıdır.
 
  $sorgu = $baglan->prepare("select * from yonetici where (kullanici=? and parola=?) limit 1 ");
  $sorgu->execute(array( $kullanici, sha1(md5($parola))));
  $yonetici=$sorgu->fetch();
//Admin doğruluğu bu yapı ile kontrol edilir. eğer $yonetici'de tuttuğumuz değerlerin eklediğimiz adminlere göre database'de bir no alanı varsa ve bu sıfırdan büyükse döngüye girer yoksa panele giremez.
if(intval($yonetici->no)>0){
	
	setcookie("tkp",$yonetici->no,time()+3*60*60);
	$_SESSION["ynt"]=sha1(md5($kullanici));
	echo "<script> window.location.href = 'anasayfa.php'; </script>";
    


}else{
	 echo "<script>
    alert('Hatalı Kullanıcı Bilgileri!');
    window.location.href = 'index.php';
    </script>";
    exit;
}




  

}
	else {
  header("Location: index.php");
	}









 ?>