<?php
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php";
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php";
  include_once PATH_DATOS.'Entidades/legajos_categorias.class.php';
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
 
  $user = $usuarioActivoSesion;
  $idsueldo= (isset($_GET["idsueldo"])?$_GET["idsueldo"]:'');

  ###########################
  # Declaración de handlers #
  ###########################

  $handlerSueldos = new HandlerSueldos;
  $handlerConsultas = new HandlerConsultas;
  $handlerTickets = new HandlerTickets;
  $handlerUsuarios = new HandlerUsuarios;
  $handlerLic = new HandlerLicencias;
  $handlerLeg = new HandlerLegajos;
  $handlerPuntaje = new HandlerPuntaje;
  $handlerLegCat = new LegajosCategorias;
  $dFechas = new Fechas;

  #####################
  # Instanciar Sueldo #
  #####################
  $sueldo = $handlerSueldos->selectSueldoById($idsueldo);
  
  ##########
  # Fechas #
  ##########
  $fDesde = $sueldo->getPeriodo()->format('d-m-Y');
  $fHasta = $sueldo->getPeriodo()->format('t-m-Y');
  $fDesdeInv = $sueldo->getPeriodo()->format('Y-m-d');
  $fHastaInv = $sueldo->getPeriodo()->format('Y-m-t');

  #######################
  # Calculo de viaticos #
  #######################
  
  include_once ('calc_viaticos.php');

  ###############################
  # Calculo de días de licencia #
  ###############################
  
  include_once ('calc_licencias.php');

  ############################
  # Calculo de dias feriados #
  ############################
  
  include_once ('calc_feriados.php');

  ##############################
  # Calculo de datos de legajo #
  ##############################
  
  include_once ('calc_legajos.php');

  #########################
  # Calculo de comisiones #
  #########################
  
  include_once ('calc_comisiones.php');

  ########################
  # Calculo de conceptos #
  ########################
  
  include_once ('calc_conceptos.php');

  #######################
  # Calculo de importes #
  #######################
  
  include_once ('calc_importes.php');

  $url_action_grabar_sueldo=PATH_VISTA.'Modulos/Sueldos/action_grabar_sueldo.php';
  $url_js = PATH_VISTA.'Modulos/Sueldos/sueldos.js';
?>
<style>
	#form_conceptos div {margin-bottom: .5em;}
