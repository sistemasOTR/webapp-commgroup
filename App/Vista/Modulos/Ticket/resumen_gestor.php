<?php
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";  
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";         
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";           

  $dFecha = new Fechas;
  $fechahoy=$dFecha->FechaActual();

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  $fusuario= (isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  $fplaza= (isset($_GET["fplaza"])?$_GET["fplaza"]:'');
  $festados= (isset($_GET["festados"])?$_GET["festados"]:'');

  $handler = new HandlerTickets;
  $handlerLic= new HandlerLicencias;
  $handlerSist = new HandlerSistema;
  $arrGestor = $handlerSist->selectAllGestor($fplaza);
  $arrCoordinador = $handlerSist->selectAllPlazasArray();

  $handlerPlaza = new HandlerPlazaUsuarios;
  $arrPlaza = $handlerPlaza->selectTodas();

  $handlerUsuarios = new HandlerUsuarios;
  $arrUsuarios = $handlerUsuarios->selectEmpleados();
  $arrGestores = $handlerUsuarios->selectGestores(null);

  $url_action_aprobar = PATH_VISTA.'Modulos/Ticket/action_aprobar.php?id=';  
  $url_action_desaprobar = PATH_VISTA.'Modulos/Ticket/action_desaprobar.php?id=';  
  $url_action_rechazar = PATH_VISTA.'Modulos/Ticket/action_rechazar.php';  
  $url_detalle = 'index.php?view=tickets_detalle&fticket=';   

  $url_retorno = "view=tickets_resumen_gestor&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&fusuario=".$fusuario."&festados=".$festados;
  $url_retorno_corta = "&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&fusuario=".$fusuario."&festados=".$festados;
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
                <div class="col-md-2">
                <label>Plazas</label>
                <select id="slt_plaza" class="form-control" style="width: 100%" name="slt_plaza" required="">                    
                  <option value=''></option>
                  <option value='0'>TODOS</option>
                  <?php
                    if(!empty($arrPlaza))
                    {                        
                      foreach ($arrPlaza as $key => $value) {
                        if($fplaza == $value->getNombre()){
                          echo "<option value='".$value->getNombre()."' selected>".$value->getNombre()."</option>";
                        } else {
                          echo "<option value='".$value->getNombre()."'>".$value->getNombre()."</option>";
                        }
                      }
                    }
                  ?>                      
                </select>     
              </div>
              <div class="col-md-2">
                  <label>Usuarios </label>  
                  <select id="slt_usuario" class="form-control" style="width: 100%" name="slt_usuario" onchange="crearHref()">
                    <option value=''></option>
                    <option value='0'>TODOS</option>
                    <?php
                      if(!empty($arrGestores) || !empty($arrUsuarios)){
                        if ($fplaza != '') {

                          foreach ($arrGestores as $user) {

                            foreach ($arrGestor as $gestor) {
                              if($fusuario == $user->getId() && $user->getUserSistema() == $gestor->GESTOR11_CODIGO && $user->getTipoUsuario()->getNombre()!= 'Empresa'){
                                echo "<option value='".$user->getId()."' selected>".$user->getApellido()." ".$user->getNombre()."</option>";
                              } elseif ($user->getUserSistema() == $gestor->GESTOR11_CODIGO && $user->getTipoUsuario()->getNombre()!= 'Empresa') {
                                echo "<option value='".$user->getId()."'>".$user->getApellido()." ".$user->getNombre()."</option>";
                                }
                              }
                            }
                        } else {
                          foreach ($arrUsuarios as $user) {
                            if($fusuario == $user->getId())
                                echo "<option value='".$user->getId()."' selected>".$user->getApellido()." ".$user->getNombre()."</option>";
                              else
                                echo "<option value='".$user->getId()."'>".$user->getApellido()." ".$user->getNombre()."</option>";                  
                                
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
                    	<th width="100">ASIG</th>
                    	<th style="display: none;">ASIG</th>
                      <th>COMPROBANTE</th>
                      <th>N° COMP</th>
                      <th>CONCEPTO</th>
                      <th style="width: 100px !important">ALED</th>                      
                      <th>LOC</th>                      
                      <th>TRAS</th>                      
                      <th width="30">OPER</th>
                      <th>IMPORTE</th>
                      <th width="100">REINT</th><!-- 
                      <th>ESTADO</th>
                      <th width="30">ADJ</th>
                      <th width='100' class="text-center">ACCION</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    	$fechaDesde = date('Y-m-d',strtotime($fdesde));
                      	$fechaHasta = date('Y-m-d',strtotime($fhasta));
                      	$FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                      	$HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
                      	$countSemana = 0;
                      	$impoSemana = 0;
                        $countCiclo = 0;
                        $impoCiclo = 0;
                      	$counterId = 1;
                      	if ($fusuario!='') {
								        $usuarioSist = $handlerUsuarios->selectById($fusuario)->getUserSistema();

                      	while (strtotime($FECHA) <= strtotime($HASTA)) {
                      		$dia = $dFecha->Dias(date('l',strtotime($FECHA)));
                      		$fechaOp =  date('d-m-Y',strtotime($FECHA));
                          $consulta = $handler->seleccionarByFiltrosAprobacion($FECHA,$FECHA,$fusuario,$festados);
                          $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,intval($fusuario),2); 
                           
                             
                                            
							
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
            								$cantServ = $countServ->selectCountServicios($FECHA, $FECHA, 100, null, $usuarioSist, null, null, null);

                            if($handlerUsuarios->selectById($fusuario)->getUsuarioPerfil()->getNombre()=="GESTOR")
                              {
                              	$cpAt = $countServ->cpAtendidos($FECHA, $usuarioSist);
                              }
            							}
                         $arrReintegro = $handler->selecionarReintegrosByDate($FECHA);
            							// var_dump($arrReintegro);
            							// exit();

                              $class_estilos_aledanio = "<span class='label label-danger'>NO</span>";
                              $reintegro = 0;
                              $opAled = 0;
                              $nombAledanio = '';
                                if (!empty($cpAt) && !empty($arrReintegro)) {
                                  foreach ($cpAt as $key => $cp) {
                                  	$reint = $handler->selectByCP($FECHA,$cp->CP);
                                  	// var_dump($reint);
                                  	// exit();
                                  	if(!empty($reint)){
                                      if ($cp->CP != '' && $reintegro < $reint->getReintegro()){
                                        $reintegro =  number_format($reint->getReintegro(),2);
                                        if ($reint->getAled()) {
                                          $opAled = 1;
                                          $class_estilos_aledanio = "<span class='label label-success'>SI</span>";
                                        } else {
                                          $opAled = 0;
                                          $class_estilos_aledanio = "<span class='label label-danger'>NO</span>";
                                        }
                                        $nombAledanio = $reint->getDescripcion();
                                      }
                                    }
                                  }
                                }

                                $valReint=0;

                                // if ($nombAledanio != '') {
                                //   $arrRintLocalidad = $handler->selectByLocalidad($FECHA,$nombAledanio);
                                //   if (!empty($arrRintLocalidad)) {
                                //     foreach ($arrRintLocalidad as $reintLoc) {

                                //       if ($reintLoc->getCantOp() < $cantServ[0]->CANTIDAD_SERVICIOS) {
                                //         $valReint = $reintLoc->getReintegro();
                                //         break;
                                //       }
                                //     }
                                //   }
                                // }
                                $deLic='';
                                if(!empty($arrLicencias)) {

                                foreach ($arrLicencias as $key => $value) {
                          
                                if (!$value->getRechazado()) {
       
                                 if($value->getAprobado()) {

                                  if ($FECHA <= $value->getFechaFin()->format('Y-m-d') ) { 
                                   
                                    $deLic= "LICENCIA EN CURSO";
                                   
                                   }
                                    else{ 
                                       $deLic="";
                                      }

                                     
                                    }
                                  }
                                }
                              }
                              $clasePeaje = '';
                      		if(!empty($consulta)) {
		                        foreach ($consulta as $key => $value) {
                              if($value->getAprobado()){
		                        	$fechaT = $value->getFechaHora()->format('Y-m-d');
                              if ($value->getImporteReintegro()>0) {
                                $valReint = $value->getImporteReintegro();
                              }
                              $countSemana = $countSemana + $valReint;
                              $impoSemana = $impoSemana + $value->getImporte();
                              $countCiclo = $countCiclo + $valReint;
                              $impoCiclo = $impoCiclo + $value->getImporte();

              									if($value->getAprobado()){
              										$class_estilos_aprobado = "<span class='label label-success'>APROBADO</span>";
              										
              										$readonly = 'readonly=""';
              									}
                                elseif($value->getRechazado())
                                {
                                  $class_estilos_aprobado = "<span class='label label-danger' data-toggle='tooltip' data-original-title='".$value->getObsRechazo()."'>RECHAZADO</span>";
                                  $readonly = 'readonly=""';                     
                                } else{
              										$class_estilos_aprobado = "<span class='label label-warning'>PENDIENTE</span>";
              										$readonly = '';
              									}

              									if($value->getAledanio()){
              										$class_estilos_aledanio = "<span class='label label-success'>SI</span>";
              									}
              									else{
              										$class_estilos_aledanio = "<span class='label label-danger'>NO</span>";
              									}
              									
              									$clasePeaje = '';
              									if (trim($value->getConcepto()) == 'PEAJES') {
              										$class_estilos_aledanio = '';
                                  $clasePeaje = 'color: white !important';
              										// $cantServ[0]->CANTIDAD_SERVICIOS = 0;
              									} else {
                                  $clasePeaje = 'color: black !important';
                                }

                                  if ($value->getTraslado()) {
		                                $class_estilos_traslado = "<span class='label label-success'>SI</span>";
		                                $opTras = 1;
		                              } else {
		                                $class_estilos_traslado = "<span class='label label-danger'>NO</span>";
		                                $opTras = 0;
		                              }
               
									
          									echo "<tr>";
          										echo "<td>".$dia."<br>".$fechaOp."</td>";
          										echo "<td style='display:none'>".$FECHA."</td>";
          									    echo "<td>".$value->getTipo()."</td>";
          									    echo "<td>".str_pad(strval(trim($value->getPuntoVenta())),4,"0",STR_PAD_LEFT)."-".str_pad(strval(trim($value->getNumero())),8,"0",STR_PAD_LEFT)."</td>";
          									    echo "<td>".$value->getConcepto()."</td>";
          									    echo "<td>".$class_estilos_aledanio."</td>";
          									    echo "<td>".$nombAledanio."</td>";
          									    echo "<td>".$class_estilos_traslado."</td>";
          									    echo "<td style='".$clasePeaje."'>".number_format($cantServ[0]->CANTIDAD_SERVICIOS,0)."</td>";;
                                echo "<td>$ ".$value->getImporte()."</td>";    
                                echo "<td>$ ".number_format($valReint,2)."</td>";
          									  echo "</tr>";
          									   } else {
                              
                                $feriado=$handler->selecionarFechasInhabilitadasByFecha($FECHA);
                                if (!empty($feriado) && trim($feriado[0]['motivo']) == 'Feriado') {
                                  $classFL = " class='bg-red'";
                                  $feriado="FERIADO";
                                } else {
                                  $feriado = '';
                                  $classFL = '';
                                }


                                if ($deLic!='') {
                                  $class_estilos_traslado='';
                                  $class_estilos_aledanio = '';
                                    $clasePeaje = 'color: white !important';
                                    $nombAledanio='';
                                    $class_estilos_aledanio = '';
                                    $classFL = " class='bg-yellow'";
                                }

                                  if ($dia == 'Domingo') {
                                    echo "<tr class='bg-navy'>";
                                    echo "<td>SUBTOTAL</td>";
                                  } else {
                                    echo "<tr".$classFL.">";
                                    echo "<td>".$dia."<br>".$fechaOp."</td>";
                                  }
                                  
                                  echo "<td style='display:none'>".$FECHA."</td>";
                                  echo "<td></td>";
                                  echo "<td></td>";
                                  echo "<td></td>";
                                  if ($dia == 'Domingo') {
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td><b>$ <span id='".$counterId."_impo'>".number_format($impoSemana,2,'.','')."</span></b></td>";
                                    echo "<td><b>$ <span id='".$counterId."_sem'>".number_format($countSemana,2)."</span></b></td>";
                                    $countSemana = 0;
                                    $impoSemana = 0;
                                              $counterId += 1;
                                  } else {
                                    echo "<td></td>";
                                    echo "<td>".$deLic.$feriado."</td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                  }
                                echo "</tr>";
                                 }
                              }
          								} else {
                            $feriado=$handler->selecionarFechasInhabilitadasByFecha($FECHA);
                            if (!empty($feriado) && trim($feriado[0]['motivo']) == 'Feriado') {
                              $classFL = " class='bg-red'";
                              $feriado="FERIADO";
                            } else {
                              $feriado = '';
                              $classFL = '';
                            }


                            if ($deLic!='') {
                            	$class_estilos_traslado='';
                            	$class_estilos_aledanio = '';
                            		$clasePeaje = 'color: white !important';
                            		$nombAledanio='';
                                $class_estilos_aledanio = '';
                            		$classFL = " class='bg-yellow'";
                            }

                              if ($dia == 'Domingo') {
          											echo "<tr class='bg-navy'>";
          											echo "<td>SUBTOTAL</td>";
          										} else {
          											echo "<tr".$classFL.">";
          											echo "<td>".$dia."<br>".$fechaOp."</td>";
          										}
          										
          										echo "<td style='display:none'>".$FECHA."</td>";
          										echo "<td></td>";
          										echo "<td></td>";
          										echo "<td></td>";
          										if ($dia == 'Domingo') {
          											echo "<td></td>";
          											echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td><b>$ <span id='".$counterId."_impo'>".number_format($impoSemana,2,'.','')."</span></b></td>";
                                echo "<td><b>$ <span id='".$counterId."_sem'>".number_format($countSemana,2)."</span></b></td>";
                                $countSemana = 0;
                                $impoSemana = 0;
                                          $counterId += 1;
          										} else {
                                echo "<td></td>";
                                echo "<td>".$deLic.$feriado."</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                              }
          									echo "</tr>";
          								}
          								$FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));
          							}
                        if (date('N',strtotime($FECHA)) != 6) {
                          
                                      if ($deLic!='') {
                                        $class_estilos_traslado='';
                                        $class_estilos_aledanio = '';
                                          $clasePeaje = 'color: white !important';
                                          $nombAledanio='';
                                          $class_estilos_aledanio = '';
                                      }

                                      
                                echo "<tr class='bg-navy'>";
                                echo "<td>SUBTOTAL</td>";
                              
                              echo "<td style='display:none'>".$FECHA."</td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                              echo "<td></td>";
                                echo "<td><b>$ <span id='".$counterId."_impo'>".number_format($impoSemana,2,'.','')."</span></b></td>";
                                echo "<td><b>$ <span id='".$counterId."_sem'>".number_format($countSemana,2)."</span></b></td>";
                                $countSemana = 0;
                                $impoSemana = 0;
                                          $counterId += 1;
                            echo "</tr>";
                        }
          							echo "<tr class='bg-green'>";
          								echo "<td>TOTAL</td>";
          								echo "<td style='display:none'>".$FECHA."</td>";
          								echo "<td></td>";
          								echo "<td></td>";
          								echo "<td></td>";
          								echo "<td></td>";
          								echo "<td></td>";
          								echo "<td></td>";
          								echo "<td></td>";
          								echo "<td><b>$ <span id='total_impo'>".number_format($impoCiclo,2,'.','')."</span></b></td>";
          								echo "<td><b>$ <span id='total_reint'>".number_format($countCiclo,2,'.','')."</span></b></td>";
          							echo "</tr>";
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
              <div class="col-md-4">
                <label>Importe</label>
                <input type="number" name="importe" class="form-control" step="0.01"  required="" readonly="">
              </div>
              <div class="col-md-4">
                <label>Reintegro</label>
                <input type="number" name="reintegro" class="form-control" step="0.01"  required="">
              </div>
              <div class="col-md-4">
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
    $("#mnu_tickets_resumen_gestor").addClass("active");
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
    var semana = $(this).attr('data-week');
    var oldReint = $(this).attr('data-old');
    var sumsem = $('#'+semana+'_sem').html();
    var imposem = $('#'+semana+'_impo').html();
    var sumTotal = $('#total_reint').html();
    var impoTotal = $('#total_impo').html();

    total_sem_reint = sumsem - Number(oldReint) + Number(reintegro);
    total_per_reint = sumTotal - Number(oldReint) + Number(reintegro);
    dif = imposem - Number(total_sem_reint);
    difTotal = impoTotal - Number(total_per_reint);
    
    console.log(total_sem_reint);
    console.log(dif);
    $('#'+semana+'_sem').html(parseFloat(total_sem_reint).toFixed(2));
    $('#'+semana+'_semdif').html(parseFloat(dif).toFixed(2));
    $('#total_reint').html(parseFloat(total_per_reint).toFixed(2));
    $('#total_dif').html(parseFloat(difTotal).toFixed(2));
    $(this).attr('data-old', reintegro);
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

      url_filtro_reporte="index.php?view=tickets_resumen_gestor&fdesde="+aStart+"&fhasta="+aEnd;


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

      url_filtro_reporte="index.php?view=tickets_resumen_gestor&fdesde="+aStart+"&fhasta="+aEnd;


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
          "order": [[ 1, "asc" ]],
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