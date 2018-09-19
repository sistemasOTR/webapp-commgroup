<?php
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";  
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";         
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";          

  $dFecha = new Fechas;

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $festados= (isset($_GET["festados"])?$_GET["festados"]:'');

  $handler = new HandlerTickets;
  $handlerSist = new HandlerSistema;
  $arrGestor = $handlerSist->selectAllGestor($fplaza);
  $arrCoordinador = $handlerSist->selectAllPlazasArray();

  $handlerPlaza = new HandlerPlazaUsuarios;
  $arrPlaza = $handlerPlaza->selectTodas();

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectEmpleados();
  $arrGestores = $handlerUsuarios->selectGestores(null);
  $arrGestoresXPlaza = $handlerUsuarios->selectGestoresByPlaza($fplaza);

  $url_action_aprobar = PATH_VISTA.'Modulos/Ticket/action_aprobar.php?id=';  
  $url_action_desaprobar = PATH_VISTA.'Modulos/Ticket/action_desaprobar.php?id=';  
  $url_action_rechazar = PATH_VISTA.'Modulos/Ticket/action_rechazar.php';  
  $url_detalle = 'index.php?view=tickets_detalle&fticket=';   

  $url_retorno = "view=tickets_aprobar&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&fusuario=".$fusuario."&festados=".$festados;
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
      Ticket Resumen
      <small>Resumen de viáticos por plaza y por gestor</small>
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
                <label>Plazas</label>
                <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" required="">                    
                  <option value=''></option>
                  <option value='0'>TODOS</option>
                  <?php
                    if(!empty($arrPlaza))
                    {                        
                      foreach ($arrPlaza as $key => $value) {
                        if($fplaza == $value->getId()){
                          echo "<option value='".$value->getId()."' selected>".$value->getNombre()."</option>";
                        } else {
                          echo "<option value='".$value->getId()."'>".$value->getNombre()."</option>";
                        }
                        
                      }
                    }                      
                  ?>                      
                </select>     
              </div>
                <div class="col-md-3">
                    <label>Fecha Desde - Hasta</label>
                    <div class="input-group">
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $fdesde; ?>"/>
                      <span class="input-group-addon" >a</span>
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $fhasta; ?>"/>
                    </div>
                    
                </div>
                

                <div class='col-md-3 pull-right'>                
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
                      <th width="20%">PLAZA</th>
                      <th width="30%">APELLIDO</th>
                      <th width="30%">NOMBRE</th>
                      <th width="10%">CANT TICKETS</th>
                      <th width="10%">REINTEGRO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $total = 0;
                    $cantTotal = 0;
                    if (!empty($fplaza)) {
                      if (!empty($arrGestoresXPlaza)) {
                        foreach ($arrGestoresXPlaza as $key => $value) {
                          $idGestor = $value->getId();
                          $resumenGestor = $handler->resumenGestor($idGestor, $fdesde, $fhasta);
                          $cantTickets = count($resumenGestor);
                          $reintegroTotal = 0;
                          if (!empty($resumenGestor)) {
                            foreach ($resumenGestor as $viatico) {
                              $reintegroTotal += $viatico->getImporteReintegro(); 
                            }
                            echo "<tr>";
                              echo "<td>".$handlerPlaza->selectById($handlerUsuarios->selectById($idGestor)->getUserPlaza())->getNombre()."</td>";
                              echo "<td>".$handlerUsuarios->selectById($idGestor)->getApellido()."</td>";
                              echo "<td>".$handlerUsuarios->selectById($idGestor)->getNombre()."</td>";
                              echo "<td>".$cantTickets."</td>";
                              echo "<td>$ ".$reintegroTotal."</td>";
                            echo "</tr>";
                            $cantTotal += $cantTickets;
                            $total += $reintegroTotal;
                          }
                            

                        }
                        echo "<tr class='bg-green'>";
                          echo "<td>".$handlerPlaza->selectById($handlerUsuarios->selectById($idGestor)->getUserPlaza())->getNombre()."</td>";
                          echo "<td>RESUMEN</td>";
                          echo "<td></td>";
                          echo "<td>".$cantTotal."</td>";
                          echo "<td>$ ".$total."</td>";
                        echo "</tr>";
                      }
                    } else {
                      if (!empty($arrPlaza)) {
                        foreach ($arrPlaza as $plaza) {
                          if ($plaza->getId() < 8) {
                            $arrGestoresXPlaza = $handlerUsuarios->selectGestoresByPlaza($plaza->getId());
                            $total = 0;
                            $cantTotal = 0;
                            if (!empty($arrGestoresXPlaza)) {
                              foreach ($arrGestoresXPlaza as $key => $value) {
                                $idGestor = $value->getId();
                                $resumenGestor = $handler->resumenGestor($idGestor, $fdesde, $fhasta);
                                $cantTickets = count($resumenGestor);
                                $reintegroTotal = 0;
                                if (!empty($resumenGestor)) {
                                  foreach ($resumenGestor as $viatico) {
                                    $reintegroTotal += $viatico->getImporteReintegro(); 
                                  }
                                  echo "<tr>";
                                    echo "<td>".$handlerPlaza->selectById($handlerUsuarios->selectById($idGestor)->getUserPlaza())->getNombre()."</td>";
                                    echo "<td>".$handlerUsuarios->selectById($idGestor)->getApellido()."</td>";
                                    echo "<td>".$handlerUsuarios->selectById($idGestor)->getNombre()."</td>";
                                    echo "<td>".$cantTickets."</td>";
                                    echo "<td>$ ".$reintegroTotal."</td>";
                                  echo "</tr>";
                                  $cantTotal += $cantTickets;
                                  $total += $reintegroTotal;
                                }
                                  

                              }
                              echo "<tr class='bg-green'>";
                                echo "<td>".$handlerPlaza->selectById($handlerUsuarios->selectById($idGestor)->getUserPlaza())->getNombre()."</td>";
                                echo "<td>RESUMEN</td>";
                                echo "<td></td>";
                                echo "<td>".$cantTotal."</td>";
                                echo "<td>$ ".$total."</td>";
                              echo "</tr>";
                            }
                          }
                          
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
<script type="text/javascript">
  $(document).ready(function(){                
    $("#mnu_tickets_resumen").addClass("active");
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
      filtrarReportePlaza();
    });
  });

  $(document).ready(function() {
    $("#slt_estados").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      filtrarReporte();
    });
  });

  $('.input-reint').on('change',function() {
  	var id = this.id;
  	var	reintegro = $(this).val();
  	$.ajax({
			type: "POST",
			url: 'App/Vista/Modulos/Ticket/action_editar_reint.php',
			data: {
				id: id,
				reintegro: reintegro
			},
			success: function(data){
				
			}
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
      f_estados = $("#slt_estados").val();

      url_filtro_reporte="index.php?view=tickets_resumen&fdesde="+aStart+"&fhasta="+aEnd;


    if(f_plaza!=undefined)
      if(f_plaza!='' && f_plaza!=0)
        url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;  

      if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario; 

        if(f_estados!=undefined)
        if(f_estados>0)
          url_filtro_reporte= url_filtro_reporte + "&festados="+f_estados;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

  function crearHrefPlaza()
  {
      aStart = $("#start").val();
      aEnd = $("#end").val();

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0]; 
      f_plaza = $("#slt_plaza").val();

      url_filtro_reporte="index.php?view=tickets_resumen&fdesde="+aStart+"&fhasta="+aEnd;


    if(f_plaza!=undefined)
      if(f_plaza!='' && f_plaza!=0)
        url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReportePlaza()
  {
    crearHrefPlaza();
    window.location = $("#filtro_reporte").attr("href");
  }
</script>

<script type="text/javascript">
    function btnAprobar(id_registro)
    {
        var id= id_registro;        
    
        var elemento = document.querySelector('#boton_aprobar_'+id);        
        formAprobar.id.value = id;   

        var importe= elemento.getAttribute('data-importe');     
        var reintegro= elemento.getAttribute('data-reintegro');     
        var aledanio = elemento.getAttribute('data-aledanio');     
        var cant_operaciones = elemento.getAttribute('data-cant_operaciones');     
        
        formAprobar.importe.value = importe;
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
          "order": [[ 0, "asc" ]],
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