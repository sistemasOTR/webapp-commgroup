<?php
  include_once PATH_NEGOCIO."Modulos/handleragenda.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     

  $fusuario= $usuarioActivoSesion->getId();
  $frubro=(isset($_GET["frubro"])?$_GET["frubro"]:0);
  $handlerAg = new HandlerAgenda;
  $arrEmpresas = $handlerAg->selectEmpresaByRubro($frubro);
  $arrRubros = $handlerAg->selectAllRubros();
  $arrAcciones = $handlerAg->selectAllAcciones();

  $url_action_guardar = PATH_VISTA.'Modulos/Agenda/action_guardar.php';
  $url_action_accion = PATH_VISTA.'Modulos/Agenda/action_accion.php';
  $url_action_eliminar = PATH_VISTA.'Modulos/Agenda/action_eliminar.php?id=';

   $url_detalle_empresa = "index.php?view=agenda_detalle";
   $url_retorno = "view=agenda";
?>
<style>

  td::before {
    content: attr(data-th);
    font-weight: bold;
    color: #a1a1a1;
    display: inline;
    font-size: 12px;
    text-transform: uppercase;
  }
  tr::before {
    content: attr(data-th);
    font-weight: bold;
    color: #fff;
    display: block;
    font-size: 14px;
    text-transform: uppercase;
    background: #555;
    width: 100% !important;
    padding-left: 5px
  }
  @media (min-width:768px){
    td::before{display: none;}
    tr::before{display: none;}
  }
  @media only screen and (max-width: 767px){
    td {display: block !important;width: auto;}
  }
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Agenda
      <small>Listado de empresas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Agenda</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">
      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-book pull-left" ></i>  
              <h3 class="box-title col-md-3">Listado de Empresas</h3>
              <div class="col-md-3">
                <label>Rubro</label>
                <select id="slt_rubro" class="form-control" style="width: 100%" name="slt_rubro">
                  <option value="">Seleccionar...</option>
                  <option value='0'>TODAS</option>
                    <?php 
                    if (!empty($arrRubros)) {
                      foreach ($arrRubros as $key => $value) {
                        if($frubro==$value->getId())
                          echo "<option value='".$value->getId()."' selected>".$value->getNombre()."</option>";
                        else
                          echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-3">
                <label>Empresa</label>
                <select id="slt_empresa" class="form-control" style="width: 100%" name="slt_empresa">
                  <option value="">Seleccionar...</option>
                  <option value='0'>TODAS</option>
                    <?php 
                    if (!empty($arrEmpresas)) {
                      foreach ($arrEmpresas as $key => $value) {
                        echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                      }
                    }
                  ?>
                </select>
              </div>
              <div class='col-md-2' style="display: none;">                
                <label></label>                
                <?php 
                echo "<a class='btn btn-block btn-success' id='filtro_reporte' onclick='crearHref()'><i class='fa fa-filter'></i> Filtrar</a>";
                ?>                  
              </div>
              <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nuevo'>
                  Nueva
              </a>
            </div>
            
        </div>
      </div>

    <?php 
    // var_dump($arrEmpresas);
    // exit();
        if(!empty($arrEmpresas))
        {
          foreach ($arrEmpresas as $key => $value) { 
            $rubro = $handlerAg->selectRubroById($value->getRubro());

            ?>

            <div class="col-xs-12">
              <div class="box box-solid">
                <div class="box-header with-border bg-teal">  
                  <h3 class="box-title"><?php echo $value->getNombre() ?></h3>
                  <a href="#" style="margin-left: 10px;margin-right: 5px;" id='<?php echo $value->getId()."_meet"; ?>' data-empresa='<?php echo $value->getId() ?>' data-cont1='<?php echo $value->getPerContacto1() ?>' data-cont2='<?php echo $value->getPerContacto2() ?>' data-tipo='Reunion' onclick="reunion(<?php echo $value->getId(); ?>)" class="btn btn-danger pull-right" data-toggle='modal' data-target='#modal-accion'><i class='fa fa-coffee'></i></a> 
                  <a href="#" style="margin-left: 10px;margin-right: 5px;" id='<?php echo $value->getId()."_mail"; ?>' data-empresa='<?php echo $value->getId() ?>' data-cont1='<?php echo $value->getPerContacto1() ?>' data-cont2='<?php echo $value->getPerContacto2() ?>' data-tipo='Correo'  onclick="correo(<?php echo $value->getId(); ?>)" class="btn btn-warning pull-right" data-toggle='modal' data-target='#modal-accion'><i class='fa fa-envelope'></i></a> 
                  <a href="#" style="margin-left: 10px;margin-right: 5px;" id='<?php echo $value->getId()."_call"; ?>' data-empresa='<?php echo $value->getId() ?>' data-cont1='<?php echo $value->getPerContacto1() ?>' data-cont2='<?php echo $value->getPerContacto2() ?>' data-tipo='Llamada' class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-accion' onclick="llamada(<?php echo $value->getId(); ?>)"><i class='fa fa-phone'></i></a>
                  <a href='<?php echo $url_detalle_empresa."&fid=".$value->getId() ?>' style="margin-left: 10px;margin-right: 5px;" class="btn btn-primary pull-right"><i class='fa fa-eye'></i></a> 
                </div>
                <div class="box-body">
                  <div class="col-md-4">
                    <table class="table-condensed table" border="0" style="margin-bottom: 20px;" width="100%">
                      <thead class="hidden-xs">
                        <tr>
                          <th>Rubro</th>
                          <th>Domicilio</th>
                          <th>Web</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr data-th='DATOS DE LA EMPRESA'>
                          <td width="200" data-th='Rubro: '><?php echo $rubro->getNombre(); ?></td>
                          <td width="200" data-th='Domicilio: '><?php echo $value->getDomicilio(); ?></td>
                          <td width="200" data-th='Web: '><?php echo $value->getWeb(); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-7">
                    <table class="table table-condensed" border="0" width="100%">
                      <thead class="hidden-xs">
                        <tr>
                          <th width="25%">Nombre</th>
                          <th width="25%">Puesto</th>
                          <th width="25%">Teléfono</th>
                          <th width="25%">E-mail</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr data-th='CONTACTO Principal'>
                          <td data-th='Nombre: '><?php echo $value->getPerContacto1(); ?></td>
                          <td data-th='Puesto: '><?php echo $value->getPuesto1(); ?></td>
                          <td data-th='Teléfono: '><?php echo $value->getTelefono1(); ?></td>
                          <td data-th='E-mail: '><?php echo $value->getEmail1(); ?></td>
                        </tr>
                        <tr data-th='CONTACTO Alternativo'>
                          <td data-th='Nombre: '><?php echo $value->getPerContacto2(); ?></td>
                          <td data-th='Puesto: '><?php echo $value->getPuesto2(); ?></td>
                          <td data-th='Teléfono: '><?php echo $value->getTelefono2(); ?></td>
                          <td data-th='E-mail: '><?php echo $value->getEmail2(); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-1">
                    
                  </div>
                </div>
              </div>
              
            </div>
            
        <?php
          }
        }
      ?>





    </div>
  </section>
</div>

<div class="modal fade in" id="modal-nuevo">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_guardar; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header bg-teal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nueva Empresa</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-xs-12" style="border-bottom: 1px solid #eee;margin-bottom:10px;">
                <h4>Datos de la Empresa</h4>
              </div>                          
              <div class="col-md-6">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control"  required="">
                <input type="text" name="tipo_usuario" class="form-control" style="display: none;" required="" value='<?php echo $usuarioActivoSesion->getUsuarioPerfil()->getNombre(); ?>'>
              </div>
              <div class="col-md-6">
                <label>Rubro</label>
                <select class="form-control" name="rubro" required="">
                  <option value=""></option>     
                  <?php if(!empty($arrRubros)) { ?>
                    <?php foreach ($arrRubros as $key => $value) { ?>
                      <option value="<?php echo $value->getId(); ?>"><?php echo $value->getNombre(); ?></option>
                    <?php } ?>                  
                  <?php } ?>
                </select>
              </div>   
              <div class="col-md-6">
                <label>Domicilio</label>
                <input type="text" name="domicilio" class="form-control"  required="">
              </div>   
              <div class="col-md-6">
                <label>Web</label>
                <input type="text" name="web" class="form-control"  required="">
              </div>
              <div class="col-xs-12" style="border-bottom: 1px solid #eee;margin-bottom:10px;">
                <h4>Contacto Principal</h4>
              </div>
              <div class="col-md-6">
                <label>Nombre</label>
                <input type="text" name="per_contacto_1" class="form-control"  required="">
              </div>
              <div class="col-md-6">
                <label>Puesto</label>
                <input type="text" name="puesto_1" class="form-control"  required="">
              </div>
              <div class="col-md-6">
                <label>Telefono</label>
                <input type="text" name="telefono_1" class="form-control"  required="">
              </div>
              <div class="col-md-6">
                <label>Correo</label>
                <input type="email" name="email_1" class="form-control"  required="">
              </div>
              <div class="col-xs-12" style="border-bottom: 1px solid #eee;margin-bottom:10px;">
                <h4>Contacto Alternativo</h4>
              </div>
              <div class="col-md-6">
                <label>Nombre</label>
                <input type="text" name="per_contacto_2" class="form-control">
              </div>
              <div class="col-md-6">
                <label>Puesto</label>
                <input type="text" name="puesto_2" class="form-control">
              </div>
              <div class="col-md-6">
                <label>Telefono</label>
                <input type="text" name="telefono_2" class="form-control">
              </div>
              <div class="col-md-6">
                <label>Correo</label>
                <input type="email" name="email_2" class="form-control">
              </div>
               
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>
<div class="modal fade in" id="modal-accion">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_accion; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="<?php echo $fusuario; ?>">

        <div class="modal-header bg-teal">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="modal_title">Contactar</h4>
        </div>
        <div class="modal-body">
            <div class="row">
            	<div class="col-xs-12">
            		<input type="number" style="display: none;" name="usuario" class="form-control" required="" value='<?php echo $fusuario; ?>'>
	            	<input type="number" style="display: none;" name="empresa" id="empresa" class="form-control"  required="">
	            	<input type="text" style="display: none;" name="tipo" id="tipo" class="form-control"  required="">
                <input type="text" style="display: none;" name="url_retorno" id="url_retorno" class="form-control" value='<?php echo $url_retorno ?>' required="">

	                <label>Contacto</label>
	                <select class="form-control" name="contacto" id="slt_contacto" required=""></select>
	                <br>
	                <label>Observaciones</label>
	                <textarea class="form-control" name="obs" id="obs" required="" rows="7"></textarea>
            	</div>
            	
              
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){                
    $("#mnu_agenda").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_agenda_inicio").addClass("active");
  });

  function llamada(id) {
    id_emp = document.getElementById(id+'_call').getAttribute('data-empresa');
    tipo = document.getElementById(id+'_call').getAttribute('data-tipo');
    contacto1 = document.getElementById(id+'_call').getAttribute('data-cont1');
    contacto2 = document.getElementById(id+'_call').getAttribute('data-cont2');

  document.getElementById("empresa").value = id_emp;
  document.getElementById("tipo").value = tipo;
  var selContacto = document.getElementById("slt_contacto");
  while (selContacto.options.length) {
        selContacto.remove(0);
    }
  var option1 = document.createElement("option");
  var option2 = document.createElement("option");
  option1.text = contacto1;
  option1.value = 'Principal';
    option2.text = contacto2;
    option2.value = 'Alternativo';
  selContacto.add(option1,selContacto[1]);
  selContacto.add(option2,selContacto[2]);
    

  }

  function reunion(id) {
  	id_emp = document.getElementById(id+'_meet').getAttribute('data-empresa');
  	tipo = document.getElementById(id+'_meet').getAttribute('data-tipo');
  	contacto1 = document.getElementById(id+'_meet').getAttribute('data-cont1');
  	contacto2 = document.getElementById(id+'_meet').getAttribute('data-cont2');

	document.getElementById("empresa").value = id_emp;
	document.getElementById("tipo").value = tipo;
	var selContacto = document.getElementById("slt_contacto");
	while (selContacto.options.length) {
        selContacto.remove(0);
    }
	var option1 = document.createElement("option");
	var option2 = document.createElement("option");
	option1.text = contacto1;
	option1.value = 'Principal';
    option2.text = contacto2;
    option2.value = 'Alternativo';
	selContacto.add(option1,selContacto[1]);
	selContacto.add(option2,selContacto[2]);
    

  }

  function correo(id) {
  	id_emp = document.getElementById(id+'_mail').getAttribute('data-empresa');
  	tipo = document.getElementById(id+'_mail').getAttribute('data-tipo');
  	contacto1 = document.getElementById(id+'_mail').getAttribute('data-cont1');
  	contacto2 = document.getElementById(id+'_mail').getAttribute('data-cont2');

	document.getElementById("empresa").value = id_emp;
	document.getElementById("tipo").value = tipo;
	var selContacto = document.getElementById("slt_contacto");
	while (selContacto.options.length) {
        selContacto.remove(0);
    }
	var option1 = document.createElement("option");
	var option2 = document.createElement("option");
	option1.text = contacto1;
	option1.value = contacto1;
    option2.text = contacto2;
    option2.value = contacto2;
	selContacto.add(option1,selContacto[1]);
	selContacto.add(option2,selContacto[2]);
    

  }
</script>
<script type="text/javascript"> 
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
</script>
<script type="text/javascript">


  $(document).ready(function() {
    $("#slt_rubro").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte(); 
    });
  });

  function crearHref()
  {
    f_rubro = $("#slt_rubro").val();
    url_filtro_reporte="index.php?view=agenda&frubro="+f_rubro;
    $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

  $(document).ready(function() {
    $("#slt_empresa").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      verEmpresa(); 
    });
  });

  function crearlink()
  {
    f_empresa = $("#slt_empresa").val();
    url_filtro_reporte="index.php?view=agenda_detalle&fid="+f_empresa;
    $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function verEmpresa()
  {
    crearlink();
    window.location = $("#filtro_reporte").attr("href");
  }


</script>