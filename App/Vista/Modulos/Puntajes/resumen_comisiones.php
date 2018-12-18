<?php
  include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";  
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";         
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  include_once PATH_DATOS.'Entidades/ticketsfechasinhabilitadas.class.php'; 
  include_once PATH_NEGOCIO."Modulos/handlerobjetivos.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";        

  $dFecha = new Fechas;
  $handler = new HandlerSueldos;
  $handlerObj = new HandlerObjetivos;
  $handlerSist = new HandlerSistema;
  $handlerLegajos = new HandlerLegajos;
  $handlerFInhab = new TicketsFechasInhabilitadas;
  $handlerConsultas= new HandlerConsultas;
  $handlerPuntaje = new HandlerPuntaje;
  $handlerPlaza = new HandlerPlazaUsuarios;
  $handlerUsuarios = new HandlerUsuarios;

  // Fechas
  // ============================
  $fechahoy=$dFecha->FechaActual();
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:null);
  $fperiodo= (isset($_GET["fperiodo"])?$_GET["fperiodo"]:'');
  $fecha = $fperiodo.'-01';

  $fDesdeComision = date('Y-m-01',strtotime($fecha));
  $fHastaComision = date('Y-m-t',strtotime($fecha));

  $fInicioMes = $fDesdeComision;
  $fFinMes = $fHastaComision;

    
  $arrPlaza = $handlerSist->selectAllPlazas();
  $arrGestores = $handlerSist->selectAllGestor($fplaza);
  $gestoresPlaza = $arrGestores;
    if(!is_null($fplaza)){

      $consulta = $handlerConsultas->consultaPuntajesCoordinador($fDesdeComision,$fHastaComision, $fplaza);
  $total_coord_servicios = 0;
  $total_coord_servicios_cerrados = 0;
  $total_coord_servicios_enviadas = 0;
  $total_coord_puntajes_enviadas = 0;

  include_once 'calculo_comisiones_coord.php';

  // Días laborales
  // ============================
  $laborales = 0;
  while (strtotime($fInicioMes) <= strtotime($fFinMes)) {

    $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($fInicioMes); 
    // var_dump($result);

    $estado_result = (!empty($result)?true:false);

    if (date('N',strtotime($fInicioMes)) != 7 && !$estado_result) {
      if (date('N',strtotime($fInicioMes)) != 6) {
        $laborales += 1;
      } else {
        $laborales += 0.5;
      }
    }

    $fInicioMes = date('Y-m-d',strtotime('+1 day',strtotime($fInicioMes)));
  }

  // Gestores / Coordinadores
  // ============================
  $gestCoor = $handlerObj->allGestCoor();
  if (!empty($gestCoor)) {
    foreach ($gestCoor as $key => $value) {
      $gc[] = intval($value->getIdGestor());
      $fechaInicioGC[intval($value->getIdGestor())] = $value->getFechaInicio();
    }
  }


  // Id PLAZA
  // ============================
  $allPlazas = $handlerPlaza->selectTodas();
  if (!empty($allPlazas)) {
    foreach ($allPlazas as $plaza) {
      if ($plaza->getNombre() == $fplaza) {
        $idPlaza = $plaza->getId();
      }
    }
  }

  // Usuarios Gestores
  // ============================
  $allUsuarios = $handlerUsuarios->selectAll();
  $gestActivosPlaza = '';
  foreach ($gestPlaza as $ind2 => $gPlaza) {
    foreach ($allUsuarios as $ind => $usuario) {
      $tipoUsuario = $usuario->getTipoUsuario();
      $perfilUsuario = $usuario->getUsuarioPerfil();
      if (is_array($tipoUsuario)) {
        $tipoUsuario = 0;
      }else{
        $tipoUsuario = $tipoUsuario->getId();
      }
      if (is_array($perfilUsuario)) {
        $perfilUsuario = 0;
      }else{
        $perfilUsuario = $perfilUsuario->getId();
      }

      if ($tipoUsuario == 3 && $usuario->getUserSistema() == intval($gPlaza) && $perfilUsuario = 5 ) {
        $gestActivosPlaza[] = array('idGestor' => $usuario->getUserSistema(),
                                    'nomGestor' => $nomGestores[$gPlaza],
                                    'idUser' => $usuario->getId());
      }
    }
  }


  // Objetivos de la plaza
  // ============================
  $objetivosXPlaza = $handlerObj->objetivosXPlaza($fplaza);
  if (!empty($objetivosXPlaza)) {
    foreach ($objetivosXPlaza as $key => $value) {
      if ($fechahoy >= $value->getVigencia()->format('Y-m-d')) {
          $objetivoBase = $value->getBasico();
          $objetivoGC = $value->getBasicoGC();
          $cantCoord = $value->getCantCoord();
          break;
        
      }
    }
  }

  // Gestores según fechas trabajadas
  // ============================
  $arrGests = '';
  foreach ($gestActivosPlaza as $idG2 => $gestPortal) {
        $legajo = $handlerLegajos->seleccionarLegajos($gestPortal['idUser']);
        if (!is_null($legajo)) {
          if ($legajo->getFechaBaja()->format('Y-m-d') != '1900-01-01' && $legajo->getFechaBaja()->format('Y-m-d') < $fDesdeComision) {
            unset($gestoresPlaza[$idG]);
          } elseif ($legajo->getFechaBaja()->format('Y-m-d') != '1900-01-01' && $legajo->getFechaBaja()->format('Y-m-d') > $fDesdeComision && $legajo->getFechaBaja()->format('Y-m-d') < $fHastaComision) {
            $trabajo = 0;
            if ($legajo->getFechaIngreso()->format('Y-m-d') > $fDesdeComision) {
              $fInicioMes = $legajo->getFechaIngreso()->format('Y-m-d');
            } else {
              $fInicioMes= $fDesdeComision;
            }
            while (strtotime($fInicioMes) <= strtotime($legajo->getFechaBaja()->format('Y-m-d'))) {

              $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($fInicioMes); 

              $estado_result = (!empty($result)?true:false);

              if (date('N',strtotime($fInicioMes)) != 7 && !$estado_result) {
                if (date('N',strtotime($fInicioMes)) != 6) {
                  $trabajo += 1;
                } else {
                  $trabajo += 0.5;
                }
              }

              $fInicioMes = date('Y-m-d',strtotime('+1 day',strtotime($fInicioMes)));
            }

            $relativo = $trabajo/$laborales;
            $arrGests[] = array('cod' => $gestPortal['idGestor'],
                              'nombre' => $gestPortal['nomGestor'],
                              'rel' => $relativo );
          } elseif ($legajo->getFechaIngreso()->format('Y-m-d') > $fDesdeComision){
            $trabajo = 0;
            $fInicioMes= $legajo->getFechaIngreso()->format('Y-m-d');
            while (strtotime($fInicioMes) <= strtotime($fFinMes)) {

              $result = $handlerFInhab->selecionarFechasInhabilitadasByFecha($fInicioMes); 
              // var_dump($result);

              $estado_result = (!empty($result)?true:false);

              if (date('N',strtotime($fInicioMes)) != 7 && !$estado_result) {
                if (date('N',strtotime($fInicioMes)) != 6) {
                  $trabajo += 1;
                } else {
                  $trabajo += 0.5;
                }
              }

              $fInicioMes = date('Y-m-d',strtotime('+1 day',strtotime($fInicioMes)));
            }
            
            $relativo = $trabajo/$laborales;
            $arrGests[] = array('cod' => $gestPortal['idGestor'],
                              'nombre' => $gestPortal['nomGestor'],
                              'rel' => $relativo );
          } else {
            $arrGests[] = array('cod' => $gestPortal['idGestor'],
                              'nombre' => $gestPortal['nomGestor'],
                              'rel' => 1 );
          }
        }
    }

  // echo "<pre>";
  // print_r($arrGests);
  // print_r($gestActivosPlaza);
  // print_r($arrGestores);
  // echo "</pre>";


  $objetivoCoord = 0;
  foreach ($arrGests as $indice => $valor) {
    // echo $valor->GESTOR21_ALIAS;
    if (!in_array($valor['cod'],$gc)) {
      $objetivoCoord += $objetivoBase * $valor['rel'];
    } else {
      $objetivoCoord += $objetivoGC* $valor['rel'];
    }
    
  }

  $arrGestor = $handlerSist->selectAllGestor($fplaza);
  $arrCoordinador = $handlerSist->selectAllPlazasArray();

  $arrUsuarios = $handlerUsuarios->selectEmpleados();
  if ($fecha != '-01') {
    $comision = $handler->selectByDate($fecha);
  }
  
}
?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Comisiones
      <small>Listado de las comisiones de los gestores</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Comisiones</li>
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
                <div class="col-md-2">
                  <label>Período</label>
                  <?php if($fperiodo != ''){ ?>
                    <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" value="<?php echo $fperiodo; ?>" onchange="crearHrefPlaza()">
                  <?php } else { ?>
                    <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" onchange="crearHrefPlaza()">
                  <?php  } ?>
                </div> 
                <div class="col-md-3">
                  <label>Plazas</label>
                  <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" required="">                    
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrPlaza)){                        
                        foreach ($arrPlaza as $key => $value) {
                          if($fplaza == $value->ALIAS){
                            echo "<option value='".$value->ALIAS."' selected>".$value->ALIAS."</option>";
                          } else {
                            echo "<option value='".$value->ALIAS."'>".$value->ALIAS."</option>";
                          }
                        }
                      }
                    ?>                      
                  </select>     
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
              <h3 class="box-title">Comisiones</h3>
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>GESTOR</th>              
                      <th>SERVICIOS TOTAL</th>              
                      <th>SERVICIOS CERRADOS</th>              
                      <th>SERVICIOS ENVIADAS</th>
                      <th>PUNTAJE</th>              
                      <th>OBJETIVO</th>              
                      <th>COMISIONES VALOR</th>              
                      <th>COMISIONES A COBRAR</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      if (!empty($arrGests) && $fecha != '-01') {
                        foreach ($arrGests as $gestor) {
                          include 'calculo_comisiones.php';
                          if (!in_array($gestor['cod'],$gc)) {
                            $objetivo = $objetivoBase * $gestor['rel'];
                          } else {
                            $objetivo = $objetivoGC* $gestor['rel'];
                          }
                          if ($total_puntajes_enviadas>floatval($objetivo)) {
                            $puntaje_comision = $total_puntajes_enviadas - floatval($objetivo);
                            $valor_comision = $puntaje_comision * $comision['valor'];
                            if ($objetivo == 0) {
                              $puntaje_comision = 0;
                              $valor_comision = 0;
                            }
                          } else {
                            $puntaje_comision = 0;
                            $valor_comision = 0;
                          }
                          if ($total_servicios>0) {
                            echo "<tr>";
                              echo "<td>".$gestor['nombre']."</td>";
                              echo "<td>".$total_servicios."</td>";
                              echo "<td>".$total_servicios_cerrados."</td>";
                              echo "<td>".$total_servicios_enviadas."</td>";
                              echo "<td>".number_format($total_puntajes_enviadas,2)."</td>";
                              echo "<td>".number_format($objetivo,2,'.','')."</td>";
                              echo "<td>".number_format($puntaje_comision,2,'.','')."</td>";
                              echo "<td>$ ".number_format($valor_comision,2,'.','')."</td>";
                            echo "</tr>";
                          }
                        }
                      }
                    ?>

                    <!-- <?php 
                      if (!is_null($fplaza)) {
                      if ($total_coord_puntajes_enviadas>floatval($objetivoCoord)) {
                        $puntaje_comision = $total_coord_puntajes_enviadas - floatval($objetivoCoord);
                        $valor_comision = $puntaje_comision * $comision['valor'];
                      } else {
                        $puntaje_comision = 0;
                        $valor_comision = 0;
                      }

                      echo "<tr class='bg-navy'>";
                        echo "<td>Coordinador/es (".$cantCoord.")</td>";
                        echo "<td>".$total_coord_servicios."</td>";
                        echo "<td>".$total_coord_servicios_cerrados."</td>";
                        echo "<td>".$total_coord_servicios_enviadas."</td>";
                        echo "<td>".number_format($total_coord_puntajes_enviadas,2,'.','')."</td>";
                        echo "<td>".number_format($objetivoCoord,2,'.','')."</td>";
                        echo "<td>".number_format($puntaje_comision,2,'.','')."</td>";
                        echo "<td>$ ".number_format($valor_comision,2,'.','')."</td>";
                      echo "</tr>";
                      echo "<tr class='bg-navy'>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td style='text-align: right;'>Por Coordinador: </td>";
                        echo "<td>$ ".number_format(($valor_comision/$cantCoord),2,'.','')."</td>";
                      echo "</tr>";
                      }

                     ?> -->
                    
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
    $("#mnu_resumen_comisiones").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_puntajes").addClass("active");
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
      // filtrarReporte();
    });
  });

</script>
<script type="text/javascript">

  function crearHrefPlaza()
  {
     f_periodo = $('#slt_periodo').val()
      f_plaza = $("#slt_plaza").val();

      url_filtro_reporte="index.php?view=resumen_comisiones&fperiodo="+f_periodo;


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
    
    $(document).ready(function() {
        $('#tabla').DataTable({
          "dom": 'Bfrtip',
          "buttons": ['copy', 'csv', 'excel', 'print'],
          "iDisplayLength":100,
          "order": [],
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