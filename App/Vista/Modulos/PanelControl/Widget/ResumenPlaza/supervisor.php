<?php
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
    
    $dFecha = new Fechas;    
    $handler = new HandlerSistema;  
  
    $user = $usuarioActivoSesion;

    /*-------------------------*/
    /* --- gestion de fechas --*/
    $fHOY = $dFecha->FechaActual();
    $fHOY = $dFecha->FormatearFechas($fHOY,"Y-m-d","Y-m-d"); 

    $f = new DateTime();
    $f->modify('first day of this month');
    $fMES = $f->format('Y-m-d'); 

    setlocale(LC_TIME, 'spanish');  
    $nombreMES = strftime("%B",mktime(0, 0, 0, $f->format('m'), 1, 2000));      
    $anioMES = $f->format('Y'); 
    /*-------------------------*/

    //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
    if(!PRODUCCION)
      $fHOY = "2018-07-03";


    //INICIO GESTIONES DIARIAS
    $sum_total_estados=0; 
    $sum_estados_gestionados=0;
    $porc_estados_gestionados=0;

    $plaza = $value["alias"];

    if(!empty($plaza))
    {
      $arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,null,null,null,$plaza,null);   

      $allEstados = $handler->selectAllEstados();

      if(!empty($arrEstados))
      {                   
        foreach ($arrEstados as $key => $value_estado) {

          $f_array = new FuncionesArray;
          $class_estado = $f_array->buscarValor($allEstados,"1",$value_estado->ESTADOS_DESCCI,"2");

            // totales
            $sum_total_estados = $sum_total_estados + $value_estado->CANTIDAD_SERVICIOS;

            if($value_estado->SERTT91_ESTADO>2)
              $sum_estados_gestionados = $sum_estados_gestionados + $value_estado->CANTIDAD_SERVICIOS;
        }
      }

      if(empty($sum_total_estados))
        $porc_estados_gestionados = 0;
      else  
        $porc_estados_gestionados = round(($sum_estados_gestionados / $sum_total_estados) *100,2);
    }
    //FIN GESTIONES DIARIAS

    //INICIO SERVICIOS DIARIOS
    $cerrados = 0; 
    $despachados = 0;
    
    if(!empty($plaza))
    {

      $arrGestores = $handler->selectServiciosByGestor($fHOY,$fHOY, null, null, null, null, $plaza, null);
      $arrEstados = $handler->selectGroupServiciosByEstados($fHOY,$fHOY,null,null,null,null,$plaza,null); 

      $cerrados_efec =  $handler->selectCountServicios($fHOY,$fHOY, 6, null, null, null, $plaza, null);
      $despachados_efec = $handler->selectCountServicios($fHOY,$fHOY, 400, null, null, null, $plaza, null);  

      if($despachados_efec[0]->CANTIDAD_SERVICIOS>0){        
        $cerrados = $cerrados + $cerrados_efec[0]->CANTIDAD_SERVICIOS;
        $despachados = $despachados + $despachados_efec[0]->CANTIDAD_SERVICIOS;
      }
      else{
        $cerrados = $cerrados + 0;
        $despachados = $despachados + 0;
      }

      if($despachados > 0)
        $efectividad_dia = round(($cerrados / $despachados) * 100, 2);

      else
        $efectividad_dia = 0;

      $class_semaforo = "bg-red";
      if($efectividad_dia>=0 && $efectividad_dia<60)
        $class_semaforo = "bg-red";

      if($efectividad_dia>=60 && $efectividad_dia<70)
        $class_semaforo = "bg-yellow";

      if($efectividad_dia>=70 && $efectividad_dia<=100)
        $class_semaforo = "bg-green";   
    }
    //FIN SERVICIOS DIARIOS

    //INICIO SERVICIOS POR VENCER

      $porcentaje_por_vencer = 0;
      $porcentaje_vencido = 0;

      if(!empty($plaza))
      {
        $arrPorVencer = $handler->selectServiciosPorVencerByGestor(2,null,null,null,$plaza,null,'A TIEMPO');

        $sum_por_vencer=0;
        if(!empty($arrPorVencer)) {
          foreach ($arrPorVencer as $key => $value_PorVencer) {

            //$url_por_vencer = "?view=servicio&fdesde=".$fHOY."&fhasta=".$fHOY."&festado=2&fgestor=".$value->CODGESTOR;

            //echo "<li><a href='".$url_por_vencer."'>".$value->NOMGESTOR."<span class='pull-right'>".$value->CANTIDAD." op</span></a></li>";

            $sum_por_vencer = $sum_por_vencer + $value_PorVencer->CANTIDAD;
          }
        }

        if($sum_total_estados > 0)
          $porcentaje_por_vencer = round((($sum_por_vencer / $sum_total_estados) * 100), 2);

        else
          $porcentaje_por_vencer = 0;
      }
    //FIN SERVICIOS POR VENCER

    //INICIO SERVICIOS VENCIDOS
      if(!empty($plaza))
      {
        $arrVencido = $handler->selectServiciosPorVencerByGestor(2,null,null,null,$plaza,null,'VENCIDOS');  

        $sum_vencido=0;
        if(!empty($arrVencido)) {
          foreach ($arrVencido as $key => $valueVencido) {
            //$url_vencido = "?view=servicio&fdesde=".$fHOY."&fhasta=".$fHOY."&festado=2&fgestor=".$value->CODGESTOR;

            //echo "<li><a href='".$url_vencido."'>".$value->NOMGESTOR."<span class='pull-right'>".$value->CANTIDAD." op</span></a></li>";

            $sum_vencido = $sum_vencido + $valueVencido->CANTIDAD;
          }

        }

        if($sum_total_estados > 0)
          $porcentaje_vencido = round((($sum_vencido / $sum_total_estados) * 100), 2);

        else
          $porcentaje_vencido = 0;
      }
    //FIN SERVICIOS VENCIDOS
