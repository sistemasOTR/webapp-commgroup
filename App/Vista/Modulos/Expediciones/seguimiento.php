<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
 
  $url_action_cambiar = PATH_VISTA.'Modulos/Expediciones/action_cambiar_estado.php';
  $url_action_recibido = PATH_VISTA.'Modulos/Expediciones/action_recibido.php';

  $dFecha = new Fechas;

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());  
  $ftipo= (isset($_GET["ftipo"])?$_GET["ftipo"]:'');
  $festados= (isset($_GET["festados"])?$_GET["festados"]:'');
  $fusuario= $usuarioActivoSesion->getId();
  $fplaza= $usuarioActivoSesion->getAliasUserSistema();

  $handler = new HandlerExpediciones;
  $arrTipo = $handler->selecionarTipo();
  $arrEstados = $handler->selecionarEstados();
  $consulta = $handler->seleccionarByFiltros($fdesde,$fhasta,$ftipo,$festados,$fplaza);
 
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1 >
      Seguimiento de mis solicitudes
      <small>Controlar todas las solicitudes realizadas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Seguimiento</li>
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

                <div class="col-md-3">
                  <label>Tipo </label>                
                  <select id="slt_tipo" class="form-control" style="width: 100%" name="slt_tipo" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrTipo))
                      {                     
                                        
                        foreach ($arrTipo as $key => $value) {                      

                          if($ftipo == $value->getId())
                            echo "<option value='".$value->getId()."' selected>".$value->getGrupo()."</option>";
                          else
                            echo "<option value='".$value->getId()."'>".$value->getGrupo()."</option>";                  
                            
                        }
                        
                      }  
                    ?>
                  </select>
                </div> 

                <div class="col-md-3">
                  <label>Estados </label>                
                  <select id="slt_estados" class="form-control" style="width: 100%" name="slt_estados" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrEstados))
                      {                     
                                        
                        foreach ($arrEstados as $key => $value) {                      

                          if($festados == $value->getId())
                            echo "<option value='".$value->getId()."' selected>".$value->getNombre()."</option>";
                          else
                            echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";                  
                            
                        }
                        
                      }       
                    ?>
                  </select>
                </div>                 

                <div class='col-md-3'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
              </div>
            </div>
        </div>
      </div>

      <div class='col-md-12'>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Seguimiento de mis solicitudes - <?php echo "desde <b>".$dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y')."</b> hasta <b>".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y')."</b>"; ?></h3>   
          </div>

          <div class="box-body table-responsive">
              <table class="table table-striped " id='tabla'>
                <thead>
                  <tr>
                    <th>FECHA</th>
                    <th>ULT ENVIO</th>
                    <th>ITEM</th>             
                    <th>CANT PEDIDA</th>             
                    <th>CANT RECIBIDA</th>             
                    <th>DETALLE</th>
                    <th width="150">ESTADO</th>             
                    <th>OBSERVACIONES</th>                             
                    <th width="30">REC</th>
                    <th width="50">PED</th>                              
                  </tr>
                </thead>
                <tbody>
                    <?php
                      if(!empty($consulta))
                      {
                          if (count($consulta)==1) {
                            $consulta = $consulta[""];
                          }
                        foreach ($consulta as $key => $value) {  
                       $envioss=$handler->selecionarEnvios($value->getId());
                       if(!empty($envioss)) {
                         foreach ($envioss as $env) {
                           $fechaEnvio=$env->getFecha()->format('d-m-Y');
                           break;
                         }   

                       } else {
                        $fechaEnvio='';
                       }

                       
                      
                          $url_detalle_pedido = 'index.php?view=exp_detalle&idpedido='.$value->getId().'&plaza='.$value->getPlaza().'&item='.$value->getItemExpediciones().'&user='.$value->getUsuarioId().'&fechaped='.$value->getFecha()->format('d/m/Y').'&fdesde='.$fdesde.'&fhasta='.$fhasta.'&festados='.$festados.'&cantped='.$value->getCantidad().'&ftipo='.$ftipo.'&vista=seguimiento';
                           $item = $handler->selectById($value->getItemExpediciones());
                          if (count($item)==1) {
                            $item = $item[""];
                          }
                          $estado = $handler->selectEstado($value->getEstadosExpediciones());    
                          $url_recibido= PATH_VISTA.'Modulos/Expediciones/action_recibido.php?id='.$value->getId().'&estado='.$estado->getId().'&fdesde='.$fdesde.'&fhasta='.$fhasta.'&festados='.$festados.'&ftipo='.$ftipo; 

                           if ($estado->getId()==1 || $estado->getId()==3) {
                                        $envios='<i class="fa fa-eye text-red"></i>';
                                       }
                              else{
                                $envios = "<a href='".$url_detalle_pedido."'  
                                        type='button' 
                                        class='fa fa-eye'></a>";
                              }         

                          if ($estado->getId()==2 || $estado->getId()==6 ) {
                                    $recibir = "<a href='".$url_recibido."'type='button' class='fa fa-play '></a>";
                                  }  elseif ($estado->getId()==4 || $estado->getId()==7) {
                                    $recibir = '<i class="fa fa-check text-green"></i>';
                                     }
                                     elseif ($estado->getId()==3|| $estado->getId()==8) {
                                    $recibir = '<i class="fa fa-close text-red"></i>';
                                     }
                                     else {
                                    $recibir = '<i class="fa fa-pause text-blue"></i>';
                                  }      
                          echo "
                            <tr>
                              <td>".$value->getFecha()->format('d/m/Y')."</td>
                              <td>".$fechaEnvio."</td>
                              <td>".$item->getNombre()."</td>                      
                                <td>".$value->getCantidad()."</td>
                                <td>".$value->getEntregada()."</td>
                                <td>".$value->getDetalle()."</td>                        
                                <td>
                                  <span class='label label-".$estado->getColor()."' style='font-size:12px;'>"
                                    .$estado->getNombre().
                                  "</span>
                                </td>
                                <td>".$value->getObservaciones()."</td>
                                <td>".$recibir."</td>
                                <td>".$envios."</td>
                               
                               </tr>";
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

  <script type="text/javascript">
    function btnCambiar(id_registro)
    {
        var id= id_registro;        
    
        var elemento = document.querySelector('#boton_cambiar_'+id);        
        formCambiar.id.value = id;                         

        var mensaje_activar="<p>Esta a punto de cambiar el estado del registro.<br>¿Desea Continuar?</p>";
        document.getElementById('mensaje_activar').innerHTML = mensaje_activar;      
    }

  </script>

  <div class="modal modal-primary fade" id="modalCambiar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="myModalLabel">Cambiar Estado</h4>
        </div>

        <form name="formCambiar" id="form" method="post" action=<?php echo $url_action_cambiar; ?>>   
          <input type="hidden" name="origen" value="SEGUIMIENTO">        

          <div class="modal-body">
              <div id="mensaje_activar">Se cambiara el estado del registro.<br>¿Desea continuar?</div>
              <input type="hidden" name="id" value="">              
              
              <div class="row">
                <div class="col-md-4">
                    <label>Estados </label>                
                    <select class="form-control" style="width: 100%" name="estados">                    
                      <?php
                        if(!empty($arrEstados))
                        {                     
                                          
                          foreach ($arrEstados as $key => $value) {    
                            if($value->getId()==4 || $value->getId()==5)                                                                                             
                              echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";                                              
                          }
                          
                        }       
                      ?>
                    </select>
                </div>           
                <div class="col-md-8">  
                  <label>Observación </label>  
                  <input type="text" name="observaciones" class="form-control" placeholder="Ingrese una observación">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
            <input  type="submit" name="submit" value="Cambiar" class="btn btn-outline">
          </div>                                      
        </form>

      </div>
    </div>
  </div>  

</div>

<script type="text/javascript"> 

  $(document).ready(function(){                
    $("#mnu_expediciones_seguimiento").addClass("active");
  });

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
    $("#slt_estados").select2({
        placeholder: "Seleccionar un Estado",                  
    });
  }); 

  $(document).ready(function() {
    $("#slt_tipo").select2({
        placeholder: "Seleccionar un Tipo",                  
    });
  }); 

  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aEnd = $("#end").val().split('/');

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                   
      f_estados = $("#slt_estados").val();     
      f_tipo = $("#slt_tipo").val();     
      
      url_filtro_reporte="index.php?view=exp_seguimiento&fdesde="+f_inicio+"&fhasta="+f_fin  

      if(f_estados!=undefined)
        if(f_estados>0)
          url_filtro_reporte= url_filtro_reporte + "&festados="+f_estados;
      
      if(f_tipo!=undefined)
        if(f_tipo>0)
          url_filtro_reporte= url_filtro_reporte + "&ftipo="+f_tipo;    

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

</script>