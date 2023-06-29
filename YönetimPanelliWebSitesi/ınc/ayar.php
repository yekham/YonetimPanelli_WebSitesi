<?php

error_reporting(0);
session_start();

try {
  $baglan = new PDO("mysql:host=localhost;dbname=websitesi;charset=utf8", "username", "password");
  $baglan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $baglan->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $baglan->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
  $baglan->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (Exception $e) {
  echo $e->getMessage();
  die();
}

function guvenlik($deger=''){
  $deger=htmlentities(strip_tags($deger));
  return $deger;
}

function yonetici($no = 0) {
  global $baglan;
  $sorgu = $baglan->prepare("select kullanici from yonetici where (no=?)");
  $sorgu->execute(array($no));
  $yonetici=$sorgu->fetch();
  return sha1(md5($yonetici->kullanici));
}

function istatistik() {
  global $baglan;
  $sorgu = $baglan->prepare("insert into istatistik values (?,?,?)");
  $sorgu->execute(array(NULL, $_SERVER["REMOTE_ADDR"], date("Y-m-d H:i:s")));
}

function tirnak($deger = '') {
  $deger = str_replace("'", "´", $deger);
  return $deger;
}






?>