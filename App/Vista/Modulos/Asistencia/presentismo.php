<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php"; 
 
  $dFecha = new Fechas;
  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());

  // $url_action_guardar_tipo = PATH_VISTA.'Modulos/Expediciones/action_item_abm.php';
  // $url_action_eliminar_tipo = PATH_VISTA.'Modulos/Expediciones/action_itemeliminar.php';
  $url_action_agregar = PATH_VISTA.'Modulos/Asistencia/action_add_hours.php';
  $url_action_editar = PATH_VISTA.'Modulos/Asistencia/action_edit_hours.php';
  // $url_action_publicar = PATH_VISTA.'Modulos/Expediciones/action_publicarcompra.php?id_usuario='.$usuarioActivoSesion->getId();

 
  $user = $usuarioActivoSesion;

  $handlerUsuarios = new HandlerUsuarios;
  $handlerSistema = new HandlerSistema;
  $handlerAsistencia= new HandlerAsistencias;
  $handlerAsist=new HandlerAsistencias;
  // $arrUsuarios = $handlerUsuarios->selectByPerfil("GESTOR");
  //selectGestoresByPlaza
 
 // var_dump($user->getUserSistema());
  $arrGestor = $handlerUsuarios->selectGestoresByPlaza(1);//$user->getUserPlaza()

  // $arrAsis=$handlerAsistencia->selectAsistenciasByFiltro($fdesde,$fusuario);

   // var_dump($arrGestor);
   //  exit();
  

 

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<style>
      .modal-backdrop {z-index: 5 !important;}
    </style>
