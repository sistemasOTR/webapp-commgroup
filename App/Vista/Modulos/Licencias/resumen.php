<?php
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";    
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";       

  $dFecha = new Fechas;

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $festados= 2;
  
  $handler = new HandlerLicencias;
  $handlerSistema = new HandlerSistema;
  $handlerUsuarios = new HandlerUsuarios;

  $user = $usuarioActivoSesion;  
  
   // $arrLicencias = $handler->seleccionarByFiltrosRRHH($fdesde,$fhasta,$fusuario,$festados);
   

 
  
  $arrUsuarios = $handlerUsuarios->selectTodos();
  //$arrGestor = $handlerSistema->selectAllGestor($user->getAliasUserSistema());
  
  // $usuarr=$handlerUsuarios->selectByTipo(3,$user->getAliasUserSistema());
  // var_dump($user->getTipoUsuario());
  // exit();


  $url_action_aprobar = PATH_VISTA.'Modulos/Licencias/action_aprobar.php?fdesde='.$fdesde.'&fhasta='.$fhasta.'&fusuario='.$fusuario.'&festados='.$festados;  
  $url_action_desaprobar = PATH_VISTA.'Modulos/Licencias/action_desaprobar.php?id=';  
  $url_action_rechazar = PATH_VISTA.'Modulos/Licencias/action_rechazar.php?fdesde='.$fdesde.'&fhasta='.$fhasta.'&fusuario='.$fusuario.'&festados='.$festados;  
  $url_action_imprimir =  PATH_VISTA.'Modulos/Licencias/action_imprimir.php?id=';

  $url_redireccion ='&fdesde='.$fdesde.'&fhasta='.$fhasta.'&fusuario='.$fusuario.'&festados='.$festados;




