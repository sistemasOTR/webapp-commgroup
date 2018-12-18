<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
 
  $dFecha = new Fechas;
  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());
  $idUser = (isset($_GET["iduser"])?$_GET["iduser"]:'');
  $id = (isset($_GET["plaza"])?$_GET["plaza"]:0);
  $estados = (isset($_GET["estados"])?$_GET["estados"]:"");
  $url_action_agregar = PATH_VISTA.'Modulos/Asistencia/action_add_hours.php?fdesde='.$fdesde.'&fhasta='.$fhasta.'&iduser='.$idUser;
  $url_action_editable = PATH_VISTA.'Modulos/Asistencia/action_edit_hours.php?perfil=historial&fdesde='.$fdesde.'&fhasta='.$fhasta.'&iduser='.$idUser;
  $url_ajax =PATH_VISTA.'Modulos/Asistencia/select_usuario.php';
 
  $user = $usuarioActivoSesion;
  // var_dump($user->getNombre());
  // exit();
  
  $handlerUsuarios = new HandlerUsuarios;
  $handlerSistema = new HandlerSistema;
  $handlerAsistencia= new HandlerAsistencias;
  $handlerAsist=new HandlerAsistencias;
  $arrEstados = $handlerAsistencia->selectEstados();
  $handlerplazas=new HandlerPlazaUsuarios();
  $plazasOtr=$handlerplazas->selectTodas();
  $arrEstados = $handlerAsistencia->selectEstados();
   

  $arrEmpleados = $handlerUsuarios->selectEmpleados();

  $Idusuario=$handlerUsuarios->selectById($idUser);


                    // exit();

 

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<style>
      .modal-backdrop {z-index: 5 !important;}
    </style>
