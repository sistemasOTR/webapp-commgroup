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
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";

  $user = $usuarioActivoSesion;
  $dFecha = new Fechas;
  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());
  $estados = (isset($_GET["estados"])?$_GET["estados"]:"");
  $modo = (isset($_GET["modo"])?$_GET["modo"]:'');//
  $id = $user->getUserPlaza();
  $empleados = unserialize(isset($_GET["empleados"])?$_GET["empleados"]:'');
  $url_ajax =PATH_VISTA.'Modulos/Asistencia/select_usuario.php';
  $url_action_select_empleados=PATH_VISTA.'Modulos/Asistencia/action_select_empleados.php';
 
  
  $handlertickets = new HandlerTickets;
  $handlerUsuarios = new HandlerUsuarios;
  $handlerSistema = new HandlerSistema;
  $handlerAsistencia= new HandlerAsistencias;
  $handlerAsist=new HandlerAsistencias;
  $arrEstados = $handlerAsistencia->selectEstados();
  $handlerplazas=new HandlerPlazaUsuarios();
  $plazasOtr=$handlerplazas->selectTodas();
  $handlerLic= new HandlerLicencias;


   

  $arrEmpleados = $handlerUsuarios->selectEmpleados();
  

 

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<style>
      .modal-backdrop {z-index: 5 !important;}
    </style>
