<?php
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
    include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
    include_once PATH_NEGOCIO."UploadFile/handleruploadfile.class.php";  
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
    
    $dFecha = new Fechas;

    $user = $usuarioActivoSesion;

    $fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:date('Y-m-d', strtotime('-0 days')));
    $fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:date('Y-m-d'));
    $handler =  new HandlerConsultas;

    $consulta = $handler->consultaResumenServicios($fdesde, $fhasta);

    
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Servicios
      <small>Consulta de todos los servicios vinculados</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Servicios</li>
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
              
              <div class='col-md-10'>
                <div class="col-md-3" id='sandbox-container'>
                  <label>Fecha Desde - Hasta </label>                
                  <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                  </div>  
                </div>
              </div>

              <div class='col-md-2'>                
                  <label></label>                
                  <a class='btn btn-block btn-success' id='filtro_reporte' onclick='crearHref()'><i class='fa fa-filter'></i> Filtrar</a>
              </div>
          </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-12">

        <div class="box box-solid" id="ID_DIV">
          <div class="box-header with-border">
            <i class="fa fa-list"></i>
            <h3 class="box-title">Servicios Encontrados</h3>
            
          </div>
          
          <div class="box-body table-responsive">          

            <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
  <thead>        
    <tr>             
      <th class='text-center'>EMPRESA</th>
      <th class='text-center'>PRODUCTO</th>
      <th class='text-left'>PLAZA</th>  
      <!-- <th class='text-left'>E.Vtas</th>  -->
      <th class='text-left'>ENVIADO</th>            
      <th class='text-left'>A LIQUIDAR</th>      
      <th class='text-left'>A LIQ CIERRE PARCIAL</th>      
      <th class='text-left'>NO EFECTIVAS</th>
    </tr>
  </thead>

  <tbody>
    <?php    
      if(!empty($consulta)){
        foreach ($consulta as $key => $value) {                    
          
          
          echo "<tr>";

              //FECHA
              echo "<td class='text-center'>".$value->EMPRESA."</td>";              

              //NUMERO
              echo "<td class='text-center'>".$value->PRODUCTO."</td>";

              //ID OPORTUNIDAD
              echo "<td class='text-left'>".$value->PLAZA."</td>";                          


              //EQUIPO DE VENTAS
              /*
              if(!empty(trim(strip_tags($value->TEPE91_EQUIPVTA))))
                if(strlen(trim(strip_tags($value->TEPE91_EQUIPVTA)))>5)
                  echo "<td class='text-left'>".substr(trim(strip_tags($value->TEPE91_EQUIPVTA)),0,5)."... <i class='fa fa-search-plus pull-right' data-toggle='tooltip' title='' data-original-title='".trim(strip_tags($value->TEPE91_EQUIPVTA))."'></i></td>";
                else
                  echo "<td class='text-left'>".trim(strip_tags($value->TEPE91_EQUIPVTA))."</td>";
              else
                echo "<td class='text-left'></td>";
              */

              //DNI              
              echo "<td class='text-left'>".$value->ENV."</td>";              
              echo "<td class='text-left'>".$value->LIQ."</td>";              
              echo "<td class='text-left'>".$value->LCP."</td>";              
              echo "<td class='text-left'>".$value->NE."</td>";              

              

            echo "</tr>";
        }
      }
              
    ?>                        
  </tbody>
</table> 

<script type="text/javascript">   

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

          </div>             
        </div>

      </div>
    </div>

  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_servicio").addClass("active");
  });
      
  

  $(document).ready(function() {
    $("#fecha").on('change', function (e) { 
      filtrarReporte(); 
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


  //filtros todos los servicios
  crearHref();
  function crearHref()
  {
    aStart = $("#start").val().split('/');
    aEnd = $("#end").val().split('/');

    f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
    f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                      
  
    url_filtro_reporte="index.php?view=servicio_resumen&fdesde="+f_inicio+"&fhasta="+f_fin

    $("#filtro_reporte").attr("href", url_filtro_reporte);

    document.cookie = "url-tmp-back="+url_filtro_reporte;
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }


</script>