<div class="content-wrapper">  
  <section class="content-header "> 
    <h1 >
      Asistencias Historial
      <small>Diario, Semanal y Mensual </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tipos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class='container-fluid'>     
        <div class="row">


      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-body">
              <div class='row'>  
                <div class="col-md-2" id='sandbox-container'>
                    <label>Fecha Desde - Hasta </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="fin" name="fin" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                      <div class="col-md-2">
                  <label class="Empleados">EMPLEADOS</label>  
                  <select id="slt_empleados" class="form-control Empleados" style="width: 100%" name="slt_empleados" onchange="crearHref()">     
                  <?php 
                 
                  foreach ($arrEmpleados as $key => $value) {
                   if ($value->getUserPlaza()==$id || $id==0) {
                   
                  if ($value->getId()==$idUser) {
                       echo "<option value='".$value->getId()."' selected >".$value->getNombre()." ".$value->getApellido()."</option>";
                     } else{ 
                    echo "<option value='".$value->getId()."'>".$value->getNombre()." ".$value->getApellido()."</option>";
                  } }elseif($id==9999){
                    if ($value->getId()==$idUser){
                    echo "<option value='".$value->getId()."' selected >".$value->getNombre()." ".$value->getApellido()."</option>";
                    }
                  } } ?> 
                  
                  </select>
                </div>
              <div class="col-md-2">
                 <label>ESTADOS</label> 
                <select id="slt_estados" class="form-control" style="width: 100%" name="slt_estados" >                
                <option value="66666">Todos</option>
                <?php foreach ($arrEstados as $key => $valEst) {
                  if($valEst->getId()==$estados){?> 
                <option value="<?php echo $valEst->getId();?>" selected><?php echo $valEst->getNombre(); ?></option>
                <?php }else{ ?>
                   <option value="<?php echo $valEst->getId();?>" ><?php echo $valEst->getNombre(); ?></option>
                <?php } }?>              
                </select>
                </div> 
                  <div class='col-md-2 '>                
                  <label></label>                
                  <a class="btn btn-block btn-success " id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
                 
            </div>
          </div>
        </div>
      </div>

           <?php

                       



                        $contador=1;
                        $flag=false;
                        $countID=1;

                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
                        while (strtotime($FECHA) <= strtotime($HASTA)) {
                        $asistencias=$handlerAsist->selectAsistenciasByFiltro($FECHA,$FECHA,$idUser);
                        $dia=$FECHA;
                        // var_dump($asistencias);
                        // exit();
                         if (!empty($asistencias)) {
                     
                         
                        if ($contador==1) {
                           echo "<div class='row'>";
                           $flag=false;
                         } 

                         if (!empty($asistencias)) {

                         $indice=count($asistencias)-1;

                      $idEstadoUltimo=$handlerAsist->selectEstadosById($asistencias[$indice]->getIngreso());
                      $ultimaFecha=$asistencias[$indice]->getFecha()->format('Y-m-d');
                     
                     if ($ultimaFecha == $FECHA)
                      { 
                      
                        if ($idEstadoUltimo[0]->getProductivo()!=0) {
                              $sinSalida="<span class='label label-danger pull-left'><b>Sin Salida</b></span><br>";
                              $idEstado=$handlerAsist->selectEstadosById($asistencias[$indice]->getIngreso());
                              
                          }else{
                            $sinSalida='';
                          }
                      
                       }
                      }else{
                        $sinSalida='';
                      } 




?>             

      
    
  
      <div class="col-md-3">
          <div class="box">

            <div class="box-body table-responsive">
             
              <table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
      
                 <thead>
                    <tr>                                       
                      <th><?php echo $sinSalida; ?>
                        <b><?php echo $FECHA ;?></b> <a href="index.php?view=estadisticas_asistencia_gestor&id_gestor=<?php echo $idUser; ?>"  class="fa fa-bar-chart "></a>
                        
                        <?php
    
                         if($user->getId()==10045 ||$user->getId()==3 ||$user->getId()==1){ ?>
                        <i class="pull-right"><a href="#" id='<?php echo $countID ?>'data-ide='<?php echo $idUser ?>' data-fecha='<?php echo $FECHA; ?>'data-usuario='<?php echo $Idusuario->getUsuarioPerfil()->getId() ?>' data-hora='<?php echo date('H:i'); ?>' class="btn btn-default btn-xs" data-toggle='modal' data-target='#modal-presentismo' onclick='cargarDatos(<?php echo $countID?>)'>Nuevo Horario</a></i>
                      <?php }  ?>
                      </th>
                     </tr>
                  </thead>
                     <tbody>
                  <?php 
                  

                              
                        foreach ($arrEstados as $key => $vv) {

                           if (($vv->getUsuarioPerfil()==0) || ($vv->getUsuarioPerfil()==$Idusuario->getUsuarioPerfil()->getId())) {
                                $act[$vv->getId()]=0;  
                                }  
                             }

                             $cant = count($asistencias);

                             for ($i=1; $i < $cant; $i++) { 
                               $id_actAnt = $asistencias[($i-1)]->getIngreso();
                               $id_actual=$asistencias[$i]->getIngreso();

                             
                               $inicioAct = new DateTime($asistencias[($i-1)]->getFecha()->format('H:i'));
                               $finAct = new DateTime($asistencias[$i]->getFecha()->format('H:i'));
                                         
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
                              
                              
                          
                                $lista1='';
                                $listaProd1=0;
                                $listaImprod1=0;

                                foreach ($arrEstados as $key => $vv) {

                                 if (($vv->getUsuarioPerfil()==0) || ($vv->getUsuarioPerfil()==$Idusuario->getUsuarioPerfil()->getId())) {
                                  if (!empty($act[$vv->getId()]) && ($estados==66666 || $estados==$vv->getId())) {
                                    $parts = explode('.', (float) $act[$vv->getId()]); 
                                    $parts1=$parts[0];
                                    if (isset($parts[1])) {
                                       $parts2=("0.".$parts[1])*60;
                                    }else{
                                      $parts2=0;
                                    }
                                   
                              
                                    $totalparcial=$parts1.":".round($parts2);
                                                                   
                                    $lista1.= "<tr><td><b>".$vv->getNombre()." : ".$totalparcial." Hs</b></td></tr>";
                                      
                                         }
                                    if ($vv->getProductivo()==1) {
                                       if (!empty($act[$vv->getId()])) {
                                                                   
                                    $listaProd1+= $act[$vv->getId()];
                                      
                                        } 
                                      } 
                                     if ($vv->getProductivo()==0) {
                                      if (!empty($act[$vv->getId()])) {
                                                                   
                                    $listaImprod1+= $act[$vv->getId()];
                                      
                                           }

                                         }    

                                       }
                                   }

                         foreach ($asistencias as $key => $val) {
                         $estadoId=$val->getIngreso();
                         if (!empty($estadoId)) {        
                        $select=$handlerAsistencia->selectEstadosById($estadoId);
                        if (!empty($select) && $estados==66666) {
                          $ingreso=$val->getFecha()->format('H:i');
                          $est=$val->getIngreso();

                        ?> 
                         <tr><td>
                               <?php if($user->getId()==10045 ||$user->getId()==3 ||$user->getId()==1){ ?>
                          <a href='#'  id='<?php echo $val->getId();?>' data-ingreso='<?php echo $est;?>' data-edithora='<?php echo $ingreso; ?>' data-editfecha='<?php echo $val->getFecha()->format('Y-m-d'); ?>' data-idi='<?php echo $val->getId();?>' data-user='<?php echo $Idusuario->getUsuarioPerfil()->getId(); ?>' data-toggle='modal' data-target='#modal-editar' class='fa fa-refresh text-yellow btn-modal' onclick='cargarDatos(<?php echo $val->getId();?>)'></a>
                        <?php } ?>
                          <?php echo " ".$val->getFecha()->format('H:i')."<span class='".$select[0]->getColor()." pull-right'><b>".$select[0]->getNombre()."</b></span>"  ?></td></tr> 
                        
                      <?php }
                      if (!empty($select) && $estados==$estadoId) {
                          $ingreso=$val->getFecha()->format('H:i');
                          
                          $est=$val->getIngreso();
                          if (isset($asistencias[($key+1)])) {
                            $ingreso2=$asistencias[($key+1)]->getFecha()->format('H:i');
                          }else{
                            $ingreso2="...";
                          }

                        ?> 
                         <tr><td>
                          <?php echo " ".$val->getFecha()->format('H:i')." a ".$ingreso2."<span class='".$select[0]->getColor()." pull-right'><b>".$select[0]->getNombre()."</b></span>"  ?></td></tr> 
                        
                      <?php }
                     

                       } }  
                    
                      echo $lista1;
                       if (empty($lista1)) { 
                        echo "<tr><td> No Hay Resultados</td></tr>"; 
                          
                           }
                      if (!empty($listaProd1) && $estados==66666) {
                       $partlist = explode('.', (float) $listaProd1); 
                                    $Prod1=$partlist[0];
                                    if (isset($partlist[1])) {
                                       $Prod2=("0.".$partlist[1])*60;
                                    }else{
                                      $Prod2=0;
                                    }
                            
                                    $totalProd=$Prod1.":".round($Prod2); 

                      echo "<tr><td class='bg-green'> HRS PRODUCTIVAS : ".$totalProd." Hs</td></tr>";
                      }
                      if (!empty($listaImprod1) && $estados==66666) {
                        $Implist = explode('.', (float) $listaImprod1); 
                                    $ImprodProd1=$Implist[0];
                                    if (isset($Implist[1])) {
                                       $ImprodProd2=("0.".$Implist[1])*60;
                                    }else{
                                      $ImprodProd2=0;
                                    }
                            
                                    $totalImprod=$ImprodProd1.":".round($ImprodProd2); 
                      echo "<tr><td class='bg-red'> HRS IMPRODUCTIVAS : ".$totalImprod." Hs</td></tr>";
                      }
                     
                     
                       ?>


                  </tbody>

                  
              </table>
            </div>
            </div>
          </div>
              <?php 
                  $contador+=1;
                if ($contador==5) {
                  echo "</div>";
                  $contador=1;
                  $flag=true;
                 } 


                    }

                     $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA))); 
                     $countID+=1;  
                     
                      
                    }


               if (!$flag) {
               echo "</div>";
                 } 
                ?>

          <div class="modal modal-primary fade in" id="modal-presentismo">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_agregar ;?>" method="post" enctype="multipart/form-data">
       

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Asistencia</h4>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-3">
                <label>Horario</label> 
                <input type="time" name="hora" id="hora" required class="form-control" value="">
                <input type="hidden" name="cord_id" id="cord_id" class="form-control">       
                <input type="hidden" name="fecha" id="fecha" class="form-control" value="">    
                <input type="hidden" name="modo" id="modo" value="historial">
                <input type="hidden" name="usuario" class="form-control" id="usuario" value="">
                </div>
                <div class="col-md-6">
                <label>Estados</label>   
                <select id="estados" class="form-control" required="" name="estados">
                <option value="">Elegir Estado</option>                       
                </select>  
                </div>                      
                <div class="col-md-8">
                <label>Observaciones</label> 
                <textarea id="observacion"  rows="3" cols="50" style="width: 430px; color: black;" name="observacion"></textarea>
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

