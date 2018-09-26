<?php
		$fdesde = $periodo.'-01';
		$fhasta = date('Y-m-t', strtotime($fdesde));
        setlocale(LC_TIME, 'spanish');  
        $nombreMES = strftime("%B",strtotime($fdesde));      
        $anioMES = date('Y',strtotime($fdesde));
       
        $impoMensual = $handlerImp->selectImportacionesByCliente($fdesde,$fhasta,$est_empresa);
        $cerrados = 0;
        $cerradosUV = 0;
        $noCerrados = 0;
        $totalServ = 0;
		

        if (!empty($impoMensual)) {
        	foreach ($impoMensual as $key => $value) {
	        	$lastEstado = $handler->selectLastEstadoServicio(intval(trim($value->getNroDoc())),$est_empresa);
	        	if (!empty($lastEstado)) {
	        		if (intval($lastEstado[0]->ESTADO) == 6 || intval($lastEstado[0]->ESTADO) == 9 || intval($lastEstado[0]->ESTADO) == 10 || intval($lastEstado[0]->ESTADO) == 14) {
	        			if (count($lastEstado) == 1) {
	        				$cerradosUV++;
	        			}else{
		        			$cerrados++;
	        			}
		        	}
	        	}
	        	$totalServ = $totalServ + count($lastEstado);
	        }

	        $efectServ = (($cerrados + $cerradosUV) * 100)/$totalServ;
	        $efectCli = (($cerrados + $cerradosUV) * 100)/count($impoMensual);
	        if ($efectServ >= 70) {
	        	$classEServ = 'bg-green-active';
	        } elseif ($efectServ >= 60) {
	        	$classEServ = 'bg-yellow-active';
	        } else {
	        	$classEServ = 'bg-red-active';
	        }
	        if ($efectCli >= 70) {
	        	$classECli = 'bg-green-active';
	        } elseif ($efectCli >= 60) {
	        	$classECli = 'bg-yellow-active';
	        } else {
	        	$classECli = 'bg-red-active';
	        }
        } ?>

        
        <div class="col-xs-12">
        	
			<div class="box box-solid">
				<div class="box-header with-border">
                <div class="col-md-3 pull-right">
                      <input type="month" class="input-sm form-control" onchange="filtrarReporte()" id="periodo" name="periodo" value="<?php echo $periodo; ?>"/>
                </div>
                <div class="col-md-3 pull-right text-right">
                    <label>Seleccione Mes...</label>
                </div>
                <div class='col-md-3 pull-right' style="display: none;">                
                  <label></label>                
                  <a class="btn btn-block btn-success" id="filtro_reporte" onclick="crearHref()"><i class='fa fa-filter'></i> Filtrar</a>
                </div>
					<h3 class="box-title"><i class="fa fa-percent"></i> <?php echo strtoupper($nombreMES)." ".$anioMES ?></h3>
				</div>
				<div class="box-body">
					<div class="col-xs-12 col-md-4 no-padding border-right">
						<h4 class="text-center">SERVICIOS</h4>
						<div class="col-xs-6" style="padding-left: 5px;padding-right: 5px;">
							<div class="small-box bg-purple">
					            <div class="inner">
					              <h3><?php echo count($impoMensual) ?></h3>

					              <p>OPERACIONES</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-user"></i>
					            </div>
					        </div>
						</div>
						<div class="col-xs-6" style="padding-left: 5px;padding-right: 5px;">
							<div class="small-box bg-purple-active">
					            <div class="inner">
					              <h3><?php echo $totalServ ?></h4>

					              <p>GESTIONES</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-truck"></i>
					            </div>
					        </div>
						</div>
					</div>
					<div class="col-xs-12 col-md-4 no-padding border-right">
						<h4 class="text-center">CERRADAS</h3>
						<div class="col-xs-4" style="padding-left: 5px;padding-right: 5px;">
							<div class="small-box bg-aqua">
					            <div class="inner">
					              <h3><?php echo $cerradosUV; ?></h3>

					              <p>1° VISITA</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-lock"></i>
					            </div>
					        </div>
						</div>
						<div class="col-xs-4" style="padding-left: 5px;padding-right: 5px;">
							<div class="small-box bg-aqua-active">
					            <div class="inner">
					              <h3><?php echo $cerrados; ?></h3>

					              <p>+ VISITAS</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-lock"></i>
					            </div>
					        </div>
						</div>
						<div class="col-xs-4" style="padding-left: 5px;padding-right: 5px;">
							<div class="small-box bg-light-blue">
					            <div class="inner">
					              <h3><?php echo ($cerrados + $cerradosUV); ?></h3>

					              <p>TOTAL</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-lock"></i>
					            </div>
					        </div>
						</div>
					</div>
					<div class="col-xs-12 col-md-4 no-padding">
						<h4 class="text-center">EFECTIVIDAD</h4>
						<div class="col-xs-6" style="padding-left: 5px;padding-right: 5px;">
							<div class="small-box <?php echo $classEServ ?>">
					            <div class="inner">
					              <h3><?php echo number_format($efectServ,2) ?> %</h3>

					              <p>GESTIONES</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-percent"></i>
					            </div>
					        </div>
						</div>
						<div class="col-xs-6" style="padding-left: 5px;padding-right: 5px;">
							<div class="small-box <?php echo $classECli ?>">
					            <div class="inner">
					              <h3><?php echo number_format($efectCli,2) ?> %</h3>

					              <p>GENERAL</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-percent"></i>
					            </div>
					        </div>
						</div>
					</div>
				</div>

			</div>
        </div>