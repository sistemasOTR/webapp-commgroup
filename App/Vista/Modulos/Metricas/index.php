<?php
  include_once PATH_NEGOCIO."Sistema/handlerconsultas.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";  

  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
  
  $user = $usuarioActivoSesion;
  
  $dFecha = new Fechas;

  $handlerSist = new HandlerSistema;
  $arrEmpresas = $handlerSist->selectAllEmpresa();
  $arrGestores = $handlerSist->selectAllGestorArray();
  $arrCoord = $handlerSist->selectAllCoordinador(null);

  $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());
  $fdesdeR = (isset($_GET["fdesdeR"])?$_GET["fdesdeR"]:'');
  $fhastaR = (isset($_GET["fhastaR"])?$_GET["fhastaR"]:'');      
  $tipo = (isset($_GET["tipo"])?$_GET["tipo"]:'');   
  $fvista = (isset($_GET["fvista"])?$_GET["fvista"]:'');
  $plaa = unserialize(isset($_GET["plaa"])?$_GET["plaa"]:'');
  $empresas = unserialize(isset($_GET["empresas"])?$_GET["empresas"]:'');
  $empleados = unserialize(isset($_GET["empleados"])?$_GET["empleados"]:'');

  $asd = 0; 
        $asdepm = 0;    
  // $url_servicios = "index.php?view=servicio&fgestor=".$fgestor."&fdesde=".$fdesde."&fhasta=".$fhasta."&festado=";     
  // $fcoordinador= $user->getAliasUserSistema();
  // $fdesde='2018-10-01';
  // $fhasta = '2018-10-31';
  // var_dump($arrGestores);
  // exit();
$url_select=PATH_VISTA.'Modulos/Metricas/action_select.php';
        
  $handler =  new HandlerConsultas;
?>
<style>
ul li {list-style:none;}
  td{font-size: 10pt;}
  /*tr {border-bottom: 1px solid #999;}*/