<div class="modal modal-primary fade in" id="modal-editar">
     <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_editable ;?>" method="post" enctype="multipart/form-data">
       

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Editar Asistencia</h4>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-3">
                <label>Horario</label> 
                <input type="time" name="hora_edit" id="hora_edit" required class="form-control" value="">
                <input type="hidden" name="edit_id" id="edit_id" class="form-control">     
                <input type="hidden" name="fecha_edit" id="fecha_edit" class="form-control">
                <input type="hidden" name="user" class="form-control" id="user" value=""> 
                </div>
                <div class="col-md-6">
                <label>Estados</label>   
                <select id="ingresos" class="form-control" name="ingresos">
                </select>  
                </div>                
              <div class="col-md-8">
                <label>Observaciones</label> 
                <textarea id="observacion" rows="3" cols="50" class="form-control" required name="observacion"></textarea>
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

      

 </div>
    </div>  

  </section>

</div>

<script type="text/javascript">

function cargarDatos(id){

    usuario = document.getElementById(id).getAttribute('data-usuario');
    cord_id = document.getElementById(id).getAttribute('data-ide');
    fecha= document.getElementById(id).getAttribute('data-fecha');
   datahora= document.getElementById(id).getAttribute('data-hora');
    document.getElementById("cord_id").value = cord_id;
    document.getElementById("fecha").value = fecha;
    document.getElementById("hora").value = datahora;
    document.getElementById("usuario").value = usuario;   
    
  } 

     $(document).ready(function(){
     $(".btn-modal").on("click",function(){ 
  
     var user= $(this).attr('data-user');
     var  edit_id= $(this).attr('data-idi');
     var fecha_edit= $(this).attr('data-editfecha');
     var ingreso= $(this).attr('data-ingreso');
     var hora_edit= $(this).attr('data-edithora');
      
      $("#user").val(user);
      $("#hora_edit").val(hora_edit);
      $("#fecha_edit").val(fecha_edit);
      $("#edit_id").val(edit_id);

      var id_tipo= $("#user").val(),
      seleccionado= ingreso;
      $.post("<?php echo $url_ajax; ?>",{ id_tipo: id_tipo,seleccionado:seleccionado }, function(data){
         $("#ingresos").html(data);

        });
     });
   });

