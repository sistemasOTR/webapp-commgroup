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

  $dFecha = new Fechas;

  $fusuariofiltro= (isset($_GET["fusuariofiltro"])?$_GET["fusuariofiltro"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');

  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $ftipo= (isset($_GET["ftipo"])?$_GET["ftipo"]:'');
  $ffecha= (isset($_GET["ffecha"])?$_GET["ffecha"]:'');
  $url_action_generar_sueldo=PATH_VISTA.'Modulos/Sueldos/action_generar_sueldo.php';
  $url_retorno = "index.php?view=sueldos_remun&fusuario=".$fusuariofiltro."&fplaza=".$fplaza;

  $handlertipocategoria= new LegajosCategorias;
  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectEmpleados();
  $plazausuarios=new HandlerPlazaUsuarios;

  $handler = new HandlerLegajos;  
  $consulta = $handler->seleccionarByFiltros($fusuario);
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
      <div class='col-md-10 col-md-offset-1'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Generar nuevo sueldo</h3>
            </div>
            <div class="box-body">
              <form action="<?php echo $url_action_generar_sueldo; ?>"  method="post">
              <div class='row'>  
                
                <div class="col-md-3">
                  <label>Fecha</label>
                  <input type="date" name="fecha" id="fecha" class="form-control">
                </div>
                <div class="col-md-3">
                  <label>Período</label>
                  <input type="month" name="periodo" id="periodo" class="form-control">
                </div>
                <div class="col-md-3">
                  <label>Empleado</label>            
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrUsuarios)){
                        foreach ($arrUsuarios as $key => $value) {
                          if($fusuario == $value->getId())
                            echo "<option value='".$value->getId()."' selected>".$value->getApellido()." ".$value->getNombre()."</option>";
                          else
                            echo "<option value='".$value->getId()."'>".$value->getApellido()." ".$value->getNombre()."</option>";
                        }
                      }
                    ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <label>Tipo</label>            
                  <select id="slt_tipo" class="form-control" style="width: 100%" name="slt_tipo" onchange="crearHref()">
                    <option value=''>Seleccione un tipo</option>
                    <option value='A'>LIQUIDACIÓN AGUINALDO</option>
                    <option value='S'>LIQUIDACIÓN SUELDO</option>
                    <option value='F'>LIQUIDACIÓN FINAL</option>
                  </select>
                </div>
              </div>
                         
                <div class='box-footer'>
                  <a href='<?php echo $url_retorno ?>' class="btn btn-danger pull-right" style='margin-left: 10px;'><i class="fa fa-times"> Cancelar</i></a>   
                  <button type="submit" class="btn btn-success pull-right"><i class='fa fa-check'></i> Generar</button>
                </div>
              </form>
            </div>

        </div>
      </div>
    </div>
  </section>
</div>


<script type="text/javascript"> 

  $(document).ready(function(){                
    $("#mnu_sueldos_remun").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_sueldos").addClass("active");
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
    });
  });

  $(document).ready(function() {
    $("#slt_tipo").select2({
        placeholder: "Seleccionar un Usuario",                  
    });
  });

  crearHref();
  function crearHref()
  {
      f_usuario = $("#slt_usuario").val();   
      f_tipo = $("#slt_tipo").val();   
      f_fecha = $("#fecha").val();
      f_periodo = $("#periodo").val();

      console.log(f_fecha,f_periodo,f_usuario,f_tipo);
      
      url_filtro_reporte=$(".btn-success").val();

      if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;

      if(f_fecha!=undefined)
        if(f_fecha!='')
          url_filtro_reporte= url_filtro_reporte + "&ffecha="+f_fecha;

      if(f_periodo!=undefined)
        if(f_periodo!='')
          url_filtro_reporte= url_filtro_reporte + "&fperiodo="+f_periodo;

      if(f_tipo!=undefined)
        if(f_tipo!='0')
          url_filtro_reporte= url_filtro_reporte + "&ftipo="+f_tipo;

      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

</script>