<?php
    include_once "../../../Config/config.ini.php";

  include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
  include_once PATH_DATOS.'BaseDatos/sql.class.php';
  include_once PATH_DATOS.'BaseDatos/conexionsistema.class.php';
  include_once PATH_DATOS.'BaseDatos/sqlsistema.class.php';
  include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';
  include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php'; 


  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handler = new HandlerSistema;
  $handlerUs = new HandlerUsuarios;
  
  $fechaRecep=(isset($_GET["fechaR"])?$_GET["fechaR"]:'');
  $plaza=(isset($_GET["plaza"])?$_GET["plaza"]:'');
  $festado = 50;
  $fequipoventa=(isset($_GET["fequipoventa"])?$_GET["fequipoventa"]:'');
  $fcliente=(isset($_GET["cuenta"])?$_GET["cuenta"]:'');
  $fgerente=(isset($_GET["fgerente"])?$_GET["fgerente"]:'');    
  $fcoordinador=(isset($_GET["fcoordinador"])?$_GET["fcoordinador"]:'');
  $fgestor=(isset($_GET["fgestor"])?$_GET["fgestor"]:'');
  $foperador=(isset($_GET["foperador"])?$_GET["foperador"]:'');
  $fest=(isset($_GET["festado"])?$_GET["festado"]:'');

  $festado += $fest;

  
  $arrDatos = $handler->selectImprimirServicios($fechaRecep,$festado,$fcliente,$fgestor,$plaza);
  $arrEstados = $handler->selectAllEstados();    
  $allEstados = $handler->selectAllEstados(); 
  $totalRecib = $handler->contarRecibidos($fechaRecep, $fcliente, $plaza,$fgestor,$fest);

                    

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Imprimir Recibidos</title>
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
    p {line-height: 25px; text-align: justify;}
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
  <thead>

    <tr >
      <td colspan="2" style="font-size: 28px;"><?php echo $handler->selectEmpresaById(trim($fcliente))[0]->EMPTT21_NOMBREFA ; ?></td>
      <th class="pull-right" border="0" style="border: 0;">Fecha: <?php echo date('d-m-Y',strtotime($fechaRecep)); ?></th>
      
    <tr>       
      <th class='text-left'>NOMBRE</th>            
      <th class='text-left'>DNI</th>            
      <th class='text-left'>ESTADO</th>
    </tr>
  </thead>

  <tbody>
    <?php    
      if(!empty($arrDatos)){
        foreach ($arrDatos as $key => $value) {                    
          
          echo "<tr>";
          //NOMBRE
          echo "<td class='text-left'>".trim(strip_tags($value->SERTT91_NOMBRE))."</td>";
          //DNI
          echo "<td class='text-left'>".$value->SERTT31_PERNUMDOC."</td>";
          //ESTADOS
          $f_array = new FuncionesArray;
          $class_estado = $f_array->buscarValor($allEstados,"1",$value->ESTADOS_DESCCI,"3");
          echo "<td class='text-left'><span class='".$class_estado."'>".$value->ESTADOS_DESCCI."</span></td>";             
          echo "</tr>";
        }
      }
              
    ?>                        
  </tbody>
  <tfoot>
    <tr>
      <th colspan="4" style="text-align: right;">Total de gestiones recibidas: <?php echo $totalRecib[0]->CANTIDAD; ?></th>
    </tr>      
    </tr>
  </tfoot>
</table> 


</div>
</body>
</html>
