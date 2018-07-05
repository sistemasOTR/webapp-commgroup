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
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');

  $handler = new HandlerTickets;  
  $consulta = $handler->seleccionarByFiltrosAprobacion($fdesde,$fhasta,$fusuario);

  $handlerSist = new HandlerSistema;
  $arrGestor = $handlerSist->selectAllGestor($fplaza);
  $arrCoordinador = $handlerSist->selectAllPlazasArray();

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectTodos();

  $url_action_aprobar = PATH_VISTA.'Modulos/Ticket/action_aprobar.php?id=';  
  $url_action_desaprobar = PATH_VISTA.'Modulos/Ticket/action_desaprobar.php?id=';  
  $url_action_rechazar = PATH_VISTA.'Modulos/Ticket/action_rechazar.php';  
  $url_detalle = 'index.php?view=tickets_detalle&fticket=';   

  $url_retorno = "view=tickets_aprobar&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario;
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
                <label>Plazas</label>
                <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" onchange="crearHref()">                              
                  <option value="">Seleccionar...</option>
                  <option value='0'>TODAS</option>
                  <?php
                    if(!empty($arrCoordinador))
                    {                        
                      foreach ($arrCoordinador as $coord) {                                                  
                        if($fplaza==$coord['PLAZA'])
                          echo "<option value='".trim($coord['PLAZA'])."' selected>".$coord['PLAZA']."</option>";
                        else
                          echo "<option value='".trim($coord['PLAZA'])."'>".$coord['PLAZA']."</option>";
                      }
                    }
                  ?>
                </select>
              </div>
                
                <div class="col-md-3">
                  <label>Usuarios </label>               
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrUsuarios)){
                        if ($fplaza != '') {

                          foreach ($arrUsuarios as $user) {

                            foreach ($arrGestor as $gestor) {
                              if($fusuario == $user->getId() && $user->getUserSistema() == $gestor->GESTOR11_CODIGO && $user->getTipoUsuario()->getNombre()!= 'Empresa'){
                                echo "<option value='".$user->getId()."' selected>".$user->getNombre()." ".$user->getApellido()."</option>";
                              } elseif ($user->getUserSistema() == $gestor->GESTOR11_CODIGO && $user->getTipoUsuario()->getNombre()!= 'Empresa') {
                                echo "<option value='".$user->getId()."'>".$user->getNombre()." ".$user->getApellido()."</option>";
                                }
                              }
                            }
                        } else {
                          foreach ($arrUsuarios as $user) {
                            if($fusuario == $user->getId() && $user->getTipoUsuario() != 1)
                                echo "<option value='".$user->getId()."' selected>".$user->getNombre()." ".$user->getApellido()."</option>";
                              elseif($user->getTipoUsuario() != 1)
                                echo "<option value='".$user->getId()."'>".$user->getNombre()." ".$user->getApellido()."</option>";                  
                                
                            }
                          }
                        }
                                 
                    ?>
                  </select>
                </div>    
                

                <div class='col-md-3'>                
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
            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>USUARIO</th>
                      <th>FECHA HORA</th>
                      <th>DOCUMENTO</th>
                      <th>RAZON SOCIAL</th>
                      <th>CUIT</th>
                      <th>ING.BRUTOS</th>
                      <th>DOMICILIO</th>
                      <th>COND.FISCAL</th>
                      <th>CONCEPTO</th>
                      <th>IMPORTE</th>                      
                      <th>REINT</th>                      
                      <th colspan="2">ALED</th>                      
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
                          if($value->getAprobado())
                            $class_estilos_aprobado = "<span class='label label-success'>APROBADO</span>";
                          else
                            $class_estilos_aprobado = "<span class='label label-danger'>NO APROBADO</span>";

                          if($value->getAledanio())
                            $class_estilos_aledanio = "<span class='label label-success'>SI</span>";
                          else
                            $class_estilos_aledanio = "<span class='label label-danger'>NO</span>";

                          $fechaT = $value->getFechaHora()->format('Y-m-d');
                          $usuarioSist = $value->getUsuarioId()->getUserSistema();
                          if($fplaza != '' || $fplaza != 0){
                            foreach ($arrGestor as $gestor) {
                                if($usuarioSist == $gestor->GESTOR11_CODIGO) {
                                    $seguir = true;
                                    break;
                                } else {
                                  $seguir = false;
                                }
                              }
                            } else {
                              $seguir = true;
                            }
                            
                            if ($seguir) {
                              $countServ = new HandlerSistema;
                              $cantServ = $countServ->selectCountServicios($fechaT, $fechaT, 100, null, $usuarioSist, null, null, null);  

                              echo "<tr>";                            
                                echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                                echo "<td>".$value->getFechaHora()->format('d/m/Y h:s')."</td>";
                                echo "<td>".$value->getTipo()."   ".$value->getPuntoVenta()."-".$value->getNumero()."</td>";
                                echo "<td>".$value->getRazonSocial()."</td>";
                                echo "<td>".$value->getCuit()."</td>";
                                echo "<td>".$value->getIibb()."</td>";
                                echo "<td>".$value->getDomicilio()."</td>";
                                echo "<td>".$value->getCondFiscal()."</td>";
                                echo "<td>".$value->getConcepto()."</td>";
                                echo "<td>$ ".$value->getImporte()."</td>";    
                                echo "<td>$ ".number_format($value->getImporteReintegro(),2)."</td>";
                                echo "<td>".$class_estilos_aledanio."</td>";
                                echo "<td>".$value->getAledNombre()."</td>";
                                echo "<td>".$cantServ[0]->CANTIDAD_SERVICIOS."</td>";                                                    
                                echo "<td>".$class_estilos_aprobado."</td>";
                                echo "<td><a href='".$value->getAdjunto()."' target='_blank'>VER</a></td>";

                                $countServicios = 0;
                                $estiloContServicios = "false";
                                if($value->getUsuarioId()->getUsuarioPerfil()->getNombre()=="GESTOR")
                                {
                                  if($value->getUsuarioId()->getTipoUsuario()->getNombre()=="Gestor")
                                  {
                                    $handlerSistema = new HandlerSistema; 
                                    $fFiltro = $value->getFechaHora()->format("Y-m-d"); 
                                    $countServicios = $handlerSistema->selectCountServicios($fFiltro,$fFiltro,null,null,$value->getUsuarioId()->getUserSistema(),null,null,null)[0]->CANTIDAD_SERVICIOS;
                                    $estiloContServicios = "false";
                                  }
                                  else
                                  {
                                    $countServicios = 0;
                                    $estiloContServicios = "true";
                                  }
                                }
                                else
                                {
                                  $countServicios = 0;
                                  $estiloContServicios = "true";
                                }

                                if(!$value->getAprobado()){
                                  $editar = "<a href='".$url_detalle.$value->getId()."' class='text-black text-center' >
                                          <i class='fa fa-edit' data-toggle='tooltip' data-original-title='Editar Ticket'></i></a>";
                                  echo "<td class='text-center'>".$editar." <a 
                                            id='boton_aprobar_".$value->getId()."'                                             
                                            type='button' 
                                            style='width:100%; font-size:20px;'
                                            class='text-green' 
                                            data-toggle='modal' 
                                            data-target='#modal-aprobar' 
                                            data-reintegro='".number_format($value->getImporteReintegro(),2)."' 
                                            data-aledanio='".$value->getAledanio()."' 
                                            data-cant_operaciones='".$cantServ[0]->CANTIDAD_SERVICIOS."'                     
                                            onclick=btnAprobar(".$value->getId().")>
                                              <i class='fa fa-thumbs-up' data-toggle='tooltip' data-original-title='Aprobar ticket'></i>
                                              
                                          </a>      
                                          <a 
                                            id='boton_rechazar_".$value->getId()."'                                             
                                            type='button' 
                                            style='width:100%; font-size:20px;'
                                            class='text-red' 
                                            data-toggle='modal' 
                                            data-target='#modal-rechazar' 
                                            data-reintegro='".number_format($value->getImporteReintegro(),2)."' 
                                            data-aledanio='".$value->getAledanio()."' 
                                            data-cant_operaciones='".$cantServ[0]->CANTIDAD_SERVICIOS."'                     
                                            onclick=btnRechazar(".$value->getId().")>
                                              <i class='fa fa-thumbs-down' data-toggle='tooltip' data-original-title='Rechazar ticket'></i>
                                              
                                          </a>   

                                        </td>";
                                }
                                else
                                {
                                  echo "<td class='text-center'>
                                        <a href='".$url_action_desaprobar.$value->getId()."' class='btn btn-danger btn-xs'>
                                          <i class='fa fa-times' data-toggle='tooltip' data-original-title='Desaprobar ticket'></i>
                                          Desaprobar Ticket
                                        </a>
                                      </td>";                                  
                                }
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

<div class="modal fade in" id="modal-aprobar">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formAprobar" action="<?php echo $url_action_aprobar; ?>" method="post">
        <input type="hidden" name="id" id="id" value=""> 
        <input type="hidden" name="url_redirect" value="<?php echo $url_retorno; ?>"> 

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Aprobar</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label>Importe Reintegro</label>
                <input type="number" name="reintegro" class="form-control" step="0.01"  required="">
              </div>
              <div class="col-md-6">
                <label>Cantidad Operaciones</label>
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
          <button type="submit" class="btn btn-success">Aprobar</button>
        </div>
      </form>

    </div>
  </div>
</div><div class="modal fade in" id="modal-rechazar">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formRechazar" action="<?php echo $url_action_rechazar; ?>" method="post">
        <input type="hidden" name="id" id="id" value=""> 
        <input type="hidden" name="url_redirect" value="<?php echo $url_retorno; ?>"> 

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Rechazar</h4>
        </div>
        <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Observaciones</label>
                <textarea name="txtObs" class="form-control" rows="5" required=""></textarea>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Rechazar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){                
    $("#mnu_tickets_aprobar").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_tickets").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte();
    });
  });

  $(document).ready(function() {
    $("#slt_plaza").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte();
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

      f_plaza = $("#slt_plaza").val();

      url_filtro_reporte="index.php?view=tickets_aprobar&fdesde="+aStart+"&fhasta="+aEnd;


    if(f_plaza!=undefined)
      if(f_plaza!='' && f_plaza!=0)
        url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;  

      if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }
</script>

<script type="text/javascript">
    function btnAprobar(id_registro)
    {
        var id= id_registro;        
    
        var elemento = document.querySelector('#boton_aprobar_'+id);        
        formAprobar.id.value = id;   

        var reintegro= elemento.getAttribute('data-reintegro');     
        var aledanio = elemento.getAttribute('data-aledanio');     
        var cant_operaciones = elemento.getAttribute('data-cant_operaciones');     
        
        formAprobar.reintegro.value = reintegro;

        if(aledanio==true)
          formAprobar.aledanio.checked = true;
        else
          formAprobar.aledanio.checked = false;

        formAprobar.operaciones.value = cant_operaciones;           

        //var mensaje_envio="<p>Esta a punto de aprobar el ticket <br> ¿Desea Continuar?</p>";
        //document.getElementById('mensaje_envio').innerHTML = mensaje_envio;      
    }
    
    function btnRechazar(id_registro)
    {
        var id= id_registro;        
    
        var elemento = document.querySelector('#boton_rechazar_'+id);        
        formRechazar.id.value = id;

        //var mensaje_envio="<p>Esta a punto de aprobar el ticket <br> ¿Desea Continuar?</p>";
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