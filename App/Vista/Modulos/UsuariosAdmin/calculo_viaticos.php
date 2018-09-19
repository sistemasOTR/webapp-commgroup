  
<?php 

     #######################
    # Calculo de viaticos #
    #######################

    $fDesde= (isset($_GET["fdesde"])?$_GET["fdesde"]:'');

    $fDesdeTicket = date('Y-m-26',strtotime($fDesde.'-1 days'));
    $fHastaTicket = date('Y-m-25',strtotime($fDesde));
    $resumenTickets = $handlerTickets->resumenGestor($id, $fDesdeTicket, $fHastaTicket);
    $reintegroTotal = 0;
    if (!empty($resumenTickets)) {
        foreach ($resumenTickets as $viatico) {
        $reintegroTotal += $viatico->getImporteReintegro(); 
        }
    }

 ?>

      
         <div class="box-body col-md-4">

              <div class='row'>  
                <div class="col-md-6">
                  <label>Período</label>
                   <?php if($fDesde != ''){ ?>
                  <input type="month" name="slt_periodo2" id="slt_periodo2" class="form-control" value="<?php echo $fDesde; ?>" onchange="NuevoHref()">
              <?php } else { ?>
                <input type="month" name="slt_periodo2" id="slt_periodo2" class="form-control" onchange="NuevoHref()">
                <?php  } ?>
                </div>

                 <div class='col-md-6 '>                
                  <label>Filtros</label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="NuevoHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
            <div class="col-md-12">
          <div class="box-body table-responsive">
           <table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="">
             <thead>
                <tr>
                     <th>CANTIDAD</th>              
                      <th style="width: 3%;" class='text-center'></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                    <td><?php echo "$ ".$reintegroTotal; ?></td>
                    </tr>
                   </tbody>
              </table>
            </div> 
            </div>  
           </div>
       </div>


  <script>
      
 NuevoHref();
  function NuevoHref()
  {
       f_periodo=$("#slt_periodo2").val(); 

        url_filtro_reporte="index.php?view=usuarioABM_edit&id=<?php echo $id ?>&pestaña=viaticos"; 
        url_filtro_reporte= url_filtro_reporte + "&fdesde="+f_periodo;


      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 


  </script>        