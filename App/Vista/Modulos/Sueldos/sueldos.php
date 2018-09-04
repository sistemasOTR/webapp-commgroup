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

  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');

  $handlerUsuarios = new HandlerUsuarios;
  if ($fplaza == '') {
    $arrEmpleados = $handlerUsuarios->selectEmpleados();
  } else {
    $arrEmpleados = $handlerUsuarios->selectByPlaza(intval($fplaza));
  }
  
  $handlerPlaza=new HandlerPlazaUsuarios;
  $arrPlazas = $handlerPlaza->selectTodas();

  $handlerSueldos = new HandlerSueldos;  
  $consulta = $handlerSueldos->selectSueldos($fplaza,$fusuario);

  $url_imprimir = PATH_VISTA.'Modulos/Sueldos/imprimir.php?idsueldo=';
  $url_borrar = PATH_VISTA.'Modulos/Sueldos/action_borrar_sueldo.php?idsueldo=';
  $url_editar = "index.php?view=sueldos_edit_form&fusuario=".$fusuario."&fplaza=".$fplaza."&idsueldo=";
  $url_nuevo = "index.php?view=sueldos_nuevo&fusuariofiltro=".$fusuario."&fplaza=".$fplaza;

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
    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>
    <div class="row">
      <?php include_once 'filtros.php'; ?>
      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-dollar"></i>
              <h3 class="box-title">Sueldos</h3>
              <a href='<?php echo $url_nuevo ?>'><button type="button" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Nuevo</button></a>
            </div>
          <div class="box-body table-responsive">                          
              <table class="table table-striped" id='tabla-sueldos'>
                <thead>
                  <tr class="bg-black">
                    <th>EMPLEADO</th>
                    <th>PLAZA</th>                          
                    <th style="display: none;">PERIODO</th>                          
                    <th>PERIODO</th>                          
                    <th>FECHA</th>                          
                    <th>TIPO</th>   
                    <th>REMUNERATIVO</th>   
                    <th>DESCUENTO</th>                                              
                    <th>NO REMUNERATIVO</th>                                 
                    <th>TOTAL</th>
                    <th class="text-right">ACCIONES</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                      if(!empty($consulta)){ 
                        foreach ($consulta as $key => $value) {

                          # Empleado #
                          $empleado = $handlerUsuarios->selectById($value->getIdUsuario());

                          # Plaza #
                          $plazaEmp = $handlerPlaza->selectById($empleado->getUserPlaza());

                          # Tipo #
                          switch ($value->getTipo()) {
                            case 'S':
                              $tipoSueldo = 'SUELDO';
                              break;
                            case 'A':
                              $tipoSueldo = 'AGUINALDO';
                              break;
                            case 'F':
                              $tipoSueldo = 'LIQ. FINAL';
                              break;
                            
                            default:
                              $tipoSueldo = '';
                              break;
                          }

                          # Total #
                          $totalSueldo= $value->getNoRemunerativo()-$value->getDescuento()+$value->getRemunerativo();

                          # Botones #
                          $impr = "<a href='".$url_imprimir.$value->getId()."' target='_blank' class='btn btn-warning'><i class='fa fa-print'></i></a>";
                          $editar = "<a href='".$url_editar.$value->getId()."' class='btn btn-info'><i class='fa fa-edit'></i></a>";
                          $borrar = "<a href='".$url_borrar.$value->getId()."' class='btn btn-danger'><i class='fa fa-trash'></i></a>";

                          
                          echo "<tr>";
                            echo "<td>".$empleado->getApellido()." ".$empleado->getNombre()."</td>";
                            echo "<td>".$plazaEmp->getNombre()."</td>";
                            echo "<td style='display: none;'>".$value->getPeriodo()->format('Y-m')."</td>";
                            echo "<td>".$value->getPeriodo()->format('m-Y')."</td>";
                            echo "<td>".$value->getFecha()->format('d-m-Y')."</td>";
                            echo "<td>".$tipoSueldo."</td>";
                            echo "<td>$ ".$value->getRemunerativo()."</td>";
                            echo "<td>$ ".$value->getDescuento()."</td>";
                            echo "<td>$ ".$value->getNoRemunerativo()."</td>";
                            echo "<td>$ ".$totalSueldo."</td>";
                            echo "<td class='text-right'>".$impr." ".$editar." ".$borrar."</td>";
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
    $("#mnu_sueldos").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_legajos_remun").addClass("active");
  });

  $(document).ready(function() {
      $('#tabla-sueldos').DataTable({
        "dom": 'Bfrtip',
        "buttons": ['copy', 'csv', 'excel', 'print'],
        "iDisplayLength":100,
        "order": [[ 2, "desc" ]],
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