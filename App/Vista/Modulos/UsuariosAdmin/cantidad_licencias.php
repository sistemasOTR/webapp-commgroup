

	   <div class="box-body table-responsive">
           <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
             <thead>
                <tr>
                   	 <th>TIPO LICENCIA</th>
                   	 <th>TOTAL DIAS</th>
                      <th>DESDE</th>
                      <th>HASTA</th>                    
                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>

				<?php	

				    ##############################
				    #Calculo de días de licencia #
				    ##############################

				  $MesActual=date('n');
            
				 for ($i=intval($MesActual); $i >= 1 ; $i--) { 
				                   
				    $fDesdeLicencia = date('Y-m-01', mktime(0,0,0,$i,1,date('Y')));
				    $fHastaLicencia = date('Y-m-t', mktime(0,0,0,$i,1,date('Y')));
				    setlocale(LC_TIME, 'spanish'); 

                     $arrayId[]=0;
				    while (strtotime($fDesdeLicencia) <= strtotime($fHastaLicencia)) {
				        $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($fDesdeLicencia,$fDesdeLicencia,$id,2);

				      
				        
				        if(!empty($arrLicencias)) {
				        
				        foreach ($arrLicencias as $key => $value) {
				        	foreach ($arrayId as $idrepeat) {
                              if (intval($value->getId()) == $idrepeat) {
                                $seguir = false;
                                break;
                              } else {
                                $seguir = true;
                              }
                            }
                         
                               if($seguir){
                                $arrayId[]=intval($value->getId());
				            if (!$value->getRechazado()) {
				            if($value->getAprobado()) {  
				            	$fin=$value->getFechaFin()->format('Y-m-d');
				            	$ini=$value->getFechaInicio()->format('Y-m-d');
				            
				             $dif_dias = $dFechas->DiasDiferenciaFechas($fin,$ini,"Y-m-d");
				             $dif_dias += 1;
				             // var_dump($dif_dias);

				              echo "<tr>";
                              echo "<td>".$value->getTipoLicenciasId()->getNombre()."</td>";
                              echo "<td>".$dif_dias."</td>";
                              echo "<td>".$value->getFechaInicio()->format('d/m/Y')."</td>";
                              echo "<td>".$value->getFechaFin()->format('d/m/Y')."</td>";
    
				               
				            	}
				            }
				        }
				      }  
				        }
				        $fDesdeLicencia = date('Y-m-d',strtotime('+1 day',strtotime($fDesdeLicencia)));
				    }
				}
				?>

			    </tbody>
              </table>
            </div>