<?php 
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";

    $handlertickets = new HandlerTickets;
    $dFechas = new Fechas;
    $handlerA=new HandlerAsistencias;
    $arrEstados = $handlerA->selectEstados();
    $handlerPerfil = new HandlerPerfiles;
    $handlerLic= new HandlerLicencias;
    $arrEstados = $handlerA->selectEstados();

    $handlerUsuarios=new HandlerUsuarios;
    $user = $usuarioActivoSesion;
    $url_action_horario= PATH_VISTA.'Modulos/Asistencia/action_add_hours.php';
    $url_ajax =PATH_VISTA.'Modulos/Asistencia/action_add_hours.php';
    

    $fechahora=$dFechas->FechaHoraActual();
    $ultimoRegistro=$handlerA->selecTop($user->getId());
    if (!empty($ultimoRegistro)) {
       $ultimaFecha=$ultimoRegistro->getFecha()->format('Y-m-d');
    } else {
      $ultimaFecha = $dFechas->RestarDiasFechaActual(1);
    }
  
   $horaAct= new DateTime(date('H:i'));


    
  ?>
  
    <style>
      .modal-backdrop {z-index: 5 !important;}
    </style>
    <?php if($esGestor){ ?>

    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <?php 
                       $asistencias=$handlerA->selectAsistenciasByFiltro($dFechas->FechaActual(),$dFechas->FechaActual(),$user->getId());

                        $listaProd1=0;
                               if (!empty($asistencias)) {

                        foreach ($arrEstados as $key => $vv) {

                           if (($vv->getUsuarioPerfil()==0) || ($vv->getUsuarioPerfil()==$user->getUsuarioPerfil()->getId())) {
                                $act[$vv->getId()]=0;  
                                }  
                             }

                             $cant = count($asistencias);
                             

                             for ($i=1; $i <= $cant; $i++) { 


                               $id_actAnt = $asistencias[($i-1)]->getIngreso();
                               $inicioAct = new DateTime($asistencias[($i-1)]->getFecha()->format('H:i'));
                               if (isset($asistencias[$i])) {
                                 $id_actual=$asistencias[$i]->getIngreso();
                                 $finAct = new DateTime($asistencias[$i]->getFecha()->format('H:i'));
                               }else{
                                 $finAct = $horaAct;
                               }
                               // var_dump($finAct);
                                         
                               #-------------------------------------------------------------------
                               $difParcial=$finAct->diff($inicioAct); 
                               $formato=$difParcial->format('%H:%i');
                               $horass=split(":",$formato);
                              
                               $total_horas=$horass[0];
                               $minutos=$horass[1]/60;
                            
                               $total=$total_horas+round($minutos,2);              
                               #-------------------------------------------------------------------
                               $act[intval($id_actAnt)] = $act[intval($id_actAnt)]+$total;

                          
                           
                             }
                             
                               $listaProd1=0;

                              foreach ($arrEstados as $key => $vv) {

                                 if (($vv->getUsuarioPerfil()==0) || ($vv->getUsuarioPerfil()==$user->getUsuarioPerfil()->getId())) {
                                  
                                    if ($vv->getProductivo()==1) {
                                     if (!empty($act[$vv->getId()])) {
                                                                   
                                    $listaProd1+= $act[$vv->getId()];
                                      
                                            } 
                                          }  

                                       }
                                   }
                                } 

        ?>
        <i class="fa fa-truck"> <?php echo $listaProd1." Hs"; ?> </i>
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>

      </a>
      <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
           
          </div>
        </li>
      </ul>
    </li>
      <?php } 

      if (!$esCliente) {
        $seguir=true;
        $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($dFechas->FechaActual(),$dFechas->FechaActual(),intval($user->getId()),2);
                    
                                if(!empty($arrLicencias)) {

                                foreach ($arrLicencias as $key => $vl) {
                          
                                if (!$vl->getRechazado()) {
       
                                 if($vl->getAprobado()) {

                                  if ($dFechas->FechaActual() <= $vl->getFechaFin()->format('Y-m-d') ) { 
                                   
                                   $seguir=false;
                                   
                                   }
                                   
                                     
                                    }
                                  }
                                }
                              }
              if ($seguir) {
                              
                                              
      
            $diadelasemana= date('N',strtotime($dFechas->FechaActual())); 
            $fechadata=$dFechas->FechaActual()." 00:00:00.000";
            $feriado=$handlertickets->selecionarFechasInhabilitadasByFecha($fechadata);   
             if (is_null($feriado) && ($diadelasemana!=7)){

       ?>

    <li class="dropdown notifications-menu">
      <a href="#"class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <?php 
         if ($ultimaFecha == $dFechas->FechaActual()){
          $ultimor=$ultimoRegistro->getIngreso();
          $text=$handlerA->selectEstadosById($ultimor);
          $color=$text[0]->getColor();
          $result=split('[-]', $color);
          switch ($result[1]) {
            case 'success':
              $color='text-green';
              break;
            case 'primary':
              $color='text-blue';
              break;
            case 'warning':
              $color='text-yellow';
              break;   
           case 'danger':
              $color='text-red';
              break;
           case 'default':
              $color='text-grey';
              break; 
           case 'info':
              $color='text-teal';
              break;     
            
          }
        
         }else{
          $color='text-red';
          }
          ?> 
        
      <i class="fa fa-calendar-plus-o <?php echo $color ?>"></i>
       </a> 
       <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">

               <?php 
                if (!empty($arrEstados)){
               foreach ($arrEstados as $key => $value) {

                 if ($value->getUsuarioPerfil()==$user->getUsuarioPerfil()->getId() || $value->getUsuarioPerfil()==0) {
                      $class='';
                    if ($ultimaFecha == $dFechas->FechaActual()){
                       if ($ultimoRegistro->getIngreso()==$value->getId()) { 
                       $class='fa fa-check pull-right';
                       }else{
                        $class='';
                       } 
                     }

                     echo "<li ><a href='#'data-toggle='modal' id='".$value->getId()."' data-nombre='".$value->getNombre()."' data-id='".$value->getId()."' data-target='#modal-estadoasistencia' onclick='AgregarInfo(".$value->getId().");' ><span class='".$value->getColor()."'><b>".$value->getNombre()."</b></span><i class='".$class."'></a></i></li>";
                  } 
                    } }else{
                      if($user->getUsuarioPerfil()->getId()!=5){
                      echo "<li><a href='index.php?view=asistencias_estados'>Cargar ABM Estados <b>(Haz Click Aquí)</b></a></li></li>";
                     }
                     elseif($user->getUsuarioPerfil()->getId()==5){
                      echo "<li><a href='#'><b>Esperando que carguen Estados ...</b></a></li></li>";
                     }
                   }
                  ?>
                </li> 
             </ul>
          </div>
        </li>
      </ul>
    </li>
   <?php 
    } } }

   if ($esCoordinador || $esGerencia) {

    $lista='';
    $activoCount=0;
    $sinSalida=0;
    $trabajando='asdas';
    $id='';
    $handlerplazas=new HandlerPlazaUsuarios();
    $plazasOtr=$handlerplazas->selectTodas();

if ($esCoordinador) {
  

    foreach ($plazasOtr as $key => $val) { 

    
      if ($user->getAliasUserSistema()==strtoupper($val->getNombre())) {

        $id=$val->getId();
      }
    
    }    

    $arrGestorr = $handlerUsuarios->selectGestores(intval($id)); 

  }else{

    $arrGestorr=$handlerUsuarios->selectEmpleados();
  }
      
                    foreach ($arrGestorr as $key => $value) {
                      $trabajando='Inactivo';
                      $clase="class='badge bg-red pull-right'";
                   $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($dFechas->FechaActual(),$dFechas->FechaActual(),intval($value->getId()),2);
                    
                                if(!empty($arrLicencias)) {

                                foreach ($arrLicencias as $key => $valu) {
                          
                                if (!$valu->getRechazado()) {
       
                                 if($valu->getAprobado()) {

                                  if ($dFechas->FechaActual() <= $valu->getFechaFin()->format('Y-m-d') ) { 
                                   
                                    $trabajando="LICENCIA EN CURSO";
                                    $clase="class='badge bg-yellow pull-right'";
                                   
                                   }
                                   
                                     
                                    }
                                  }
                                }
                              }


                    $ultimoRegistro=$handlerA->selecTop($value->getId());
                  
                    if (!empty($ultimoRegistro)) {

                    $idEstadoUltimo=$handlerA->selectEstadosById($ultimoRegistro->getIngreso());
                    $ultimaFecha=$ultimoRegistro->getFecha()->format('Y-m-d');
                   
                   if ($ultimaFecha == $dFechas->FechaActual())
                    { 
                    
                      if ($idEstadoUltimo[0]->getProductivo()!=0) {
                            $activoCount+=1;
                          }

                            $idEstado=$handlerA->selectEstadosById($ultimoRegistro->getIngreso());
                            $trabajando=$idEstado[0]->getNombre();
                            $clase="class='".$idEstado[0]->getColor()." pull-right'"; 
                     } 
                        $diadelasemana= date('N',strtotime($dFechas->FechaActual()));
                         if ($diadelasemana!=1) {
                           $diaAnterior=$dFechas->RestarDiasFechaActual(1);
                         }else{
                          $diaAnterior=$dFechas->RestarDiasFechaActual(2);
                         }
                       
                      $ultimoAyer=$handlerA->selecTopAyer($value->getId(),$diaAnterior);//'2018-09-11'
                      // var_dump($ultimoAyer);
                      if (!empty($ultimoAyer)) {
                        
                       $idEstadoSalida=$handlerA->selectEstadosById($ultimoAyer->getIngreso());

                       
                      if ($idEstadoSalida[0]->getProductivo()==1) { 
                         $sinSalida+=1;
                      }                     
                       
                 }
                  }
              if ($esGerencia) {
              $lista.="<li><a href='index.php?view=asistencias_gerenciaBO' ><b>".$value->getApellido()." ".$value->getNombre()."</b><span ".$clase.">".$trabajando."</span></a> </li>";
              }else{
             $lista.="<li><a href='index.php?view=asistencias' ><b>".$value->getApellido()." ".$value->getNombre()."</b><span ".$clase.">".$trabajando."</span></a> </li>";
              }
                } 
                ?>
    
     <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-user"></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>
        
          <span id="contador_noti_empresa" class="label label-success" style="font-size:12px;">
                <?php echo $activoCount ;?>
          </span>
          </a>
          <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
               <?php echo $lista ; ?>
          
            </ul>
          </div>
        </li>
      </ul>
    </li>
     <?php if ($sinSalida>0){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-user-times "></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>
        
          <span id="contador_noti_empresa" class="label label-danger" style="font-size:12px;">
                <?php echo $sinSalida; ?> 
          </span>
          </a>
          <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
                  
                <li>
                  <?php  
                          $diadelasemana= date('N',strtotime($dFechas->FechaActual()));
                         if ($diadelasemana!=1) {
                           $diaAnterior=$dFechas->RestarDiasFechaActual(1);
                         }else{
                          $diaAnterior=$dFechas->RestarDiasFechaActual(2);
                         }

                  if ($esGerencia) { ?>
                <a href="index.php?view=asistencias_gerenciaBO&salida=no&fdesde=<?php echo $diaAnterior; ?>" ><b>Sin Salida Dia Anterior</b><span class="badge bg-red pull-right">
                     <?php  echo $sinSalida."</span></a>"; 
                    }else{  ?> 
                <a href="index.php?view=asistencias&salida=no&fdesde=<?php echo $diaAnterior; ?>" ><b>Sin Salida Dia Anterior</b><span class="badge bg-red pull-right">
                  <?php echo $sinSalida."</span></a>"; 

                     }
                   ?>


              </li> 
            </ul>
          </div>
        </li>
      </ul>
    </li>

  <?php
     } }
  ?>
   <div class="modal fade in" id="modal-estadoasistencia">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="" method="post">
       

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>        
          <h3 id="nombre"></h3>    
        </div>
        <div class="modal-body">
          <div class="row">
  
                <input type="hidden" name="user_id" id="user_id" class="form-control"value="<?php echo $user->getId(); ?>">    
                <input type="hidden" name="ingreso" id="ingreso" class="form-control" value="">    
                       
              <div class="col-md-12">
                <label>Observacion</label> 
                <textarea class='form-control' id="observacion" name="observacion" rows="3" cols="50" ></textarea>
              </div>
        </div>
      </div>
        <div class="modal-footer">
          <button type="submit" id="ok"class="btn btn-primary">Ok</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript">
  
function AgregarInfo(id){

 ide= document.getElementById(id).getAttribute('id');
 nombre= document.getElementById(id).getAttribute('data-nombre');

 document.getElementById("ingreso").value = ide;
 document.getElementById("nombre").innerHTML = nombre;

 }

 $(document).ready(function(){                
    $("#ok").on('click',function(){
    var user_id= $("#user_id").val(),
    ingreso=$("#ingreso").val(),
    observacion=$("#observacion").val(),
    self=this;

   
    $.ajax({
       type:"POST",
       url:'<?php echo $url_ajax; ?>',
       data:{
        user_id: user_id ,
        ingreso:ingreso , 
        observacion:observacion
        }, 
        beforeSend:function(){
           $(self).html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
            },
        success:function(data){    
          window.location.reload();
        }

    });
  });
 });


</script>