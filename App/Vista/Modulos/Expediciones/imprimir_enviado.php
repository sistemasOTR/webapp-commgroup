<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f= new Fechas;
	$fecha=$f->FechaActual();
	$handler= new handlerexpediciones;	
  
    $pedID=(isset($_GET["pedID"])?$_GET["pedID"]:'');
	$plazaEnv=(isset($_GET["plazaEnv"])?$_GET["plazaEnv"]:'');

	$envios=$handler->selectByNroEnvio($pedID);

	

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Imprimir Remito <?php echo $pedID;?></title>
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

  <style>
    p {line-height: 25px; text-align: justify;}
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
    <section class="invoice" style="margin: 0 50px;">

    <div class="row">
      <div class="col-md-12">
      	<div class="col-md-4">
      		<img src="otrLogo.png" style="width: 100px;float:left;">
      	</div>
      	<div class="col-md-8 text-right">
      		<h5>REMITO: <b><?php echo $pedID;?></b> | Fecha: <b><?php echo $fecha;?></b></h5>
      	</div>
      	<br>
      	<div class="col-md-12">
      		<h5>Destino: <b><?php echo $plazaEnv;?></b></h5>
      	</div>

       <!--  <h5><b style="margin-left: 100px ">PLAZA:</b> <b class="pull-right">FECHA:<?php echo $fecha;?></b><br><br><h5><b class="pull-left">REMITO:<?php echo $pedID;?></b></h5><br>

 -->
 		<br>
        <div class="table-responsive">
            
              <table class="table table-striped" id='tabla'>
                <thead>
                  <tr>
                    <th style="text-align:left;">ITEM-DESCRIPCION</th>
                    <th style="text-align: center;">CANTIDAD</th>             
                  </tr>
                </thead>
                <tbody>
                     <?php if(!empty($envios)) 
                      {  

                        foreach ($envios as $key => $value) {
                           $idPed = $value->getIdPedido();
                           $items=$handler->selectByIdEnvio($idPed);
       //                     var_dump($items->getItemExpediciones());
							// exit();
                           
                           $item = $handler->selectById($items->getItemExpediciones());
                           if (count($item)==1) {
                            $item = $item[""];
                           }
                          echo "
                            <tr>
                            <td style='text-align: left;'>".$item->getNombre()."".$item->getDescripcion()."</td>
                            <td style='text-align: center;'>".$value->getCantidadEnviada()."</td>
                            
                            </tr> ";    
                          
                        }
                      }
                    ?> 

            
                  </tbody>
              </table>
          </div>
      </div>

    </div>
  </section>


</div>
</body>
</html>