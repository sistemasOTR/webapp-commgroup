<?php
  include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";  
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";         
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php";         

  $dFecha = new Fechas;
  $fechahoy=$dFecha->FechaActual();
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $fperiodo= (isset($_GET["fperiodo"])?$_GET["fperiodo"]:'');
  $fecha = $fperiodo.'-01';

  $fDesdeComision = date('Y-m-01',strtotime($fecha));
  $fHastaComision = date('Y-m-t',strtotime($fecha));

  $handler = new HandlerSueldos;
  $handlerSist = new HandlerSistema;
  $handlerConsultas= new HandlerConsultas;
  $handlerPuntaje = new HandlerPuntaje;
  $arrGestor = $handlerSist->selectAllGestor($fplaza);
  $arrCoordinador = $handlerSist->selectAllPlazasArray();

  $handlerPlaza = new HandlerPlazaUsuarios;
  $arrPlaza = $handlerPlaza->selectTodas();

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectEmpleados();
  $arrGestores = $handlerUsuarios->selectGestores($fplaza);
  if ($fecha != '-01') {
    $comision = $handler->selectByDate($fecha);
  }
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Comisiones
      <small>Listado de las comisiones de los gestores</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Comisiones</li>
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
                <div class="col-md-2">
                  <label>Período</label>
                  <?php if($fperiodo != ''){ ?>
                    <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" value="<?php echo $fperiodo; ?>" onchange="crearHrefPlaza()">
                  <?php } else { ?>
                    <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" onchange="crearHrefPlaza()">
                  <?php  } ?>
                </div> 
                <div class="col-md-3">
                  <label>Plazas</label>
                  <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" required="">                    
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrPlaza)){                        
                        foreach ($arrPlaza as $key => $value) {
                          if($fplaza == $value->getId()){
                            echo "<option value='".$value->getId()."' selected>".$value->getNombre()."</option>";
                          } else {
                            echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                          }
                        }
                      }
                    ?>                      
                  </select>     
                </div>
              <div class='col-md-3 pull-right'>                
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
              <i class="fa fa-ticket"></i>  
              <h3 class="box-title">Comisiones</h3>
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>GESTOR</th>              
                      <th>SERVICIOS TOTAL</th>              
                      <th>SERVICIOS CERRADOS</th>              
                      <th>SERVICIOS ENVIADAS</th>
                      <th>PUNTAJE</th>              
                      <th>OBJETIVO</th>              
                      <th>COMISIONES VALOR</th>              
                      <th>COMISIONES A COBRAR</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if (!empty($arrGestores) && $fecha != '-01') {
                        foreach ($arrGestores as $gestor) {
                          include 'calculo_comisiones.php';
                          if ($total_puntajes_enviadas>floatval($objetivo)) {
                            $puntaje_comision = $total_puntajes_enviadas - floatval($objetivo);
                            $valor_comision = $puntaje_comision * $comision['valor'];
                          } else {
                            $puntaje_comision = 0;
                            $valor_comision = 0;
                          }
                          echo "<tr>";
                            echo "<td>".$gestor->getApellido()." ".$gestor->getNombre()."</td>";
                            echo "<td>".$total_servicios."</td>";
                            echo "<td>".$total_servicios_cerrados."</td>";
                            echo "<td>".$total_servicios_enviadas."</td>";
                            echo "<td>".number_format($total_puntajes_enviadas,2)."</td>";
                            echo "<td>".number_format($objetivo,2,'.','')."</td>";
                            echo "<td>".number_format($puntaje_comision,2,'.','')."</td>";
                            echo "<td>$ ".number_format($valor_comision,2,'.','')."</td>";
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

<script type="text/javascript">
  $(document).ready(function(){                
    $("#mnu_resumen_comisiones").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_puntajes").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte();
    });
  });

  $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReportePlaza();
    });
  });

  $(document).ready(function() {
    $("#slt_estados").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      // filtrarReporte();
    });
  });

</script>
<script type="text/javascript">

  function crearHrefPlaza()
  {
     f_periodo = $('#slt_periodo').val()
      f_plaza = $("#slt_plaza").val();

      url_filtro_reporte="index.php?view=resumen_comisiones&fperiodo="+f_periodo;


    if(f_plaza!=undefined)
      if(f_plaza!='' && f_plaza!=0)
        url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReportePlaza()
  {
    crearHrefPlaza();
    window.location = $("#filtro_reporte").attr("href");
  }
</script>

<script type="text/javascript">
    
    $(document).ready(function() {
        $('#tabla').DataTable({
          "dom": 'Bfrtip',
          "buttons": ['copy', 'csv', 'excel', 'print'],
          "iDisplayLength":100,
          "order": [],
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