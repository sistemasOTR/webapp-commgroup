<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
  include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
  include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
  include_once PATH_DATOS.'Entidades/legajos_categorias.class.php';
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 

  $user = $usuarioActivoSesion;
  $dFecha = new Fechas;
  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());
  $estados = (isset($_GET["estados"])?$_GET["estados"]:"");
  $licencias = (isset($_GET["licencias"])?$_GET["licencias"]:"");
  $modo = (isset($_GET["modo"])?$_GET["modo"]:'');//
  $id = $user->getUserPlaza();
  $empleados =(isset($_GET["fusuario"])?$_GET["fusuario"]:'0');
  $url_ajax =PATH_VISTA.'Modulos/Asistencia/select_usuario.php';
  $url_action_select_empleados=PATH_VISTA.'Modulos/Asistencia/action_select_empleados.php';
 
  $handlerLeg = new HandlerLegajos;
  $handlertipocategoria= new LegajosCategorias;
  $handlertickets = new HandlerTickets;
  $handlerUsuarios = new HandlerUsuarios;
  $handlerSistema = new HandlerSistema;
  $handlerAsistencia= new HandlerAsistencias;
  $handlerAsist=new HandlerAsistencias;
  $arrEstados = $handlerAsistencia->selectEstados();
  $handlerplazas=new HandlerPlazaUsuarios();
  $plazasOtr=$handlerplazas->selectTodas();
  $handlerLic= new HandlerLicencias;

  $arrLicenciasAll=$handlerLic->selecionarTipos();
  $arrEmpleados = $handlerUsuarios->selectEmpleados();


 

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
<style>
      .modal-backdrop {z-index: 5 !important;}
    </style>
