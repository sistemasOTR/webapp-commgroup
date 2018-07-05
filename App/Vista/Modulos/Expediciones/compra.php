<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
 
  $url_action_cambiar = PATH_VISTA.'Modulos/Expediciones/action_cambiar_estado.php';
 

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
  $consulta = $handler->seleccionarComprasByFiltros($fdesde,$fhasta,$ftipo,$festados);
  $user = $usuarioActivoSesion;
  //var_dump($consulta);
  //exit();
 
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1 >
      Seguimiento de mis Compras
      <small>Controlar todas las compras realizadas</small>
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
                    <?php if ($festados == 1 ): ?>
                      <option value='1' selected="">Pendientes</option>
                      <?php else: ?>
                        <option value='1'>Pendientes</option>
                    <?php endif ?>
                    <?php if ($festados == 2 ): ?>
                      <option value='2' selected="">Recibidos</option>
                      <?php else: ?>
                        <option value='2'>Recibidos</option>
                    <?php endif ?>
                    
                    
                    
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
            <h3 class="box-title"> Seguimiento de mis compras - <?php echo "desde <b>".$dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y')."</b> hasta <b>".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y')."</b>"; ?></h3>   
          </div>

          <div class="box-body table-responsive">
              <table class="table table-striped " id='tabla'>
                <thead>
                  <tr>
                    <th width="150">FECHA PEDIDA</th>
                    <th width="150">FECHA RECIBIDA</th>
                    <th>ITEM</th>             
                    <th width="100">CANTIDAD</th>                                                
                    <th width="30">RECIBIDO</th>                                                  
                  </tr>
                </thead>
                <tbody>
                    <?php
                      if(!empty($consulta))
                      {               
                        foreach ($consulta as $key => $value) { 
                          $item = $handler->selectById($value->getItemExpediciones());
                          $url_action_recibido = PATH_VISTA.'Modulos/Expediciones/action_comprarecibida.php?idpedido='.$value->getId().'&iditem='.$value->getItemExpediciones().'&usuario='.$user->getId().'&cantidad='.$value->getCantidad().'&stock='.$item->getStock().'&fdesde='.$fdesde.'&fhasta='.$fhasta.'&tipo='.$ftipo.'&estado='.$festados;
                          $fecharecibido=$value->getFechaRecibido()->format('d/m/Y');
                          $fechanula='01/01/1900';
                         // var_dump($fecharecibido,$fechanula);
                         // exit();
                          
                           if ($fecharecibido>$fechanula) {
                                $fechaok=$value->getFechaRecibido()->format('d/m/Y');                         
                           }
                           else {
                            $fechaok='';
                           }


                          if ($value->getRecibido()==0) {
                            $recibido='<a href="'.$url_action_recibido.'"class="fa fa-play"></a>';
                          }
                          elseif ($value->getRecibido()==1)  {
                            $recibido='<i class="fa fa-check text-green"></i>';
                          }
                       
            
                         
                           
                         
                          echo "
                            <tr>
                              <td>".$value->getFecha()->format('d/m/Y')."</td>
                              <td>".$fechaok."</td>
                              <td>".$item->getNombre()."</td>                      
                                <td>".$value->getCantidad()."</td>
                                <td>".$recibido."</td>
                                
                               
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
    $("#mnu_expediciones_compra").addClass("active");
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
      
      url_filtro_reporte="index.php?view=exp_compra&fdesde="+f_inicio+"&fhasta="+f_fin  

      if(f_estados!=undefined)
        if(f_estados>0)
          url_filtro_reporte= url_filtro_reporte + "&festados="+f_estados;
      
      if(f_tipo!=undefined)
        if(f_tipo>0)
          url_filtro_reporte= url_filtro_reporte + "&ftipo="+f_tipo;    

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

</script>