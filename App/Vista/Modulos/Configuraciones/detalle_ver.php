<?php
		
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php";  	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
  include_once PATH_DATOS.'Entidades/empresapuntaje.class.php'; 
  include_once PATH_DATOS.'Entidades/gestorobjetivo.class.php';
  include_once PATH_DATOS.'Entidades/coordinadorobjetivo.class.php';
  include_once PATH_DATOS.'Entidades/supervisorobjetivo.class.php';

  $id= (isset($_GET["id"])?$_GET["id"]:'');
  $admin=(isset($_GET["admin"])?$_GET["admin"]:'');

  // var_dump($ide, $admin);
  // exit();
	
 $f= new Fechas;
 $fecha=$f->FechaActual();

  switch ($admin) {
    case 'empresa':
       $handlerempresa= new EmpresaPuntaje;
       $Empresa=$handlerempresa->selectById($id);
      break;
    case 'gestor':
      $handlergestor= new GestorObjetivo;
      $Gestor=$handlergestor->selectById($id);
      break;
    case 'coordinador':
      $handlercoordinador= new CoordinadorObjetivo;
       $Coordinador=$handlercoordinador->selectById($id);
      break; 
    case 'supervisor':
       $handlersupervisor= new SupervisorObjetivo;
       $Supervisor=$handlersupervisor->selectById($id);
     break; 
  }

?>
	<div class="content-wrapper">  
  <section class="content-header">
    <div class="col-md-8 col-md-offset-2 text-left" >
    
    </div>
        
  </section>  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

	<div class="row">
	  <div class='col-md-7 col-md-offset-2'>
        <div class="box box-solid">

            <!-- <div class="box-header with-border pull-right">
              <i class="fa fa-plane"></i>
              <h3 class="box-title">Tabla Remitos</h3>
            </div>	 -->

    	<div class="box-body  table-responsive">
              <table class="table table-striped table-condensed"  id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="">NOMBRE</th>
                      <th width="">PUNTAJE</th>
                      <th width="">FECHA DESDE</th>     
                      <th width="">FECHA HASTA</th>                 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                  // var_dump($arrCliente);
                    if ($admin=='empresa') {

                  if(!empty($Empresa))
                  {
                    foreach ($Empresa as $key => $value) { 
                       $handler = new HandlerSistema;
                        $arrCliente = $handler->selectEmpresaById($id);
                        if (is_null($value->getFechaHasta())) {
                         $fechaHasta="<span class='label label-success'>ACTUALIDAD</span>";

                        }else{
                          $fechaHasta=$value->getFechaHasta()->Format('d/m/Y');
                        }

                      echo "
                      <tr>
                         <td>".$arrCliente[0]->EMPTT21_NOMBREFA."</td>
                         <td>".$value->getPuntaje()."</td>
                         <td>".$value->getFechaDesde()->Format('d/m/Y')."</td>
                         <td>".$fechaHasta."</td>
                      </tr>";
                    }
                   }
                 }

                 if ($admin=='gestor') {

                  if(!empty($Gestor))
                  {
                    foreach ($Gestor as $key => $value) { 

                       $handler = new HandlerSistema;
                        $arrCliente = $handler->selectGestorById($id);
                        if (is_null($value->getFechaHasta())) {
                         $fechaHasta="<span class='label label-success'>ACTUALIDAD</span>";

                        }else{
                          $fechaHasta=$value->getFechaHasta()->Format('d/m/Y');
                        }

                      echo "
                      <tr>
                         <td>".$arrCliente[0]->GESTOR21_ALIAS."</td>
                         <td>".$value->getObjetivo()."</td>
                         <td>".$value->getFechaDesde()->Format('d/m/Y')."</td>
                         <td>".$fechaHasta."</td>
                      </tr>";
                    }
                   }
                 }
                
                if ($admin=='coordinador') {

                  if(!empty($Coordinador))
                  {
                    foreach ($Coordinador as $key => $value) { 

                        if (is_null($value->getFechaHasta())) {
                         $fechaHasta="<span class='label label-success'>ACTUALIDAD</span>";

                        }else{
                          $fechaHasta=$value->getFechaHasta()->Format('d/m/Y');
                        }

                      echo "
                      <tr>
                         <td>".$value->getIdCoordinadorSistema()."</td>
                         <td>".$value->getObjetivo()."</td>
                         <td>".$value->getFechaDesde()->Format('d/m/Y')."</td>
                         <td>".$fechaHasta."</td>
                      </tr>";
                    }
                   }
                 }



                if ($admin=='supervisor') {

                  if(!empty($Supervisor))
                  {
                    foreach ($Supervisor as $key => $value) { 
                       $handler = new HandlerSupervisor;
                        $arrSupervisor = $handler->selectSupervisorById($id);
                        if (is_null($value->getFechaHasta())) {
                         $fechaHasta="<span class='label label-success'>ACTUALIDAD</span>";

                        }else{
                          $fechaHasta=$value->getFechaHasta()->Format('d/m/Y');
                        }

                      echo "
                      <tr>
                         <td>".$arrSupervisor['nombre']."</td>
                         <td>".$value->getObjetivo()."</td>
                         <td>".$value->getFechaDesde()->Format('d/m/Y')."</td>
                         <td>".$fechaHasta."</td>
                      </tr>";
                    }
                   }
                 }

                 

                ?>

                     
                  </tbody>
                </table>
                
              </div>
            </div>
             <div>
             
              <a href="javascript:history.back(-1);" class="btn btn-primary" title="Ir la página anterior">Regresar</a>
  
             </div>
          </div>

        </div>
           
       </section> 
     </div>