?>
    <div class="box no-border">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="ion-stats-bars"> </i> <?php echo $value["alias"]; ?></h3>
      </div>
      <div class="box-body no-padding">
        <div class="box-group" id="accordion">
          <!--GESTIONES-->
          <div class="col-md-3 col-sm-6">
            <div class="panel box no-border">
              <div class="box-header no-padding">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $plaza; ?>-collapse1">
                  <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="ion-ios-paperplane"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">GESTIONES</span>
                      <span class="info-box-number"><?php echo $porc_estados_gestionados."%"; ?></span>

                      <div class="progress">
                        <div class="progress-bar" style="width: <?php echo $porc_estados_gestionados."%"; ?>"></div>
                      </div>
                      <span class="progress-description">
                        <?php echo $sum_total_estados; ?> <small>Total</small> 
                        <span class="pull-right"><?php echo $sum_estados_gestionados; ?> <small>Gestionadas</small></span>
                      </span>
                    </div>
                  </div>
                </a>
              </div>
              <div id="<?php echo $plaza; ?>-collapse1" class="panel-collapse collapse">
                <div class="box-body no-padding">
                  <ul class="nav nav-stacked">
                    <?php
                      if(!empty($arrEstados))
                      {                   
                        foreach ($arrEstados as $key => $value_estado_gestion) {

                          $f_array = new FuncionesArray;
                          $class_estado = $f_array->buscarValor($allEstados,"1",$value_estado_gestion->ESTADOS_DESCCI,"2");

                            if(!($value_estado_gestion->ESTADOS_DESCCI=="Liquidar C. Parcial") || !($value_estado_gestion->ESTADOS_DESCCI=="No Efectivas"))
                            {
                              echo "                  
                                <li><a href='#'>".$value_estado_gestion->ESTADOS_DESCCI." <span class='pull-right badge ".$class_estado."'>
                                ".round($value_estado_gestion->CANTIDAD_SERVICIOS,2)."
                                </span></a></li>";
                            }
                        }                        
                      }                 
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!--EFECTIVIDAD-->
          <div class="col-md-3 col-sm-6">
            <div class="panel box no-border">
              <div class="box-header no-padding">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $plaza; ?>-collapse2">
                  <div class="info-box <?php echo $class_semaforo; ?>">
                    <span class="info-box-icon"><i class="ion-arrow-graph-up-right"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Efectividad</span>
                      <span class="info-box-number"><?php echo round($efectividad_dia,2); ?>%</span>

                      <div class="progress">
                        <div class="progress-bar" style="width: <?php echo round($efectividad_dia,2); ?>%"></div>
                      </div>
                      <span class="progress-description">

                      </span>

                    </div>

                  </div> 
                </a>
              </div>
              <div id="<?php echo $plaza; ?>-collapse2" class="panel-collapse collapse">
                <div class="box-body no-padding">
                  <ul class="nav nav-stacked">
                    <?php             
                      if( !empty($arrGestores)) {

                        foreach ($arrGestores as $key => $value) {
                          if($value->DESPACHADO>0){        
                            $efec_gestor = 100 * $value->CERRADO / $value->DESPACHADO;
                          }
                          else{
                            $efec_gestor = 0;
                          }                

                        $class_semaforo_gestor = "bg-red";
                        if($efec_gestor>=0 && $efec_gestor<60)
                          $class_semaforo_gestor = "bg-red";

                        if($efec_gestor>=60 && $efec_gestor<70)
                          $class_semaforo_gestor = "bg-yellow";

                        if($efec_gestor>=70 && $efec_gestor<=100)
                          $class_semaforo_gestor = "bg-green";  
  
                          echo "<li><a href='#'>".$value->NOMGESTOR." <span class='pull-right badge ".$class_semaforo_gestor."'>".round($efec_gestor,2)."%</span></a></li>";
                        }                    

                      }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!--POR VENCER-->
          <div class="col-md-3 col-sm-6">
            <div class="panel box no-border">
              <div class="box-header no-padding">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $plaza; ?>-collapse3">
                  <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="ion-alert-circled"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Próx. Vencimientos</span>
                      <span class="info-box-number"><?php echo $sum_por_vencer; ?></span>
                      <div class="progress">
                        <div class="progress-bar" style="width: <?php echo round($porcentaje_por_vencer,2); ?>%"></div>                         
                      </div>
                      <span class="progress-description pull-right">
                      <?php echo $porcentaje_por_vencer; ?>  % del total
                      </span>
                    </div>
                  </div>
                </a>
              </div>
              <div id="<?php echo $plaza; ?>-collapse3" class="panel-collapse collapse">
                <div class="box-body no-padding">
                  <ul class="nav nav-stacked">
                    <?php             
                      if(!empty($arrPorVencer)) {
                        foreach ($arrPorVencer as $key => $valuePorVencerGestor) {
                        
                          echo "<li><a href='#'>".$valuePorVencerGestor->NOMGESTOR."<span class='pull-right'>".$valuePorVencerGestor->CANTIDAD." op</span></a></li>";
                        }
                      }                        
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!--VENCIDAS-->
          <div class="col-md-3 col-sm-6">
            <div class="panel box no-border">
              <div class="box-header no-padding">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $plaza; ?>-collapse4">
                  <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="ion-ios-timer-outline"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Gestiones vencidas</span>
                      <span class="info-box-number"><?php echo $sum_vencido; ?></span>
                      <div class="progress">
                        <div class="progress-bar" style="width: <?php echo round($porcentaje_vencido,2); ?>%"></div>   
                      </div>
                      <span class="progress-description pull-right">
                      <?php echo $porcentaje_vencido; ?>  % del total
                      </span>
                    </div>
                  </div>
                </a>
              </div>
              <div id="<?php echo $plaza; ?>-collapse4" class="panel-collapse collapse">
                <div class="box-body no-padding">
                  <ul class="nav nav-stacked">
                    <?php             
                      if(!empty($arrVencido)) {
                        foreach ($arrVencido as $key => $valueVencidoGestor) {
                        
                          echo "<li><a href='#'>".$valueVencidoGestor->NOMGESTOR."<span class='pull-right'>".$valueVencidoGestor->CANTIDAD." op</span></a></li>";
                        }
                      }                        
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div> 
        </div>
      </div>
    </div>