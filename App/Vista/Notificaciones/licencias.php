 <?php 
    include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
    include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";

    $handlerSist = new HandlerSistema;
    $handlerLic = new HandlerLicencias;
    $handlerUs = new HandlerUsuarios;
    
    $arrUsuarios = $handlerUs->selectTodos();
    $userPlaza = $usuarioActivoSesion->getAliasUserSistema();

    $dFechas = new Fechas;
    $fdesde=$dFechas->RestarDiasFechaActual(60);
    // $fhasta= $dFechas->RestarDiasFechaActual(13);
    $fhasta= $dFechas->SumarDiasFechaActual(180);
    $ini=date('Y-m-01',strtotime($dFechas->FechaActual()));

   
    $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($fdesde,$fhasta,null,2);
    $url_redireccion ='index.php?view=licencias_control&fdesde='.$fdesde.'&fhasta='.$fhasta.'&festados=2&fusuario=';
    $url_redireccionCord ='index.php?view=licencias_controlcoord&fdesde='.$fdesde.'&fhasta='.$fhasta.'&festados=2&fusuario=';
    $url_pendientes ='index.php?view=licencias_control&fdesde='.$fdesde.'&fhasta='.$fhasta.'&festados=1&fusuario=';
    $url_pendientesCoord ='index.php?view=licencias_controlcoord&fdesde='.$fdesde.'&fhasta='.$fhasta.'&festados=1&fusuario=';

    if ($esCoordinador) {
  
      $arrUsuarios = '';
      $arrGestoresSist = $handlerSist->selectAllGestor($usuarioActivoSesion->getAliasUserSistema());
      $arrGestoresPort = $handlerUs->selectGestores(null);
      if (!empty($arrGestoresPort) && !empty($arrGestoresSist)) {
      	foreach ($arrGestoresPort as $gestPort) {
	        foreach ($arrGestoresSist as $gestSist) {
	          if ($gestPort->getUserSistema() == $gestSist->GESTOR11_CODIGO){
	            $arrUsuarios[] = $gestPort;
	          }
	        }
	      }
      }
      
    }

    $datos='';

    if (!empty($arrUsuarios)) {
    	foreach ($arrUsuarios as $key => $value) {
	    	$arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($fdesde,$fhasta,$value->getId(),2);
	        if(!empty($arrLicencias)){
	          foreach ($arrLicencias as $licencia) {
	            if ($licencia->getAprobado() && $licencia->getFechaFin()->format('Y-m-d') >= $dFechas->FechaActual() ) {
	              $datos[]= array('userId' => $licencia->getUsuarioId()->getId(),
	                              'Nombre' => $licencia->getUsuarioId()->getNombre()." ".$licencia->getUsuarioId()->getApellido(),
	                              'Desde' => $licencia->getFechaInicio()->format('d-m-Y'),
	                              'Hasta' => $licencia->getFechaFin()->format('d-m-Y'));
	            }
	            
	          }
	        }
	    }
    }
    


   $arrLicenciasPend = $handlerLic->seleccionarByFiltros($fdesde,$fhasta,null,1);


if ($esCoordinador) {

  $licPendientes='';
if (!empty($arrLicenciasPend) && !empty($arrGestoresSist)) {

  foreach ($arrLicenciasPend as $key => $value) {
     foreach ($arrGestoresSist as $gestor) {

      if($value->getUsuarioId()->getUserSistema()==$gestor->GESTOR11_CODIGO){

          $licPendientes+=1;
           }
         } 
        }
      }
   }
      else{
             $fechaDesde = date('Y-m-d',strtotime($fdesde));
             $fechaHasta = date('Y-m-d',strtotime($fhasta));
             $FECHA = $dFechas->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
             $HASTA = $dFechas->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");  
             $suma=0;                
             $arrayId[]=0;
               while (strtotime($FECHA) <= strtotime($HASTA)) {
                   $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,null,1);             
                     if(!empty($arrLicencias))
                     {   
                       foreach ($arrLicencias as $key => $value) {
                         foreach ($arrayId as $idrepeat) {

                            if (intval($value->getId()) == $idrepeat) {
                              $seguir = false;
                              break;
                            } else {
                              $seguir = true;
                            }
                          }
                          if($seguir){
                             $arrayId[]=intval($value->getId());
                             $suma+=1;
                           }
                          
                        }
                      } 

                   $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));

               }
             $licPendientes=$suma;
  
      }

      $numLic = count($datos);
    
  ?>

  <?php if(($esBO || $esRRHH || $esCoordinador)  && ($datos != '' || $licPendientes>0)){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-certificate"></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>

        <?php if(($numLic)>0 && $datos != ''){ ?>
          <span id="contador_noti_empresa" class="label label-danger" style="font-size:12px;">
            <?php echo ($numLic+$licPendientes); ?>
          </span>
        <?php } elseif ($licPendientes>0) { ?>
          <span id="contador_noti_empresa" class="label label-danger" style="font-size:12px;">
            <?php echo ($licPendientes); ?>
          </span>
        <?php } ?>
      </a>
      <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php if ($datos != ''): ?>
                <?php foreach ($datos as $key => $value): ?>
                  <li>
                    <?php if ($esCoordinador) { ?>
                    <a href='<?php echo $url_redireccionCord.$value["userId"] ?>' disabled><?php echo $value['Nombre']." | ".$value['Desde']." | ".$value['Hasta'] ?></a>
                  <?php } elseif ($esRRHH || $esBO){ ?>

                    <a href='<?php echo $url_redireccion.$value["userId"] ?>' disabled><?php echo $value['Nombre']." | ".$value['Desde']." | ".$value['Hasta'] ?></a>

                  <?php } ?>
                    
                  </li>
                <?php endforeach ?>
                
              <?php endif ?>
              
            </ul>
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php if (($licPendientes)>0): ?>
              <li>
                <?php if ($esCoordinador) { ?>
                  <a href="<?php echo $url_pendientesCoord; ?>" ><b>Pendientes</b><span class="badge bg-red pull-right">
                      <?php  echo $licPendientes; } else{ ?>
                 
                <a href="<?php echo $url_pendientes; ?>" ><b>Pendientes</b><span class="badge bg-red pull-right">
                      <?php  echo $licPendientes; }?>
                    </span></a>
              </li>
               <?php endif ?>
            </ul>  
          </div>
        </li>
      </ul>
    </li>
  <?php } ?>
