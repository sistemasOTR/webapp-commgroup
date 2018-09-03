<?php
  include_once "../../../Config/config.ini.php";

  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php";
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php";
  include_once PATH_DATOS.'Entidades/legajos_categorias.class.php';
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 

  $idsueldo= (isset($_GET["idsueldo"])?$_GET["idsueldo"]:'');

   ###########################
  # Declaración de handlers #
  ###########################

  $handlerSueldos = new HandlerSueldos;
  $handlerUsuarios = new HandlerUsuarios;
  $handlerLeg = new HandlerLegajos;
  $handlerLegCat = new LegajosCategorias;
  $dFechas = new Fechas;

  #####################
  # Instanciar Sueldo #
  #####################
  $sueldo = $handlerSueldos->selectSueldoById($idsueldo);

  ###########################
  # Instanciar Items Sueldo #
  ###########################
  $arrSueldo = $handlerSueldos->selectItemsBySueldo($idsueldo);
  $cantItems = count($arrSueldo);

  ##############################
  # Instanciar Ultimos Sueldos #
  ##############################
  $ultimosSueldos = $handlerSueldos->selectLast2SueldosByUsuario($sueldo->getIdUsuario(),$sueldo->getPeriodo()->format('Y-m-d'));
  if (count($ultimosSueldos)>1) {
    $periodoAnt= $ultimosSueldos[1]->getPeriodo()->format('m-Y');
    $depAnt= $ultimosSueldos[1]->getFecha()->format('d-m-Y');
  } else {
    $periodoAnt= '';
    $depAnt='';
  }

  #####################
  # Instanciar Legajo #
  #####################
  $legajo = $handlerLeg->seleccionarByFiltros($sueldo->getIdUsuario());

  #####################
  # Instanciar Básico #
  #####################
  $basico = $sueldo->getBasico();

  ########################
  # Instanciar Categoría #
  ########################
  $idCategoria = $sueldo->getCategoria();
  $cat = $handlerLegCat->selectById($idCategoria);

  $dia = $sueldo->getFecha()->format('N');
  $nrodia = $sueldo->getFecha()->format('d'); 
  $mes = $sueldo->getFecha()->format('m');
  $año = $sueldo->getFecha()->format('Y'); 

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
  <title>Imprimir Recibo de Sueldo</title>
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
  th, td {padding: 5px;font-size: 12px;}
  section {border: 1px solid #555; padding: 10px;}
  table {margin: 2px 0;}
</style>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
    <section class="invoice" style="height: 1050px;">
      <!-- title row -->
      <div class="row" style="border-bottom: 1px solid #555;">
        <div class="col-xs-6">
          <h5>COMMERCIAL GROUP SRL<br>30-71239507-5</h5>
        </div>
        <div class="col-xs-6">
          <h5>Córdoba 3479 - Rosario<br>LEGAJO N° <?php echo $legajo[""]->getNumeroLegajo() ?></h5>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info" style="margin: 10px 0px;">
          <table width="100%" cellpadding="2" border="1">
            <thead>
              <tr>
                <th width="16.7%" style="text-align: center;">Apellido y Nombre</th>
                <th width="16.7%" style="text-align: center;">Fecha de Ingreso</th>
                <th width="16.7%" style="text-align: center;">CUIL</th>
                <th width="33.3%" style="text-align: center;">C.C.T.</th>
                <th width="16.7%" style="text-align: center;">Remuneración Básica</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td width="16.7%" style="text-align: center;"><?php echo $legajo[""]->getNombre() ?></td>
                <td width="16.7%" style="text-align: center;"><?php echo $legajo[""]->getFechaIngreso()->format('d-m-Y') ?></td>
                <td width="16.7%" style="text-align: center;"><?php echo $legajo[""]->getCuit() ?></td>
                <td width="33.3%" style="text-align: center;">130/75</td>
                <td width="16.7%" style="text-align: center;"><?php echo $cat['categoria']; ?></td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellpadding="2" border="1">
            <thead>
              <tr>
                <th width="16.7%" style="text-align: center;">Período SUSS mes anterior</th>
                <th width="33.3%" style="text-align: center;">Banco Depósito</th>
                <th width="16.7%" style="text-align: center;">Fecha Último Depósito</th>
                <th width="33.3%" style="text-align: center;">Calificación Profesional</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td width="16.7%" style="text-align: center;"><?php echo $periodoAnt ?></td>
                <td width="33.3%" style="text-align: center;">Banco Macro S.A.</td>
                <td width="16.7%" style="text-align: center;"><?php echo $depAnt ?></td>
                <td width="33.3%" style="text-align: center;"><?php echo $cat['categoria']; ?></td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellpadding="2" border="1">
            <thead>
              <tr>
                <th width="16.7%" style="text-align: center;">Período Abonado</th>
                <th width="33.3%" style="text-align: center;">Domicilio de Pago</th>
                <th width="16.7%" style="text-align: center;">Fecha de Pago</th>
                <th width="33.3%" style="text-align: center;">Tarea Desempeñada</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td width="16.7%" style="text-align: center;"><?php echo $sueldo->getPeriodo()->format('m-Y') ?></td>
                <td width="33.3%" style="text-align: center;">Córdoba 3479</td>
                <td width="16.7%" style="text-align: center;"><?php echo $sueldo->getFecha()->format('d-m-Y') ?></td>
                <td width="33.3%" style="text-align: center;"></td>
              </tr>
            </tbody>
          </table>
          <table width="100%" cellpadding="2" border="1" style="height: 900px;">
            <thead>
              <tr>
                <th width="33.3%" style="text-align: center;">Descripción de Conceptos</th>
                <th width="16.7%" style="text-align: center;">Unidades</th>
                <th width="16.7%" style="text-align: center;">Remuneración</th>
                <th width="16.7%" style="text-align: center;">Descuentos</th>
                <th width="16.7%" style="text-align: center;">Conceptos no remunerativos</th>
              </tr>
            </thead>
            <tbody>
                <?php if (!empty($arrSueldo)) { 
                  foreach ($arrSueldo as $key => $value) { 
                    if ($value->getUnidad()>0) { 
                      $remu = '';
                      $desc = '';
                      $noremu = '';
                      if ($value->getRemunerativo()>0) {
                        $remu = '$ '.$value->getRemunerativo();
                      }
                      if ($value->getNoRemunerativo()>0) {
                        $noremu = '$ '.$value->getNoRemunerativo();
                      }
                      if ($value->getDescuento()>0) {
                        $desc = '$ '.$value->getDescuento();
                      }
                      ?>
                    <tr style="height: .75em;">
                      <td width="33.3%" style="text-align: left;border: none;font-size: 10px;"><?php echo $value->getConcepto() ?></td>
                      <td width="16.7%" style="text-align: center;border: none;font-size: 10px;"><?php echo $value->getUnidad() ?></td>
                      <td width="16.7%" style="text-align: center;border: none;font-size: 10px;"><?php echo $remu ?></td>
                      <td width="16.7%" style="text-align: center;border: none;font-size: 10px;"><?php echo $desc ?></td>
                      <td width="16.7%" style="text-align: center;border: none;font-size: 10px;"><?php echo $noremu ?></td>
                    </tr>
                 <?php }
                     } 
                } ?>
                <tr>
                  <td width="33.3%" rowspan="2" style="text-align: left;"></td>
                  <td width="16.7%" style="text-align: center;"><b>Sub-total</b></td>
                  <td width="16.7%" style="text-align: center;">$ <?php echo $sueldo->getRemunerativo() ?></td>
                  <td width="16.7%" style="text-align: center;">$ <?php echo $sueldo->getDescuento() ?></td>
                  <td width="16.7%" style="text-align: center;">$ <?php echo $sueldo->getNoRemunerativo() ?></td>
                </tr>
                <tr>
                  <td width="16.7%" style="text-align: center;"></td>
                  <td width="16.7%" style="text-align: center;"></td>
                  <td width="16.7%" style="text-align: center;"><b>Total Neto</b></td>
                  <td width="16.7%" style="text-align: center;">$ <?php echo ($sueldo->getNoRemunerativo() -$sueldo->getDescuento()+$sueldo->getRemunerativo()) ?></td>
                </tr>
                <tr>
                  <td colspan="5" style="text-align: center;">Recibí conforme la suma de $<?php  echo ($sueldo->getNoRemunerativo() -$sueldo->getDescuento()+$sueldo->getRemunerativo()) ?> en concepto de mis haberes correspondoentes al período indicado y según la presente liquidación, dejo constancia de haber recibido un duplicado de este recibo.</td>
                </tr>
            </tbody>
          </table>
      </div>

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-4 col-xs-offset-1 border-right" style="position: absolute;bottom: 15px; left: 0%;text-align: center;">        
          <hr style="margin-bottom: 0; margin-top: 0;">
          <h6>FIRMA EMPLEADO</h6>
        </div>
        
        <div class="col-xs-4 col-xs-offset-1" style="position: absolute;bottom: 15px;left: 50%;text-align: center;">
          <hr style="margin-bottom: 0; margin-top: 0;">
          <h6>FIRMA EMPLEADOR</h6>
        </div>
      </div>
      
    </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