<div class="content-wrapper">  
  <section class="content-header "> 
    <h1 >
      Comparativas
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
                      <input type="text" class="input-sm form-control"  id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control"  id="fin" name="fin" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                <div class="col-md-2">
                 <label>ESTADOS</label> 
                <select id="slt_estados" class="form-control" style="width: 100%" name="slt_estados" >                
                <option value="99999">Todos</option>
                <?php foreach ($arrEstados as $key => $valEst) {
                  if($valEst->getId()==$estados){?> 
                <option value="<?php echo $valEst->getId();?>" selected><?php echo $valEst->getNombre(); ?></option>
                <?php }else{ ?>
                   <option value="<?php echo $valEst->getId();?>" ><?php echo $valEst->getNombre(); ?></option>
                <?php } }?>              
                </select>
                </div>
                   <div class="col-md-1">
                  <label>EMPLEADOS</label> 
                <a data-toggle='modal' data-target='#modal-nuevo' class="btn btn-block btn-primary"><i class="fa fa-hand-pointer-o"></i></a>
                </div> 
            
                 
            </div>
          </div>
        </div>
      </div>

          <?php 

          $contador=1;
          $flag=false;
          $asd=0;
      
         
          if (!empty($empleados)) {
        
         
            
       foreach ($empleados as $key => $value) {

      
               $arrEmp = $handlerUsuarios->selectById($value);           
     
                    
             $lista2='';
             $listaProd=0;
             $listaImprod=0;
           

             $asistencias1=$handlerAsist->selectAsistenciasByFiltro($fdesde,$fhasta,$arrEmp->getId());
             $arrLicencias2 = $handlerLic->seleccionarByFiltrosRRHH($fdesde,$fhasta,intval($arrEmp->getId()),2);
             
          
             if (count($asistencias1)>1 || !empty($arrLicencias2)) {//
              

               $deLic=0;                
             
               
                        
                        $cantDias=0; 
                        $diasProd=0;  
                        $diasImProd=0; 
                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");

                          foreach ($arrEstados as $key => $v) {

                             // if ($v->getUsuarioPerfil()==0 || $v->getUsuarioPerfil()==$arrEmp->getUsuarioPerfil()->getId()) {
                                  $act[$v->getId()]=0;
                                  $prom[$v->getId()]='';  
                                  $pp[$v->getId()]=''; 
                               // }  
                          }
                        while (strtotime($FECHA) <= strtotime($HASTA)) {
                        $asistencias=$handlerAsist->selectAsistenciasByFiltro($FECHA,$FECHA,$arrEmp->getId());
                        $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,intval($arrEmp->getId()),2);
                        $dia=$FECHA;
                        

                      if (!empty($asistencias)) {

                            $Ppd='';  
                            $Ipd='';  
               

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

                               #--------------------------

                                if ($asistencias[($i-1)]->getFecha()->format('Y-m-d')!= $pp[intval($id_actAnt)]) {
                         
                                      $pp[intval($id_actAnt)]=$asistencias[($i-1)]->getFecha()->format('Y-m-d');
                                      $prom[intval($id_actAnt)]+=1;

                                     $estAsis=$handlerAsist->selectEstadosById($asistencias[($i-1)]->getIngreso());

                                     if ($estAsis[0]->getProductivo()==1 && $asistencias[($i-1)]->getFecha()->format('Y-m-d')!=$Ppd){
                                         $diasProd+=1;
                                         $Ppd=$asistencias[($i-1)]->getFecha()->format('Y-m-d'); 
                                       }
                                     elseif ($estAsis[0]->getProductivo()==0 && $asistencias[($i-1)]->getFecha()->format('Y-m-d')!=$Ipd) {
                                         $diasImProd+=1;
                                         $Ipd=$asistencias[($i-1)]->getFecha()->format('Y-m-d'); 
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
                        </td></tr>                    
                      <?php } } }  

 
                   
                      }// cierre asistencias.


                       $diadelasemana= date('N',strtotime($FECHA));
                       $fechadata=$FECHA." 00:00:00.000";
                       $feriado=$handlertickets->selecionarFechasInhabilitadasByFecha($fechadata);   
                       if (is_null($feriado) && ($diadelasemana!=7)){
                        $cantDias+=1;

                       }
                            
                          
                             
                          if(!empty($arrLicencias)) {

                                foreach ($arrLicencias as $key => $valuue) {
                          
                                if (!$valuue->getRechazado()) {
       
                                      if($valuue->getAprobado()) {

                                           if ($FECHA <= $valuue->getFechaFin()->format('Y-m-d') ) { 
                                   
                                            $deLic+=1;
                                            // "<span class='label label-warning pull-left'> LICENCIA EN CURSO</span>";
                                   
                                            }
                                       }
                                    }
                                }
                              

                        }

                         
                   
                    
                       $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA))); 
                     }
                           
                         // var_dump($prom);
                              
                                foreach ($arrEstados as $key => $v) {

                                 // if ($v->getUsuarioPerfil()==0 || $v->getUsuarioPerfil()==$arrEmp->getUsuarioPerfil()->getId()) {

                                    if (!empty($prom[$v->getId()])) {

                                          $canti=$act[$v->getId()]/$prom[$v->getId()];
                                          // $canti=1;
                                          
                                         }

                                       if (!empty($act[$v->getId()])) {
                                         if ($v->getId()==$estados || $estados==99999) {
                                           
                                        
                                                                     
                                           $lista2.= "<tr><td>".$v->getNombre()." : ".$act[$v->getId()]." Hs<span class='label label-default pull-right'>PROM ".number_format($canti,2)."</span></td></tr>";
                                             }
                                         }


                                              if ($v->getProductivo()==1) { 
                                               $listaProd+=$act[$v->getId()];
                                             } 
                                             if ($v->getProductivo()==0) {                                 
                                                $listaImprod+= $act[$v->getId()];  
                                             }  

                                  }
                                // }
                             
                             if ($lista2) { ?>
                               
                    
                         
                        <div class='col-md-3'>
                         <div class="box">
                          <div class="box-body table-responsive ">
                           
                            <table class="table table-striped table-condensed " id="tabla-items" cellspacing="0" width="100%">

                               <thead>
                                  <tr>                                       
                                    <th>
                                      <b><?php echo $arrEmp->getApellido()." ".$arrEmp->getNombre() ;?></b> 
                              
                                    </th>
                                   </tr>
                                </thead>

                                <tbody>

                          <?php

                          if ($contador==1) {
                              echo "<div class='row'>";
                              $flag=false;
                           } 


                          
                        
                          if ($lista2){
                          echo $lista2;
                         }  
                         if (!empty($deLic)) {
                           if ($deLic==1) {
                          echo "<tr><td class='bg-yellow'> LICENCIA : ".$deLic." Dia <a class='fa fa-search pull-right' href='#'></a></td></tr>";
                             }else{
                              echo "<tr><td class='bg-yellow'> LICENCIAS : ".$deLic." Dias <a class='fa fa-search pull-right' href='index.php?view=licencias_controlcoord&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$arrEmp->getId()."&festados=2'></a></td></tr>";
                             }  
                           }
                     if ($estados==99999) {   

                           if (!empty($listaProd)) {
                        echo "<tr><td class='bg-green'> HRS PRODUCTIVAS : ".$listaProd." Hs<span class='label label-default pull-right'>PROM ".number_format(($listaProd/$diasProd),2)."</span></td></tr>";
                        }
                        if (!empty($listaImprod)) {
                        echo "<tr><td class='bg-red'> HRS IMPRODUCTIVAS : ".$listaImprod." Hs<span class='label label-default pull-right'>PROM:".number_format(($listaImprod/$diasImProd),2)."</span></td></tr>";
                        }

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
            } 
               // }
             // } 
          } 
            } 
               if (!$flag) {
               echo "</div>";
                 } 

             ?>      


    </div>
 <div class="modal modal-primary fade" id="modal-nuevo">
     <div class="modal-dialog" style="width: 60vw;">
    <div class="modal-content">

      <form action="<?php echo $url_action_select_empleados ;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 id="pla" class="modal-title">PLAZAS</h4>
        </div>      
             
        <div class="modal-body">
            <div class="row">
            <input type="hidden" id="ini" value="" name="fechad"> 
            <input type="hidden" id="finn" value="" name="fechah"> 
            <input type="hidden" id="s_estados" value="" name="s_estados"> 
           <div class="col-xs-12">

             <?php if (empty($empleados)) { ?>
             <ul>
             <li> <input type="checkbox" name="all" checked="" id="all" ><label> TODOS</label><br> 
             <ul>   
            <?php foreach ($arrEmpleados as $key => $vaal) { ?>
             <li class="col-md-4"><input type="checkbox" name="empleados[]" checked="" id="<?php echo $asd+=1 ?>" class="empleados" value="<?php echo $vaal->getId()?>"> <?php echo $vaal->getApellido()." ".$vaal->getNombre(); ?> </li> 
            <?php } ?>
            </ul>
          </li>
          </ul>
          <?php } else{ ?>
            <ul>
             <li> <input type="checkbox" name="all" id="all" ><label> TODOS</label><br> 
             <ul>   
            <?php foreach ($arrEmpleados as $key => $vaal) { 
                foreach ($empleados as $key => $vlv) { 
                   if($vaal->getId()==$vlv){
                     $chek="checked";
                     break;
                      }else{
                      $chek="";
                     }  
                    }  ?>                      
             <li class="col-md-4"><input type="checkbox" name="empleados[]"  <?php echo $chek ?> id="<?php echo $asd+=1 ?>" class="empleados" value="<?php echo $vaal->getId()?>"> <?php echo $vaal->getApellido()." ".$vaal->getNombre(); ?> </li> 
            <?php  } ?>
            </ul>
          </li>
          </ul>


          <?php } ?>
           </div>      
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit"id='enviar' class="btn btn-primary">OK</button>
        </div>
      </form>

    </div>
  </div>
