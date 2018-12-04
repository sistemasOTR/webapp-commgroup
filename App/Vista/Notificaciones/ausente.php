<?php 
    include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
    include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
    include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";

    $handlerSist = new HandlerSistema;
    $handlerLic = new HandlerLicencias;
    $handlerUs = new HandlerUsuarios;
    $handlerAsist = new HandlerAsistencias;
    $user = $usuarioActivoSesion;
    $arrUsuarios = $handlerUs->selectTodos();
    $userPlaza = $usuarioActivoSesion->getAliasUserSistema();
    $arrEstados = $handlerAsist->selectEstados();
    $handlerplazas=new HandlerPlazaUsuarios();
    $plazasOtr=$handlerplazas->selectTodas();
    $handlerLic= new HandlerLicencias;
  
    $arrLicenciasAll=$handlerLic->selecionarTipos();
    $arrEmpleados = $handlerUsuarios->selectEmpleados();

    $dFechas = new Fechas;
    $fdesde=$dFechas->FechaActual();
    $fhasta= $dFechas->FechaActual();
    $ini=date('Y-m-01',strtotime($dFechas->FechaActual()));

    $horactual=date('H:i');


      $a=0;
        $listaa='';
      foreach ($arrEmpleados as $key => $value) { 
                       
      if ($horactual>='10:00') {
                        
        $fechaDesde = date('Y-m-d',strtotime($fdesde));
        $fechaHasta = date('Y-m-d',strtotime($fhasta));
        $FECHA = $dFechas->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
        $HASTA = $dFechas->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d"); 
        while (strtotime($FECHA) <= strtotime($HASTA)) {
        
         $asistencias=$handlerAsist->selectAsistenciasByFiltro($FECHA,$FECHA,$value->getId());
         $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,intval($value->getId()),2);
         $diadelasemana= date('N',strtotime($FECHA));
         $fechadata=$FECHA." 00:00:00.000";
         $feriado=$handlertickets->selecionarFechasInhabilitadasByFecha($fechadata);  

           if (!$feriado && $diadelasemana!=7 && empty($asistencias) && empty($arrLicencias)) {
                   $listaa.="<a href='".$value->getId()."' disabled>". $value->getApellido()." ".$value->getNombre()."</a>";
                    $a+=1;
              }

                $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
          }
         }else{
           $a="...";
           }
       }    

    
  ?>

   <?php if(($user->getId()==20168 || $user->getId()==10104)){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-user-md"></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>

          <span id="contador_noti_empresa" class="label label-danger" style="font-size:12px;">
            <?php echo $a; ?>
          </span>  
      </a>
      <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
             <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php if ($a != 0): ?>
               
                  <li>
                    <?php 
                  
                     echo "<a href='index.php?view=tabla_asistencias&ausente=ausentes&notificacion=si'><b>Sin Logear</b><span class='badge bg-red pull-right'>".$a."</span></a>" ; 
             
                 echo "</li>"; 
                
                
               endif ?>
              
            </ul> 
          </div>
        </li>
      </ul>
    </li> 
  <?php } ?>