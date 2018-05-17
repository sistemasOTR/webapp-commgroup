<?php 
 // $arrDatos = $handlerimpresoras->AllImpresoras($fplaza,$fgestorId);

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>

<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Listado de Impresoras</h3>

    
    <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nuevo'>
        <i class="fa fa-plus"></i> Agregar
    </a>
    <div class="col-xs-12 col-md-2 pull-right"><input type="text" id="search" class="form-control" placeholder="Escribe para buscar..." /></div>
  </div>

  <div class="box-body table-responsive"> 
    
    <table class="table table-striped table-condensed" id="tabla-plaza" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center'>Serial</th>
          <th class='text-center'>Marca</th>
          <th class='text-center'>Modelo</th>
          <th class='text-center'>Estado</th>
          <th class='text-center' width="200">Plaza</th>
          <th class='text-center' width="200">Gestor</th>
          <th class='text-center' width="150">Asignación</th>
          <th class='text-center' colspan="3">Acciones</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        

      ?>                        
      </tbody>
    </table> 
  </div>             
</div>
<script type="text/javascript">   

  $(function () {

  $('#search').quicksearch('table tbody tr');               
});
       
</script>
