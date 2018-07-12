<?php
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";         
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";        

  $dFecha = new Fechas;

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->RestarDiasFechaActual(30));
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $user = $usuarioActivoSesion;
  $handlerSist = new HandlerSistema;
  $arrGestor = $handlerSist->selectAllGestor($user->getAliasUserSistema());

  $handler = new HandlerTickets;  
  $consulta = $handler->seleccionarByFiltros($fdesde,$fhasta,$fusuario,null);

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectTodos();

  $url_action_enviar = PATH_VISTA.'Modulos/Ticket/action_enviar.php?id=';  
  $url_action_noenviar = PATH_VISTA.'Modulos/Ticket/action_noenviar.php?id=';  
  $url_detalle = 'index.php?view=tickets_detalle&fticket=';  

  $url_retorno = 'view=tickets_control&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fusuario='.$fusuario;
?>
<style>
  .input-group {position: relative;display: block;border-collapse: separate;}
  .input-group-addon {background: #d2d6de !important;}
  @media (min-width: 768px){
    .input-group {position: relative;display: table;border-collapse: separate;}
  }
</style>

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

      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Filtros Disponibles</h3>
              <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <div class="box-body">
              <div class='row'>  
                <div class="col-md-3">
                    <label>Fecha Desde - Hasta</label>
                    <div class="input-group">
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $fdesde; ?>"/>
                      <span class="input-group-addon" >a</span>
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $fhasta; ?>"/>
                    </div>
                    
                </div>
                
                <div class="col-md-3">
                  <label>Usuarios </label>                
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php 
                        if(!empty($arrUsuarios)){
                          foreach ($arrUsuarios as $usuario) {
                            foreach ($arrGestor as $gestor) {
                              if($fgestorId == $usuario->getId() && $usuario->getUserSistema() == $gestor->GESTOR11_CODIGO)
                                  echo "<option value='".$usuario->getId()."' selected>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                                elseif ($usuario->getUserSistema() == $gestor->GESTOR11_CODIGO) {
                                  echo "<option value='".$usuario->getId()."'>".$usuario->getNombre()." ".$usuario->getApellido()."</option>";
                              }
                            }
                          } 
                        }
                      ?>
                  </select>
                </div>    
                
                <div class='col-md-3 col-md-offset-3'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
              </div>
            </div>
        </div>
      </div>      
      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-ticket"></i>  
              <h3 class="box-title">Ticket</h3>
            </div>
            <div class="box-body  table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>USUARIO</th>
                      <th>FECHA HORA</th>
                      <th>DOCUMENTO</th>
                      <th>RAZON SOCIAL</th>
                      <th>CUIT</th>
                      <th>DOMICILIO</th>
                      <th>COND.FISCAL</th>
                      <th>CONCEPTO</th>
                      <th>IMPORTE</th>                      
                      <th>REINT</th>                      
                      <th colspan="2">ALEDAÑO</th>          
                      <th width="30">OPER</th>
                      <th>ESTADO</th>
                      <th width="30">ADJ</th>
                      <th width='100' class="text-center">ACCION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if(!empty($consulta))
                      {
                        foreach ($consulta as $key => $value) {

                          $fechaT = $value->getFechaHora()->format('Y-m-d');
                          $usuarioSist = $value->getUsuarioId()->getUserSistema();
                          foreach ($arrGestor as $gestor) {
                              if($usuarioSist == $gestor->GESTOR11_CODIGO) {
                                  $seguir = true;
                                  break;
                              } else {
                                $seguir = false;
                              }
                            }
                            if ($seguir) {
                              $countServ = new HandlerSistema;
                              $cantServ = $countServ->selectCountServicios($fechaT, $fechaT, 100, null, $usuarioSist, null, null, null);
                              if($value->getUsuarioId()->getUsuarioPerfil()->getNombre()=="GESTOR")
                                {
                                $cpAt = $countServ->cpAtendidos($fechaT, $usuarioSist);
                                }
                              
                              $diaSemana=$value->getFechaHora()->format('N');
                              
                              $arrReintegro = $handler->selecionarReintegrosByDate($fechaT);
                              $class_estilos_aledanio = "<span class='label label-danger'>NO</span>";
                              $reintegro = 0;
                              $opAled = 0;
                              if ($value->getImporteReintegro() != 0 || $value->getAledanio()) {
                                $reintegro = number_format($value->getImporteReintegro(),2);
                                $opAled = $value->getAledanio();
                                if ($value->getAledanio()) {
                                  $class_estilos_aledanio = "<span class='label label-success'>SI</span>";
                                } else {
                                  $class_estilos_aledanio = "<span class='label label-danger'>NO</span>";
                                }
                              } else {
                                if (!empty($cpAt) && !empty($arrReintegro)) {
                                  foreach ($cpAt as $key => $cp) {
                                    foreach ($arrReintegro as $reintegroXCp) {
                                      if ($cp->CP != '' && $cp->CP == $reintegroXCp->getCp() && $reintegro < $reintegroXCp->getReintegro()){
                                        $reintegro =  number_format($reintegroXCp->getReintegro(),2);
                                        if ($reintegroXCp->getAled()) {
                                          $opAled = 1;
                                          $class_estilos_aledanio = "<span class='label label-success'>SI</span>";
                                        } else {
                                          $opAled = 0;
                                          $class_estilos_aledanio = "<span class='label label-danger'>NO</span>";
                                        }
                                      }
                                    }
                                  }
                                }
                              }
                                

                              if ($cantServ[0]->CANTIDAD_SERVICIOS < 5 || $diaSemana >=6) {
                                $reintegro = number_format($reintegro * 0.53 ,0);
                              }
                        
                              if ($reintegro > number_format($value->getImporte(),2) ) {
                                $reintegro = number_format($value->getImporte(),2);
                              }

                              $editar = "<a href='".$url_detalle.$value->getId()."' class='text-navi text-center' >
                                          <i class='fa fa-edit' data-toggle='tooltip' data-original-title='Deshace Envio'></i></a>";

                              if($value->getEnviado())
                                $class_estilos_enviado = "<a href='".$url_action_noenviar.$value->getId()."&url_redirect=".$url_retorno."' class='text-red text-center' >
                                          <i class='fa fa-refresh' data-toggle='tooltip' data-original-title='Deshace Envio'></i>
                                        </a>";
                              else
                                $class_estilos_enviado = "<a href='#' 
                                            id='boton_enviar_".$value->getId()."'                                             
                                            data-toggle='modal' 
                                            data-target='#modal-enviar' 
                                            data-reintegro='".number_format($reintegro,2)."' 
                                            data-aledanio='".$opAled."' 
                                            data-cant_operaciones='".number_format($cantServ[0]->CANTIDAD_SERVICIOS,2)."'     
                                            onclick=btnEnviar(".$value->getId().")
                                            class = 'text-blue text-center'>
                                              <i class='fa fa-send' data-toggle='tooltip' data-original-title='Enviar registro'></i>
                                          </a>";

                              if($value->getAprobado()){
                                $class_estilos_aprobado = "<span class='label label-success'>APROBADO</span>";
                                $class_estilos_enviado = '';
                                $editar = "";
                              }
                              elseif ($value->getRechazado()) {
                                $class_estilos_aprobado = "<span class='label label-danger' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='".trim(strip_tags($value->getObsRechazo()))."'> <i class='fa fa-search'></i> RECHAZADO</span>";
                                $editar = "<a href='".$url_detalle.$value->getId()."' class='text-black text-center' >
                                          <i class='fa fa-edit' data-toggle='tooltip' data-original-title='Editar Ticket'></i></a>";
                              } elseif (!$value->getAprobado() && $value->getEnviado()) {
                                $class_estilos_aprobado = "<span class='label label-warning'>EN ESPERA</span>";
                                $editar = "<a href='".$url_detalle.$value->getId()."' class='text-black text-center' >
                                          <i class='fa fa-edit' data-toggle='tooltip' data-original-title='Editar Ticket'></i></a>";
                              }
                              else {
                                $class_estilos_aprobado = "<span class='label label-primary'>SIN ENVIAR</span>";
                                $editar = "<a href='".$url_detalle.$value->getId()."' class='text-black text-center' >
                                          <i class='fa fa-edit' data-toggle='tooltip' data-original-title='Editar Ticket'></i></a>";
                              }
       
                              echo "<tr>";                            
                                echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                                echo "<td>".$value->getFechaHora()->format('d/m/Y h:s')."</td>";
                                echo "<td>".$value->getTipo()."   ".$value->getPuntoVenta()."-".$value->getNumero()."</td>";
                                echo "<td>".$value->getRazonSocial()."</td>";
                                echo "<td>".$value->getCuit()."</td>";
                                echo "<td>".$value->getDomicilio()."</td>";
                                echo "<td>".$value->getCondFiscal()."</td>";
                                echo "<td>".$value->getConcepto()."</td>";                            
                                echo "<td>$ ".number_format($value->getImporte(),2)."</td>";                          
                                echo "<td>$ ".$reintegro."</td>";
                                echo "<td class='text-center'>".$class_estilos_aledanio."</td>";
                                echo "<td class='text-center'>".$value->getAledNombre()."</td>";
                                echo "<td class='text-center'>".$cantServ[0]->CANTIDAD_SERVICIOS."</td>";
                                echo "<td class='text-center'>".$class_estilos_aprobado."</td>";
                                echo "<td class='text-center'><a href='".$value->getAdjunto()."' target='_blank'>VER</a></td>";
                                echo "<td class='text-center'>".$editar." ".$class_estilos_enviado."</td>";
                              echo "</tr>";
                            }
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

<div class="modal fade in" id="modal-enviar">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formEnviar" action="<?php echo $url_action_enviar; ?>" method="post">
        <input type="hidden" name="id" id="id" value=""> 
        <input type="hidden" name="url_redirect" value="<?php echo $url_retorno; ?>"> 

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Enviar</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="callout callout-info">
                  <h4>Envio de Ticket</h4>
                  <p id="mensaje_envio">Se enviará el ticket para aprobación.</p>
                </div>                
              </div>
              <div class="col-md-12">
                <div class="callout callout-warning">
                  <h4>Monto de reintegro</h4>
                  <p>Si la cantidad de operaciones es menor a 5, el sistema automáticamente reduce el monto a la mitad.</p>
                </div>                
              </div>
              <div class="col-md-3">
                <label>Importe Reintegro</label>
                <input type="number" name="reintegro" class="form-control" step="0.01"  required="">
              </div>
              <div class="col-md-6">
                <label>Nombre aledaño</label>
                <input type="text" name="aledNombre" class="form-control" step="0.01"  required="">
              </div>
              <div class="col-md-3">
                <label>Operaciones</label>
                <input id="input_cant_operaciones" type="number" name="operaciones" class="form-control" step="0.01"  required="" readonly="">
              </div>
              <div class="col-md-12">
                 <label>
                    <input type="checkbox" name="aledanio" style="margin-top: 20px;"> Es Aledaño
                  </label>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){                
    $("#mnu_tickets_control").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_tickets").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
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
      aStart = $("#start").val();
      aEnd = $("#end").val();

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      f_usuario = $("#slt_usuario").val();     
      
      url_filtro_reporte="index.php?view=tickets_control&fdesde="+aStart+"&fhasta="+aEnd;

      if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 
</script>


<script type="text/javascript">
    function btnEnviar(id_registro)
    {
        var id= id_registro;        
    
        var elemento = document.querySelector('#boton_enviar_'+id);        
        formEnviar.id.value = id;   

        var reintegro= elemento.getAttribute('data-reintegro');     
        var aledanio = elemento.getAttribute('data-aledanio');     
        var cant_operaciones = elemento.getAttribute('data-cant_operaciones');     
        
        formEnviar.reintegro.value = reintegro;

        if(aledanio==true)
          formEnviar.aledanio.checked = true;
        else
          formEnviar.aledanio.checked = false;

        formEnviar.operaciones.value = cant_operaciones;   

        //var mensaje_envio="<p>Esta a punto de enviar el ticket<br>¿Desea Continuar?</p>";
        //document.getElementById('mensaje_envio').innerHTML = mensaje_envio;      
    }

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