<div class="content-wrapper">  
  <section class="content-header "> 
    <h1 >
      TABLA PRESENTISMO
      <small>Diario, Semanal y Mensual </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Tipos</li>
    </ol>
  </section>        
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

    <div class='container-fluid'>     
        <div class="row">


      <div class='col-md-12'>
        <div class="box box-solid">
            <div class="box-body">
              <div class='row'>  

                <div class="col-md-2" id='sandbox-container'>
                    <label>Fecha Desde - Hasta </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control"  id="start" name="start" onclick="crearHref()" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control"  id="fin" name="fin" onclick="crearHref()" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div>
                <div class="col-md-2">
                  <label>EMPLEADOS</label> 
                  <select id="slt_usuario" class="form-control" onchange="crearHref()" style="width: 100%" name="usuario" >                
                  <option value="0">Todos</option>
                  <?php foreach ($arrEmpleados as $key => $valEst) {
                    var_dump($arrEmpleados);
                    if($valEst->getId()==$empleados){?> 
                  <option value="<?php echo $valEst->getId();?>" selected><?php echo $valEst->getNombre()." ".$valEst->getApellido(); ?></option>
                  <?php }else{ ?>
                     <option value="<?php echo $valEst->getId();?>" ><?php echo $valEst->getNombre()." ".$valEst->getApellido(); ?></option>
                  <?php } }?>              
                  </select>
                </div>

                <div class="col-md-2">
                  <label>LICENCIAS</label> 
                  <select id="slt_licencias" class="form-control" onchange="crearHref()" style="width: 100%" name="licencias" >               
                    <option value="0" <?php echo ($licencias==0)?"selected":""; ?> >Con o Sin</option>
                    <option value="88888888"<?php echo ($licencias==88888888)?"selected":""; ?> >Ninguna</option>
                    <option value="99999999"<?php echo ($licencias==99999999)?"selected":""; ?>  >Todas</option>
                    <?php foreach ($arrLicenciasAll as $key => $valueLic) {
                      if($valueLic->getId()==$licencias){ var_dump($licencias,$valueLic->getId());   ?> 
                    <option value="<?php echo $valueLic->getId();?>" selected><?php echo $valueLic->getNombre(); ?></option>
                    <?php }else{ ?>
                       <option value="<?php echo $valueLic->getId();?>" ><?php echo $valueLic->getNombre(); ?></option>
                    <?php } }?>              
                  </select>
                </div>

                 <div class='col-md-2 pull-right'>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
                 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class='col-md-10'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-calendar-check-o"></i>  
              <h3 class="box-title">Asistencia</h3>
            </div>
            <div class="box-body  table-responsive">
              <table class="table  table-condensed" style="background-color: rgb(255, 224, 178);" id="tabla" cellspacing="0" width="100%">
                  <thead style="background-color: rgb(232, 234, 246);">
                    <tr>
                      <th  style="width: 40px;"><i style="background-size: red;">EMPLEADOS</i></th>

                      <?php
                       
                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");

                       while (strtotime($FECHA) <= strtotime($HASTA)) { 
                          
                       $diadelasemana= date('N',strtotime($FECHA));
                       $fechadata=$FECHA." 00:00:00.000";
                       $feriado=$handlertickets->selecionarFechasInhabilitadasByFecha($fechadata);   
                       if (is_null($feriado) && ($diadelasemana!=7)){
                        
                          list($año, $dia, $mes) = split('[/.-]', $FECHA);
                          


                         echo "<th >".$mes."/".$dia."</th>";
                       }elseif($diadelasemana==7){
                        echo "<th >Dom</th>";
                       }elseif($feriado){
                        echo "<th>Feriado</th>";
                       }
                        $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA))); 
                      } 

                      ?> 
                      <th>ASIST</th>                                   
                      <th>INASIST</th>                                   
                      <th>DIAS LIC</th>                                   
                      <th>HRS ANOTADO</th>                                   
                    </tr>
                  </thead>
                  <tbody>
                    <?php



                      if (!empty($empleados)) {
                        $seguir=false;
                        $consulta = $handlerLeg->seleccionarByFiltros($empleados);   
                        $arrEmpleados=$handlerUsuarios->selectById($empleados);
                        $l=0;
                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d"); 
                          while (strtotime($FECHA) <= strtotime($HASTA)) { 
                         $arrLicencias2 = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,$arrEmpleados->getId(),2);
                         if (!empty($arrLicencias2)) {
                         	$l+=1;
                         }
                         $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                       }
    
                        if ($licencias==0) {   
                        echo "<tr style='width:10px;'><td width='30'>".$arrEmpleados->getApellido()."".$arrEmpleados->getNombre()."</td>";
                        $seguir=true;
                         }
                        elseif ($licencias==88888888 && empty($l)) {   
                        echo "<tr style='width:10px;'><td width='30'>".$arrEmpleados->getApellido()."".$arrEmpleados->getNombre()."</td>";
                        $seguir=true;
                         } 
                        elseif ($licencias==99999999 && !empty($l)) {   
                        echo "<tr style='width:10px;'><td width='30'>".$arrEmpleados->getApellido()."".$arrEmpleados->getNombre()."</td>";
                        $seguir=true;
                         } 
                         elseif (($licencias!=99999999 ||$licencias!=0 ||$licencias!=88888888) && !empty($l)) { 
                        $l=0;  
                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d"); 
                          while (strtotime($FECHA) <= strtotime($HASTA)) { 
                         $arrLicenciasId=$handlerLic->seleccionarByFiltroTipoRRHH($FECHA,$FECHA,$arrEmpleados->getId(),2,intval($licencias));
                           if (!empty($arrLicenciasId)) {
                         	$l+=1;
                         }
                         $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                       }
                         // var_dump($fdesde,$fhasta,$arrEmpleados->getId(),$licencias,$arrLicenciasId);
                         
                         if (!empty($l)) {
                         	
                             echo "<tr style='width:10px;'><td width='30'>".$arrEmpleados->getApellido()."".$arrEmpleados->getNombre()."</td>";
                            
                        $seguir=true;
                        $datolic=true;
                           }  
                       
                         } 
                         if ($seguir) {
                         
                        $p=0;
                        $lic=0;
                        $a=0;                       
                        

                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d"); 
                          while (strtotime($FECHA) <= strtotime($HASTA)) {
                            $asd="";
                            $asistencias=$handlerAsist->selectAsistenciasByFiltro($FECHA,$FECHA,$arrEmpleados->getId());
                            $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,$arrEmpleados->getId(),2);
                            $diadelasemana= date('N',strtotime($FECHA));
                            $fechadata=$FECHA." 00:00:00.000";
                            $feriado=$handlertickets->selecionarFechasInhabilitadasByFecha($fechadata);  
                            


                          if (!empty($asistencias)) {
             
                        echo "<td><span class='label label-success'>P</span></td>";
                        $p+=1;

                         }elseif(!empty($arrLicencias)){

                                foreach ($arrLicencias as $key => $valuue) {
                          
                                if (!$valuue->getRechazado()) {
       
                                      if($valuue->getAprobado()) {

                                           if ($FECHA <= $valuue->getFechaFin()->format('Y-m-d') ) { 
                                             $lic+=1;
                                            
                                             $tipolic=$handlerLic->selecionarTiposById($valuue->getTipoLicenciasId()->getId());
                                             echo "<td><span class='label label-warning'>".trim($tipolic[0]->getAbreviatura())."</span><a href='index.php?view=licencias_controlcoord&fdesde=".$FECHA."&fhasta=".$FECHA."&fusuario=".$arrEmpleados->getId()."&festados=2'> <i data-toggle='tooltip' title data-original-title='".$tipolic[0]->getNombre()."' class='fa fa-plus-square-o'></i></a></td>";
                                            

                                            }
                                       }
                                    }
                                }
                              

                        }elseif ($feriado || $diadelasemana==7) {
                          echo "<td style='background-color:rgb(232, 234, 246); text-align:center;'><i>-</i></td>";
                        } 
                         else{
                           $a+=1;
                          echo "<td><font color='red'>A</font></td>";
                         }  
                         
                        $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                       }
                     echo "<td style='background-color: rgb(82, 190, 128); text-align:center;'>".$p."</td>";
                     echo "<td style='background-color:rgb(229, 152, 102); text-align:center;'>".$a."</td>";
                     echo "<td style=' background-color: #80ced6; text-align:center;'>".$lic."</td>";
                     if (!empty($consulta2)) {
                     	 echo "<td style=' background-color: rgb(215, 189, 226); text-align:center;'>".$consulta2[""]->getHoras()."</td>";
                     }else{
                     	echo "<td style=' background-color: rgb(215, 189, 226); text-align:center;'>-</td>";
                     }
                     echo "</tr>";

                      } } // cierre si hay empleado
                      else{

                        
                     foreach ($arrEmpleados as $key => $value) { 
                        $seguir=false;
                        $consulta2 = $handlerLeg->seleccionarByFiltros($value->getId());
                        // var_dump($consulta2);
                        $l=0;
                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d"); 
                          while (strtotime($FECHA) <= strtotime($HASTA)) { 
                         $arrLicencias= $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,$value->getId(),2);
                         if (!empty($arrLicencias)) {
                         	$l+=1;
                         }
                         $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                       }
                        


                        if ($licencias==0) {   
                        echo "<tr style='width:10px;'><td width='30'>".$value->getApellido()."".$value->getNombre()."</td>";
                        $seguir=true;
                         }
                        elseif ($licencias==88888888 && empty($l)) {   
                        echo "<tr style='width:10px;'><td width='30'>".$value->getApellido()."".$value->getNombre()."</td>";
                        $seguir=true;
                         } 
                        elseif ($licencias==99999999 && !empty($l)) {   
                        echo "<tr style='width:10px;'><td width='30'>".$value->getApellido()."".$value->getNombre()."</td>";
                        $seguir=true;
                         } 
                         elseif (($licencias!=99999999 ||$licencias!=0 ||$licencias!=88888888) && !empty($l)) { 
                        $l=0;
                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d"); 
                          while (strtotime($FECHA) <= strtotime($HASTA)) { 
                         $arrLicenciasId=$handlerLic->seleccionarByFiltroTipoRRHH($FECHA,$FECHA,$value->getId(),2,$licencias);
                         if (!empty($arrLicenciasId)) {
                         	$l+=1;
                         }
                         $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                       } 
                         
                         if (!empty($l)) {
                             echo "<tr style='width:10px;'><td width='30'>".$value->getApellido()."".$value->getNombre()."</td>";
                        $seguir=true;
                        $datolic=true;
                           }  
                       
                         } 
                         if ($seguir) {
                         
                        $p=0;
                        $lic=0;
                        $a=0;

                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d"); 
                          while (strtotime($FECHA) <= strtotime($HASTA)) {
                            $asd="";
                            $asistencias=$handlerAsist->selectAsistenciasByFiltro($FECHA,$FECHA,$value->getId());
                            $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,intval($value->getId()),2);
                            $diadelasemana= date('N',strtotime($FECHA));
                            $fechadata=$FECHA." 00:00:00.000";
                            $feriado=$handlertickets->selecionarFechasInhabilitadasByFecha($fechadata);  


                          if (!empty($asistencias)) {
             
                        echo "<td><span class='label label-success'>P</span></td>";
                         $p+=1;

                         }elseif(!empty($arrLicencias)){
                            foreach ($arrLicencias as $key => $valuue) {
                          
                                if (!$valuue->getRechazado()) {
       
                                      if($valuue->getAprobado()) {

                                           if ($FECHA <= $valuue->getFechaFin()->format('Y-m-d') ) { 
                                            $lic+=1;
                                            $tipolic=$handlerLic->selecionarTiposById($valuue->getTipoLicenciasId()->getId());

                                             echo "<td><span class='label label-warning'>".trim($tipolic[0]->getAbreviatura())."</span><a href='index.php?view=licencias_controlcoord&fdesde=".$FECHA."&fhasta=".$FECHA."&fusuario=".$value->getId()."&festados=2'> <i data-toggle='tooltip' title data-original-title='".$tipolic[0]->getNombre()."' class='fa fa-plus-square-o'></i></a></td>";
                                            

                                            }
                                       }
                                    }
                                }
                         }elseif ($feriado || $diadelasemana==7) {
                          echo "<td style='background-color:rgb(232, 234, 246); text-align:center;'><i>-</i></td>";
                        }else{
                          $a+=1;
                          echo "<td><font color='red'>A</font></td>";
                         }    

                         
                        $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
                       }
                       
                     echo "<td style='background-color: rgb(82, 190, 128); text-align:center;'>".$p."</td>";
                     echo "<td style='background-color:rgb(229, 152, 102); text-align:center;'>".$a."</td>";
                     echo "<td style=' background-color: #80ced6; text-align:center;'>".$lic."</td>";
                     if (!empty($consulta2)) {
                     	 echo "<td style=' background-color: rgb(215, 189, 226); text-align:center;'>".$consulta2[""]->getHoras()."</td>";
                     }else{
                     	echo "<td style=' background-color: rgb(215, 189, 226); text-align:center;'>-</td>";
                     }
                    
                     echo "</tr>";
                     } 
                    }
                  } 
                    ?>      
                 <i style="text-align:center;  "></i>
                </tbody>
              </table>
               
              

            </div>
        </div>
      </div>

       <div class='col-md-2'>
        <div class="box box-solid">
            <div class="box-header with-border">  
              <i class="fa fa-file-text-o"></i>  
              <h3 class="box-title">Licencias</h3>
            </div>
            <div class="box-body  table-responsive">
        <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
           <thead>
              <tr>
                <th  style="width: 40px;"><span>ABREVIACIÓN</span></th> 
                <th  style="width: 40px;"><span>NOMBRE</span></th> 
                 </tr>
                  </thead>
                 <tbody>
                  <?php 

                    $todasLic=$handlerLic->selecionarTipos();
                       foreach ($todasLic as $key => $vl) {
                         echo "<tr><td>".$vl->getAbreviatura()."</td><td>".$vl->getNombre()."</td></tr>";
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

  $(document).ready(function() {
    $("#slt_usuario").select2({
        placeholder: "Seleccionar",                  
      }).on('change', function (e) { 
      
      });
    }); 
    $(document).ready(function() {
    $("#slt_licencias").select2({
        placeholder: "Seleccionar",                  
    }).on('change', function (e) { 
      
    });
  });
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
  crearHref();
  function crearHref()
  {
      aStart = $("#start").val().split('/');;
      aEnd = $("#fin").val().split('/');;

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      f_usuario = $("#slt_usuario").val();     
      f_licencias = $("#slt_licencias").val();     
      
      url_filtro_reporte="index.php?view=tabla_asistencias&fdesde="+f_inicio+"&fhasta="+f_fin+"&fusuario="+f_usuario+"&licencias="+f_licencias;
   
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 
</script>
  