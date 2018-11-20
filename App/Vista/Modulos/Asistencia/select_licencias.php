<?php 
      include_once "../../../Config/config.ini.php";
	    include_once '../../../Datos/BaseDatos/conexionapp.class.php';
	    include_once '../../../Datos/BaseDatos/sql.class.php';
      include_once "../../../Negocio/Modulos/handlerasistencias.class.php";
      include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";
      include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
      include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

      $handlerLic= new HandlerLicencias;
      $handlerUsuarios = new HandlerUsuarios;
      $dFecha = new Fechas;

      $id_plaza=$_POST['id_plaza'];
      $id_fdesde=$_POST['id_fdesde'];
      $id_fhasta=$_POST['id_fhasta'];
                 
      $arrEmpleados = $handlerUsuarios->selectByPlaza($id_plaza);


     ?> 
         <div class='col-md-12'>
            <div class="box">
               <div class="box-body table-responsive ">
                               
                <table class="table table-striped table-condensed " id="tabla-items" cellspacing="0" width="100%">

                  <thead>
                    <tr>                                       
                     <th>
                       <i>EMPLEADOS</i>                   
                      </th>
                       <th>
                       <i>DIAS LICENCIAS</i>  
                       </th>
                       <th>
                       <i>VER</i>  
                       </th>
                      </tr>
                     </thead>
                    <tbody>

      <?php foreach ($arrEmpleados as $key => $value) {
         $deLic=0;

          $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($id_fdesde,$id_fhasta,intval($value->getId()),2);

         // if (!empty($arrLicencias)) {
           
        

            $fechaDesde = date('Y-m-d',strtotime($id_fdesde));
            $fechaHasta = date('Y-m-d',strtotime($id_fhasta));
            $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
            $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
            while (strtotime($FECHA) <= strtotime($HASTA)) {

            $arrLicencias2 = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,intval($value->getId()),2);

                if (!empty($arrLicencias2)) { 
             foreach ($arrLicencias2 as $key => $valuue) {
                              
                                    if (!$valuue->getRechazado()) {
           
                                          if($valuue->getAprobado()) {

                                               if ($FECHA <= $valuue->getFechaFin()->format('Y-m-d') ) { 
                                       
                                                $deLic+=1;
                                                
                                       
                                                }
                                           }
                                        }

                                    }                                                    
                                       
                                }

                       $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));
                 } 
                  if (!empty($deLic)) { ?>
   
                           <tr>
                             <td><?php echo $value->getNombre()."-".$value->getApellido()?></td>
                              <td><?php echo $deLic; ?> </td>
                              <td><a href="index.php?view=licencias_controlcoord&fdesde=<?php echo $id_fdesde; ?>&fhasta=<?php echo $id_fhasta; ?>&fusuario=<?php echo $value->getId() ?>&festados=2"><i class="fa fa-search"></i></a></td>
                           </tr>   
                          
                  <?php }
                 
                  
              }
         // }  


          ?>


                              </tbody>

                              
                          </table>
                        </div>
                        </div>
                      </div> 
          
<!-- 

          <div class='col-md-12'>
             <div class="box">
                  <div class="box-body table-responsive ">
                               
                     <table class="table table-striped table-condensed " id="tabla-items" cellspacing="0" width="100%">

                      <thead>
                       <tr>                                       
                       <th>
                           <i>EMPLEADOS</i>                   
                         </th>
                         <th>
                          <i>DIAS LICENCIAS</i>  
                         </th>
                            </tr>
                            </thead>
                            <tbody>
                           <tr>
                             <td><?php echo $value->getNombre()."-".$value->getApellido()?></td>
                              <td><?php echo $deLic; ?> </td>
                           </tr>   
                           
                              </tbody>

                              
                          </table>
                        </div>
                        </div>
                      </div> -->
           
                  
                              


      