<div class="content-wrapper">  
  <section class="content-header "> 
    <h1 style="text-align: center;">
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
      <div class='col-md-8 col-md-offset-2 '>
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
                  <div class='col-md-3 pull-right'>                
                  <label></label>                
                  <a class="btn btn-block btn-success " id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
                 
            </div>
          </div>
        </div>
      </div>
          <div class='col-md-8 col-md-offset-2'>
           <div class="box">
            <div class="box-body table-responsive">
             
              <table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
                <div class="col-md-3 pull-right">
              <input type="text" id="search-items" class="form-control" placeholder="Buscar Usuario..." />
              </div>
                  <thead>
                    <tr>
                      <th>USUARIO</th>                                  
                      <th>ENTRADA</th>                                  
                      <th>SALIDA</th>
                      <th>ENTRADA</th>                                  
                      <th>SALIDA</th>
                      <th>ENTRADA</th>                                  
                      <th>SALIDA</th>
                      <th>TOTAL HRS</th>

                      <th colspan="3" style="text-align: center;">ACCIÓN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <td><b><?php echo $user->getNombre()."".$user->getApellido() ; ?></b></td>
                    <?php 
                    $asistencias=$handlerAsist->selectAsistenciasByFiltro($fdesde,$user->getId()); //
                    for ($i=0; $i <6 ; $i++) { 
                           
                          
                            if (!empty($asistencias[$i])) {
                              $ingreso=$asistencias[$i]->getFecha()->format('H:i');
                            echo"<td>".$ingreso." "."<a href='#' id='".$asistencias[$i]->getId()."' data-editfecha='".$fdesde."' data-idi='".$asistencias[$i]->getId()."' data-toggle='modal' data-target='#modal-editar' class='fa fa-refresh text-yellow' onclick='cargarDatos(".$asistencias[$i]->getId().")'></a></td> ";
                               
                               $arrValor[]=$asistencias[$i]->getFecha()->format('H:i');
                             
                            
                            }
                             else{
                            echo "<td></td>";
                              $arrValor[]="00:0";
                            }

                           } 

                            $data1=new DateTime($arrValor[0]);  
                            $data2=new DateTime($arrValor[1]);
                            if ($data2->format('H:i')=='00:00'){
                                $total1=$data2->diff($data2);
                              } else{ 
                            $total1=$data2->diff($data1);
                             }

                            $data3=new DateTime($arrValor[2]);  
                            $data4=new DateTime($arrValor[3]); 
                            if ($data4->format('H:i')=='00:00'){
                                $total2=$data4->diff($data4);
                              } else{ 
                            $total2=$data4->diff($data3);
                             }
                            $data5=new DateTime($arrValor[4]);  
                            $data6=new DateTime($arrValor[5]);
                            if ($data6->format('H:i')=='00:00'){
                                $total3=$data6->diff($data6);
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
                            
                            $total=$total_horas+round($minutos,2);                      
                           
                            unset($arrValor); 

                     ?>
                     
                      <td><?php echo $total;?></td> 
                     <?php 


                      $ultimoAyer=$handlerAsist->selecTopAyer($user->getId(),$fdesde);//'2018-09-11'
                             if (!empty($ultimoAyer)) {
                             if ($ultimoAyer->getIngreso()==1) {
                             $accion="salida";
                                } elseif ($ultimoAyer->getIngreso()==0) {
                             $accion="entrada";
                                }                                         
                             } else{
                              $accion="entrada";
                             } ?>

                    <td width="50"> <a href="#" id='<?php echo $user->getId() ?>'data-ide='<?php echo $user->getId() ?>'  data-fecha='<?php echo $fdesde;?>' data-estados='<?php echo $accion; ?>'class="btn btn-success btn-xs" data-toggle='modal' data-target='#modal-presentismo' onclick='cargarDatos(<?php echo $user->getId() ?>)'>Nuevo</a></td>
                    <?php
                      if (!empty($arrGestor)) { 
                       
                        foreach ($arrGestor as $key => $value) { 
                          $total=0;


                           
                        $asistencias=$handlerAsist->selectAsistenciasByFiltro($fdesde,$value->getId()); // 
                      
                          ?>

                          <tr>
                            <td> <?php echo $value->getNombre()."".$value->getApellido() ;?> </td>
                            <?php for ($i=0; $i <6 ; $i++) { 
                           
                          
                            if (!empty($asistencias[$i])) {
                              $ingreso=$asistencias[$i]->getFecha()->format('H:i');
                            echo"<td>".$ingreso." "."<a href='#' id='".$asistencias[$i]->getId()."' data-editfecha='".$fdesde."' data-idi='".$asistencias[$i]->getId()."' data-toggle='modal' data-target='#modal-editar' class='fa fa-refresh text-yellow' onclick='cargarDatos(".$asistencias[$i]->getId().")'></a></td> ";
                               
                               $arrValor[]=$asistencias[$i]->getFecha()->format('H:i');
                             
                            
                            }
                             else{
                            echo "<td></td>";
                              $arrValor[]="00:0";
                            }

                           } 

                            
                            $data1=new DateTime($arrValor[0]);  
                            $data2=new DateTime($arrValor[1]);
                            if ($data2->format('H:i')=='00:00'){
                                $total1=$data2->diff($data2);
                              } else{ 
                            $total1=$data2->diff($data1);
                             }

                            $data3=new DateTime($arrValor[2]);  
                            $data4=new DateTime($arrValor[3]); 
                            if ($data4->format('H:i')=='00:00'){
                                $total2=$data4->diff($data4);
                              } else{ 
                            $total2=$data4->diff($data3);
                             }
                            $data5=new DateTime($arrValor[4]);  
                            $data6=new DateTime($arrValor[5]);
                            if ($data6->format('H:i')=='00:00'){
                                $total3=$data6->diff($data6);
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
                            
                            $total=$total_horas+round($minutos,2);                      
                           
                            unset($arrValor); 

                             $ultimoAyer=$handlerAsist->selecTopAyer($value->getId(),$fdesde);//'2018-09-11'
                             if (!empty($ultimoAyer)) {
                             if ($ultimoAyer->getIngreso()==1) {
                             $accion="salida";
                                } elseif ($ultimoAyer->getIngreso()==0) {
                             $accion="entrada";
                                }                                         
                             } else{
                              $accion="entrada";
                             }
                             
                            ?>
                            
                          
                            <td><?php echo $total; ?></td> 
                             <?php ?>                   
                            <td width="50"> <a href="#" id='<?php echo $value->getId() ?>'data-ide='<?php echo $value->getId() ?>' data-fecha='<?php echo $fdesde;?>' data-estados='<?php echo $accion; ?>'class="btn btn-primary btn-xs" data-toggle='modal' data-target='#modal-presentismo' onclick='cargarDatos(<?php echo $value->getId() ?>)'>Nuevo</a></td>
                          
                            
                             
                          </tr>
                    <?php 
                        } 
                      }
                    ?>
                  </tbody>
              </table>
            </div>
            </div>
          </div>

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
                <input type="time" name="hora" id="hora"required class="form-control" value="">
                <input type="hidden" name="cord_id" id="cord_id" class="form-control">    
                <input type="hidden" name="estados" id="estados" class="form-control">    
                <input type="hidden" name="fecha" id="fecha" class="form-control">    
                <input type="hidden" name="modo" id="modo" value="coordinador">    
              </div>         
              <div class="col-md-8">
                <label>Observaciones</label> 
                <textarea id="observacion" rows="3" cols="50" name="observacion"></textarea>
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
                <input type="time" name="hora" id="hora"required class="form-control" value="">
                <input type="hidden" name="edit_id" id="edit_id" class="form-control">     
                <input type="hidden" name="fecha_edit" id="fecha_edit" class="form-control">    
              </div>         
              <div class="col-md-8">
                <label>Observaciones</label> 
                <textarea id="observacion" rows="3" cols="50" name="observacion"></textarea>
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

    cord_id = document.getElementById(id).getAttribute('data-ide');
    edit_id = document.getElementById(id).getAttribute('data-idi');
    estados= document.getElementById(id).getAttribute('data-estados');
    fecha= document.getElementById(id).getAttribute('data-fecha');
    fecha_edit= document.getElementById(id).getAttribute('data-editfecha');
   
    document.getElementById("cord_id").value = cord_id;
    document.getElementById("edit_id").value = edit_id;
    document.getElementById("estados").value = estados;
    document.getElementById("fecha").value = fecha;
    document.getElementById("fecha_edit").value = fecha_edit;
 
    
  }

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

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];                        


      url_filtro_reporte="index.php?view=asistencias&fdesde="+f_inicio;  
      

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 
 //  function cargarNuevo(){
    
 //    estado = document.getElementById('btn-nuevo').getAttribute('data-accion');
   
 //    document.getElementById("estado").value = estado;
 //    document.getElementById("nombre_item").value = '';
 //    document.getElementById("descripcion").value = '';
 //    document.getElementById("stock").value = '';
 //    document.getElementById("ptopedido").value = '';
 //     document.getElementById("grupo").value = '';

    
 //  }
 //  function eliminarDatos(id){

 //    id_eliminar = document.getElementById(id+'_elim').getAttribute('data-id');
 //    document.getElementById("id_eliminar").value = id_eliminar;
   

 //  }
 //  function agregarPedido(id){

 //    id_agregar = document.getElementById(id).getAttribute('data-id');
 //    nombreitem = document.getElementById(id).getAttribute('data-nombre');

 //    document.getElementById("id_agregar").value = id_agregar;
 //    document.getElementById("nombreitem").value = nombreitem;
   

 //  }
</script>
