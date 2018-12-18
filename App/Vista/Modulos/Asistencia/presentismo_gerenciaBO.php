<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
 
  $dFecha = new Fechas;
  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $plazas = (isset($_GET["fplaza"])?$_GET["fplaza"]:0);
  $salida = (isset($_GET["salida"])?$_GET["salida"]:'');

  $url_action_agregar = PATH_VISTA.'Modulos/Asistencia/action_add_hours.php?perfil=gerenciaBO&fdesde='.$fdesde.'&fplaza='.$plazas;
  $url_action_editar = PATH_VISTA.'Modulos/Asistencia/action_edit_hours.php?perfil=gerenciaBO&fdesde='.$fdesde.'&fplaza='.$plazas;
  $url_ajax =PATH_VISTA.'Modulos/Asistencia/select_usuario.php';
 
  $url_historial='';
 
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
  $handlerLic= new HandlerLicencias;

  

  $arrEmpleados = $handlerUsuarios->selectEmpleados();
// var_dump($arrCoordinador);
// exit();
 

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<style>
      .modal-backdrop {z-index: 5 !important;}
    </style>
<div class="content-wrapper">  
  <section class="content-header "> 
    <h1 >
      Asistencias
      <small>Agregar, modificar Horarios y Presentismo </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tipos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <div class='col-md-12'>
        <div class="box box-solid">

           <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Filtros Disponibles</h3>
              <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <div class="box-body">
              <div class='row'>  
                <div class="col-md-2" id='sandbox-container'>
                    <label>Buscar Fecha </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                <div class="col-md-2">
                  <label>PLAZAS</label>  
                  <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" onchange="crearHref()">
                  <option value="0">TODAS</option>
                  <?php 
                  foreach ($plazasOtr as $key => $value) {
                  if ($value->getId()==$plazas) {
                       echo "<option value='".$value->getId()."' selected >".$value->getNombre()."</option>";
                     } else{ 
                    echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                  } }?> 
                  
                  </select>
                </div> 
                  <div class='col-md-3 pull-right'>                
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
          // var_dump($arrCoordinador);  

          if (!empty($arrEmpleados)) {

                           
            foreach ($arrEmpleados as $key => $value) { 
            // var_dump($value->getUsuarioPerfil()->getId());
            // exit(); 

            if ($value->getUserPlaza()==$plazas || $plazas==0 ) {
                                     
              
            if ($contador==1) {
               echo "<div class='row'>";
               $flag=false;
             } 
            
             $asistencias=$handlerAsist->selectAsistenciasByFiltro($fdesde,$fdesde,$value->getId());
              $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($fdesde,$fdesde,intval($value->getId()),2);
             

                // $ultimoRegistro=$handlerAsist->selecTop($value->getId());

                      if (!empty($asistencias)) {

                         $indice=count($asistencias)-1;

                      $idEstadoUltimo=$handlerAsist->selectEstadosById($asistencias[$indice]->getIngreso());
                      $ultimaFecha=$asistencias[$indice]->getFecha()->format('Y-m-d');
                     
                     if ($ultimaFecha == $fdesde)
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


               // var_dump($asistencias);
               // exit();
               ?>  
              <div class='col-md-3'>
               <div class="box">
                <div class="box-body table-responsive ">
                 
                  <table class="table table-striped table-condensed " id="tabla-items" cellspacing="0" width="100%">

                     <thead>
                        <tr>                                       
                          <th><?php echo $sinSalida; ?>
                            <b><?php echo $value->getApellido()." ".$value->getNombre() ;?></b> <a href="index.php?view=estadisticas_asistencia_gestor&id_gestor=<?php echo $value->getId(); ?>" class="fa fa-bar-chart "></a>
                            <a href="index.php?view=asistencias_historial&userPerfil=gerenciaBO&iduser=<?php echo $value->getId(); ?>&plaza=<?php echo $value->getUserPlaza(); ?>&estados=66666" style="" class="btn btn-primary pull-right btn-xs">Ver Historial</a>
                            <?php if($user->getId()==10045 ||$user->getId()==3 ||$user->getId()==1){  
                              $seguir=true;
                             $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($dFechas->FechaActual(),$dFechas->FechaActual(),intval($value->getId()),2);
                    
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
                             
                              ?>
                            <i class="pull-right"><a href="#" id='<?php echo $value->getId() ?>'data-ide='<?php echo $value->getId() ?>' data-fecha='<?php echo $fdesde;?>' data-usuario='<?php echo $value->getUsuarioPerfil()->getId(); ?>' data-hora='<?php echo date('H:i'); ?>' class="btn btn-default btn-xs" data-toggle='modal' data-target='#modal-presentismo' onclick='cargarDatos(<?php echo $value->getId() ?>)'>Nuevo Horario</a></i>
                          <?php } } ?> 
                          </th>
                         </tr>
                      </thead>

                      <tbody>
                        <?php  
                               if (!empty($asistencias)) {
                        foreach ($arrEstados as $key => $v) {

                           if ($v->getUsuarioPerfil()==0 || $v->getUsuarioPerfil()==$value->getUsuarioPerfil()->getId()) {
                                $act[$v->getId()]=0;  
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
                               
                               // $ArrVar[]=array('actividad'=>$id_actAnt,'cantidad'=>$act[intval($id_actAnt)]); 
                           
                             }
                               // var_dump($ArrVar);
                              
                          
                                $lista2='';
                                $listaProd=0;
                                $listaImprod=0;

                                foreach ($arrEstados as $key => $v) {

                                 if ($v->getUsuarioPerfil()==0 || $v->getUsuarioPerfil()==$value->getUsuarioPerfil()->getId()) {
                                       if (!empty($act[$v->getId()])) {
                                        $comp = explode('.', (float) $act[$v->getId()]); 
                                            $comp1=$comp[0];
                                            if (isset($comp[1])) {
                                               $comp2=("0.".$comp[1])*60;
                                            }else{
                                              $comp2=0;
                                            }
                                           
                                      
                                            $totalcomp=$comp1.":".round($comp2);
                                                                   
                                           $lista2.= "<tr><td>".$v->getNombre()." : ".$totalcomp." Hs</td></tr>";
                                      
                                         }
                                            if ($v->getProductivo()==1) { 
                                               $listaProd+=$act[$v->getId()];
                                             } 
                                             if ($v->getProductivo()==0) {                                 
                                                $listaImprod+= $act[$v->getId()];  
                                             }    

                                       }
                                   }


                         foreach ($asistencias as $key => $valu) {
                         $estadoId=$valu->getIngreso();
                         if (!empty($estadoId)) {        
                        $select=$handlerAsistencia->selectEstadosById($estadoId);
                        if (!empty($select)) {

                          $ingreso=$valu->getFecha()->format('H:i');
                          $est=$valu->getIngreso();

                        ?> 

                        <tr><td>
                           <?php if($user->getId()==10045 ||$user->getId()==3 ||$user->getId()==1){ ?>
                          <a href='#'  id='<?php echo $valu->getId();?>' data-ingreso='<?php echo $est;?>' data-edithora='<?php echo $ingreso; ?>' data-editfecha='<?php echo $fdesde; ?>' data-idi='<?php echo $valu->getId();?>' data-user='<?php echo $value->getUsuarioPerfil()->getId(); ?>' data-toggle='modal' data-target='#modal-editar' class='fa fa-refresh text-yellow btn-modal' onclick='cargarDatos(<?php echo $valu->getId();?>)'></a>
                        <?php } ?>
                          <?php echo " ".$valu->getFecha()->format('H:i')."<span class='".$select[0]->getColor()." pull-right '><b>".$select[0]->getNombre()."</b></span>"  ?></td></tr>                    
                      <?php } } } 

 
                      echo $lista2;
                      if (!empty($listaProd)) {
                       $compListaProd = explode('.', (float) $listaProd); 
                       $compP1=$compListaProd[0];
                        if (isset($compListaProd[1])) {
                         $compP2=("0.".$compListaProd[1])*60;
                          }else{
                           $compP2=0;
                             }             
                          $totalcompP=$compP1.":".round($compP2); 
                      echo "<tr><td class='bg-green'> HRS PRODUCTIVAS : ".$totalcompP." Hs</td></tr>";
                      }
                      if (!empty($listaImprod)) {
                        $compListaImprod = explode('.', (float) $listaImprod); 
                         $compI1=$compListaImprod[0];
                          if (isset($compListaImprod[1])) {
                          $compI2=("0.".$compListaImprod[1])*60;
                           }else{
                           $compI2=0;
                            }
                             $totalcompI=$compI1.":".round($compI2);
                      echo "<tr><td class='bg-red'> HRS IMPRODUCTIVAS : ".$totalcompI." Hs</td></tr>";
                      }

                       
                      }else{
                        $deLic='';
                                if(!empty($arrLicencias)) {

                                foreach ($arrLicencias as $key => $value) {
                          
                                if (!$value->getRechazado()) {
       
                                 if($value->getAprobado()) {

                                  if ($fdesde <= $value->getFechaFin()->format('Y-m-d') ) { 
                                   
                                    $deLic= "<span class='label label-warning pull-left'> LICENCIA EN CURSO</span>";
                                   
                                   }
                                    else{ 
                                       $deLic="";
                                      }

                                     
                                    }
                                  }
                                }
                              }

                       echo"<tr><td >".$deLic."</td></tr>";
                        }// cierre asistencias.
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
               }
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
                <input type="hidden" name="modo" id="modo" value="gerenciaBO">
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

      <form action="<?php echo $url_action_editar ;?>" method="post" enctype="multipart/form-data">
       

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
  <!-- </div> -->
<!-- </div> -->
  </section>

</div>


<script type="text/javascript">

  $(function () {
  $('#search-items').quicksearch('#tabla-items tbody tr');               
});
  $(document).ready(function(){                
    $("#mnu_expediciones_item_abm").addClass("active");
  });  

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

$(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "TODAS",                  
    });
  });

  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_plaza = $("#slt_plaza").val();                        
      url_filtro_reporte="index.php?view=asistencias_gerenciaBO&fdesde="+f_inicio+"&fplaza="+f_plaza;  
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
