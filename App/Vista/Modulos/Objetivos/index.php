<?php
	
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
	include_once PATH_NEGOCIO."Modulos/handlerobjetivos.class.php";
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";

	$handlerSist = new HandlerSistema;
	$handlerObj = new HandlerObjetivos;
	$handlerFecha = new Fechas;
  
	$vista = (isset($_GET["vista"])?$_GET["vista"]:"");

	$href1 = '?view=objetivos&vista=1';
	$href2 = '?view=objetivos&vista=2';
	$href3 = '?view=objetivos&vista=3';
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Objetivos
      <small>Configuración general de la plataforma</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Objetivos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class="row">
      <div class="col-md-3">
        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Ver</h3>
          </div>
          <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
              <li><a href="<?php echo $href1; ?>"><i class="fa fa-bullseye"></i> Objetivos por plaza</a></li>
              <li><a href="<?php echo $href2; ?>"><i class="fa fa-users"></i> Gestor/Coordinador</a></li>
            </ul>
          </div>  
        </div>
      </div>
      <div class="col-md-9">
        <?php
          switch ($vista) {
            case '1':
              include_once "objetivos.php";
              break;

            case '2':
              include_once "gestor_coord.php";
              break;

            case '3':
              include_once "detalle_plaza.php";
              break;                            
          }
        ?>  
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_objetivos").addClass("active");
    $("#mnu_puntajes").addClass("active");
  });
</script>