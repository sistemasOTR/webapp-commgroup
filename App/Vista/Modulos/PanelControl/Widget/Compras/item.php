<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";


  $handler = new HandlerExpediciones;
  $arrItemApedir = $handler->selecionarApedir();

  ?>

  <div class="col-md-12 nopadding">
	<div class="box box-solid">
	  <div class="box-header with-border">
	  	<a href="index.php?view=exp_item_abm&apedir=1" class="fa fa-search pull-right" id="btn-nuevo"></a>
	    <i class=" fa fa-battery-1"></i>
	    <h3 class="box-title">Tabla Item. 
	    	<span class='text-red'><b>Stock Bajo</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body" style='text-align: center;'>
	  	<table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="text-align: center">ITEM</th>                                            
                      <th style="text-align: center">STOCK</th>
                      <th style="text-align: center">PTO PEDIDO</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      if (!empty($arrItemApedir)) { 

                        foreach ($arrItemApedir as $key => $value) { 
                          
                            
                          ?>
                          <tr>
                            <td> <?php echo $value->getNombre();?> </td>
                             <td> <?php echo $value->getStock();?> </td>
                             <td> <?php echo $value->getPtopedido();?> </td>
                             
                          </tr>
                    <?php 
                        } 
                      }
                    ?>
                  </tbody>
              </table>	  
	  </div>
	</div>
</div>