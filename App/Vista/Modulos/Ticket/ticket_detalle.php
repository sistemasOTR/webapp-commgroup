<?php
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";        

  $dFecha = new Fechas;

  $fticket = (isset($_GET["fticket"])?$_GET["fticket"]:'');    
  $fusuario= $usuarioActivoSesion->getId();

  $handler = new HandlerTickets;  
  $consulta = $handler->seleccionarById($fticket);

  $arrConceptos = $handler->selecionarConceptos();

  $url_action_actualizar = PATH_VISTA.'Modulos/Ticket/action_actualizar.php';
  $url_action_eliminar = PATH_VISTA.'Modulos/Ticket/action_eliminar.php?id=';
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Ticket
      <small>Gastos ocacionados por Gestor en los servicios</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Ticket</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>


    <div class="row">      
      <div class='col-md-8 col-md-offset-2'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-ticket"></i>  
              <h3 class="box-title">Ticket</h3>
              
             
            </div>
            <div class="box-body">
              <form action="<?php echo $url_action_actualizar; ?>" method="post" enctype="multipart/form-data">
              <div class="row">


            <?php foreach ($consulta as $key => $value) { ?>
              <div class="col-md-5">
                <label>Fecha Hora</label>
                <input type="datetime-local" name="fecha_hora" class="form-control" required="" value='<?php echo $value->getFechaHora()->format('Y-m-d\TH:i'); ?>'>
              </div>                            
              <div class="col-md-3">
                <label>Tipo Comprobante</label>
                <select class="form-control" name="tipo"  required="">
                  <option value="FACTURA B" <?php if (trim($value->getTipo()) == 'FACTURA B') {echo 'selected'; } ?>>FACTURA B</option>
                  <option value="TICKET FACTURA" <?php if (trim($value->getTipo()) == 'TICKET FACTURA') {echo 'selected'; } ?>>TICKET FACTURA</option>                  
                </select>
              </div>
              <div class="col-md-2">
                <label>Punto Vta</label>
                <input type="number" name="punto_venta" class="form-control"  required="" value='<?php echo intval($value->getPuntoVenta()); ?>'>
              </div>              
              <div class="col-md-2">
                <label>Numero</label>
                <input type="number" name="numero" class="form-control"  required="" value='<?php echo intval($value->getNumero()); ?>'>
              </div>               
              <div class="col-md-6">
                <label>Razon Social</label>
                <input type="text" name="razon_social" class="form-control"  required="" value='<?php echo trim($value->getRazonSocial()); ?>'>
                <input type="text" name="tipo_usuario" class="form-control" style="display: none;" required="" value='<?php echo $usuarioActivoSesion->getUsuarioPerfil()->getNombre(); ?>'>
                <input type="number" name="idTicket" class="form-control" style="display: none;" required="" value='<?php echo $value->getId(); ?>'>
              </div>
              <div class="col-md-6">
                <label>CUIT</label>
                <input type="text" name="cuit" class="form-control"  required="" value='<?php echo trim($value->getCuit()); ?>'>
              </div>  
              <div class="col-md-6">
                <label>Domicilio</label>
                <input type="text" name="domicilio" class="form-control"  required="" value='<?php echo trim($value->getDomicilio()); ?>'>
              </div>  
              <div class="col-md-6">
                <label>Condición Fiscal</label>
                <select class="form-control" name="condicion_fiscal"  required="">
                  <option value="RESPONSABLE INSCRIPTO" <?php if (trim($value->getCondFiscal()) == 'RESPONSABLE INSCRIPTO') {echo 'selected'; }?>>RESPONSABLE INSCRIPTO</option>
                  <option value="MONOTRIBUTISTA" <?php if (trim($value->getCondFiscal()) == 'MONOTRIBUTISTA') {echo 'selected'; }?>>MONOTRIBUTISTA</option>
                  <option value="EXCENTO" <?php if (trim($value->getCondFiscal()) == 'EXCENTO') {echo 'selected'; }?>>EXCENTO</option>
                  <option value="CONSUMIDOR FINAL" <?php if (trim($value->getCondFiscal()) == 'CONSUMIDOR FINAL') {echo 'selected'; }?>>CONSUMIDOR FINAL</option>
                </select>
              </div>  

              <div class="col-md-6">
                <label>Concepto</label>
                <select class="form-control" name="concepto" required="">
                  <option value=""></option>     
                  <?php if(!empty($arrConceptos)) { ?>
                    <?php foreach ($arrConceptos as $concepto) {
                      if($concepto->getNombre() == trim($value->getConcepto())) { ?>
                        <option value="<?php echo $concepto->getNombre(); ?>" selected><?php echo $concepto->getNombre(); ?></option>

                      <?php } else { ?>
                        <option value="<?php echo $concepto->getNombre(); ?>"><?php echo $concepto->getNombre(); ?></option>
                      <?php } ?>

                    <?php } ?>                  
                  <?php } ?>
                </select>
              </div>           

              <div class="col-md-6">
                <label>Importe</label>
                <input type="number" name="importe" class="form-control" step="0.01"  required="" value='<?php echo intval($value->getImporte()); ?>'>
              </div>   
              <div class="col-md-12">
                <label>Adjunto</label>
                <input type="text" name="adjActual" class="form-control" style="display: none;" required="" value='<?php echo $value->getAdjunto(); ?>'>
                <a href='<?php echo $value->getAdjunto(); ?>' target='_BLANK'> Ver Adjunto</a>
                <input type="file" name="adjunto" class="form-control">
              </div>
            <?php } ?> 
            </div>
            <hr>
            <div class="col-xs-12">
              <button type="button" onclick="history.back()" class="pull-left btn btn-default"><i class="ion-chevron-left"></i> Volver</button>
              <button type="submit" class="btn btn-primary pull-right">Guardar</button>
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
    $("#mnu_tickets").addClass("active");
  });
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