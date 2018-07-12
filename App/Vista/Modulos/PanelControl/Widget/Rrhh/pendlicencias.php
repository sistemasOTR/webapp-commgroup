<?php
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";    
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         

  $dFecha = new Fechas;

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fechaInicial= date('Y-m-01',strtotime($dFecha->FechaActual()));
  $fechaFin= $dFecha->SumarDiasFechaActual(365);

  $handler = new HandlerLicencias;  
  $arrLicencias = $handler->seleccionarByFiltros($fechaInicial,$fechaFin,$fusuario,null);

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectByPerfil("GESTOR");

  $url_action_aprobar = PATH_VISTA.'Modulos/Licencias/action_aprobar.php?id=';  
  $url_action_desaprobar = PATH_VISTA.'Modulos/Licencias/action_desaprobar.php?id=';  
  $url_action_imprimir = 'index.php?view=licencias_imprimir&id=';
?>
  <div class="col-md-12 nopadding">
	<div class="box box-solid">
	  <div class="box-header with-border">
	  	<a href=" <?php echo 'index.php?view=licencias_control&fdesde='.$fechaInicial.'&fhasta='.$fechaFin.'&festados=1'; ?>" class="fa fa-search pull-right" id="btn-nuevo"></a>
	    <i class=" fa fa-clone"></i>
	    <h3 class="box-title">Tabla licencias 
	    	<span class='text-red'><b>Pendientes</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body table-responsive" style='text-align: center;'>
	  	<table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
        <thead>
                    <tr>                     
                      <!-- <th style='text-align: center;'> FECHA</th> -->
                      <th style='text-align: center;'>USUARIO</th>
                      <th style='text-align: center;'>TIPO LICENCIA</th>
                      <th style='text-align: center;'>DESDE</th>
                      <th style='text-align: center;'>HASTA</th>
                      <th style='text-align: center;'>OBSERVACIONES</th>
                      <th style='text-align: center;'>ESTADO</th>
                   
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if(!empty($arrLicencias))
                      {
                        foreach ($arrLicencias as $key => $value) {

                          if (!$value->getRechazado()) {
     
                          if(!$value->getAprobado()){

                            $estado="<span class='label label-primary'>PENDIENTE</span>";

                        echo "<tr>";
                            // echo "<td>".$value->getFecha()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                            echo "<td>".$value->getTipoLicenciasId()->getNombre()."</td>";
                            echo "<td>".$value->getFechaInicio()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getFechaFin()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getObservaciones()."</td>";
                            echo "<td>".$estado."</td>";
                            echo "</tr>";
                        
                            }
                          }
                        }          
                      }            
                    ?>
                  </tbody>
                  
              </table>	  
	  </div>
	</div>
</div>