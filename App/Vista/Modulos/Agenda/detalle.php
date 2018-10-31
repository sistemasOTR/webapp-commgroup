<?php
  include_once PATH_NEGOCIO."Modulos/handleragenda.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     

  $fusuario= $usuarioActivoSesion->getId();
  $handlerUs = new HandlerUsuarios;
  $handlerAg = new HandlerAgenda;
  $handlePlazas = new HandlerPlazaUsuarios;
  $arrPlazas = $handlePlazas->selectAll();
  $empresaId = (isset($_GET["fid"])?$_GET["fid"]:0);
  $datosEmpresa = $handlerAg->selectEmpresaById($empresaId);
  $rubro = $handlerAg->selectRubroById($datosEmpresa->getRubro());
  $arrRubros = $handlerAg->selectAllRubros();
  $arrDatos = $handlerAg->historicoEmpresa($empresaId);
  $arrEstados = $handlerAg->selectEstados();

  $url_action_guardar = PATH_VISTA.'Modulos/Agenda/action_actualizar.php';
  $url_action_accion = PATH_VISTA.'Modulos/Agenda/action_accion.php';
  $url_retorno = "view=agenda_detalle&fid=".$empresaId;
?>
<style>

  .desc {font-size: 16px;font-weight: bold;color: #a1a1a1;display: inline;text-transform: uppercase;}
  .deta {font-size: 14px; padding-left: 10px;}
  .acordeon {background: #555;}
  .acordeon a {color: white !important;}
  .acordeon a:hover {color: white !important;background: transparent;}
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Agenda
      <small>Detalles de la Empresa</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Agenda</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>
    <?php 
      if (!is_null($datosEmpresa->getPlaza())) {
        $plazaEmp = $handlePlazas->selectById($datosEmpresa->getPlaza());
        $plazaId = $plazaEmp->getId();
        $nombrePlaza = $plazaEmp->getNombre();
      } else {
        $nombrePlaza = 'No definida';
        $plazaId = 0;
      }
      if (!is_null($datosEmpresa->getInstancia())) {
        $estadoEmp = $handlerAg->selectEstadoById($datosEmpresa->getInstancia());
        $instanciaEmp = $estadoEmp[""]->getNombre();
        $claseInstanciaEmp = "class='".$estadoEmp[""]->getColor()."'";

      } else {
        $instanciaEmp = "";
        $claseInstanciaEmp = "";
      }
      
      
     ?>

    <div class="row">
      <div class='col-md-3'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-book"></i>  
              <h3 class="box-title"><?php echo $datosEmpresa->getNombre(); ?><br><span style="font-size: 9pt;margin-top: 5px;" <?php echo $claseInstanciaEmp; ?>><?php echo $instanciaEmp; ?></span></h3>
              <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nuevo'>
                  Editar
              </a>

            </div>
            <div class="box-body">
              <p class="desc">Rubro</p>
              <p class='deta'><?php echo $rubro->getNombre(); ?></p>
              <p class="desc">Domicilio</p>
              <p class='deta'><?php echo $datosEmpresa->getDomicilio(); ?></p>
              <p class="desc">Localidad</p>
              <p class='deta'><?php echo $nombrePlaza; ?></p>
              <p class="desc">Página Web</p>
              <p class='deta'><a href="<?php echo $datosEmpresa->getWeb(); ?>" target="_blank"><?php echo $datosEmpresa->getWeb(); ?></a></p>
              <div class="box-group" id="accordion">
                <div class="panel box box-solid">
                  <div class="box-header with-border acordeon">
                    <h3 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Contacto Principal
                      </a>
                    </h3>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
                      <p class="desc">Nombre</p>
                      <p class='deta'><?php echo $datosEmpresa->getPerContacto1(); ?></p>
                      <p class="desc">Puesto</p>
                      <p class='deta'><?php echo $datosEmpresa->getPuesto1(); ?></p>
                      <p class="desc">Teléfono</p>
                      <p class='deta'><?php echo $datosEmpresa->getTelefono1(); ?></p>
                      <p class="desc">Correo</p>
                      <p class='deta'><?php echo $datosEmpresa->getEmail1(); ?></p>
                    </div>
                  </div>
                </div>
                <div class="panel box box-solid">
                  <div class="box-header with-border acordeon">
                    <h3 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Contacto Alternativo
                      </a>
                    </h3>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
                      <p class="desc">Nombre</p>
                      <p class='deta'><?php echo $datosEmpresa->getPerContacto2(); ?></p>
                      <p class="desc">Puesto</p>
                      <p class='deta'><?php echo $datosEmpresa->getPuesto2(); ?></p>
                      <p class="desc">Teléfono</p>
                      <p class='deta'><?php echo $datosEmpresa->getTelefono2(); ?></p>
                      <p class="desc">Correo</p>
                      <p class='deta'><?php echo $datosEmpresa->getEmail2(); ?></p>
                    </div>
                  </div>
                </div>
              </div><br>
            <a href="index.php?view=agenda" class="pull-left btn btn-default"><i class="ion-chevron-left"></i> Volver</a>
            </div>
            
        </div>
      </div>
      <div class='col-md-9'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-book"></i>  
              <h3 class="box-title">Histórico de contactos</h3>
              <a href="#" style="margin-left: 10px;margin-right: 5px;" id='<?php echo $datosEmpresa->getId()."_meet"; ?>' data-tipo='Reunion'  onclick="reunion(<?php echo $datosEmpresa->getId(); ?>)" class="btn btn-danger pull-right" data-toggle='modal' data-target='#modal-accion'><i class='fa fa-coffee'></i></a> 
              <a href="#" style="margin-left: 10px;margin-right: 5px;" id='<?php echo $datosEmpresa->getId()."_mail"; ?>' data-tipo='Correo'  onclick="correo(<?php echo $datosEmpresa->getId(); ?>)" class="btn btn-warning pull-right" data-toggle='modal' data-target='#modal-accion'><i class='fa fa-envelope'></i></a> 
              <a href="#" style="margin-left: 10px;margin-right: 5px;" id='<?php echo $datosEmpresa->getId()."_call"; ?>' data-tipo='Llamada' class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-accion' onclick="llamada(<?php echo $datosEmpresa->getId(); ?>)"><i class='fa fa-phone'></i></a>
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla-entregas" cellspacing="0" width="100%" style="text-align:center;">
                <thead>
                  <tr>
                  	<th></th>
                    <th class='text-center' width="100">FECHA</th>
                    <th class='text-center' width="60">HORA</th>
                    <th class='text-center' width="200">CONTACTO</th>
                    <th class='text-center' width="200">USUARIO</th>
                    <th class='text-center' width="100">ESTADO</th>
                    <th>OBSERVACIONES</th>
                  </tr>
                </thead>

                <tbody>
                <?php    
                  if(!empty($arrDatos)){
                    foreach ($arrDatos as $key => $value) {
                      $user = $handlerUs->selectById($value->getUsuarioId());

                      if (!is_null($value->getInstancia())) {
                        $estadoHist = $handlerAg->selectEstadoById($value->getInstancia());
                        $instancia = $estadoHist[""]->getNombre();
                        $claseInstancia = "class='badge ".$estadoHist[""]->getColor()."'";
                      } else {
                        $instancia = "";
                        $claseInstancia = "";
                      }
                      

                      if ($value->getTipoId()=='Llamada') {
                      	$identificador = '<i class="fa fa-phone text-green"></i>';
                      } elseif ($value->getTipoId()=='Reunion') {
                      	$identificador = '<i class="fa fa-coffee text-red"></i>';
                      } elseif ($value->getTipoId()=='Correo') {
                      	$identificador = '<i class="fa fa-envelope text-yellow"></i>';
                      }
                      echo "<tr>";
                      echo "<td>".$identificador."</td>";
                      echo "<td>".$value->getFechaHora()->format('d-m-Y')."</td>";
                      echo "<td>".$value->getFechaHora()->format('H:i')."</td>";
                      echo "<td>".$value->getContacto()."</td>";
                      echo "<td>".$user->getNombre()." ".$user->getApellido()."</td>";
                      echo "<td ".$claseInstancia.">".$instancia."</td>";
                      echo "<td style='text-align:left;'>".$value->getObs()."</td>";
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
<div class="modal fade in" id="modal-nuevo">
  <div class="modal-dialog" style="width: 90vw;">
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
              <div class="col-md-3">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control"  required="" value='<?php echo $datosEmpresa->getNombre(); ?>'>
                <input type="number" name="id" class="form-control" style="display: none;" required="" value='<?php echo $datosEmpresa->getId(); ?>'>
              </div>
              <div class="col-md-3">
                <label>Rubro</label>
                <select class="form-control" name="rubro" required="">
                  <option value=""></option>     
                  <?php if(!empty($arrRubros)) { ?>
                    <?php foreach ($arrRubros as $key => $value) { 
                      if ($value->getId() == $rubro->getId()) {?>
                        <option value="<?php echo $value->getId(); ?>" selected><?php echo $value->getNombre(); ?></option>
                      <?php } else { ?>
                        <option value="<?php echo $value->getId(); ?>"><?php echo $value->getNombre(); ?></option>
                    <?php }
                      } 
                     } ?>
                </select>
              </div>   
              <div class="col-md-3">
                <label>Domicilio</label>
                <input type="text" name="domicilio" class="form-control"  required="" value='<?php echo $datosEmpresa->getDomicilio(); ?>'>
              </div>   
              <div class="col-md-3">
                <label>Web</label>
                <input type="text" name="web" class="form-control"  required=""  value='<?php echo $datosEmpresa->getWeb(); ?>'>
              </div>
              <div class="col-xs-12" style="border-bottom: 1px solid #eee;margin-bottom:10px;">
                <h4>Contacto Principal</h4>
              </div>
              <div class="col-md-3">
                <label>Nombre</label>
                <input type="text" name="per_contacto_1" class="form-control"  required=""  value='<?php echo $datosEmpresa->getPerContacto1(); ?>'>
              </div>
              <div class="col-md-3">
                <label>Puesto</label>
                <input type="text" name="puesto_1" class="form-control"  required=""  value='<?php echo $datosEmpresa->getPuesto1(); ?>'>
              </div>
              <div class="col-md-3">
                <label>Telefono</label>
                <input type="text" name="telefono_1" class="form-control"  required=""  value='<?php echo $datosEmpresa->getTelefono1(); ?>'>
              </div>
              <div class="col-md-3">
                <label>Correo</label>
                <input type="email" name="email_1" class="form-control"  required=""  value='<?php echo $datosEmpresa->getEmail1(); ?>'>
              </div>
              <div class="col-xs-12" style="border-bottom: 1px solid #eee;margin-bottom:10px;">
                <h4>Contacto Alternativo</h4>
              </div>
              <div class="col-md-3">
                <label>Nombre</label>
                <input type="text" name="per_contacto_2" class="form-control"  value='<?php echo $datosEmpresa->getPerContacto2(); ?>'>
              </div>
              <div class="col-md-3">
                <label>Puesto</label>
                <input type="text" name="puesto_2" class="form-control"  value='<?php echo $datosEmpresa->getPuesto2(); ?>'>
              </div>
              <div class="col-md-3">
                <label>Telefono</label>
                <input type="text" name="telefono_2" class="form-control" value='<?php echo $datosEmpresa->getTelefono2(); ?>'>
              </div>
              <div class="col-md-3">
                <label>Correo</label>
                <input type="email" name="email_2" class="form-control" value='<?php echo $datosEmpresa->getEmail2(); ?>'>
              </div>
              <div class="col-md-6">
                <label>Plaza</label>
                <select name="plaza" id="plaza" class="form-control">
                  <option value="0">No definida</option>
                  <?php 
                    if (!empty($arrPlazas)) {
                      foreach ($arrPlazas as $plaza) {
                        if ($plaza->getTipo() == 0) {
                          if ($plaza->getId() == $plazaId) {
                           echo "<option value='".$plaza->getId()."' selected>".$plaza->getNombre()."</option>";
                          } else {
                            echo "<option value='".$plaza->getId()."'>".$plaza->getNombre()."</option>";
                          }
                          
                        }
                        
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-6" style="/*display: none;*/">
                <label>Estado</label>
                <select name="instancia" id="instancia" class="form-control">
                  <?php 
                    if (!empty($arrEstados)) {
                      foreach ($arrEstados as $est) {
                        if ($est->getId() == $estadoEmp[""]->getId()) {
                          echo "<option style='font-size:12pt;font-weight:100;' class='".$est->getColor()."' value='".$est->getId()."' selected>".$est->getNombre()."</option>";
                        } else {
                          echo "<option style='font-size:12pt;font-weight:100;' class='".$est->getColor()."' value='".$est->getId()."'>".$est->getNombre()."</option>";
                        }
                        
                      }
                    }
                  ?>
                </select>
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
	            	<input type="number" style="display: none;" name="empresa" id="empresa" class="form-control" value='<?php echo $datosEmpresa->getId(); ?>' required="">
                <input type="text" style="display: none;" name="tipo" id="tipo" class="form-control"  required="">
	            	<input type="text" style="display: none;" name="url_retorno" id="url_retorno" class="form-control" value='<?php echo $url_retorno ?>' required="">

	                <label>Contacto</label>
	                <select class="form-control" name="contacto" id="slt_contacto" required="">
                   <option value="Principal"><?php echo $datosEmpresa->getPerContacto1() ?></option> 
                   <option value="Alternativo"><?php echo $datosEmpresa->getPerContacto2() ?></option> 
                  </select>
                  <br>
                  <label>Estado</label>
                  <select name="instancia" id="instancia_accion" class="form-control">
                    <?php 
                      if (!empty($arrEstados)) {
                        foreach ($arrEstados as $est) {
                          if ($est->getId() == $estadoEmp[""]->getId()) {
                          echo "<option style='font-size:12pt;font-weight:100;' class='".$est->getColor()."' value='".$est->getId()."' selected>".$est->getNombre()."</option>";
                        } else {
                          echo "<option style='font-size:12pt;font-weight:100;' class='".$est->getColor()."' value='".$est->getId()."'>".$est->getNombre()."</option>";
                        }
                        }
                      }
                    ?>
                  </select>
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
    tipo = document.getElementById(id+'_call').getAttribute('data-tipo');
    
  document.getElementById("tipo").value = tipo;
  }

  function reunion(id) {
  	tipo = document.getElementById(id+'_meet').getAttribute('data-tipo');
  	
	document.getElementById("tipo").value = tipo;
  }

  function correo(id) {
  	tipo = document.getElementById(id+'_mail').getAttribute('data-tipo');
	document.getElementById("tipo").value = tipo;
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
  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aEnd = $("#end").val().split('/');

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      //f_usuario = $("#slt_usuario").val();     
      
      url_filtro_reporte="index.php?view=tickets_carga&fdesde="+f_inicio+"&fhasta="+f_fin  

      /*if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;
      */
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 
</script>