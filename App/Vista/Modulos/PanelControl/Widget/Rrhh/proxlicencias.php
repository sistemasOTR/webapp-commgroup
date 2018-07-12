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
  $fin=$dFecha->SumarDiasFechaActual(20);


  $handler = new HandlerLicencias;  
  $arrLicencias = $handler->seleccionarByFiltros($fdesde,$fin,null,null);
  // var_dump($arrLicencias);
  // exit();
                          

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectByPerfil("GESTOR");

  $url_action_aprobar = PATH_VISTA.'Modulos/Licencias/action_aprobar.php?id=';  
  $url_action_desaprobar = PATH_VISTA.'Modulos/Licencias/action_desaprobar.php?id=';  
  $url_action_imprimir = 'index.php?view=licencias_imprimir&id=';
?>
  <div class="col-md-12 nopadding">
	<div class="box box-solid">
	  <div class="box-header with-border">
	  	<a href="<?php echo 'index.php?view=licencias_control&fdesde='.$dFecha->FechaActual().'&fhasta='.$dFecha->SumarDiasFechaActual(20).'&festados=2'; ?>" class="fa fa-search pull-right" id="btn-nuevo"></a>
	    <i class=" fa fa-clock-o"></i>
	    <h3 class="box-title">Tabla licencias 
	    	<span class='text-yellow'><b>Proximas</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body table-responsive"  style='text-align: center;'>
	  	<table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
        <thead>
                    <tr>                     
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
                           // var_dump($value);
                           // exit();
               


                          $fechahoy=$dFecha->FechaActual();


                          
                           if ($fechahoy>$value->getFechaInicio()->format('Y-m-d') && $fechahoy < $value->getFechaFin()->format('Y-m-d') ) {

                            $situacion="<span class='label label-success'>EN CURSO</span>";
                            }
                            else{
                                  $situacion="<span class='label label-warning'>PROXIMA</span>";

                            } 
                           if (!$value->getRechazado()) {
 
                           if($value->getAprobado()) {

                            if ($fechahoy < $value->getFechaFin()->format('Y-m-d') ) {
     
                          echo "<tr>";
                            echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                            echo "<td>".$value->getTipoLicenciasId()->getNombre()."</td>";
                            echo "<td>".$value->getFechaInicio()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getFechaFin()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getObservaciones()."</td>";
                            echo "<td>".$situacion."</td>";

                                  
                          echo "</tr>"; 
                          }
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