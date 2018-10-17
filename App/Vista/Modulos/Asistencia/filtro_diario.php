


      <div class='col-md-12'>
        <div class="box box-solid">

           <!-- <div class="box-header with-border">
              <i class="fa fa-filter"></i>
              <h3 class="box-title">Filtros Disponibles</h3>
              <button type="button" class="btn btn-box-tool pull-right bg-red" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div> -->
            <div class="box-body">
              <div class='row'>  
                <div class="col-md-2" id='sandbox-container'>
                    <label>Fecha Desde - Hasta </label>                
                    <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="start" name="start" value="<?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y'); ?>"/>
                      <span class="input-group-addon">a</span>
                      <input type="text" class="input-sm form-control" onchange="crearHref()" id="fin" name="fin" value="<?php echo $dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?>"/>
                    </div>
                </div> 
                  <div class='col-md-2 '>                
                  <label></label>                
                  <a class="btn btn-block btn-success " id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
                 
            </div>
          </div>
        </div>
      </div>

           <?php

                        

                        $contador=1;
                        $flag=false;

                        $fechaDesde = date('Y-m-d',strtotime($fdesde));
                        $fechaHasta = date('Y-m-d',strtotime($fhasta));
                        $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
                        $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
                        while (strtotime($FECHA) <= strtotime($HASTA)) {
                        $asistencias=$handlerAsist->selectAsistenciasByFiltro($FECHA,$FECHA,$user->getId());
                        $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,intval($user->getId()),2);
                        // var_dump($FECHA,$asistencias);
                        // exit();
                         if (!empty($asistencias) || !empty($arrLicencias) ) {
                      
                         
                        if ($contador==1) {
                           echo "<div class='row'>";
                           $flag=false;
                         } 


                       
                      
?>             

      
    
  
      <div class="col-md-3 ">
          <div class="box">

            <div class="box-body table-responsive">
             
              <table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
      
                 <thead>
                    <tr>                                       
                      <th><b><?php echo $FECHA ;?></b>
                        <a href="index.php?view=estadisticas_asistencia_gestor&id_gestor=<?php echo $user->getId();?>&fdesde=<?php echo $FECHA ?>&fhasta=<?php echo $FECHA ?>" class="fa fa-bar-chart"></a>
                        <?php if($user->getId()==10045 ||$user->getId()==3 ||$user->getId()==10007){ ?>
                        <i class="pull-right"><a href="#" id='<?php echo $user->getId() ?>'data-ide='<?php echo $user->getId() ?>' data-fecha='<?php echo $fdesde;?>'data-usuario='4' data-hora='<?php echo date('H:i'); ?>' data-estados='<?php echo $accion; ?>'class="btn btn-default btn-xs" data-toggle='modal' data-target='#modal-presentismo' onclick='cargarDatos(<?php echo $user->getId()?>)'>Nuevo Horario</a></i>
                      <?php } ?>
                      </th>
                     </tr>
                  </thead>
                     <tbody>
                  <?php }
                  
                        if (!empty($asistencias)){
                              
                        foreach ($arrEstados as $key => $vv) {

                           if (($vv->getUsuarioPerfil()==0) || ($vv->getUsuarioPerfil()==$user->getUsuarioPerfil()->getId())) {
                                $act[$vv->getId()]=0;  
                                }  
                             }

                             $cant = count($asistencias);

                             for ($i=1; $i < $cant; $i++) { 
                               $id_actAnt = $asistencias[($i-1)]->getIngreso();
                               $id_actual=$asistencias[$i]->getIngreso();

                             
                               $inicioAct = new DateTime($asistencias[($i-1)]->getFecha()->format('H:i'));
                               $finAct = new DateTime($asistencias[$i]->getFecha()->format('H:i'));
                                         
                               #-------------------------------------------------------------------
                               $difParcial=$finAct->diff($inicioAct); 
                               $formato=$difParcial->format('%H:%i');
                               $horass=split(":",$formato);
                              
                               $total_horas=$horass[0];
                               $minutos=$horass[1]/60;
                            
                               $total=$total_horas+round($minutos,2);              
                               #-------------------------------------------------------------------
                               $act[intval($id_actAnt)] = $act[intval($id_actAnt)]+$total;  
                           
                             }
                              
                              
                          
                                $lista1='';
                                $listaProd1=0;
                                $listaImprod1=0;

                                foreach ($arrEstados as $key => $vv) {

                                 if (($vv->getUsuarioPerfil()==0) || ($vv->getUsuarioPerfil()==$user->getUsuarioPerfil()->getId())) {
                                  if (!empty($act[$vv->getId()])) {
                                                                   
                                    $lista1.= "<tr><td>".$vv->getNombre()." : ".$act[$vv->getId()]." Hs</td></tr>";
                                      
                                         }
                                    if ($vv->getProductivo()==1) {
                                       if (!empty($act[$vv->getId()])) {
                                                                   
                                    $listaProd1+= $act[$vv->getId()];
                                      
                                        } 
                                      } 
                                     if ($vv->getProductivo()==0) {
                                      if (!empty($act[$vv->getId()])) {
                                                                   
                                    $listaImprod1+= $act[$vv->getId()];
                                      
                                           }

                                         }    

                                       }
                                   }

                         foreach ($asistencias as $key => $val) {
                         $estadoId=$val->getIngreso();
                         if (!empty($estadoId)) {        
                        $select=$handlerAsistencia->selectEstadosById($estadoId);
                        if (!empty($select)) {
                          $ingreso=$val->getFecha()->format('H:i');
                          $est=$val->getIngreso();
                        ?> 
                         <tr><td>
                          <?php echo " ".$val->getFecha()->format('H:i')."<span class='".$select[0]->getColor()." pull-right'><b>".$select[0]->getNombre()."</b></span>"  ?></td></tr> 
                      <?php } } }  

                      echo $lista1;
                      if (!empty($listaProd1)) {
                      echo "<tr><td class='bg-green'> HRS PRODUCTIVAS : ".$listaProd1." Hs</td></tr>";
                      }
                      if (!empty($listaImprod1)) {
                      echo "<tr><td class='bg-red'> HRS IMPRODUCTIVAS : ".$listaImprod1." Hs</td></tr>";
                      }
                     
                     
                       ?>


                  </tbody>

                  
              </table>
            </div>
            </div>
          </div>
              <?php 
                  $contador+=1;
                if ($contador==5) {
                  echo "</div>";
                  $contador=1;
                  $flag=true;
                 } 


                    }else{
                       

                      $deLic='';
                                if(!empty($arrLicencias)) {

                                foreach ($arrLicencias as $key => $value) {
                          
                                if (!$value->getRechazado()) {
       
                                 if($value->getAprobado()) {

                                  if ($FECHA <= $value->getFechaFin()->format('Y-m-d') ) { 
                                   
                                    $deLic= "<span class='label label-warning pull-left'> LICENCIA EN CURSO</span>";
                                   
                                   }
                                    else{ 
                                       $deLic="";
                                      }

                                     
                                    }
                                  }
                                }
                              

                       
                       echo"<tr><td >".$deLic."</td></tr>";
                        ?>
                        </tbody>

                          
                      </table>
                    </div>
                    </div>
                  </div>
                      <?php 
                          $contador+=1;
                        if ($contador==5) {
                          echo "</div>";
                          $contador=1;
                          $flag=true;
                         } 


                        }
                         }
                    
            
                     $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));    

                    }

               if (!$flag) {
               echo "</div>";
                 } 
                 
                ?>

