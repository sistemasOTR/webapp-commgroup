<?php
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";  

    $dFecha = new Fechas;    
    $handler = new HandlerSistema;
    $handlertickets = new HandlerTickets;
    $handlerUsuario = new Usuario;
  
    $user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();
         foreach ($arrPlaza as $key => $valor) {
    $arrUsuarios=$handlerUsuario->selectByPlaza($valor->getId());
   
    //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
    if(!PRODUCCION)
      $fHOY = "2018-08-27";
    $reintegroGasoil=0;
    $reintegroNafta=0;
    $reintegroGnc=0;
    
    $dataReintegro=0;
    if (!empty($arrUsuarios)) {
     
    foreach ($arrUsuarios as $value ) {
   $arrReintegro=$handlertickets->seleccionarByConcepto($fdesde,$fhasta,$value->getId());

      if( !empty($arrReintegro)) {

              foreach ($arrReintegro as $val) {
                if (trim($val->getConcepto())=='GASOIL' ) {
                 $reintegroGasoil+=$val->getImporteReintegro();
               }
               elseif (trim($val->getConcepto())=='NAFTA') {
                 $reintegroNafta+=$val->getImporteReintegro();
               }
               elseif (trim($val->getConcepto())=='GNC') {
                 $reintegroGnc+=$val->getImporteReintegro();
               }
      }

    }
  }
}
     $dataReintegro =$reintegroNafta.",".$reintegroGasoil.",".$reintegroGnc;
     if ($dataReintegro!="0,0,0") {
       $arrReintegroTickets[]=array('PLAZA'=>$valor->getId()); 

?>

<div class="col-md-12 nopadding">
  <div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i> Reintegro <span><b></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    </div>
    <div class="box-body text-center">
   <canvas id="budget_reintegro_<?php echo $valor->getId(); ?>" class="col-xs-12 chart"></canvas>
     </div>
  </div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_reintegro<?php echo $valor->getId(); ?> = {

type: 'bar',
    data: {
      
      labels: ['NAFTA','GASOIL','GNC'],
      datasets: [{ 
        label: 'Reintegro',
        data: [<?php echo $dataReintegro ?>],
        fill: false,
        borderColor: 'cornflowerblue',
        backgroundColor:['#2980B9','#5D6D7E','#138D75'], 
        borderWidth: 0,
        lineTension: 0,
        pointRadius: 1,
      }]
    },
    options: {
      responsive: true,
      legend: {display:false},
      title: {
        display: false,
      },
      scales: {
        
        xAxes:[{
          gridLines: {
            display: false,
          },
          ticks:{
            stepSize:1,
            autoSkip: false

          },
        }],
        yAxes:[{
          ticks: {
            min: 0,
            gridLines: {
              display: false,
            },
          }
        }]
      },
      tooltips: {
        xPadding:20,
        yPadding:20,
      },
    }
  };


</script> 
<?php
}
}
?>