?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Resumen Licencias
      <small>Licencias solicitadas por Empleados</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Licencias</li>
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
                <div class="col-md-3" id='sandbox-container'>
                    <label>Fecha Desde - Hasta </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                <?php
                // var_dump($arrUsuarios);
                //   exit();

                // if(!empty($arrUsuarios))
                //       {                     
                                        
                //         foreach ($arrUsuarios as $key => $value) {
                //           var_dump($value->getTipoUsuario()->getId());
                //         }
                //       }
                //       ?>
            <div class="col-md-3">
                  <label>Usuarios </label>                
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrUsuarios))
                      {                     
                                        
                        foreach ($arrUsuarios as $key => $value) {

                          if (!is_array($value->getTipoUsuario())) {
                            if ($value->getTipoUsuario()->getId() != '1') {
                              $notHidden = true;
                            } else {
                              $notHidden = false;
                            }
                          } else {
                            $notHidden = true;
                          }
                          if($fusuario == $value->getId() && $notHidden){
                            echo "<option value='".$value->getId()."' selected>".$value->getApellido()." ".$value->getNombre()."</option>";
                          }
                          elseif($notHidden){
                            echo "<option value='".$value->getId()."'>".$value->getApellido()." ".$value->getNombre()."</option>";                  
                          }
                            
                        }
                        
                      }           
                    ?>
                  </select>
                </div>       
                <!-- <div class="col-md-2">
                  <label>Estados </label>                
                  <select id="slt_estados" class="form-control" style="width: 100%" name="slt_estados" onchange="crearHref()">
                    <option value='0'>TODOS</option>
                    <option value='1' <?php if ($festados == 1) { echo "selected";} ?>>PENDIENTES</option>
                    <option value='2' <?php if ($festados == 2) { echo "selected";} ?>>APROBADOS</option>
                    <option value='3' <?php if ($festados == 3) { echo "selected";} ?>>RECHAZADOS</option>
                 </select>
                </div>     -->
                <div class='col-md-3 col-md-offset-1 pull-right'>                
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
              <i class="fa fa-certificate"></i>       
              <h3 class="box-title">Licencias</h3>   
            </div>
            <div class="box-body table-responsive">
              <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>EMPLEADO</th>
                      <th>TIPO LICENCIA</th>
                      <th>DESDE</th>
                      <th>HASTA</th>
                      <th>OBSERVACIONES</th>
                      <th>DÍAS</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        if ($fusuario!= '') {
                            $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                            $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
                            
                            $arrayIde[]=0;
                            $total = 0;
                            while (strtotime($FECHA) <= strtotime($HASTA)) {
                            $arrLicencia = $handler->seleccionarByFiltrosRRHH($FECHA,$FECHA,$fusuario,$festados);
                            // var_dump(count($arrLicencia));
                            
                            if(!empty($arrLicencia))
                               { 
                            
                                                                        
                                foreach ($arrLicencia as $key => $value) {
                                    foreach ($arrayIde as $idrepeate) {
                                    if (intval($value->getId()) == $idrepeate) {
                                        $seguir = false;
                                        break;
                                    } else {
                                        $seguir = true;
                                    }
                                    }
                                
                                    if($seguir){
                                        $arrayIde[]=intval($value->getId());
        
                                        if (strtotime($FECHA) == strtotime($value->getFechaInicio()->format('Y-m-d')) ) {
                                            $inicio = $value->getFechaInicio()->format('d-m-Y');
                                        } else {
                                            $inicio = date('d-m-Y',strtotime($FECHA)).' <span class="text-red" style="padding-left: 10px;">('.$value->getFechaInicio()->format('d-m-Y').')</span>';
                                        }
                                        
                                        $dias = date_diff( date_create($FECHA), date_create($value->getFechaFin()->format('Y-m-d')) );
                                        $cantDias = $dias->days + 1;
                                        $total += $cantDias;
                                    
                                    echo "<tr>";
                                        echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                                        echo "<td>".$value->getTipoLicenciasId()->getNombre()."</td>";
                                        echo "<td>".$inicio."</td>";
                                        echo "<td>".$value->getFechaFin()->format('d-m-Y')."</td>";
                                        echo "<td>".$value->getObservaciones()."</td>";
                                        echo "<td>".$cantDias."</td>";
        
                                    echo "</tr>";
                                    
                                    }
                                    
                                }
        
                                
                                
                                } 
                                
                                $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));    
                            
                            }
                            
                            echo "<tr class='bg-green'>";
                            echo "<td>Total</td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td></td>";
                            echo "<td>".$total."</td>";
        
                            echo "</tr>";
                        } else {
                          if (!empty($arrUsuarios)) {
                            foreach ($arrUsuarios as $usuario) {
                              $fusuario= $usuario->getId();

                              $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                              $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
                              
                              $arrayIde[]=0;
                              $total = 0;
                              while (strtotime($FECHA) <= strtotime($HASTA)) {
                              $arrLicencia = $handler->seleccionarByFiltrosRRHH($FECHA,$FECHA,$fusuario,$festados);
                              // var_dump(count($arrLicencia));
                              
                              if(!empty($arrLicencia))
                                 { 
                              
                                                                          
                                  foreach ($arrLicencia as $key => $value) {
                                      foreach ($arrayIde as $idrepeate) {
                                      if (intval($value->getId()) == $idrepeate) {
                                          $seguir = false;
                                          break;
                                      } else {
                                          $seguir = true;
                                      }
                                      }
                                  
                                      if($seguir){
                                          $arrayIde[]=intval($value->getId());
          
                                          if (strtotime($FECHA) == strtotime($value->getFechaInicio()->format('Y-m-d')) ) {
                                              $inicio = $value->getFechaInicio()->format('d-m-Y');
                                          } else {
                                              $inicio = date('d-m-Y',strtotime($FECHA)).' <span class="text-red" style="padding-left: 10px;">('.$value->getFechaInicio()->format('d-m-Y').')</span>';
                                          }
                                          
                                          $dias = date_diff( date_create($FECHA), date_create($value->getFechaFin()->format('Y-m-d')) );
                                          $cantDias = $dias->days + 1;
                                          $total += $cantDias;
                                      
                                      echo "<tr>";
                                          echo "<td>".$value->getUsuarioId()->getApellido()." ".$value->getUsuarioId()->getNombre()."</td>";
                                          echo "<td>".$value->getTipoLicenciasId()->getNombre()."</td>";
                                          echo "<td>".$inicio."</td>";
                                          echo "<td>".$value->getFechaFin()->format('d-m-Y')."</td>";
                                          echo "<td>".$value->getObservaciones()."</td>";
                                          echo "<td>".$cantDias."</td>";
          
                                      echo "</tr>";
                                      
                                      }
                                      
                                  }
          
                                  
                                  
                                  } 
                                  
                                  $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));    
                              
                              }
                              if ($total>0) {
                                echo "<tr class='bg-green'>";
                                  echo "<td>Total</td>";
                                  echo "<td></td>";
                                  echo "<td></td>";
                                  echo "<td></td>";
                                  echo "<td></td>";
                                  echo "<td>".$total."</td>";
            
                                echo "</tr>";
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

  $(document).ready(function(){                
    $("#mnu_licencias_resumen").addClass("active");
  });

  function rechazar(id){
    document.getElementById('idRechazar').value = id;
  }
  function aprobar(id){
    document.getElementById('idAprobar').value = id;
  }



  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');
      aEnd = $("#end").val().split('/');

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      f_usuario = $("#slt_usuario").val(); 
      
      url_filtro_reporte="index.php?view=licencias_resumen&fdesde="+f_inicio+"&fhasta="+f_fin  

      if(f_usuario!=undefined)
        if(f_usuario>0)
          url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });

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