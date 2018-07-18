<?php

  include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
  include_once PATH_DATOS.'BaseDatos/sql.class.php';
  include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';
  include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php'; 


  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handler = new HandlerSistema;
  $handlerimpresoras = new HandlerImpresoras;
  $handlerUs = new HandlerUsuarios;

  $user = $usuarioActivoSesion;
  $fplaza=(isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $fgestor=(isset($_GET["fgestor"])?$_GET["fgestor"]:'');
  $fgestorId=(isset($_GET["fgestorId"])?$_GET["fgestorId"]:0);
  $arrCoordinador = $handler->selectAllPlazasArray();
  $arrUsuarios = $handlerUs->selectGestores();

  $url_detalle = "index.php?view=impresora_detalle";
  $url_asignacion = "index.php?view=asignar_imp";
  $url_impresion = PATH_VISTA.'Modulos/Herramientas/Impresoras/imprimir_comodato.php?';

  $url_action_guardar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_guardar.php';
  $url_action_asignar = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_asignar.php';
  $url_action_devolver = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_devolver.php';
  $url_action_baja = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_baja.php';
  $url_action_devGestor = PATH_VISTA.'Modulos/Herramientas/Impresoras/action_devolver_gestor.php';
  

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Herramientas
      <small>ABM de herramientas </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li>Herramientas</li>
      <li class="active">Impresoras</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <?php if ($user->getUsuarioPerfil()->getNombre() != 'COORDINADOR') { ?>
        <div class="col-md-12">
          <?php include_once 'filtro_plaza.php'; ?>
        </div>
      <?php } ?>
      
      <div class="col-md-12">
        <?php 
          switch ($user->getUsuarioPerfil()->getNombre()) {
            case 'COORDINADOR':

             include_once "vista_coordinador.php";
                
             break;

            case 'GERENCIA' || 'BACK OFFICE':
              include_once "vista_admin.php";
              break;                   
          }
        ?>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_herramientas").addClass("active");
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
</script>
