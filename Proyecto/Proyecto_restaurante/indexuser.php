<!DOCTYPE html>
<?php
  ob_start();
   session_start();
  if(isset($_SESSION["tipo"])){
    if( $_SESSION["tipo"]=="admin"){
        header("Location: ./admin/indexadmin.php");
    }elseif($_SESSION["tipo"]=="user"){

    }
  }else{

  }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h3> Bienvienido <?php echo $_SESSION["user"]." ".$_SESSION["tipo"];?> </h3>
    <a href="indexuser.php?logout=yes">Cerrar session</a>
    <?php

        if (isset($_GET["logout"])){
                session_destroy();
                header("Location: index.php");
        }else{

        }
    ?>
</body>
</html>