</style>
<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Métricas
      <small>Detalle del métricas con resolución entre el <?php echo $fdesde ?> y el <?php echo $fhasta ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Puntajes</li>
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
          <form action="<?php echo $url_select; ?>" method="post" enctype="multipart/form-data">
              <div class='row'> 
                <div class="col-md-3">
                    <label>Fecha Operación: Desde - Hasta</label>
                    <div class="input-group">
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $fdesde; ?>"/>
                      <span class="input-group-addon" >a</span>
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="end" name="end" value="<?php echo $fhasta; ?>"/>
                    </div>
                    
                </div>
                <div class="col-md-3">
                <label>Nivel</label>
                <select id="slt_tipo" class="form-control" style="width: 100%" name="slt_tipo" onchange="crearHref()">
                  <!-- <option value='0' <?php if ($tipo == 0) { echo "selected";} ?>>GLOBAL</option> -->
                  <option value='1' <?php if ($tipo == 1) { echo "selected";} ?>>EMPRESA</option>
                  <option value='2' <?php if ($tipo == 2) { echo "selected";} ?>>PLAZA</option>
                  <option value='3' <?php if ($tipo == 3) { echo "selected";} ?>>GESTOR</option>
                  
                </select>
              </div>
                <div class="col-md-2">
                  <label >Vista</label>
                  <select name="slt_vista" id="slt_vista" class="form-control" onchange="crearHref()">
                    <option value="0">Completa</option>
                    <option value="1" <?php if ($fvista == 1) {echo "selected";} ?>>Numérica</option>
                    <option value="2" <?php if ($fvista == 2) {echo "selected";} ?>>Porcentual</option>
                  </select>
                </div>
                

                
              </div>
              <div class="row">  
                <div class="col-md-3">
                    <label>Fecha Resolución: Desde - Hasta</label>
                    <div class="input-group">
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="startR" name="startR" value="<?php echo $fdesdeR; ?>"/>
                      <span class="input-group-addon" >a</span>
                      <input type="date" class="input-sm form-control" onchange="crearHref()" id="endR" name="endR" value="<?php echo $fhastaR; ?>"/>
                    </div>
                </div>
           
                <div class="col-xs-3">
                  <label></label> 
                  <a data-toggle='modal' data-target='#modal-nuevo' class="btn btn-block btn-warning">Plazas</a>
                </div>
                <div class="modal modal-default fade" id="modal-nuevo">
                   <div class="modal-dialog" >
                  <div class="modal-content">

                    <!-- <form id="form_plaza" action="<?php echo $url_action_select_plazas ;?>" method="post" enctype="multipart/form-data"> -->
                      <input type="hidden" name="usuario" value="">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span></button>
                        <h4 id="pla" class="modal-title">PLAZAS</h4>
                      </div>      
                           
                      <div class="modal-body">
                          <div class="row">
                         <div class="col-xs-12">
                           
                          <?php if (empty($plaa)) { ?>
                             <ul>
                          <?php  foreach ($arrCoord as $sltPlaza) { 
                            if ($sltPlaza->CORDI91_ALIGTE == 'ZARATE' || $sltPlaza->CORDI91_ALIGTE == 'CORIA') { ?>
                           <li  class="col-md-6"><input type="checkbox" id="plaza_<?php echo $asd+=1 ?>" class="plazas" name="id[]" value="<?php echo $sltPlaza->CORDI11_ALIAS ?>"> <?php echo $sltPlaza->CORDI11_ALIAS; ?> </li> 
                          <?php }} ?>
                        </ul>
                          <?php } else{ ?> 
                           <ul>
                          <?php  foreach ($arrCoord as $sltPlaza) {
                            if ($sltPlaza->CORDI91_ALIGTE == 'ZARATE' || $sltPlaza->CORDI91_ALIGTE == 'CORIA') {
                               foreach ($plaa as $key => $vlv) { 
                                 if($sltPlaza->CORDI11_ALIAS==$vlv){
                                   $chek="checked";
                                   break;
                                    }else{
                                    $chek="";
                                    }
                                 }  ?>                                                                              
                           <li class="col-md-6"><input type="checkbox" <?php echo $chek ?> id="plaza_<?php echo $asd+=1 ?>" class="plazas" name="id[]" value="<?php echo $sltPlaza->CORDI11_ALIAS?>"> <?php echo $sltPlaza->CORDI11_ALIAS; ?> </li> 
                          <?php   }}  ?>
                        </ul>

                <?php } ?> 

                         </div>      
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id='plaza_todas' data-dismiss="modal" class="btn btn-default pull-left">TODAS</button>
                        <button type="button" id='enviar'  data-dismiss="modal" class="btn btn-primary">OK</button>
                      </div>
                    <!-- </form> -->

                  </div>
                </div>
              </div>


                <div class="col-xs-3">
                  <label></label> 
                  <a data-toggle='modal' data-target='#modal-nuevo-empresas' class="btn btn-block btn-warning">Empresas</a>
                </div>

                <div class="modal modal-default fade" id="modal-nuevo-empresas">
                   <div class="modal-dialog" style="width: 60vw;">
                  <div class="modal-content">

                    <!-- <form action="<?php echo $url_action_select_empleados ;?>" method="post" enctype="multipart/form-data"> -->
                      <input type="hidden" name="usuario" value="">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span></button>
                        <h4 id="pla" class="modal-title">EMPRESAS</h4>
                      </div>      
                           
                      <div class="modal-body">
                          <div class="row">
                         <div class="col-xs-12">

                           <?php if (empty($empresas)) { ?>
                           <ul>   
                          <?php foreach ($arrEmpresas as $empresa_chk) { 
                            if ($empresa_chk->EMPTT91_ACTIVA == 'S') {
                                ?>
                           <li class="col-md-4"><input type="checkbox" name="empresas[]" id="empre<?php echo $asdepm+=1 ?>" class="empresas" value="<?php echo $empresa_chk->EMPTT11_CODIGO ?>"> <?php echo $empresa_chk->EMPTT21_NOMBREFA; ?> </li> 
                          <?php }} ?>
                        </ul>
                        <?php } else{ ?>
                           <ul>   
                          <?php foreach ($arrEmpresas as $empresa_chk) { 
                            if ($empresa_chk->EMPTT91_ACTIVA == 'S') {
                              foreach ($empresas as $key => $vlv) { 
                                 if($empresa_chk->EMPTT11_CODIGO == $vlv){
                                   $chek="checked";
                                   break;
                                    }else{
                                    $chek="";
                                   }  
                                  }  ?>                      
                           <li class="col-md-4"><input type="checkbox" name="empresas[]"  <?php echo $chek; ?> id="empre<?php echo $asdepm+=1; ?>" class="empresas" value="<?php echo $empresa_chk->EMPTT11_CODIGO ?>"> <?php echo $empresa_chk->EMPTT21_NOMBREFA; ?> </li> 
                          <?php  }} ?>
                        </ul>

                        <?php } ?>
                         </div>      
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id='empresas_todas' data-dismiss="modal" class="btn btn-default pull-left">TODAS</button>
                        <button type="button" data-dismiss="modal" id='enviar_emp' class="btn btn-primary">OK</button>
                      </div>
                    <!-- </form> -->

                  </div>
                </div>
              </div>


                <div class="col-xs-3">
                  <label></label> 
                  <a data-toggle='modal' <?php if($tipo == 2){ echo "disabled"; } ?> data-target='#modal-nuevo-empleados' class="btn btn-block btn-warning">Gestores</a>
                </div>

                 <div class="modal modal-default fade" id="modal-nuevo-empleados">
                   <div class="modal-dialog" style="width: 60vw;">
                  <div class="modal-content">

                    <!-- <form action="<?php echo $url_action_select_empleados ;?>" method="post" enctype="multipart/form-data"> -->
                      <input type="hidden" name="usuario" value="">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span></button>
                        <h4 id="pla" class="modal-title">GESTORES</h4>
                      </div>      
                           
                      <div class="modal-body">
                          <div class="row">
                         <div class="col-xs-12">

                           <?php if (empty($empleados)) { ?>
                           <ul>   
                          <?php foreach ($arrGestores as $gestor) { 
                            if ($gestor[5] == 'S') {
                                ?>
                           <li class="col-md-4"><input type="checkbox" name="empleados[]" id="emp<?php echo $asdepm+=1 ?>" class="empleados" value="<?php echo $gestor[0]?>"> <?php echo $gestor[1]; ?> </li> 
                          <?php }} ?>
                        </ul>
                        <?php } else{ ?>
                           <ul>   
                          <?php foreach ($arrGestores as $gestor) { 
                            if ($gestor[5] == 'S') {
                              foreach ($empleados as $key => $vlv) { 
                                 if($gestor[0]==$vlv){
                                   $chek="checked";
                                   break;
                                    }else{
                                    $chek="";
                                   }  
                                  }  ?>                      
                           <li class="col-md-4"><input type="checkbox" name="empleados[]"  <?php echo $chek; ?> id="emp<?php echo $asdepm+=1; ?>" class="empleados" value="<?php echo $gestor[0] ?>"> <?php echo $gestor[1]; ?> </li> 
                          <?php  }} ?>
                        </ul>

                        <?php } ?>
                         </div>      
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" id='empleados_todas' data-dismiss="modal" class="btn btn-default pull-left">TODOS</button>
                        <button type="button" data-dismiss="modal" id='enviar_emp' class="btn btn-primary">OK</button>
                      </div>
                    <!-- </form> -->

                  </div>
                </div>
              </div>
                
              </div>
              <div class="row">
                <div class='col-md-3 pull-right'>                
                    <label></label>                
                    <button type="submit" class="btn btn-block btn-success" id="filtro_reporte"><i class='fa fa-calculator'></i> Calcular</button>
                  </div>
              </div>
          </form>     
              </div>
            </div>
        </div>
      <?php 
        switch ($tipo) {
          case 0:
            include_once 'global.php';
            break;
          case 1:
            include_once 'empresas.php';
            break;
          case 2:
            include_once 'plazas.php';
            break;
          case 3:
            include_once 'gestores.php';
            break;
          
          default:
            include_once 'global.php';
            break;
        }
       ?>

