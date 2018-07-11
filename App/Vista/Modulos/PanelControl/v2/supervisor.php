<?php
  include_once PATH_NEGOCIO."Sistema/handlersupervisor.class.php";  
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 

  $dFecha = new Fechas;
  $handler = new HandlerSupervisor;
  $handlerS = new HandlerSistema;

  $user = $usuarioActivoSesion;

  $fHOY = $dFecha->FechaActual();
  $fHOY = $dFecha->FormatearFechas($fHOY,"Y-m-d","Y-m-d"); 

  $f = new DateTime();
  $f->modify('first day of this month');
  $fMES = $f->format('Y-m-d'); 

  setlocale(LC_TIME, 'spanish');  
  $nombreMES = strftime("%B",mktime(0, 0, 0, $f->format('m'), 1, 2000));      
  $anioMES = $f->format('Y'); 

  $mes = $dFecha->Mes($f->format('m'));
  
  $allPlazas = $handler->selectPlazasBySupervisorId($user->getUserSistema());

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>Resumen Diario - (<span class="text-yellow"><?php echo $dFecha->FormatearFechas($fHOY,'Y-m-d','d/m/Y - h:i'); ?></span>)</h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>      
    </ol>
  </section>
  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>
                  
    <div class="content-fluid">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Plazas</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Productos</a></li>
            </ul>
            <div class="tab-content col-xs-12">
              <div class="tab-pane active" id="tab_1">
                <div class="cpanel">
                  <?php
                    if(!empty($allPlazas))
                    {                   
                      foreach ($allPlazas as $key => $value) {
                  
                        include PATH_VISTA."Modulos/PanelControl/Widget/ResumenPlaza/supervisor.php";

                      }
                    }
                  ?>
                </div>
              </div>
              <div class="tab-pane" id="tab_2">
                <div class="cpanel">
                  <?php
                    if(!empty($allPlazas)) {
                      
                      $allEmpresas = [];
                      foreach ($allPlazas as $key => $value) {

                        $arrEmpre = $handlerS->selectAllEmpresaFiltro(null, null, null, $value["alias"], null);

                        
                        if(!empty($arrEmpre))
                        {                   
                          foreach ($arrEmpre as $key => $value1) {

                            $allEmpresas[] = $value1->EMPTT11_CODIGO;

                          }
                        }
                        
                      }

                      $allEmpresas = array_unique($allEmpresas);

                      foreach ($allEmpresas as $key => $value2) {

                        $valueEmpresas = $handlerS->selectEmpresaById($value2)[0];

                        include PATH_VISTA."Modulos/PanelControl/Widget/ResumenProducto/supervisor.php";
                      }

                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="padding-top: 20px;">
        <div class="col-md-12 col-lg-12">
          <div class="col-md-6">
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Estados/supervisor.php"; ?>
          </div>

          <div class="col-md-6">
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Efectividad/supervisor.php"; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content-header">
    <h1>Resumen Mensual - (<span class="text-yellow"><?php echo($mes.' '.$anioMES); ?></span>)</h1>
  </section>

  <section class="content">
    <div class="content-fluid">
      <div class="row">
        <div class="col-md-12 col-lg-12">
            
          <div class="col-md-4">
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/GestionMensualEfectividad/supervisor.php"; ?>
          </div>

          <div class="col-md-4">
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/ServiciosMensualEfectividad/supervisor.php"; ?>
          </div>

          <div class="col-md-4">
            <?php include_once PATH_VISTA."Modulos/PanelControl/Widget/Puntaje/supervisor.php"; ?>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>

<script type="text/javascript">        
  $(document).ready(function(){                
    $("#mnu_panelcontrol").addClass("active");
  });

  setTimeout('document.location.reload()',300000);
</script>