<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
	include_once PATH_DATOS.'Entidades/importaciontipo1.class.php'; 
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  	
  	$dFecha = new Fechas;    
  	$handler = new HandlerSistema;
  	$handlerImp = new ImportacionTipo1;
  
 	  $user = $usuarioActivoSesion;
    $est_empresa=$usuarioActivoSesion->getUserSistema();

    /*-------------------------*/
    /* --- gestion de fechas --*/
    $periodo = (isset($_GET["periodo"])?$_GET["periodo"]:date('Y-m',strtotime($dFecha->FechaActual())));
    /*-------------------------*/
     if(!PRODUCCION)
      $fHOY = "2018-07-23"; ?>
  <style>
  	.small-box .icon {font-size: 80px !important;}
  </style>
<div class="content-wrapper">  
		  <section class="content-header">
		    <h1>
		      Estadísticas
		      <small>Consultas personalizadas</small>
		    </h1>
		    <ol class="breadcrumb">
		      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
		      <li class="active">Estadísticas</li>
		    </ol>
		  </section>        
		  
		  <section class="content">
		  	<div class="row"> 
		  		<?php if ($usuarioActivoSesion->getUserSistema() == 2 || $usuarioActivoSesion->getUserSistema() == 3 || $usuarioActivoSesion->getUserSistema() == 11 || $usuarioActivoSesion->getUserSistema() == 13 || $usuarioActivoSesion->getUserSistema() == 14 || $usuarioActivoSesion->getUserSistema() == 15 || $usuarioActivoSesion->getUserSistema() == 18 || $usuarioActivoSesion->getUserSistema() == 23 || $usuarioActivoSesion->getUserSistema() == 31 || $usuarioActivoSesion->getUserSistema() == 37 || $usuarioActivoSesion->getUserSistema() == 43){
		  			echo "<h1 style='font-size:36px;'>Sección en construcción.</h1>";
		  		} else { 
  	
            
           include 'met_mensual_empresa.php'; 

}
?>
	</div>
    </section>
</div>

<!-- SCRIPTS PARA GRAFICAR -->

<script>
	crearHref();
  function crearHref()
  {
      aEnd = $("#periodo").val();

      url_filtro_reporte="index.php?view=metricas_empresa&periodo="+aEnd;
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }
</script>