</div>
</section>
</div>



<script type="text/javascript">

  function crearHref()
  {
      aStart = $("#start").val();
      aEnd = $("#end").val();

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];   

      aStartR = $("#startR").val();
      aEndR = $("#endR").val();

      f_inicioR = aStartR[2] +"-"+ aStartR[1] +"-"+ aStartR[0];
      f_finR = aEndR[2] +"-"+ aEndR[1] +"-"+ aEndR[0];                                 

      // f_usuario = $("#slt_usuario").val();   


      f_plazas = $('#form_plaza').serialize();
      console.log(f_plazas);
      // f_plaza = $("#slt_plaza").val();
      f_tipo = $("#slt_tipo").val();
      f_plaza = $("#slt_plaza").val();
      f_vista = $("#slt_vista").val();

      url_filtro_reporte="index.php?view=metricas_tt&fdesde="+aStart+"&fhasta="+aEnd+"&fdesdeR="+aStartR+"&fhastaR="+aEndR;
    // if(f_plaza!=undefined)
    //   if(f_plaza!='' && f_plaza!=0)
    //     url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;  

    //   if(f_usuario!=undefined)
    //     if(f_usuario>0)
    //       url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario; 

        if(f_tipo!=undefined)
          url_filtro_reporte= url_filtro_reporte + "&tipo="+f_tipo;

        if(f_plaza!=undefined)
          if (f_plaza>'0')
            url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;

        if(f_vista!=undefined)
          if (f_vista>'0')
            url_filtro_reporte= url_filtro_reporte + "&fvista="+f_vista;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  }

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }

  $(document).ready(function(){                
    $("#mnu_estadisticas").addClass("active");
  });
  $(document).ready(function(){                
    $("#mnu_metricas_tt").addClass("active");
  });

  $(document).ready(function() {
    $("#slt_plazas").select2({
        placeholder: "Seleccionar",                  
    });
  });

  $(document).ready(function(){


     $('#plaza_todas').click(function(event) {   
        $('.plazas').each(function() {
          this.checked = false;                       
        });
        
    });
     
       $('#empresas_todas').click(function(event) { 
        $('.empresas').each(function() {
          this.checked = false;                       
        });
    });

       $('#empleados_todas').click(function(event) {
        $('.empleados').each(function() {
          this.checked = false;
        });
    });
     });

</script>