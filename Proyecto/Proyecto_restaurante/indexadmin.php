<!DOCTYPE html>
<?php
  session_start();
  if( $_SESSION["tipo"]=="user"){
      header("Location: indexuser.php");
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
                header("Location: login.php");
        }else{

        }
    ?>
</body>
</html>