</style>

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
      <div class='col-md-12'>
        
          <div class="box box-solid">
          	<form action="<?php echo $url_action_grabar_sueldo; ?>"  method="post">
	          <input type="hidden" value='<?php echo $idsueldo; ?>' name="idsueldo">
	          <input type="hidden" value='<?php echo $basico; ?>' name='basico' id='basico'>
	          <input type="hidden" value='<?php echo $jornada; ?>' name='jornada' id='jornada'>
	          <input type="hidden" value='<?php echo intval(trim($legajo[""]->getCategoria())); ?>' name='categoria' id='categoria'>
            <div class="box-header with-border">
              <i class="fa fa-dollar"></i>
              <h3 class="box-title">Generar nuevo sueldo</h3>
              <button type="button" class="btn btn-primary pull-right" id="more_fields" onclick="add_fields();"> Agregar Concepto</button>
            </div>
            <div class="box-body">
            	<div class="col-xs-12 no-padding" id="form_conceptos">
	            	<div>
	            		<div class="col-md-4">
	            			<label>Concepto</label>
	            		</div>
	            		<div class="col-md-2">
	            			<label>Unidades</label>
	            		</div>
	            		<div class="col-md-2">
	            			<label>Remunerativo</label>
	            		</div>
	            		<div class="col-md-2">
	            			<label>Descuento</label>
	            		</div>
	            		<div class="col-md-2">
	            			<label>No Remunerativo</label>
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Sueldo básico" name="concepto_1" id="concepto_1" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $diasLab ?>' onchange="changeUnidades()" name="unidades_1" id="unidades_1" class="form-control unidad">
	            			<input type="hidden" value='30' name="base_1" id="base_1" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>Días</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $basicoACob ?>' name="remu_1" id="remu_1" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_1" id="desc_1" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_1" id="no_remu_1" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Feriado nacional/Día del Gremio" name="concepto_2" id="concepto_2" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $feriados ?>' onchange="changeUnidades()" name="unidades_2" id="unidades_2" class="form-control unidad">
	            			<input type="hidden" value='25' name="base_2" id="base_2" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>Días</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $feriadosACob; ?>' name="remu_2" id="remu_2" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_2" id="desc_2" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_2" id="no_remu_2" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Licencias con goce de sueldo" name="concepto_3" id="concepto_3" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $deLicCGS ?>' onchange="changeUnidades()" name="unidades_3" id="unidades_3" class="form-control unidad">
	            			<input type="hidden" value='25' name="base_3" id="base_3" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>Días</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $licConACob; ?>' name="remu_3" id="remu_3" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_3" id="desc_3" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_3" id="no_remu_3" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Licencias sin goce de sueldo" name="concepto_4" id="concepto_4" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $deLicSGS ?>' onchange="changeUnidades()" name="unidades_4" id="unidades_4" class="form-control unidad">
	            			<input type="hidden" value='25' name="base_4" id="base_4" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>Días</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $licSinACob; ?>' name="remu_4" id="remu_4" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_4" id="desc_4" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_4" id="no_remu_4" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Antigüedad" name="concepto_5" id="concepto_5" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $antig ?>' onchange="changeUnidades()" name="unidades_5"id="unidades_5" class="form-control unidad">
	            			<input type="hidden" value='100' name="base_5" id="base_5" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>%</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $antigACob; ?>' name="remu_5"id="remu_5" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_5" id="desc_5" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_5" id="no_remu_5" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Asignación Asistencia y Puntualidad" name="concepto_6" id="concepto_6" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $concepto[0]["valor"] ?>' onchange="changeUnidades()" name="unidades_6" id="unidades_6" class="form-control unidad">
	            			<input type="hidden" value='<?php echo $concepto[0]["base"] ?>' name="base_6" id="base_6" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>%</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $presentACob; ?>' name="remu_6" id="remu_6" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_6" id="desc_6" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_6" id="no_remu_6" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Comisiones" name="concepto_7" id="concepto_7" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $comisionesValor ?>' onchange="changeUnidades()" name="unidades_7" id="unidades_7" class="form-control unidad">
	            			<input type="hidden" value='<?php echo $concepto[1]["valor"] ?>' name="base_7" id="base_7" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>Pts</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $comisionesACob; ?>' name="remu_7" id="remu_7" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_7" id="desc_7" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_7" id="no_remu_7" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Adicional Premio por Productividad" name="concepto_8" id="concepto_8" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='0' onchange="changeUnidades()" name="unidades_8" id="unidades_8" class="form-control unidad">
	            			<input type="hidden" value='1' name="base_8" id="base_8" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6></h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' name="remu_8" id="remu_8" class="form-control remuneracion" onchange="actualizaTotal()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_8" id="desc_8" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_8" id="no_remu_8" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Jubilación" name="concepto_9" id="concepto_9" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $concepto[2]["valor"] ?>' onchange="changeUnidades()" name="unidades_9" id="unidades_9" class="form-control unidad">
	            			<input type="hidden" value='<?php echo $concepto[2]["base"] ?>' name="base_9" id="base_9" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>%</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="remu_9" id="remu_9" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $descJubilacion ?>' name="desc_9" id="desc_9" class="form-control descuento" onchange="actualizaTotalDesc()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_9" id="no_remu_9" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Ley 19032" name="concepto_10" id="concepto_10" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $concepto[3]["valor"] ?>' onchange="changeUnidades()" name="unidades_10" id="unidades_10" class="form-control unidad">
	            			<input type="hidden" value='<?php echo $concepto[3]["base"] ?>' name="base_10" id="base_10" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>%</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="remu_10" id="remu_10" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $descLey19032 ?>' name="desc_10" id="desc_10" class="form-control descuento" onchange="actualizaTotalDesc()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_10" id="no_remu_10" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Obra Social" name="concepto_11" id="concepto_11" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $concepto[4]["valor"] ?>' onchange="changeUnidades()" name="unidades_11" id="unidades_11" class="form-control unidad">
	            			<input type="hidden" value='<?php echo $concepto[4]["base"] ?>' name="base_11" id="base_11" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>%</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="remu_11" id="remu_11" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $descObraSocial ?>' name="desc_11" id="desc_11" class="form-control descuento" onchange="actualizaTotalDesc()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_11" id="no_remu_11" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="A.E.C." name="concepto_12" id="concepto_12" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $concepto[5]["valor"] ?>' onchange="changeUnidades()" name="unidades_12" id="unidades_12" class="form-control unidad">
	            			<input type="hidden" value='<?php echo $concepto[5]["base"] ?>' name="base_12" id="base_12" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>%</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="remu_12" id="remu_12" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $descAEC ?>' name="desc_12" id="desc_12" class="form-control descuento" onchange="actualizaTotalDesc()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_12" id="no_remu_12" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="FAECyS" name="concepto_13" id="concepto_13" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $concepto[6]["valor"] ?>' onchange="changeUnidades()" name="unidades_13" id="unidades_13" class="form-control unidad">
	            			<input type="hidden" value='<?php echo $concepto[6]["base"] ?>' name="base_13" id="base_13" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6>%</h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="remu_13" id="remu_13" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $descFAECyS ?>' name="desc_13" id="desc_13" class="form-control descuento" onchange="actualizaTotalDesc()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_13" id="no_remu_13" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Obra Social Aporte Extraordinario O.S.E.C.A.C." name="concepto_14" id="concepto_14" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php echo $concepto[7]["base"] ?>' onchange="changeUnidades()" name="unidades_14" id="unidades_14" class="form-control unidad">
	            			<input type="hidden" value='1' name="base_14" id="base_14" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6></h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="remu_14" id="remu_14" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $descOSECAC ?>' name="desc_14" id="desc_14" class="form-control descuento" onchange="actualizaTotalDesc()" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="no_remu_14" id="no_remu_14" class="form-control" step="0.01">
	            		</div>
	            	</div>
	            	<div>
	            		<div class="col-md-4">
	            			<input type="text" value="Viáticos" name="concepto_15" id="concepto_15" class="form-control">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<input type="number" value='<?php if($viaticos>0){echo "1";}else{echo "0";} ?>' onchange="changeUnidades()" name="unidades_15" id="unidades_15" class="form-control unidad">
	            			<input type="hidden" value='1' name="base_15" id="base_15" class="form-control base">
	            		</div>
	            		<div class="col-md-1 col-xs-6">
	            			<h6></h6>
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="remu_15" id="remu_15" class="form-control" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='0' style="color: #eee;" readonly="" name="desc_15" id="desc_15" class="form-control descuento" step="0.01">
	            		</div>
	            		<div class="col-md-2">
	            			<input type="number" value='<?php echo $viaticos ?>' name="no_remu_15" id="no_remu_15" class="form-control" onchange="actualizaTotalNR()" step="0.01">
	            		</div>
	            	</div>
	            </div>
            	<div>
            		<div class="col-md-4">
            			<input type="text" readonly="" value="TOTALES" name="concepto_totales" id="concepto_totales" class="form-control bg-green">
            		</div>
            		<div class="col-md-2">
            			<input type="hidden" value='15' name="cant_totales" id="cant_totales" class="form-control bg-green" step="0.01">
            		</div>
            		<div class="col-md-2">
            			<input type="number" readonly="" value='<?php echo $subtotalACob ?>' name="remu_totales" id="remu_totales" class="form-control bg-green" step="0.01">
            		</div>
            		<div class="col-md-2">
            			<input type="number" readonly="" value='<?php echo $subtotalDesc ?>' name="desc_totales" id="desc_totales" class="form-control bg-green" step="0.01">
            		</div>
            		<div class="col-md-2">
            			<input type="number" readonly="" value='<?php echo $viaticos ?>' name="no_remu_totales" id="no_remu_totales" class="form-control bg-green" step="0.01">
            		</div>
            	</div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success pull-right">Guardar</button>
            </div>
        	</form>
          </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript" language="javascript" src='<?php echo $url_js; ?>'></script>