$(document).ready(function() {
    $("#slt_empleados").select2();
  });
$(document).ready(function() {
    $("#slt_estados").select2();
  });


  $('#sandbox-container .input-daterange').datepicker({
      format: "dd/mm/yyyy",
      clearBtn: false,
      language: "es",
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true,
      todayHighlight: true,                                                                        
      multidate: false,
      todayBtn: "linked",  
  });
  
crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aFin = $("#fin").val().split('/');
      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];                        
      f_fin = aFin[2] +"-"+ aFin[1] +"-"+ aFin[0];   
      f_empleados= $("#slt_empleados").val();
      f_estado=$("#slt_estados").val();
      <?php if ($id==9999) {?>  
      url_filtro_reporte="index.php?view=asistencias_historial&plaza=9999&fdesde="+f_inicio+"&fhasta="+f_fin+"&iduser="+f_empleados+"&estados="+f_estado;
      <?php }else {?>                   
      url_filtro_reporte="index.php?view=asistencias_historial&plaza=<?php echo $id; ?>&fdesde="+f_inicio+"&fhasta="+f_fin+"&iduser="+f_empleados+"&estados="+f_estado;  
      <?php } ?>
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

 $(document).ready(function(){                
    $("#modal-presentismo").on('shown.bs.modal',function(){
      console.log("asdad");
    var id_tipo= $("#usuario").val();
    console.log(id_tipo);
    $.post("<?php echo $url_ajax; ?>",{ id_tipo: id_tipo }, function(data){
              $("#estados").html(data);
            });

    });
  });



</script>