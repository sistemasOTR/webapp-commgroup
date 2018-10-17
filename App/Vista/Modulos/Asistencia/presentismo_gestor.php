<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
 
  $dFecha = new Fechas;
  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());

  $url_action_agregar = PATH_VISTA.'Modulos/Asistencia/action_add_hours.php';
  $url_action_editar = PATH_VISTA.'Modulos/Asistencia/action_edit_hours.php';
  $url_ajax =PATH_VISTA.'Modulos/Asistencia/select_usuario.php';
 
  $user = $usuarioActivoSesion;
  // var_dump($user->getNombre());
  // exit();
  
  $handlerUsuarios = new HandlerUsuarios;
  $handlerSistema = new HandlerSistema;
  $handlerAsistencia= new HandlerAsistencias;
  $handlerAsist=new HandlerAsistencias;
  $id='';
  $arrEstados = $handlerAsistencia->selectEstados();
  $handlerplazas=new HandlerPlazaUsuarios();
  $plazasOtr=$handlerplazas->selectTodas();

    foreach ($plazasOtr as $key => $value) {   
    
      if ($user->getAliasUserSistema()==strtoupper($value->getNombre())) {

        $id=$value->getId();
      }
    
    }    

  $arrGestor = $handlerUsuarios->selectGestores(intval($id));




 

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<style>
      .modal-backdrop {z-index: 5 !important;}
    </style>
<div class="content-wrapper">  
  <section class="content-header "> 
    <h1 >
      Asistencias Control
      <small>Diario, Semanal y Mensual </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tipos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class='container-fluid'>     
        <div class="row">
          <!-- MULTI PESTAÑAS -->
          <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class='active'><a href="#tab_1" data-toggle="tab" aria-expanded="true">Filtro</a></li> 
            
          </ul>
          <div class="tab-content col-xs-12">
            <div class='tab-pane active' id="tab_1">
               <div class='row'>
                <?php include_once"filtro_diario.php";?>
             </div>
            </div>          
          </div>
        </div>
                
      </div>        
     </div>
    </div>  

  </section>

</div>


  <script type="text/javascript">

  $(function () {
  $('#search-items').quicksearch('#tabla-items tbody tr');               
});
  $(document).ready(function(){                
    $("#mnu_expediciones_item_abm").addClass("active");
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

  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aFin = $("#fin").val().split('/');
      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];                        
      f_fin = aFin[2] +"-"+ aFin[1] +"-"+ aFin[0];                        
      url_filtro_reporte="index.php?view=asistencias_gestor&fdesde="+f_inicio+"&fhasta="+f_fin;  
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 


   
</script>
        
            