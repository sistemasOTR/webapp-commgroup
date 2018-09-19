   <?php

    #########################
    # Calculo de comisiones #
    #########################

    // $userPuntaje = $handler->selectById($id);
    $total_servicios = 0;
    $total_servicios_cerrados = 0;
    $total_efectividad = 0;
    $total_puntajes_cerrados = 0;

    $total_servicios_enviadas = 0;
    $total_puntajes_enviadas = 0;
   
    // $fDesdeCom = date('Y-m-01');
    // $fHastaCom = date('Y-m-t');

    $fDesde2= (isset($_GET["fdesde2"])?$_GET["fdesde2"]:'');

    $fDesdeComision = date('Y-m-01',strtotime($fDesde2));
    $fHastaComision = date('Y-m-t',strtotime($fDesde2));
  
    $objetivo=0;
    $consulta = $handlerConsultas->consultaPuntajes($fDesdeComision, $fHastaComision, $user->getUserSistema());


    $arrConceptos = $handlerSueldos->selectConceptos();


    if(!empty($consulta))
    {
        foreach ($consulta as $key => $value) {
            $fechaPuntajeActual = $handlerPuntaje->buscarFechaPuntaje();
        
        if ($fechaPuntajeActual->format('Y-m-d') <= $value->FECHA->format('Y-m-d')) {
            $objetivo = $handlerPuntaje->buscarObjetivo($value->COD_GESTOR); 
        }else{
            $objetivo = $handlerPuntaje->buscarPuntajeFechaGestor($value->COD_GESTOR,$fHastaComision);                        
            }
        
            $localidad = strtoupper($value->LOCALIDAD);
            $localidad = str_replace('(', '', $localidad);
            $localidad = str_replace(')', '', $localidad);
        if ($value->FECHA->format('d-m-Y')>= $fechaPuntajeActual->format('d-m-Y')) {
            $puntaje = $handlerPuntaje->buscarPuntaje($value->COD_EMPRESA);
            if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
            $puntaje = 2;
            }
        } else {
            $puntaje = $handlerPuntaje->buscarPuntajeFecha($value->COD_EMPRESA,$value->FECHA->format('Y-m-d'));
            if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
            $puntaje = 2;
            }
        }
        
        if(empty($objetivo))                                                  
            $objetivo = 0;

        if (($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && $value->FECHA->format('d-m-Y') <= date('d-m-Y',strtotime('31-06-2018'))) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {

            if(empty($puntaje))
            $puntaje_enviadas = 0;
            else
            $puntaje_enviadas = round($value->TOTAL_SERVICIOS*$puntaje,2);

            $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas;

        }else{
            if(empty($puntaje))
            $puntaje_cerrados = 0;
            else
            $puntaje_cerrados = round($value->CERRADO*$puntaje,2);

            if(empty($puntaje))
            $puntaje_enviadas = 0;
            else
            $puntaje_enviadas = round($value->ENVIADO*$puntaje,2);

            $total_puntajes_cerrados = $total_puntajes_cerrados + $puntaje_cerrados;
            $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas; 
        }

        $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
        $total_servicios_cerrados = $total_servicios_cerrados + $value->CERRADO;
        $total_servicios_enviadas = $total_servicios_enviadas + $value->ENVIADO;
        }
    }

        if (!empty($arrConceptos)) {
        foreach ($arrConceptos as $key => $value) {
            $concepto[] = array('valor' => $value->getValor() , 
                                'base' => $value->getBase());
        }
    }

    if ($total_puntajes_enviadas > $objetivo) {
        $comisionesACob = floatval(number_format(($total_puntajes_enviadas-$objetivo)*$concepto[1]['valor']/$concepto[1]['base'],2,'.',''));
        $comisionesValor = $total_puntajes_enviadas - $objetivo;
    } else {
        $comisionesACob = 0;
        $comisionesValor = 0;
    }


// echo "total servicios <b>".$total_servicios."</b><br>";
// echo "total servicios cerrados <b>".$total_servicios_cerrados."</b><br>";
// echo "total servicios enviadas <b>".$total_servicios_enviadas."</b><br>";
// echo "total objetivo <b>".$objetivo."</b><br>";
// echo "total comisiones Valor <b>".$comisionesValor."</b><br>";
// echo "total comisiones a Cobrar <b>".$comisionesACob."</b><br>";

?>

      <div class="box-body col-md-8">

              <div class='row'>  
                <div class="col-md-3">
                  <label>Período</label>
                   <?php if($fDesde2 != ''){ ?>
                  <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" value="<?php echo $fDesde2; ?>" onchange="ComisionHref()">
              <?php } else { ?>
                <input type="month" name="slt_periodo" id="slt_periodo" class="form-control" onchange="ComisionHref()">
                <?php  } ?>
                </div>

                 <div class='col-md-3 '>                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte2" onclick="ComisionHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
            <div class="col-md-12">
          <div class="box-body table-responsive">
           <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="">
             <thead>
                <tr>
                     <th>SERVICIOS TOTAL</th>              
                     <th>SERVICIOS CERRADOS</th>              
                     <th>SERVICIOS ENVIADAS</th>
                     <th>PUNTAJE</th>              
                     <th>OBJETIVO</th>              
                     <th>COMISIONES VALOR</th>              
                     <th>COMISIONES A COBRAR</th>              
                                   
                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    <td><?php echo $total_servicios; ?></td>
                    <td><?php echo $total_servicios_cerrados; ?></td>
                    <td><?php echo $total_servicios_enviadas; ?></td>
                    <td><?php echo $total_puntajes_enviadas; ?></td>
                    <td><?php echo $objetivo; ?></td>
                    <td><?php echo $comisionesValor; ?></td>
                    <td><?php echo "$ ".$comisionesACob; ?></td>
                    
                    </tr>
                   </tbody>
              </table>
            </div> 
            </div>  
           </div>
       </div>
 <script>
      
 ComisionHref();
  function ComisionHref()
  {
       f_periodo=$("#slt_periodo").val(); 

        url_filtro_reporte="index.php?view=usuarioABM_edit&id=<?php echo $id ?>&pestaña=comisiones"; 
        url_filtro_reporte= url_filtro_reporte + "&fdesde2="+f_periodo;


      $("#filtro_reporte2").attr("href", url_filtro_reporte);
  } 


  </script>        