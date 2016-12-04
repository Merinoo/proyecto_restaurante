<!DOCTYPE html>

<?php
  ob_start();
   session_start();
  if(isset($_SESSION["tipo"])){
    if( $_SESSION["tipo"]=="admin"){

    }elseif($_SESSION["tipo"]=="user"){
      header("Location: ../indexuser.php");
    }
  }else{
    header("Location: ../index.php");
  }
?>

<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
    <link href="../css/login.css" rel="stylesheet" type="text/css">

    <?php
      if(isset($_SESSION["tipo"])){
        if($_SESSION["tema"]==1){
          echo '<link rel="stylesheet" href="../css/indexhtml.css">';
        }elseif($_SESSION["tema"]==2){
          echo '<link rel="stylesheet" href="../css/indexhtml2.css">';
        }elseif($_SESSION["tema"]==3){
          echo '<link rel="stylesheet" href="../css/indexhtml3.css">';
        }
      }else{
        echo '<link rel="stylesheet" href="../css/indexhtml.css">';
      }
    ?>

     <!-- Tenemos que poner el css del login sino el cuadro no aparecera -->

    <!-- Estas son las librerias de ajax y bootstrap online que necesito para el slidercentral -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    <style>
    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width:1300px;
        height:740px;
        margin: auto;
        margin-top:0px;
    }
    </style>

  </head>

    <body>

      <div id='global'>
          <div id='menucabecera'>

              <div id="logo">
              </div>

              <div id="menu">
                <ul>
                  <li><a href="../admin/indexadmin.php">Inicio</a></li>
                  <li><a href="../admin/admin_usuarios.php">Usuarios</a></li>
                  <li><a href="../admin/admin_producto.php">Productos</a></li>
                  <li><a href="../admin/admin_pedidos.php">Pedidos</a></li>
                  <li class="active"><a href="../admin/admin_estadisticas.php">Estadisticas</a></li>


                    <ul style="float:right; list-style-type:none;">

                  <!-- Aqui miramos si al darle al login esta logueado  o no -->
                  <!-- Si no esta logueado muestra el boton de login y mostrara luego el menú para loguearnos -->
                      <?php if(empty($_SESSION["user"])) : ?>
                          <li><a href="./registro.php">Registro</a></li>
                           <li><a href="#login">Login</a></li>

                  <!-- Si esta logueado mostrara el menu del usuario que se logueo -->
                  <!-- Añadimos al boton el enlace con valor logout yes-->
                      <?php else : ?>
                          <li><a href="./editar_admin_logeado.php"><?php echo $_SESSION["user"]; ?></a></li>
                          <li><a href="../index.php?logout=yes"><img id="cerrar_sesion" src="../logo/logout.png" /></a></li>
                      <?php endif ?>


                    <?php
                      if(empty($_GET["logout"])){
                      }else{
                        session_destroy();
                        header("Location: ../admin/indexadmin.php");
                      }
                    ?>


                      <div id="login" class="loginDialog">
                          <div>	<a href="#close" title="Close" class="close">X</a>
                               <h2><center>Login</center></h2>
                               <form method="post" action="./index.php">
                                 <table>
                                   <tr>
                                      <td><input type="text" id="user" name ="user" placeholder="Usuario"></td>
                                   </tr>
                                   <tr>
                                      <td><input type="password" id="pass" name="pass" placeholder="Contraseña"></td>
                                   </tr>
                                   <tr>
                                     <td><input class="btn-style" type="submit" value="Entrar"/></td>
                                   </tr>
                                   <tr><td><a href="#" id="olvido_contrasena">¿Olvido su Contraseña?</a></td></tr>
                                 </table>
                               </form>
                          </div>
                      </div>

                    </ul>
                </ul>
              </div> <!-- Cierra <div id="menu"> -->
            </div> <!-- Cierra <div id='menucabecera'> -->

            <?php
              //Recuperar los datos
                 if (isset($_POST["user"])){

                    //Recogiendo los datos del user y pass
                    $user=$_POST["user"];
                    $pass=$_POST["pass"];
                    $tipouser="";

                    //Conexion con la base de datos
                    include("../conexion.php");

                    //Aqui ponemos $user y $pass porque recogemos las variables arriba por eso no usamos $_POST.
                    $consulta="select * from usuarios where Username='".$user."' and Password=md5('".$pass."');";

                    if ($result = $connection->query($consulta)) {

                          //Si te devuelve 0 es que el usuario no esta en la base de datos.Sino si existe y mira en else
                          if ($result->num_rows==0) {
                            //echo "EL USUARIO NO EXISTE";
                          } else {
                              //Coge los datos devueltos por la consulta.
                              while($fila=$result->fetch_object()){
                                  $tipouser=$fila->Tipo;
                                //Creamos la session
                                $_SESSION["user"]=$user;
                                $_SESSION["tipo"]=$tipouser;
                              }
                              //Si el tipo de usuario es administrador lo manda a indexadmin.php y si es usuario corriente lo manda indexuser.php .
                              if ($tipouser=="user"){
                                  header("Location: ../index.php");

                              }else{
                                  header("Location: ../admin/indexadmin.php");
                              }

                          }

                      } else {

                      }

                }

            ?>


      <div id='slidercentral' style="height:1500px;">

        <div style="width:100%:position:relative;">
          <div class="row" style="width:90%;margin: 0 auto;">
            <div id="cuerpo_prov">
                <div id="cr_prov">
                  <form class="form-horizontal" role="form" method="post">
                      <fieldset>
                        <legend><span class="glyphicon glyphicon-cutlery"></span> CANTIDAD PRODUCTOS POR TIPO</legend>
                        <?php
                          include("./estadisticas_tipo_producto.php");
                         ?>
                      </fieldset>
                      <fieldset>
                        <legend><span class="glyphicon glyphicon-cutlery"></span> PRODUCTOS MAS VENDIDOS</legend>
                        <?php
                          include("./estadisticas_productos_mas_vendidos.php");
                         ?>
                      </fieldset>
                      <fieldset>
                        <legend><span class="glyphicon glyphicon-cutlery"></span> ESTADISTICAS GENERALES</legend>
                        <?php
                          include("./estadisticas_generales.php");
                         ?>
                      </fieldset>


                  </form>
                </div>
            </div>
          </div>


      </div>
    </div>

          <div id='pie'>
            © 2015 BAR MERI España. Todos los derechos reservados.
          </div>

      </div>
    </body>
</html>
