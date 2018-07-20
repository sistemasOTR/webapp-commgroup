<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         

  
  $url_action_eliminar = PATH_VISTA.'Modulos/Expediciones/action_eliminar_pedido.php';
  $url_action_cancelar = PATH_VISTA.'Modulos/Expediciones/action_cancelar_pedido.php';
  

  $dFecha = new Fechas;


  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->RestarDiasFechaActual(90));
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());   
//  $ftipo= (isset($_GET["ftipo"])?$_GET["ftipo"]:'');
  $festados= (isset($_GET["festados"])?$_GET["festados"]:'');
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $plazaEnv= (isset($_GET["plazaEnv"])?$_GET["plazaEnv"]:'');

  $handlersistema = new HandlerSistema; 
  $plazas=$handlersistema->selectAllPlazasArray();

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectTodos();
  $user = $usuarioActivoSesion;


  $handler = new HandlerExpediciones;
  $arrTipo = $handler->selecionarTipo();
  $arrEstados = $handler->selecionarEstados();
 // $consulta = $handler->seleccionarByFiltros($fdesde,$fhasta,$ftipo,9,$fplaza);
  $sinpedir=$handler->seleccionarApedir();

  $consulta = $handler->seleccionarByEnviados($fdesde,$fhasta);


  $url_action_cambiar = PATH_VISTA.'Modulos/Expediciones/action_enviar_pedido.php?id=';
  $url_redireccion ='index.php?view=exp_control_coordinador&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fplaza='.$fplaza.'&festados=9';
  $url_detalle ='index.php?view=exp_detalle_remito&id=';
  $url_action_eliminar_envio = PATH_VISTA.'Modulos/Expediciones/action_eliminaritem_envio.php?id=';
  $url_action_publicar=PATH_VISTA.'Modulos/Expediciones/action_enviado.php?fdesde='.$fdesde.'&fhasta='.$fhasta.'&fplaza='.$fplaza;

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1 class="text-center">
      Seguimiento de Remitos
      <small>Seguimiento de las Remitos </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Seguimiento Remitos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">
      <div class='col-md-5 col-md-offset-3'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Filtros Disponibles</h3>
              <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <div class="box-body">
              <div class='row'>  
                <div class="col-md-6" id='sandbox-container'>
                    <label>Fecha Desde - Hasta </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                <div class='col-md-5 col-md-offset-1'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
              </div>
            </div>
        </div>     
      </div>

      <div class='col-md-5 col-md-offset-3'>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Seguimiento de Remitos - <?php echo "desde <b>".$dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y')."</b> hasta <b>".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y')."</b>"; ?></h3>   
          </div>

          <div class="box-body table-responsive">
              <table class="table table-striped" id='tabla'>
                <thead>
                  <tr>
                    <th width="150">NRO REMITO</th> 
                    <th width="">FECHA</th>                                                             
                    <th width="150">RECIBIR</th>                          
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
                          // $idPed =$handler->selectByNroEnvio($value->getId());
                          // $items=$handler->selectByIdEnvio($idPed);
                          $url_recibir_remito ='index.php?view=exp_recibir_remito&id='.$value->getId().'&fechasolic='.$value->getFecha()->Format('d/m/Y').'&plaza='.$value->getPlaza();

                           $envios = "<a href='".$url_recibir_remito."'  
                                        type='button' 
                                         class='fa fa-play'></a>";            

                          echo "
                            <tr>
                              <td>".$value->getId()."</td>  
                              <td>".$value->getFecha()->Format('d/m/Y')."</td>        
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

</div>

<script type="text/javascript"> 

  $(document).ready(function(){                
    $("#mnu_expediciones_control").addClass("active");
  });

  $(document).ready(function() {
      $('#tabla').DataTable({
        "dom": 'Bfrtip',
        "buttons": ['copy', 'csv', 'excel', 'print'],
        "iDisplayLength":10,
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
    $("#slt_usuario").select2({
        placeholder: "Seleccionar un Usuario",                  
    });
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

      f_plaza = $("#slt_plaza").val();     
      f_estados = $("#slt_estados").val();     
      f_tipo = $("#slt_tipo").val();     
      console.log(f_plaza);
      console.log(f_tipo);

      url_filtro_reporte="index.php?view=exp_control_coordinador&fdesde="+f_inicio+"&fhasta="+f_fin;  

      url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;
      

      if(f_estados!=undefined)
        if(f_estados>0)
          url_filtro_reporte= url_filtro_reporte + "&festados="+f_estados;
      
      if(f_tipo!=undefined)
        if(f_tipo>0)
          url_filtro_reporte= url_filtro_reporte + "&ftipo="+f_tipo;    

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

</script>