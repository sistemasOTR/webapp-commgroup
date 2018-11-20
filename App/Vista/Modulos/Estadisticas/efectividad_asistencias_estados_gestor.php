<?php
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";
    include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
    include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";

  	$dFecha = new Fechas;    
    $handler = new HandlerSistema;
    // $id_usuario = (isset($_GET["id_usuario"])?$_GET["id_usuario"]:'');
    $user_perfil = (isset($_GET["user_perfil"])?$_GET["user_perfil"]:'');
    $handlertickets = new HandlerTickets;
  	$handlerUsuario = new HandlerUsuarios; 
  	$user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $handlerAsistencia= new HandlerAsistencias;
    $arrPlaza = $handlerPlaza->selectTodas();
    $arrEstados=  $handlerAsistencia->selectEstados();
    $handlerLic= new HandlerLicencias;
    

         
      
          
    $arruser=$handlerUsuario->selectById($id_gestor); // 
    // var_dump($arruser->getId());
   
  

    $dataAsistencia2=0;
    
    if (!empty($arrEstados)) {
     foreach ($arrEstados as $key => $v) {

            if ($v->getUsuarioPerfil()==0 || $v->getUsuarioPerfil()==$arruser->getUsuarioPerfil()->getId()) {
                 $act2[$v->getId()]=0;  
                   }  
                      }
                    }
 
    if (!empty($arruser)) {
      $deLic=0;

    // foreach ($arruser as $value ) {
    //   if ($arruser->getUsuarioPerfil()->getId()==$user_perfil) {       

           $fechaDesde = date('Y-m-d',strtotime($fdesde));
           $fechaHasta = date('Y-m-d',strtotime($fhasta));
           $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
           $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
           while (strtotime($FECHA) <= strtotime($HASTA)) {
           $asistencias=$handlerAsistencia->selectAsistenciasByFiltro($FECHA,$FECHA,$id_gestor);  //  
          $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($FECHA,$FECHA,intval($id_gestor),2);
          

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
                  if(!empty($arrLicencias)) {

                                foreach ($arrLicencias as $key => $valuue) {
                          
                                if (!$valuue->getRechazado()) {
       
                                      if($valuue->getAprobado()) {

                                           if ($FECHA <= $valuue->getFechaFin()->format('Y-m-d') ) { 
                                   
                                            $deLic+=1;
                                            // "<span class='label label-warning pull-left'> LICENCIA EN CURSO</span>";
                                   
                                            }
                                       }
                                    }
                                }
                              

                        }               

              $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA))); 
              
          
    
         }

   //   }

   // }  
 
  

$labelsAsistencia2='';
$dataAsistencia2='';
if (!empty($act2)) {
 foreach ($act2 as $k => $valores) {
  if ($valores!=0) {
$labl=$handlerAsistencia->selectEstadosById($k);
$labelsAsistencia2=$labelsAsistencia2."'".$labl[0]->getNombre()."', ";
$dataAsistencia2=$dataAsistencia2.$valores." , ";
  }
 }
}
// unset($act2);
// var_dump($labelsAsistencia,$dataAsistencia);
// exit();
} 


if ($dataAsistencia2!=0)  {
   
?>

<div class="col-md-12 nopadding">
	<div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
         </i> Horas por Estados de Trabajo
         <?php if (!empty($deLic)) { ?>
        <small class="pull-right" style="font-size: 15px;"><span class='bg-yellow '><b><?php echo "DIAS LICENCIAS</span><span class='bg-green'>"."[ ".$deLic."  ]</span></b>"; ?></b></span></small>
      <?php } ?>
      </h3>
    </div>
    <div class="box-body text-center">
	 <canvas id="budget_horas_estados_gestor" class="col-xs-12 chart"></canvas>
     </div>
	</div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


    var config_horas_estados_gestor = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labelsAsistencia2 ?>],
      datasets: [{ 
        label: '% Asistencias',
        data: [<?php echo $dataAsistencia2 ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:['#D7BDE2','#D17272','#27AE60'], 
      
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

?>
