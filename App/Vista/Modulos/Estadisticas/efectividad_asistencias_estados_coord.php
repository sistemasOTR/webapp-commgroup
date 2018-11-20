<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";

  	$dFecha = new Fechas;    
    $handler = new HandlerSistema;
    $handlertickets = new HandlerTickets;
  	$handlerUsuario = new Usuario; 
  	$user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $handlerAsistencia= new HandlerAsistencias;
    $arrPlaza = $handlerPlaza->selectTodas();
    $arrEstados=  $handlerAsistencia->selectEstados();
         foreach ($arrPlaza as $key => $valor) {
      
          
    $arruser=$handlerUsuario->selectByPlaza($valor->getId()); // selectGestores
   
      if(count($arruser)==1){
          $arruser = array('' => $arruser ); 
        }

    $dataAsistencia2=0;
    
    if (!empty($arrEstados)) {
     foreach ($arrEstados as $key => $v) {

            if ($v->getUsuarioPerfil()==0 || $v->getUsuarioPerfil()==4) {
                 $act2[$v->getId()]=0;  
                   }  
                      }
                    }
 
    if (!empty($arruser)) {

    foreach ($arruser as $value ) {
      if ($value->getUsuarioPerfil()->getId()==4) {       
           // var_dump($value->getNombre());
           $fechaDesde = date('Y-m-d',strtotime($fdesde));
           $fechaHasta = date('Y-m-d',strtotime($fhasta));
           $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
           $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
           while (strtotime($FECHA) <= strtotime($HASTA)) {
           $asistencias=$handlerAsistencia->selectAsistenciasByFiltro($FECHA,$FECHA,$value->getId());  //  

         if(!empty($asistencias)) {
        
              $cantEst=count($arrEstados);        
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
                            
                   $total2=$total_horas+round($minutos,2);              
                #-------------------------------------------------------------------
                   $act2[intval($id_actAnt)] = $act2[intval($id_actAnt)]+$total2;

                   }
                 }               

              $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA))); 
              
          
    
         }

     }

   }  
 
     // var_dump($act); 
     // exit();   

$labelsAsistencia2='';
$dataAsistencia2='';
if (!empty($act)) {
 foreach ($act2 as $k => $valores) {
  if ($valores!=0) {
$labl=$handlerAsistencia->selectEstadosById($k);
$labelsAsistencia2=$labelsAsistencia2."'".$labl[0]->getNombre()."', ";
$dataAsistencia2=$dataAsistencia2.$valores." , ";
  }
 }
}
unset($act2);
// var_dump($labelsAsistencia,$dataAsistencia);
// exit();
} 


    if ($dataAsistencia2!=0) { 
   $arrEstadosCoordAsistencia[]=array('PLAZA'=>$valor->getId());
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
         </i> Horas Estados(<b>COORDINADORES</b>) <span><b><?php echo $valor->getNombre();?></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_horas_estados_coord_<?php echo $valor->getId(); ?>" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


    var config_horas_estados_coord_<?php echo $valor->getId(); ?> = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labelsAsistencia2 ?>],
      datasets: [{ 
        label: '% Asistencias',
        data: [<?php echo $dataAsistencia2 ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:['#D17272','#F9E79F','#D7BDE2','#27AE60'], 
      
      }]
    },
    options: {
      responsive: true,
      legend: {display:true,position:'right'},
      title: {
        display: false,
      },
    }
  };

</script>  
 
<?php
   
   }

   
 }
?>