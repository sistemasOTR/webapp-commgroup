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

  $handler = new HandlerLicencias;  
  $arrLicencias = $handler->seleccionarByFiltros($fdesde,$fhasta,$fusuario);

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectTodos();

  $url_action_aprobar = PATH_VISTA.'Modulos/Licencias/action_aprobar.php?id=';  
  $url_action_desaprobar = PATH_VISTA.'Modulos/Licencias/action_desaprobar.php?id=';  
  $url_action_rechazar = PATH_VISTA.'Modulos/Licencias/action_rechazar.php';  
  $url_action_imprimir = 'index.php?view=licencias_imprimir&id=';

  $url_redireccion ='&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fusuario='.$fusuario;

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Licencias
      <small>Licencias solicitadas por el gestor</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Licencias</li>
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
                <div class="col-md-3" id='sandbox-container'>
                    <label>Fecha Desde - Hasta </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                <?php
                // if(!empty($arrUsuarios))
                //       {                     
                                        
                //         foreach ($arrUsuarios as $key => $value) {
                //           var_dump($value->getTipoUsuario()->getId());
                //         }
                //       }
                //       ?>
                <div class="col-md-3">
                  <label>Usuarios </label>                
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrUsuarios))
                      {                     
                                        
                        foreach ($arrUsuarios as $key => $value) {

                          if (!is_array($value->getTipoUsuario())) {
                            if ($value->getTipoUsuario()->getId() != '1') {
                              $notHidden = true;
                            } else {
                              $notHidden = false;
                            }
                          } else {
                            $notHidden = true;
                          }
                          if($fusuario == $value->getId() && $notHidden){
                            echo "<option value='".$value->getId()."' selected>".$value->getNombre()." ".$value->getApellido()."</option>";
                          }
                          elseif($notHidden){
                            echo "<option value='".$value->getId()."'>".$value->getNombre()." ".$value->getApellido()."</option>";                  
                          }
                            
                        }
                        
                      }           
                    ?>
                  </select>
                </div>    
                
                <div class='col-md-3 col-md-offset-3'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
              </div>
            </div>
        </div>
      </div>  

      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">    
              <i class="fa fa-certificate"></i>       
              <h3 class="box-title">Licencias</h3>   
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>USUARIO</th>
                      <th>FECHA</th>
                      <th>TIPO LICENCIA</th>
                      <th>DESDE</th>
                      <th>HASTA</th>
                      <th>OBSERVACIONES</th>
                      <th>ADJUNTO 1</th>
                      <th>ADJUNTO 2</th>
                      <th>ESTADO</th>
                      <th>FECHA RECHAZO</th>
                      <th>OBS RECHAZO</th>
                      <th style="width: 3%;" class='text-center'></th>
                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if(!empty($arrLicencias))
                      {
                        foreach ($arrLicencias as $key => $value) {
                          
                          if(!$value->getAprobado() && !$value->getRechazado()){
                            $estado = "<span class='label label-warning'>PENDIENTE</span>";
                            $frech = '';
                          }
                          elseif($value->getAprobado()) {
                            $estado = "<span class='label label-success'>APROBADO</span>";
                            $frech = '';
                          } elseif ($value->getRechazado()) {
                            $estado = "<span class='label label-danger'>RECHAZADO</span>";
                            $frech = $value->getFechaRechazo()->format('d-m-Y');
                          }

                          echo "<tr>";
                            echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                            echo "<td>".$value->getFecha()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getTipoLicenciasId()->getNombre()."</td>";
                            echo "<td>".$value->getFechaInicio()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getFechaFin()->format('d/m/Y')."</td>";
                            echo "<td>".$value->getObservaciones()."</td>";

                            if(!empty($value->getAdjunto1()))
                              echo "<td><a href='".$value->getAdjunto1()."' target='_blank'>VER ADJUNTO</a></td>";
                            else
                              echo "<td></td>";

                            if(!empty($value->getAdjunto2()))
                              echo "<td><a href='".$value->getAdjunto2()."' target='_blank'>VER ADJUNTO</a></td>";
                            else
                              echo "<td></td>";

                            echo "<td>".$estado."</td>";
                            echo "<td>".$frech."</td>";
                            echo "<td>".$value->getObsRechazo()."</td>";

                            if(!$value->getAprobado() && !$value->getRechazado()){
                              echo "<td class='text-center' width='100'>
                                      <a href='".$url_action_aprobar.$value->getId()."' class='btn btn-success btn-xs pull-left'>
                                        <i class='fa fa-thumbs-up' data-toggle='tooltip' data-original-title='Aprobar Licencia'></i>
                                        
                                      </a> 
                                      <a href='#' id='".$value->getId()."' data-toggle='modal' data-target='#modal-rechazar' class='btn btn-danger btn-xs pull-left' style='margin-left:10px;' data-id='".$value->getId()."' onclick='rechazar(".$value->getId().")'>
                                        <i class='fa fa-thumbs-down' data-toggle='tooltip' data-original-title='Rechazar Licencia'></i>
                                        
                                      </a>
                                    </td>";
                            }
                            elseif($value->getRechazado()){
                              echo "<td class='text-center' width='60'>
                                      
                                    </td>";

                            } else
                            {
                              echo "<td class='text-center'>
                                    <a href='".$url_action_desaprobar.$value->getId()."' class='btn btn-danger btn-xs'>
                                      <i class='fa fa-times' data-toggle='tooltip' data-original-title='Desaprobar Licencia'></i>
                                      Desaprobar Licencia
                                    </a>
                                  </td>";                                  
                            } 

                            if($value->getAprobado()){
                              echo "<td class='text-center'>
                                      <a href='".$url_action_imprimir.$value->getId()."' class='btn btn-default btn-xs'>
                                        <i class='fa fa-print' data-toggle='tooltip' data-original-title='Imprimir'></i>
                                        Imprimir
                                      </a>
                                    </td>";
                            } else {
                              echo "<td></td>";
                            }                           
                          echo "</tr>";
                        }          
                      }            
                    ?>
                  </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal modal-danger fade" id="modal-rechazar">
     <div class="modal-dialog ">
    <div class="modal-content ">

      
      <form  method="post" enctype="multipart/form-data" action=<?php echo $url_action_rechazar;?>>

        <div class="modal-header ">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h3 class="modal-title" style="" >Rechazar licencia</h3>
        </div>
        <div class="modal-body ">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">  
                  <label>Observación </label>  
                  <input type="text" name="observaciones" class="form-control" placeholder="Ingrese una observación">
                </div>                                                      
                <input type="number" name="id" id="idRechazar" class="form-control"  required="" style="display:none;">
                <input type="date" name="fechaElim" id="fechaElim" class="form-control"  required="" style="display:none;" value='<?php echo $dFecha->FechaActual(); ?>'>
                <input type="hidden" name="url_redireccion" class="form-control" value='<?php echo $url_redireccion; ?>'> 
              
               
              </div>
        </div>
        <div class="modal-footer ">
          <input type="submit" name="submit" value="Rechazar" class="btn btn-danger">
        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript"> 
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
</script>
<script type="text/javascript">

  function rechazar(id){
    document.getElementById('idRechazar').value = id;
  }



  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aEnd = $("#end").val().split('/');

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      f_usuario = $("#slt_usuario").val();     
      
      url_filtro_reporte="index.php?view=licencias_control&fdesde="+f_inicio+"&fhasta="+f_fin  

      if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  $(document).ready(function() {
        $('#tabla').DataTable({
          "dom": 'Bfrtip',
          "buttons": ['copy', 'csv', 'excel', 'print'],
          "iDisplayLength":100,
          "language": {
              "sProcessing":    "Procesando...",
              "sLengthMenu":    "Mostrar _MENU_ registros",
              "sZeroRecords":   "No se encontraron resultados",
              "sEmptyTable":    "Ningún dato disponible en esta tabla",
              "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix":   "",
              "sSearch":        "Buscar:",
              "sUrl":           "",
              "sInfoThousands":  ",",
              "sLoadingRecords": "Cargando...",
              "oPaginate": {
                  "sFirst":    "Primero",
                  "sLast":    "Último",
                  "sNext":    "Siguiente",
                  "sPrevious": "Anterior"
              },
              "oAria": {
                  "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                  "sSortDescending": ": Activar para ordenar la columna de manera descendente"
              }
          }
        });
    });
</script>