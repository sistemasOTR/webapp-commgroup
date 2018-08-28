<?php
  include_once PATH_NEGOCIO."Guias/handlerguias.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";     
  include_once PATH_NEGOCIO."Parametros/handlerparametros.class.php";   
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";      
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php";
  include_once PATH_DATOS.'Entidades/legajos_categorias.class.php'; 
 
  $user = $usuarioActivoSesion;
  $url_descargar = PATH_VISTA.'Modulos/Sueldos/action_descargar_lote.php?carpeta='.$user->getEmail().'&usuario='; 
  $url_descargar_excel = PATH_VISTA.'Modulos/Sueldos/action_descargar_excel.php?usuario_email='.$user->getEmail(); 

  $dFecha = new Fechas;

  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:0);

  $handlerUsuarios = new HandlerUsuarios;
  if ($fplaza == '0') {
    $arrEmpleados = $handlerUsuarios->selectEmpleados();
  } else {
    $arrEmpleados = $handlerUsuarios->selectByPlaza(intval($fplaza));
  }
  
  $handlerPlaza=new HandlerPlazaUsuarios;
  $arrPlazas = $handlerPlaza->selectTodas();

  $handlerSueldos = new HandlerSueldos;  
  $consulta = $handlerSueldos->selectSueldos($fplaza,$fusuario);
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Detalle de sueldos
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Sueldos</li>
    </ol>
  </section>        
  
  <section class="content">
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
                
                <div class="col-md-3">
                  <label>Plazas</label>                
                  <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrPlazas)){
                        foreach ($arrPlazas as $plaza) { 
                          if($fplaza == $plaza->getId())
                            echo "<option value='".$plaza->getId()."' selected>".$plaza->getNombre()."</option>";
                          else
                            echo "<option value='".$plaza->getId()."'>".$plaza->getNombre()."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Empleados</label>                
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrEmpleados)){
                        foreach ($arrEmpleados as $key => $value) { 
                          if($fusuario == $value->getId())
                            echo "<option value='".$value->getId()."' selected>".$value->getApellido()." ".$value->getNombre()."</option>";
                          else
                            echo "<option value='".$value->getId()."'>".$value->getApellido()." ".$value->getNombre()."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>    
                         
                <div class='col-md-2 pull-right'>                
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
              <i class="fa fa-dollar"></i>
              <h3 class="box-title">Sueldos</h3>
              <button type="button" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nuevo</button>
            </div>
          <div class="box-body table-responsive">                          
              <table class="table table-striped" id='tabla'>
                <thead>
                  <tr>
                    <th>USUARIO</th>                          
                    <th>PERIODO</th>                          
                    <th>FECHA</th>                          
                    <th>TIPO</th>   
                    <th>REMUNERACION</th>   
                    <th>DESCUENTO</th>                                              
                    <th>NO REMUNERATIVO</th>                                 
                    <th>TOTAL</th>                  
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                      if(!empty($consulta)){                        
                        foreach ($consulta as $key => $value) {

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
    $("#mnu_sueldos").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_legajos_remun").addClass("active");
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

  $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar un Usuario",                  
    }).on('change', function (e) { 
      filtrarReporte();
    });
  });

  $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar un Usuario",                  
    }).on('change', function (e) { 
      filtrarReporte();
    });
  });
  
  function crearHref()
  {
      f_usuario = $("#slt_usuario").val();   
      f_plaza = $("#slt_plaza").val();   
      
      url_filtro_reporte="index.php?view=sueldos_remun";

      if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;

      if(f_plaza!=undefined)
        if(f_plaza>0)
          url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }  

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

</script>