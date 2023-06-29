<?php 

require_once '../ınc/ayar.php';

    setcookie("tkp","",time()-1);
    $_SESSION["ynt"]="";
    //session_unset($_SESSION["ynt"]);
    session_destroy();
     
     echo "<script>
    window.location.href = 'index.php';
    </script>";
  
 ?>