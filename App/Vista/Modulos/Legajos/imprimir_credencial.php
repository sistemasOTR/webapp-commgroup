<?php
    include_once "../../../Config/config.ini.php";

  include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
  include_once PATH_DATOS.'BaseDatos/sql.class.php';
  include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';
  include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php';
  include_once PATH_NEGOCIO."Funciones/String/string.class.php";


  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handler = new HandlerSistema;
  $handlerUs = new HandlerUsuarios;
  $handlerLeg = new HandlerLegajos;

  $userId=(isset($_GET["userId"])?$_GET["userId"]:'');
  $usuario= $handlerUs->selectById($userId);
  $legajo_gestor = $handlerLeg->seleccionarLegajos($userId);
  

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Imprimir Credencial</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />       
  <!-- Ionicons -->
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
  <!-- Theme style -->
  <link href=<?php echo PATH_VISTA.'assets/dist/css/AdminLTE.min.css'; ?> rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    p {line-height: 30px; text-align: justify;}
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
    <section class="invoice" style="margin: 30px; border: solid 1px #999; width: 200px; height: 350px">
      <img src="header_otr.png" alt="" style="margin-bottom: 15px;">

    
        <?php 
          if(StringUser::emptyUser($usuario->getFotoPerfil()))
            $foto_perfil = "../../assets/dist/img/sinlogo_usuario.png";
          else
            $foto_perfil = "../../../../Usuario/".$usuario->getFotoPerfil();
         ?>
         <img src="<?php echo $foto_perfil ?>" style="width: 60%; margin-left: 20%; margin-bottom: 15px;">
        <h4 style="text-align: center;">
          <?php echo $usuario->getApellido(); ?><br><?php echo $usuario->getNombre(); ?>
        </h4>
        <h5 style="text-align: center;">
          CUIL: <?php echo $legajo_gestor->getCuit() ?>
          <br><br><br><br>
        </h5>
        <h6 style="text-align: right;margin: 2px 5px;"><em>OTR Group SRL</em></h6>
        <!--<h6 style="text-align: right;margin: 2px 5px;"><em>San Luis 912</em></h6>
        <h6 style="text-align: right;margin: 2px 5px;"><em>Rosario - Santa Fe</em></h6>-->
        <h6 style="text-align: right;margin: 2px 5px;"><em>0810 345 2683</em></h6>
        <h6 style="text-align: right;margin: 2px 5px;"><em>www.otrgroup.com.ar</em></h6>
  </section>


</div>
</body>
</html>
