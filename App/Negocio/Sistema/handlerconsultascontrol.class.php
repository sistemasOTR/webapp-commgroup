<?php

	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";

	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionsistema.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/loginlog.class.php';
	include_once PATH_DATOS.'Entidades/expediciones.class.php';
	include_once PATH_DATOS.'Entidades/expedicionescompras.class.php';
	include_once PATH_DATOS.'Entidades/guias.class.php';

	include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php';	

	class HandlerConsultasControl {

		public function controlInicioSesion($fdesde, $fhasta, $usuario){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (login_log.fecha_hora AS DATE) = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (login_log.fecha_hora AS DATE) =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (login_log.fecha_hora AS DATE) >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (login_log.fecha_hora AS DATE) <=  '".$tmp."' AND ";
					}
				}
											
				$filtro_usuario="";
				if(!empty($usuario))								
					$filtro_usuario = "login_log.usuario_id = ".$usuario." AND ";
													
				$filtro_estado = "login_log.estado = 'true'";

				$query = "SELECT login_log.*
							FROM login_log
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_usuario."
									".$filtro_estado;
					//echo $query;
					//exit;

				$result = SQL::selectObject($query, new LoginLog);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

		public function seleccionarExpedicionesByFiltros($fdesde, $fhasta, $tipo_expe, $estados_expe, $plaza){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha <=  '".$tmp."' AND ";
					}
				}

				$filtro_tipo_expe="";
				if(!empty($tipo_expe))								
					$filtro_tipo_expe = "tipo_id = ".$tipo_expe." AND ";

				$filtro_estados_expe="";
				if(!empty($estados_expe))
					if ($estados_expe == 1000) {
						$filtro_estados_expe = "(estados_expediciones_id = 1 OR estados_expediciones_id = 6 OR estados_expediciones_id = 7) AND ";
					}
					elseif ($estados_expe == 2000) {
						$filtro_estados_expe = "(estados_expediciones_id = 2 OR estados_expediciones_id = 4 OR estados_expediciones_id = 6 OR estados_expediciones_id = 7) AND ";
					} else {
						$filtro_estados_expe = "estados_expediciones_id = ".$estados_expe." AND ";				
					}
					
											
				$filtro_plaza="";
				if(!empty($plaza))
				if ($plaza=='CASA CENTRAL') {
					$filtro_plaza = "(plaza ='RRHH' OR plaza='BACK OFFICE' OR plaza='CONTABILIDAD' OR plaza='GERENCIA') AND ";							
				}else{								
					$filtro_plaza = "plaza = '".$plaza."' AND ";
				}

				$filtro_sin_publicar = "sin_publicar = 'false' AND ";
				$filtro_estado = "expediciones.estado = 'true'";				

				$query = "SELECT *
							FROM expediciones inner join expediciones_items
							on expediciones.item_expediciones_id = expediciones_items.item_id 
							inner join expediciones_tipo2
							on expediciones_items.num_grupo = expediciones_tipo2.tipo_id
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_plaza."
									".$filtro_estados_expe."
									".$filtro_tipo_expe."									
									".$filtro_sin_publicar."
									".$filtro_estado." 
								ORDER BY fecha ASC";

                   // var_dump($query);
				$result = SQL::selectObject($query, new Expediciones);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		public function seleccionarExpedicionesByFiltroEnvios($fdesde,$fhasta,$estados_expe, $plaza){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha <=  '".$tmp."' AND ";
					}
				}

				$filtro_estados_expe="";
				if(!empty($estados_expe))
					
						$filtro_estados_expe = "estados_expediciones_id = ".$estados_expe." AND ";				
		
											
				$filtro_plaza="";
				if(!empty($plaza))								
					$filtro_plaza = "plaza = '".$plaza."' AND ";
				
				$filtro_sin_enviar = "sin_enviar =1";			

				$query = "SELECT * FROM expediciones_envios as en inner join expediciones as ex
							on en.id_pedido= ex.id 
							inner join expediciones_items as i 
							on ex.item_expediciones_id=i.item_id 
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_plaza."
									".$filtro_estados_expe."									
									".$filtro_sin_enviar."
								ORDER BY en.id desc, fecha ASC";


				$result = SQL::selectObject($query, new Expediciones);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		public function seleccionarEnviados($fdesde,$fhasta){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha <=  '".$tmp."' AND ";
					}
				}

				
				
				$filtro_estado = "estado =1";			

				$query = "SELECT * FROM expediciones_enviados 
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta." 												
									".$filtro_estado."
								ORDER BY fecha ASC";


				$result = SQL::selectObject($query, new ExpedicionesEnviados);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
        public function seleccionarComprasByFiltros($fdesde, $fhasta,$tipo_expe,$estados_expe){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha <=  '".$tmp."' AND ";
					}
				}

				$filtro_tipo_expe="";
				if(!empty($tipo_expe))								
					$filtro_tipo_expe = "tipo_id = ".$tipo_expe." AND ";

				$filtro_estados_expe="";
				if(!empty($estados_expe))								
					if ($estados_expe == 1) {
						$filtro_estados_expe = "recibido = 'false' AND ";
					} elseif ($estados_expe == 2) {
						$filtro_estados_expe = "recibido = 'true' AND ";
					}
					
				$filtro_sin_publicar = "sin_pedir = 'false' AND ";
				$filtro_estado = "expediciones_compras.estado = 'true'";
				
				$query = "SELECT *
							FROM expediciones_compras inner join expediciones_items
							on expediciones_compras.id_item = expediciones_items.item_id 
							inner join expediciones_tipo2
							on expediciones_items.num_grupo = expediciones_tipo2.tipo_id
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta."
									".$filtro_tipo_expe."			
									".$filtro_estados_expe."				
									".$filtro_sin_publicar."
									".$filtro_estado." 
								ORDER BY fecha ASC";


				$result = SQL::selectObject($query, new ExpedicionesCompras);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		} 
		public function seleccionarTodasComprasByFiltros($fdesde, $fhasta,$tipo_expe,$estados_expe){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "fecha >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "fecha <=  '".$tmp."' AND ";
					}
				}

				$filtro_tipo_expe="";
				if(!empty($tipo_expe))								
					$filtro_tipo_expe = "tipo_id = ".$tipo_expe." AND ";

				$filtro_estados_expe="";
				if(!empty($estados_expe))								
					if ($estados_expe == 1) {
						$filtro_estados_expe = "recibido = 'false' AND ";
					} elseif ($estados_expe == 2) {
						$filtro_estados_expe = "recibido = 'true' AND ";
					}
					
				$filtro_estado = "expediciones_compras.estado = 'true'";
				
				$query = "SELECT *
							FROM expediciones_compras inner join expediciones_items
							on expediciones_compras.id_item = expediciones_items.item_id 
							inner join expediciones_tipo2
							on expediciones_items.num_grupo = expediciones_tipo2.tipo_id
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta."
									".$filtro_tipo_expe."			
									".$filtro_estados_expe."
									".$filtro_estado." 
								ORDER BY fecha ASC";


				$result = SQL::selectObject($query, new ExpedicionesCompras);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		public function seleccionarGuiasByFiltros($fdesde, $fhasta, $usuario, $empresa){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (fecha_hora AS DATE) = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (fecha_hora AS DATE) =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (fecha_hora AS DATE) >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (fecha_hora AS DATE) <=  '".$tmp."' AND ";
					}
				}
											
				$filtro_plaza="";
				if(!empty($fplaza))								
					$filtro_plpaza = "plaza = ".$usuario." AND ";

				$filtro_cliente="";
				if($empresa>-1){												
					$filtro_cliente = "empresa_sistema = ".$empresa." AND ";						
				}

				//var_dump($filtro_cliente);
				//exit();

				$filtro_estado = "estado = 'true'";

				$query = "SELECT *
							FROM guias
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_plaza."
									".$filtro_cliente."
									".$filtro_estado;
					//echo $query;
					//exit;

				$result = SQL::selectObject($query, new Guias);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

	}

?>