</div>
  </section>

</div>
<style type="text/css">
  
  ul li {list-style:none;}
</style>


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
        $('.empleados').click(function(event) { 
       var cantidad = $(".empleados").length;
       console.log(cantidad); 
       for (var i = 1; i <= cantidad; i++) {
        // var c='#'+i;
         if ( $('#'+i).prop('checked')) {
           $('#enviar').show();
           console.log('t');
           break;
         }else{
          $('#enviar').hide();
          console.log($('#'+i).val());
         }
       }      
      
     });







       $('#all').click(function(event) {   
        if(this.checked) {
          $('#enviar').show();
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $('#enviar').hide();
            $(':checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });

       $("#enviar").on("click",function(){ 
      aStart = $("#start").val().split('/');
      aEnd = $("#fin").val().split('/');
      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];     
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];
      f_estado=$("#slt_estados").val()
       $("#ini").val(f_inicio);
       $("#finn").val(f_fin);
       $("#s_estados").val(f_estado);
      });

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

$(document).ready(function() {
    $("#slt_estados").select2({
        placeholder: "TODOS",                  
    });
  });



   $(document).ready(function(){                
    $("#modal-presentismo").on('shown.bs.modal',function(){
      console.log("asdad");
    var id_tipo= $("#usuario").val();
    $.post("<?php echo $url_ajax; ?>",{ id_tipo: id_tipo }, function(data){
              $("#estados").html(data);
            });

    });
  });
 
</script>
