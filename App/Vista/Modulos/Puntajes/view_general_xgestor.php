<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 

  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $user = $usuarioActivoSesion;
  
  $dFecha = new Fechas;

  $handlerSist = new HandlerSistema;
  $arrEmpresas = $handlerSist->selectAllEmpresa();

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());      
  $fgestor = (isset($_GET["fgestor"])?$_GET["fgestor"]:'');      
  $fnomgestor = (isset($_GET["fnomgestor"])?$_GET["fnomgestor"]:''); 
  $url_servicios = "index.php?view=servicio&fgestor=".$fgestor."&fdesde=".$fdesde."&fhasta=".$fhasta."&festado=";     
  // $fcoordinador= $user->getAliasUserSistema();

  $handler =  new HandlerConsultas;
?>
<style>
    td a {display: block; width: 100%}
  @media (min-width:768px){
  }
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Puntajes
      <small>Detalle del puntaje entre el <?php echo $fdesde ?> y el <?php echo $fhasta ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Puntajes</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <div class="col-md-12">
        <?php
          
            $total_servicios = 0;
            $total_servicios_CERRADO = 0;
            $total_servicios_ENV = 0;
            $total_servicios_CERRADO_PARCIAL = 0;
            $total_servicios_RE_PACTADO = 0;
            $total_servicios_RE_LLAMAR = 0;
            $total_servicios_NEGATIVO = 0;
            $total_servicios_PROBLEMAS = 0;
            $total_servicios_A_LIQUIDAR = 0;
            $total_servicios_CANCELADO = 0;
            $total_servicios_NEGATIVO_BO = 0;
            $total_servicios_PROBLEMAS_BO = 0;
            $total_servicios_LIQUIDAR_C_PARCIAL = 0;
            $total_servicios_NO_EFECTIVAS = 0;
            $total_servicios_cerrados = 0;
            $total_efectividad = 0;
            $total_puntajes_cerrados = 0;

            $total_servicios_enviadas = 0;
            $total_puntajes_enviadas = 0;

            $objetivo=0;
            $consulta = $handler->consultaPuntajes($fdesde, $fhasta, $fgestor);
            // var_dump($consulta);
            // exit();

            if(!empty($consulta))
            {
              foreach ($consulta as $key => $value) { 


                $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                $total_servicios_CERRADO = $total_servicios_CERRADO + $value->CERRADO;
                $total_servicios_ENV = $total_servicios_ENV + $value->ENV;
                $total_servicios_CERRADO_PARCIAL = $total_servicios_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                $total_servicios_RE_PACTADO = $total_servicios_RE_PACTADO + $value->RE_PACTADO;
                $total_servicios_RE_LLAMAR = $total_servicios_RE_LLAMAR + $value->RE_LLAMAR;
                $total_servicios_NEGATIVO = $total_servicios_NEGATIVO + $value->NEGATIVO;
                $total_servicios_PROBLEMAS = $total_servicios_PROBLEMAS + $value->PROBLEMAS;
                $total_servicios_A_LIQUIDAR = $total_servicios_A_LIQUIDAR + $value->A_LIQUIDAR;
                $total_servicios_NEGATIVO_BO = $total_servicios_NEGATIVO_BO + $value->NEGATIVO_BO;
                $total_servicios_PROBLEMAS_BO = $total_servicios_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                $total_servicios_LIQUIDAR_C_PARCIAL = $total_servicios_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                $total_servicios_NO_EFECTIVAS = $total_servicios_NO_EFECTIVAS + $value->NO_EFECTIVAS;
              }
            }

            // if($objetivo != 0){
            //       if ($total_puntajes_enviadas > $objetivo) {
            //         $clase_medidor = 'class="info-box bg-green"';
            //         $puntajePorciento = round(($total_puntajes_enviadas - $objetivo)*100/$objetivo,2);
            //         $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
            //       } else {
            //         $clase_medidor = 'class="info-box bg-yellow"';
            //         $puntajePorciento = round(($total_puntajes_enviadas) * 100 /$objetivo,2);
            //         $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
            //       }

            //     } else {
            //       $clase_medidor = 'class="info-box bg-yellow"';
            //       $puntajePorciento = 50;
            //       $txtPuntajePorciento = 50;
            //     }

            //     if(!empty($total_servicios)){
            //       $total_efectividad = round(($total_servicios_enviadas+$total_servicios_cerrados)*100/$total_servicios,2) ;
            //       if ($total_efectividad > 70) {
            //         $clase_efectividad = 'class="text-center text-green"';
            //       } else if($total_efectividad < 60){
            //         $clase_efectividad = 'class="text-center text-red"';
            //       } else {
            //         $clase_efectividad = 'class="text-center text-yellow"';
            //       }
            //      } else {
            //       $total_efectividad = 0;
            //       $clase_efectividad = 'class="text-center text-red"';
            //     }
            if(!empty($consulta)){
        ?>
        <div class="col-sm-6 col-md-4">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;"><?php echo $fnomgestor ?></h3>
              </div>    
              <div class="box-body table-responsive">
                <table class="table no-border" id="tabla" cellspacing="0" width="100%" style="text-align: center;" >
                  <thead>
                  	<tr class="bg-black">
                  		<th style="width: 50%;text-align: center;">ESTADO</th>
                  		<th style="width: 50%;text-align: center;">OPERACIONES</th>
                  	</tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>CERRADO</td><td style="text-align: center;"><a href='<?php echo $url_servicios."6" ?>'><?php echo $total_servicios_CERRADO ?></a></td>
                    </tr>
                    <tr>
                      <td>ENVIADO</td><td style="text-align: center;"><a href='<?php echo $url_servicios."9" ?>'><?php echo $total_servicios_ENV ?></a></td>
                    </tr>
                    <tr>
                      <td>A LIQUIDAR</td><td  style="text-align: center;"><a href='<?php echo $url_servicios."10" ?>'><?php echo $total_servicios_A_LIQUIDAR ?></a></td>
                    </tr>
                    <tr>
                      <td>CERRADO PARCIAL</td><td style="text-align: center;"><a href='<?php echo $url_servicios."3" ?>'><?php echo $total_servicios_CERRADO_PARCIAL ?></a></td>
                    </tr>
                    <tr>
                      <td>RE PACTADO</td><td style="text-align: center;"><a href='<?php echo $url_servicios."4" ?>'><?php echo $total_servicios_RE_PACTADO ?></a></td>
                    </tr>
                    <tr>
                      <td>RE LLAMAR</td><td style="text-align: center;"><a href='<?php echo $url_servicios."5" ?>'><?php echo $total_servicios_RE_LLAMAR ?></a></td>
                    </tr>
                    <tr>
                      <td>NEGATIVO</td><td style="text-align: center;"><a href='<?php echo $url_servicios."7" ?>'><?php echo $total_servicios_NEGATIVO ?></a></td>
                    </tr>
                    <tr>
                      <td>CERRADO EN PROBLEMAS</td><td style="text-align: center;"><a href='<?php echo $url_servicios."8" ?>'><?php echo $total_servicios_PROBLEMAS ?></a></td>
                    </tr>
                    <tr>
                      <td>NEGATIVO BO</td><td style="text-align: center;"><a href='<?php echo $url_servicios."11" ?>'><?php echo $total_servicios_NEGATIVO_BO ?></a></td>
                    </tr>
                    <tr>
                      <td>PROBLEMAS BO</td><td style="text-align: center;"><a href='<?php echo $url_servicios."13" ?>'><?php echo $total_servicios_PROBLEMAS_BO ?></a></td>
                    </tr>
                    <tr>
                      <td>LIQUIDAR CIERRE PARCIAL</td><td style="text-align: center;"><a href='<?php echo $url_servicios."14" ?>'><?php echo $total_servicios_LIQUIDAR_C_PARCIAL ?></a></td>
                    </tr>
                    <tr>
                      <td>NO EFECTIVAS</td><td style="text-align: center;"><a href='<?php echo $url_servicios."15" ?>'><?php echo $total_servicios_NO_EFECTIVAS ?></td>
                    </tr>
                    <tr>
                      <td>TOTAL</td><td style="text-align: center;"><?php echo $total_servicios ?></td>
                    </tr>
                  </tbody>
                  
                </table>

              </div>
            </div>
        </div>


          <?php 
          } ?>

           <div class="col-sm-6 col-md-8">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;">Por empresa</h3>
              </div>    
              <div class="box-body table-responsive">
                <table class="table table-striped table-condensed" id="tablaXEmpresa" style="text-align: center;">
                	<thead class="bg-black">
	                  	<th>EMPRESA</th>
	                	<th style="width:15%;text-align: center;">CERRADAS</th>
	                	<th style="width:15%;text-align: center;">ENVIADAS</th>
						<th style="width:15%;text-align: center;">PUNTAJE ENVIADAS</th>
					</thead>
                  <tbody>
                    <?php
                    if (!empty($arrEmpresas)) {
                      // var_dump($arrEmpresas);
                      // exit();
                    	$total_puntos=0;
                      foreach ($arrEmpresas as $emp) {
                        $total_puntajes_cerrados = 0;
                        $total_puntajes_enviadas = 0;
                        $cant_servicios_cerrados = 0;
            			$cant_servicios_enviados = 0;
                        // echo $emp->EMPTT11_CODIGO;
                        if(!empty($consulta)){
                          foreach ($consulta as $key => $value) {

                            if ($emp->EMPTT11_CODIGO == $value->COD_EMPRESA) {
                            	// echo $value->COD_EMPRESA;
                              $handlerP = new HandlerPuntaje;
                              $objetivo = $handlerP->buscarObjetivo($value->COD_GESTOR);                        
                              $fechaPuntajeActual = $handlerP->buscarFechaPuntaje();
                              $localidad = strtoupper($value->LOCALIDAD);
                              $localidad = str_replace('(', '', $localidad);
                              $localidad = str_replace(')', '', $localidad);
                              if ($value->FECHA->format('d-m-Y')>= $fechaPuntajeActual->format('d-m-Y')) {
                                $puntaje = $handlerP->buscarPuntaje($value->COD_EMPRESA);
                                if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
                                  $puntaje = 2;
                                }
                              } else {
                                $puntaje = $handlerP->buscarPuntajeFecha($value->COD_EMPRESA,$value->FECHA->format('Y-m-d'));
                                if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
                                  $puntaje = 2;
                                }
                              }
                              
                              if(empty($objetivo))                                                  
                                $objetivo = 0;

                              if (($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && $value->FECHA->format('d-m-Y') <= date('d-m-Y',strtotime('31-06-2018'))) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {

                                if(empty($puntaje))
                                  $puntaje_enviadas = 0;
                                else
                                  $puntaje_enviadas = round($value->TOTAL_SERVICIOS*$puntaje,2);

                                $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas;
                                $total_puntos = $total_puntos + $puntaje_enviadas;
                                $cant_servicios_enviados = $cant_servicios_enviados + $value->ENVIADO;
                                $cant_servicios_cerrados = $cant_servicios_cerrados + $value->CERRADO;
                                 
                              }else{
                                if(empty($puntaje))
                                  $puntaje_cerrados = 0;
                                else
                                  $puntaje_cerrados = round($value->CERRADO*$puntaje,2);

                                if(empty($puntaje))
                                  $puntaje_enviadas = 0;
                                else
                                  $puntaje_enviadas = round($value->ENVIADO*$puntaje,2);

                                $total_puntos = $total_puntos + $puntaje_enviadas;
                                $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas;
                                $cant_servicios_enviados = $cant_servicios_enviados + $value->ENVIADO;
                                $cant_servicios_cerrados = $cant_servicios_cerrados + $value->CERRADO;

                              }
                            }
                          }
                        }
                        if($cant_servicios_enviados > 0 || $cant_servicios_cerrados > 0){
                          echo "<tr>";
		                      echo "<td style='text-align: left;'>".trim($emp->EMPTT21_NOMBREFA)."</td>";
		                      echo "<td>".trim($cant_servicios_cerrados)."</td>";
		                      echo "<td>".trim($cant_servicios_enviados)."</td>";
		                      echo "<td>".trim($total_puntajes_enviadas)."</td>";
                          echo "</tr>";
                      	}
                      }
                      echo "<tr class='bg-green'>";
	                      echo "<td style='text-align: left;'><b>TOTAL</b></td>";
	                      echo "<td></td>";
	                      echo "<td></td>";
	                      echo "<td><b>".$total_puntos."</b></td>";
	                  echo "</tr>";
                    }
                    
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        <div class="col-xs-12">
          <a href="#" onClick="history.go(-1);return true;" class="btn btn-default"><i class="fa fa-chevron-left"></i> Volver</a>
        </div>
      </div>                
    </div>

  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_puntajes").addClass("active");
  });
</script>