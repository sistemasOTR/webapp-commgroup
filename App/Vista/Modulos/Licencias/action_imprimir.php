<?php
  include_once "../../../Config/config.ini.php";  

  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";

  $handler = new HandlerLicencias();
  $handlerLegajo = new HandlerLegajos();
  $handlerUs = new HandlerUsuarios();
  $handlerPlaza = new HandlerPlazaUsuarios();
  $f= new Fechas();

  $id = (isset($_GET["id"])?$_GET["id"]:'');

  $licencia = $handler->seleccionarLicenciasById($id);
  $legajo = $handlerLegajo->seleccionarLegajos($licencia->getUsuarioId()->getId());
  $usuario = $handlerUs->selectById($licencia->getUsuarioId()->getId());
  $plaza = $handlerPlaza->selectById($usuario->getUserPlaza());

  $url_action_imprimir = PATH_VISTA.'Modulos/Licencias/action_imprimir.php?id=';   
  $dia = $licencia->getFechaInicio()->format('N');
  $nrodia = $licencia->getFechaInicio()->format('d'); 
  $mes = $licencia->getFechaInicio()->format('m');
  $año = $licencia->getFechaInicio()->format('Y'); 

  switch ($dia) {
    case '1':
      $dia = 'Lunes';
      break;
    case '2':
      $dia = 'Martes';
      break;
    case '3':
      $dia = 'Miércoles';
      break;
    case '4':
      $dia = 'Jueves';
      break;
    case '5':
      $dia = 'Viernes';
      break;
    case '6':
      $dia = 'Sábado';
      break;
    case '7':
      $dia = 'Domingo';
      break;
    default:
      # code...
      break;
  }
  switch ($mes) {
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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Imprimir Licencia</title>
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

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
  th, td {padding: 7px 5px;}
  section {border: 2px solid #555; padding: 10px;}
</style>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header text-center">
            Notificación de Licencias
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info" style="margin-bottom: 30px;">
        <div class="col-md-12 invoice-col pull-right">
          <b>
            Rosario, 
            <?php echo $dia; ?>
            <?php echo $nrodia; ?>
            de
            <?php echo $mes; ?>
            de
            <?php echo $año; ?>            
          </b>
        </div>
      </div>
      <div class="row invoice-info">
        <div class="col-sm-6 invoice-col pull-left">

          <address style="line-height: 25px;">
            Señor/a: <strong><?php echo $legajo->getNombre(); ?></strong><br>
            CUIL: <?php echo $legajo->getCuit(); ?><br>
            Legajo N°: <?php echo $legajo->getNumeroLegajo(); ?><br>
            Plaza: <?php echo $plaza->getNombre(); ?>
          </address>
        </div>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12 pull-left">
          <p>Por medio de la presente, notificamos que se le otorga la siguiente licencia</p>
        </div>
      </div>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="" width="100%" border="1" bordercolor="#999999" cellpadding="2">
            <thead>
            <tr>
              <th>Dias</th>
              <th>Licencia</th>
              <th>Desde</th>
              <th>Hasta</th>
            </tr>
            </thead>

            <?php 
              $dif = $f->DiasDiferenciaFechas($licencia->getFechaInicio()->format("Y-m-d"),$licencia->getFechaFin()->format("Y-m-d"),"Y-m-d");
            ?>

            <tbody>
              <tr>            
                <td><?php echo $dif + 1; ?></td>
                <td><?php echo $licencia->getTipoLicenciasId()->getNombre();?></td>
                <td><?php echo $licencia->getFechaInicio()->format("Y-m-d"); ?></td>
                <td><?php echo $licencia->getFechaFin()->format("Y-m-d"); ?></td>
              </tr>          
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row" style="margin-top: 50px;margin-bottom: 50px">
        <div class="col-xs-10 col-xs-offset-1">
          <table>
            <tbody>
              <tr>
                <td>Observaciones:</td>
                <td><?php echo $licencia->getObservaciones(); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        
      </div>

      <div class="row" style="margin-top: 300px;margin-bottom: 50px">
        <!-- accepted payments column -->
        <div class="col-xs-4 col-xs-offset-2 border-right">        
          <hr>
          <h4>FIRMA EMPLEADO</h4>
        </div>
        
        <div class="col-xs-4">
          <hr>
          <h4>FIRMA REFERENTE</h4>
        </div>

      </div>
      
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
