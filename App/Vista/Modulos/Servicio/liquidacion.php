<?php
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."UploadFile/handleruploadfile.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  
  // Handlers
  // ============================
  $dFecha = new Fechas;
  $handlerCons =  new HandlerConsultas;
  $handlerSist =  new HandlerSistema;

  // Recoleccion de datos
  // ============================
  $fperiodo= (isset($_GET["fperiodo"])?$_GET["fperiodo"]:'');
  $fempresa= (isset($_GET["fempresa"])?$_GET["fempresa"]:'');

  // Tratado de fechas
  // ============================
  $fInicio = $fperiodo.'-01';
  $fFin = date('Y-m-t',strtotime($fInicio));
  setlocale(LC_TIME, 'spanish');  
  $nombreMES = strftime("%B",mktime(0, 0, 0, date('m',strtotime($fInicio)), 1, 2000));      
  $anioMES = date('Y',mktime(0,0,0,date('m',strtotime($fInicio)),1,date('Y',strtotime($fInicio))));

  // Empresas
  // ============================
  $arrEmpresas = $handlerSist->selectEmpresasActivas();
    
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
          </div>
          <div class="box-body">
            <div class='row'>
              <div class='col-md-10'>
                <div class="col-md-3">
                  <label>Período</label>
                  <?php if($fperiodo != ''){ ?>
                    <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" value="<?php echo $fperiodo; ?>" onchange="crearHref()">
                  <?php } else { ?>
                    <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" onchange="crearHref()">
                  <?php  } ?>
                </div>
                <div class="col-md-3">
                  <label>Empresas</label>
                  <select id="slt_empresa" class="form-control" style="width: 100%" name="slt_empresa" required="" onchange="crearHref()">                    
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrEmpresas)){                        
                        foreach ($arrEmpresas as $key => $value) {
                          if($fempresa == $value->EMPTT11_CODIGO){
                            echo "<option value='".$value->EMPTT11_CODIGO."' selected>".$value->EMPTT21_NOMBREFA."</option>";
                          } else {
                            echo "<option value='".$value->EMPTT11_CODIGO."'>".$value->EMPTT21_NOMBREFA."</option>";
                          }
                        }
                      }
                    ?>                      
                  </select>     
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

        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="fa fa-list"></i>
            <h3 class="box-title">Servicios Encontrados</h3>
          </div>
          <div class="box-body table-responsive">
            <?php 
              if ($fempresa != '') {
                $EMP = $handlerSist->selectEmpresaById($fempresa);
                $nombreEmpresa = trim($EMP[0]->EMPTT21_NOMBRE);
                switch ($nombreEmpresa) {
                  case 'BUDGET SRL':
                   include_once 'budget.php';
                    break;
                  
                  default:
                    include_once 'no-budget.php';
                    break;
                }
              }

             ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <head>
    <title><?php echo ' - Liquidación '.$EMP[0]->EMPTT21_NOMBREFA.' - '.$nombreMES.' '.$anioMES; ?></title>
  </head>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_servicio").addClass("active");
    $("#mnu_liquidacion").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_empresa").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      // filtrarReporte();
    });
  });

  crearHref();
  function crearHref()
  {
   f_periodo = $('#slt_periodo').val();
   f_empresa = $('#slt_empresa').val();

      url_filtro_reporte="index.php?view=liquidacion&fperiodo="+f_periodo;


    if(f_empresa!=undefined)
      if(f_empresa!='' && f_empresa!=0)
        url_filtro_reporte= url_filtro_reporte +"&fempresa="+f_empresa;      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }
  
  $(document).ready(function() {
    $('#tabla-servicios').DataTable({
      "dom": 'Bfrtip',
      "buttons": ['copy', 'csv', 'excel', 'print'],
      "iDisplayLength":50,
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