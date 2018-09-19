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


    $dFechas = new Fechas;
    $handlerA=new HandlerAsistencias;
    $handlerUsuarios=new HandlerUsuarios;
    $user = $usuarioActivoSesion;
    $url_action_horario= PATH_VISTA.'Modulos/Asistencia/action_add_hours.php';
    if($esGestor){

    $fechahora=$dFechas->FechaHoraActual();
    $ultimoRegistro=$handlerA->selecTop($user->getId());
    // var_dump($ultimoRegistro,$dFechas->FechaActual());
    if (!empty($ultimoRegistro)) {
       $ultimaFecha=$ultimoRegistro->getFecha()->format('Y-m-d');
    } else {
      $ultimaFecha = $dFechas->RestarDiasFechaActual(1);
    }
  
   $horaAct= new DateTime(date('H:i'));
    // var_dump($horaAct);
    //  exit();
   
     
   
   
    
  ?>
  
    <style>
      .modal-backdrop {z-index: 5 !important;}
    </style>

    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <?php

        $asistencias=$handlerA->selectAsistenciasByFiltro($dFechas->FechaActual(),$user->getId()); //40016
           for ($i=0; $i <6 ; $i++) { 
                  
             if (!empty($asistencias[$i])) {
                $ingreso=$asistencias[$i]->getFecha()->format('H:i');                     
                $arrValor[]=$asistencias[$i]->getFecha()->format('H:i');
                 }
                       else{
                         $arrValor[]="00:0";
                       }

             } 

                            $data1=new DateTime($arrValor[0]);  
                            $data2=new DateTime($arrValor[1]);
                            if ($data1->format('H:i')=='00:00' && $data2->format('H:i')=='00:00'){
                                 $total1=$data2->diff($data1);
                              }
                            if ($data2->format('H:i')=='00:00' && $data1->format('H:i')!='00:00' ){
                                $total1=$horaAct->diff($data1);
                            } else{ 
                            $total1=$data2->diff($data1);
                            
                             }

                            $data3=new DateTime($arrValor[2]);  
                            $data4=new DateTime($arrValor[3]); 
                            if ($data3->format('H:i')=='00:00' && $data4->format('H:i')=='00:00'){
                                 $total2=$data4->diff($data3);
                              }
                            if ($data4->format('H:i')=='00:00' && $data3->format('H:i')!='00:00' ){
                                $total2=$horaAct->diff($data3);
                              } else{ 
                            $total2=$data4->diff($data3);                       
                             }
                            
                            $data5=new DateTime($arrValor[4]);  
                            $data6=new DateTime($arrValor[5]);
                           if ($data5->format('H:i')=='00:00' && $data6->format('H:i')=='00:00'){
                                 $total3=$data6->diff($data5);
                              }
                            if ($data6->format('H:i')=='00:00' && $data5->format('H:i')!='00:00' ){
                                $total3=$horaAct->diff($data5);
                              } else{   
                            $total3=$data6->diff($data5);
                            }

                            $spl2=$total2->format('%H:%i');
                            $horas2=split(":", $spl2);

                            $spl1=$total1->format('%H:%i');
                            $horas1=split(":", $spl1);

                            $spl3=$total3->format('%H:%i');
                            $horas3=split(":", $spl3);
                            
                            $total_horas=$horas1[0]+$horas2[0]+$horas3[0];
                            $minutos=($horas1[1]+$horas2[1]+$horas3[1])/60;
                            
                            $total=$total_horas+round($minutos,2); //round($minutos,2)
        

        ?>
        <i class="fa fa-truck"><?php echo " ".round($total,2)." Hs"; ?> </i>
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>

      </a>
      <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
           
          </div>
        </li>
      </ul>
    </li>

    <li class="dropdown notifications-menu">
      <?php if ($ultimaFecha == $dFechas->FechaActual()){
       if ($ultimoRegistro->getIngreso()=='1') { ?>
      <a href="#" id='<?php echo $user->getId() ?>'data-id='<?php echo $user->getId() ?>'data-accion='salida' data-toggle='modal' data-target='#modal-asistencia' onclick='cargarDatos(<?php echo $user->getId() ?>)'class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        
         <i class="fa fa-calendar-plus-o text-red"></i> 
       <?php }elseif ($ultimoRegistro->getIngreso()=='0') {?>
        <a href="#" id='<?php echo $user->getId() ?>'data-id='<?php echo $user->getId() ?>'data-accion='ingreso' data-toggle='modal' data-target='#modal-asistencia' onclick='cargarDatos(<?php echo $user->getId() ?>)'class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
         <i class="fa fa-calendar-plus-o text-green"></i>
         <?php } }else {?> 
          <a href="#" id='<?php echo $user->getId() ?>'data-id='<?php echo $user->getId() ?>'data-accion='ingreso' data-toggle='modal' data-target='#modal-asistencia' onclick='cargarDatos(<?php echo $user->getId() ?>)'class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
         <i class="fa fa-calendar-plus-o text-green"></i>
       <?php  }?>
          
          
        
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

   if ($esCoordinador) {

    $lista='';
    $activoCount=0;
    $sinSalida=0;
    $trabajando='asdas';
    $id='';
    $handlerplazas=new HandlerPlazaUsuarios();
    $plazasOtr=$handlerplazas->selectTodas();

    foreach ($plazasOtr as $key => $value) {   
    
      if ($user->getAliasUserSistema()==strtoupper($value->getNombre())) {

        $id=$value->getId();
      }
    
    }    

    $arrGestorr = $handlerUsuarios->selectGestoresByPlaza($id); 
      
                    foreach ($arrGestorr as $key => $value) {
                      $trabajando='Inactivo';
                      $clase="class='badge bg-red pull-right'";

                    $ultimoRegistro=$handlerA->selecTop($value->getId());
                  
                    if (!empty($ultimoRegistro)) {
                    
                    $ultimaFecha=$ultimoRegistro->getFecha()->format('Y-m-d');
                   
                   if ($ultimaFecha == $dFechas->FechaActual())
                    { 
                    
                      if ($ultimoRegistro->getIngreso()==1) {
                            $activoCount+=1;
                            $trabajando='Activo';
                            $clase="class='badge bg-green pull-right'";
                            
                        }
                    
                         elseif($ultimoRegistro->getIngreso()==0){
                          $trabajando='Break';
                          $clase="class='badge bg-yellow pull-right'";
                        } 

                     } 
                        $diadelasemana= date('N',strtotime($dFechas->FechaActual()));
                         if ($diadelasemana!=1) {
                           $diaAnterior=$dFechas->RestarDiasFechaActual(1);
                         }else{
                          $diaAnterior=$dFechas->RestarDiasFechaActual(2);
                         }
                       
                      $ultimoAyer=$handlerA->selecTopAyer($value->getId(),$diaAnterior);//'2018-09-11'
                      if (!empty($ultimoAyer)) {
                       
                      if ($ultimoAyer->getIngreso()==1) {
                        $sinSalida+=1;
                      }                     
                       
                 }

             $lista.="<li><a href='#' ><b>".$value->getNombre()." ".$value->getApellido()."</b><span ".$clase.">".$trabajando."</span></a> </li>";
                       
        
                
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

                   ?>
                <a href="index.php?view=asistencias&fdesde=<?php echo $diaAnterior; ?>" ><b>Sin Salida Dia Anterior</b><span class="badge bg-red pull-right">
                      <?php  echo $sinSalida; ?> </span></a>
              </li> 
            </ul>
          </div>
        </li>
      </ul>
    </li>

  <?php
     } }
  ?>
   <div class="modal fade in" id="modal-asistencia">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_horario ;?>" method="post" enctype="multipart/form-data">
       

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Asistencia</h4>
        </div>
        <div class="modal-body">
          <div class="row">
        
                <input type="hidden" name="hora" id="hora"required class="form-control" value="">
                <input type="hidden" name="user_id" id="user_id" class="form-control">    
                <input type="hidden" name="estado" id="estado" class="form-control">    
                       
              <div class="col-md-12">
                <label>Observacion</label> 
                <textarea class='form-control' id="observacion" name="observacion" rows="3" cols="50" ></textarea>
              </div>
        </div>
      </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Ok</button>
        </div>
      </form>

    </div>
  </div>
</div>

  

  <script type="text/javascript">

function cargarDatos(id){

    item_id = document.getElementById(id).getAttribute('data-id');
    estado= document.getElementById(id).getAttribute('data-accion');
   
    document.getElementById("user_id").value = item_id;
    document.getElementById("estado").value = estado;
 
    
  }
 </script>

