<?php
    include_once "../../../../Config/config.ini.php";

  include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
  include_once PATH_DATOS.'BaseDatos/sql.class.php';
  include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';
  include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php'; 


  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";
  include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handler = new HandlerSistema;
  $handlerCel = new HandlerCelulares;
  $handlerUs = new HandlerUsuarios;
  $handlerLeg = new HandlerLegajos;

  $entId=(isset($_GET["fID"])?$_GET["fID"]:'');
  $tipo = (isset($_GET["fTipo"])?$_GET["fTipo"]:'');
  #var_dump($tipo);
  #exit();

  $entrega = $handlerCel->getLineaEntregada($entId);

  $usuario= $handlerUs->selectById($entrega->getUsId());
  if($entrega->getIMEI()!=''){
    $equipo = $handlerCel->getDatosByIMEI($entrega->getIMEI());
  }
  $linea = $handlerCel->getDatosByNroLinea($entrega->getNroLinea());
  $legajo_gestor = $handlerLeg->seleccionarLegajos($entrega->getUsId());
  
  $fmes = date('m');
  $fdia = date('d');
  $fyear = date('Y');
  if ($tipo == '') {
    $ffechaAsig = $entrega->getFechaEntregaEquipo()->format('d-m-Y');
  } else {
    $ffechaAsig = $entrega->getFechaEntregaLinea()->format('d-m-Y');
  }
  

  switch ($fmes) {
    case '01':
      $mes = 'Enero';
      break;
    case '02':
      $mes = 'Febrero';
      break;
    case '03':
      $mes = 'Marzo';
      break;
    case '04':
      $mes = 'Abril';
      break;
    case '05':
      $mes = 'Mayo';
      break;
    case '06':
      $mes = 'Junio';
      break;
    case '07':
      $mes = 'Julio';
      break;
    case '08':
      $mes = 'Agosto';
      break;
    case '09':
      $mes = 'Septiembre';
      break;
    case '10':
      $mes = 'Octubre';
      break;
    case '11':
      $mes = 'Noviembre';
      break;
    case '12':
      $mes = 'Diciembre';
      break;
    
    default:
      # code...
      break;
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Imprimir Comodato</title>
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
    <section class="invoice" style="margin: 80px 100px 0;">

    <div class="row">
      <div class="col-md-12">
        <img src="http://commgroup.com.ar/images/logos/transparente.png" style="float: left;width: 40%;">
        <p style="text-align: right; line-height: 1.5em;">COMMERCIAL GROUP SRL<br>CUIT Nº: 30-71239507-5<br>San Luis 912-Rosario<br><br></p>

        <h4 class="text-right">Rosario, <?php echo $fdia.' de '.$mes.' de '.$fyear; ?>.-</h4>
        <br><br><br>
        <?php if ($tipo == 'linea') { ?>
          <p>Por medio de la presente, Yo, <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?>, hago entrega a Commercial Group S.R.L de una línea telefónica habilitada.<br>Los datos del bien entregado son:</p>
          <p><b>CANTIDAD</b>: 01<br>
          <b>N° DE LÍNEA</b>: <?php echo $linea->getNroLinea() ?>.<br>
          <b>ESTADO</b>: Habilitada<br>
          <b>OBSERVACIONES</b>: <?php echo $entrega->getObsDev() ?></p>

          <p><br>Este bien fue oportunamente recibido en condición de comodatario conforme contrato de comodato de fecha <?php echo $ffechaAsig; ?>.<br>A partir de este momento nada tendrán que recamarse las partes por el vínculo contractual habido.</p>
        
        <?php } elseif ($tipo == 'condi') { ?>
          <p>Por medio de la presente, Yo, <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?>, hago entrega a Commercial Group S.R.L de las siguientes herramientas:</p>

          <p><b>CANTIDAD</b>: 01 <br>
          <b>MARCA Y MODELO</b>: <?php echo $equipo->getMarca(); ?> <?php echo $equipo->getModelo(); ?><br>
          <b>Nº IMEI</b>: <?php echo $equipo->getIMEI(); ?><br>
          <b>N° DE LÍNEA</b>: <?php echo $linea->getNroLinea() ?>.<br>
          <b>ESTADO</b>: Satisfactorio<br>
          <b>OBSERVACIONES</b>: <?php echo $entrega->getObsDev() ?></p>
          <p><br>Este bien fue oportunamente recibido en condición de comodatario conforme contrato de comodato de fecha <?php echo $ffechaAsig; ?>. En consecuencia, nada tendrán que reclamarse las partes por el vínculo contractual habido.</p>

        <?php } elseif ($tipo == 'roto01') { ?>
          <p>Por medio de la presente, Yo, <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?>, hago entrega a Commercial Group S.R.L de las siguientes herramientas:</p>

          <p><b>CANTIDAD</b>: 01 <br>
          <b>MARCA Y MODELO</b>: <?php echo $equipo->getMarca(); ?> <?php echo $equipo->getModelo(); ?><br>
          <b>Nº IMEI</b>: <?php echo $equipo->getIMEI(); ?><br>
          <b>N° DE LÍNEA</b>: <?php echo $linea->getNroLinea() ?>.<br>
          <b>ESTADO</b>: <?php echo $entrega->getObsDev() ?>.</p>
          <p><br>Este bien fue oportunamente recibido en condición de comodatario conforme contrato de comodato de fecha <?php echo $ffechaAsig; ?>.</p>

        <?php } elseif ($tipo == 'roto02') { ?>
          <p>Por medio de la presente, Yo, <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?>, hago entrega a Commercial Group S.R.L de las siguientes herramientas:</p>

          <p><b>CANTIDAD</b>: 01 <br>
          <b>MARCA Y MODELO</b>: <?php echo $equipo->getMarca(); ?> <?php echo $equipo->getModelo(); ?><br>
          <b>Nº IMEI</b>: <?php echo $equipo->getIMEI(); ?><br>
          <b>N° DE LÍNEA</b>: <?php echo $linea->getNroLinea() ?>.<br>
          <b>ESTADO</b>: <?php echo $entrega->getObsDev() ?>.</p>
          <p><br>Este bien fue oportunamente recibido en condición de comodatario conforme contrato de comodato de fecha <?php echo $ffechaAsig; ?>.</p>

        <?php } elseif ($tipo == 'roto') { ?>
          <p>Por medio de la presente, Yo, <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?>, hago entrega a Commercial Group S.R.L de las siguientes herramientas:</p>

          <p><b>CANTIDAD</b>: 01 <br>
          <b>MARCA Y MODELO</b>: <?php echo $equipo->getMarca(); ?> <?php echo $equipo->getModelo(); ?><br>
          <b>Nº IMEI</b>: <?php echo $equipo->getIMEI(); ?><br>
          <b>N° DE LÍNEA</b>: <?php echo $linea->getNroLinea() ?>.<br>
          <b>ESTADO</b>: <?php echo $entrega->getObsDev() ?>.</p>
          <p><br>Este bien fue oportunamente recibido en condición de comodatario conforme contrato de comodato de fecha <?php echo $ffechaAsig; ?>.</p>

        <?php } elseif ($tipo == 'robo') { ?>
          <p>Se deja sin efecto el comodato a nombre del Sr/a. <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?> iniciado el día <?php echo $ffechaAsig; ?> referido a tal bien: Un teléfono <?php echo $equipo->getMarca(); ?>, modelo <?php echo $equipo->getModelo(); ?> con Nº DE IMEI <?php echo $equipo->getIMEI(); ?>, con la línea habilitada nro. <?php echo $linea->getNroLinea() ?> siendo que ha sufrido un hecho de inseguridad (robo en la vía pública) mientras cumplía tareas laborales cuya denuncia en sede policial acredita la declaración del empleado y se adjunta a la presenta baja de comodato</p>
        <?php } elseif ($tipo == 'perd') { ?>
          <p>Se deja sin efecto el comodato a nombre del Sr/a. <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?> iniciado el día <?php echo $ffechaAsig; ?> referido a tal bien: Un teléfono <?php echo $equipo->getMarca(); ?>, modelo <?php echo $equipo->getModelo(); ?> con Nº DE IMEI <?php echo $equipo->getIMEI(); ?>, con la línea habilitada nro. <?php echo $linea->getNroLinea() ?> siendo que ha extraviado dicho bien. <br><br></p>
        <?php } ?>
        
        <p style="line-height: 100px;margin-top: 50px;">Firma:</p>
        <p>Aclaración:</p>
        <p>D.N.I.:</p>

      </div>

    </div>
  </section>


</div>
</body>
</html>
