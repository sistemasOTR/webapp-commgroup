<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class Tickets
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }		
		
		private $_usuarioId;
		public function getUsuarioId(){ return $this->_usuarioId; }
		public function setUsuarioId($usuario_id){ $this->_usuarioId=$usuario_id; }		

		private $_fechaHora;
		public function getFechaHora(){ return $this->_fechaHora; }
		public function setFechaHora($fechaHora){ $this->_fechaHora=$fechaHora; }

		private $_tipo;
		public function getTipo(){ return $this->_tipo; }
		public function setTipo($tipo){ $this->_tipo=$tipo; }

		private $_puntoVenta;
		public function getPuntoVenta(){ return $this->_puntoVenta; }
		public function setPuntoVenta($puntoVenta){ $this->_puntoVenta=$puntoVenta; }

		private $_numero;
		public function getNumero(){ return $this->_numero; }
		public function setNumero($numero){ $this->_numero=$numero; }			

		private $_razonSocial;
		public function getRazonSocial(){ return $this->_razonSocial; }
		public function setRazonSocial($razonSocial){ $this->_razonSocial=$razonSocial; }	

		private $_cuit;
		public function getCuit(){ return $this->_cuit; }
		public function setCuit($cuit){ $this->_cuit=$cuit; }	

		private $_iibb;
		public function getIibb(){ return $this->_iibb; }
		public function setIibb($iibb){ $this->_iibb=$iibb; }	

		private $_domicilio;
		public function getDomicilio(){ return $this->_domicilio; }
		public function setDomicilio($domicilio){ $this->_domicilio=$domicilio; }			

		private $_condFiscal;
		public function getCondFiscal(){ return $this->_condFiscal; }
		public function setCondFiscal($condFiscal){ $this->_condFiscal=$condFiscal; }

		private $_importe;
		public function getImporte(){ return $this->_importe; }
		public function setImporte($importe){ $this->_importe=$importe; }

		private $_adjunto;
		public function getAdjunto(){ return $this->_adjunto; }
		public function setAdjunto($adjunto){ $this->_adjunto=$adjunto; }		
		
		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }			

		private $_enviado;
		public function getEnviado(){ return var_export($this->_enviado,true); }
		public function setEnviado($enviado){ $this->_enviado=$enviado; }

		private $_aprobado;
		public function getAprobado(){ return var_export($this->_aprobado,true); }
		public function setAprobado($aprobado){ $this->_aprobado=$aprobado; }					

		private $_importeReintegro;
		public function getImporteReintegro(){ return $this->_importeReintegro; }
		public function setImporteReintegro($importeReintegro){ $this->_importeReintegro=$importeReintegro; }

		private $_aledanio;
		public function getAledanio(){ return $this->_aledanio; }
		public function setAledanio($aledanio){ $this->_aledanio=$aledanio; }

		private $_cantOperaciones;
		public function getCantOperaciones(){ return $this->_cantOperaciones; }
		public function setCantOperaciones($cantOperaciones){ $this->_cantOperaciones=$cantOperaciones; }		

		private $_concepto;
		public function getConcepto(){ return $this->_concepto; }
		public function setConcepto($concepto){ $this->_concepto=$concepto; }		

		private $_aledNombre;
		public function getAledNombre(){ return $this->_aledNombre; }
		public function setAledNombre($aledNombre){ $this->_aledNombre=$aledNombre; }

		private $_rechazado;
		public function getRechazado(){ return var_export($this->_rechazado,true); }
		public function setRechazado($rechazado){ $this->_rechazado=$rechazado; }	

		private $_traslado;
		public function getTraslado(){ return var_export($this->_traslado,true); }
		public function setTraslado($traslado){ $this->_traslado=$traslado; }					

		private $_obsRechazo;
		public function getObsRechazo(){ return $this->_obsRechazo; }
		public function setObsRechazo($obsRechazo){ $this->_obsRechazo=$obsRechazo; }

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setUsuarioId(new Usuario);			

			$this->setFechaHora('');			
			$this->setTipo('');
			$this->setPuntoVenta('');
			$this->setNumero('');
			$this->setRazonSocial('');
			$this->setCuit('');
			$this->setIibb('');
			$this->setDomicilio('');
			$this->setCondFiscal('');
			$this->setImporte(0);
			$this->setAdjunto('');
			
			$this->setEstado(true);
			$this->setAprobado(false);
			$this->setEnviado(false);

			$this->setImporteReintegro(0);	
			$this->setAledanio(false);			
			$this->setCantOperaciones(0);
			$this->setConcepto('');
			$this->setAledNombre('');
			$this->setRechazado(false);			
			$this->setTraslado(false);			
			$this->setObsRechazo('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario Vacio");	
				
				# Query 			
				$query="INSERT INTO tickets (
		        						id_usuario,
		        						fecha_hora,		    
		        						tipo,
		        						punto_vta,
		        						numero,
		        						razon_social,
		        						cuit,
		        						iibb,
		        						domicilio,		        						    					
		        						condicion_fiscal,		        								        						
		        						importe,
		        						adjunto,		
		        						importe_reintegro,
		        						aledanio,
		        						cant_operaciones,
		        						concepto,        						
		        						aled_nombre,        						
		        						aprobado,
		        						enviado,
		        						estado,
		        						rechazado,
		        						traslado,
		        						obsRechazo
	        			) VALUES (
	        							".$this->getUsuarioId().",   	
	        							'".$this->getFechaHora()."',   
										'".$this->getTipo()."',   
										'".$this->getPuntoVenta()."',   
										'".$this->getNumero()."',   
										'".$this->getRazonSocial()."',   
										'".$this->getCuit()."',   
										'".$this->getIibb()."',   
										'".$this->getDomicilio()."',   										
	        							'".$this->getCondFiscal()."',   	
	        							".$this->getImporte().",   	
	        							'".$this->getAdjunto()."',   
	        							".$this->getImporteReintegro().",
	        							'".$this->getAledanio()."',   
	        							".$this->getCantOperaciones().",   					
	        							'".$this->getConcepto()."',
	        							'".$this->getAledNombre()."',
	        							'".$this->getAprobado()."',   
	        							'".$this->getEnviado()."',   
	        							'".$this->getEstado()."',
	        							'".$this->getRechazado()."',   
	        							'".$this->getTraslado()."',   
	        							'".$this->getObsRechazo()."'
	        			)";        
			
	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::insert($conexion,$query);
			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function update($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Ticket no identificado");

				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario Vacio");			

				# Query 			
				$query="UPDATE tickets SET
								id_usuario=".$this->getUsuarioId().",								
								fecha_hora='".$this->getFechaHora()."',
								tipo='".$this->getTipo()."',
								punto_vta='".$this->getPuntoVenta()."',
								numero='".$this->getNumero()."',
								razon_social='".$this->getRazonSocial()."',
								cuit='".$this->getCuit()."',
								iibb='".$this->getIibb()."',
								domicilio='".$this->getDomicilio()."',
								condicion_fiscal='".$this->getCondFiscal()."',
								importe=".$this->getImporte().",
								adjunto='".$this->getAdjunto()."',		
								importe_reintegro=".$this->getImporteReintegro().",
								aledanio='".$this->getAledanio()."',
								cant_operaciones=".$this->getCantOperaciones().",
								concepto='".$this->getConcepto()."',						
								aled_nombre='".$this->getAledNombre()."',						
								aprobado='".$this->getAprobado()."',
								traslado='".$this->getTraslado()."',
								enviado='".$this->getEnviado()."',
								estado='".$this->getEstado()."'
							WHERE id=".$this->getId();

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function delete($conexion)
		{
			try {
				
				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Legajo no identificado");
			
				# Query 			
				$query="UPDATE tickets SET							
								estado='false'
							WHERE id=".$this->getId();

				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function select()
		{			
			try {
											
				# Query
				if(empty($this->getId()))
				{
					$query = "SELECT * FROM tickets WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id del Legajo");		

					$query="SELECT * FROM tickets WHERE id=".$this->getId();
				}
				
				//echo $query;
				//exit();

				# Ejecucion 					
				$result = SQL::selectObject($query, new Tickets);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function setPropiedadesBySelect($filas)
		{	
			if(empty($filas)){
				$this->cleanClass();
			}
			else{
				$this->setId($filas['id']);				

				$u = new Usuario;
				$u->setId($filas['id_usuario']);			
				$u = $u->select();
				$this->setUsuarioId($u);					

				$this->setFechaHora($filas['fecha_hora']);				
				$this->setTipo($filas['tipo']);				
				$this->setPuntoVenta($filas['punto_vta']);	
				$this->setNumero($filas['numero']);			
				$this->setRazonSocial($filas['razon_social']);				
				$this->setCuit($filas['cuit']);				
				$this->setIibb($filas['iibb']);				
				$this->setDomicilio($filas['domicilio']);				
				$this->setCondFiscal($filas['condicion_fiscal']);				
				$this->setImporte($filas['importe']);
				$this->setAdjunto($filas['adjunto']);	
				$this->setImporteReintegro($filas['importe_reintegro']);	
				$this->setAledanio($filas['aledanio']);	
				$this->setCantOperaciones($filas['cant_operaciones']);	
				$this->setConcepto($filas['concepto']);	
				$this->setAledNombre($filas['aled_nombre']);	
				$this->setAprobado($filas['aprobado']);
				$this->setEnviado($filas['enviado']);
				$this->setEstado($filas['estado']);
				$this->setRechazado($filas['rechazado']);
				$this->setTraslado($filas['traslado']);
				$this->setObsRechazo($filas['obsRechazo']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setUsuarioId(new Usuario);			

			$this->setFechaHora('');			
			$this->setTipo('');
			$this->setPuntoVenta('');
			$this->setNumero('');
			$this->setRazonSocial('');
			$this->setCuit('');
			$this->setIibb('');
			$this->setDomicilio('');
			$this->setCondFiscal('');
			$this->setImporte(0);
			$this->setAdjunto('');
			
			$this->setEstado(true);
			$this->setAprobado(false);
			$this->setEnviado(false);

			$this->setImporteReintegro(0);	
			$this->setAledanio(false);			
			$this->setCantOperaciones(0);
			$this->setConcepto('');
			$this->setAledNombre('');
			$this->setRechazado(false);			
			$this->setTraslado(false);			
			$this->setObsRechazo('');			
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';

			/*
			USE [AppWeb]
			GO
			SET ANSI_NULLS ON
			GO
			SET QUOTED_IDENTIFIER ON
			GO
			CREATE TABLE [dbo].[tickets](
				[id] [numeric](18, 0) IDENTITY(1,1) NOT NULL,
				[tipo] [nchar](100) NULL,
				[punto_vta] [nchar](100) NULL,
				[numero] [nchar](100) NULL,
				[razon_social] [nchar](100) NULL,
				[cuit] [nchar](100) NULL,
				[iibb] [nchar](100) NULL,
				[domicilio] [nchar](100) NULL,
				[condicion_fiscal] [nchar](100) NULL,
				[importe] [numeric](18, 2) NULL,
				[adjunto] [nchar](100) NULL,
				[estado] [bit] NULL,
				[enviado] [bit] NULL,
				[aprobado] [bit] NULL,
				[fecha_hora] [datetime] NULL,
				[id_usuario] [numeric](18, 0) NULL,
				[importe_reintegro] [numeric](18, 2) NULL,
				[aledanio] [bit] NULL,
				[cant_operaciones] [numeric](18, 2) NULL,
				[concepto] [nchar](100) NULL,
				[rechazado] [bit] NULL,
				[obsRechazo] [text] NULL,
			 CONSTRAINT [PK_tickets] PRIMARY KEY CLUSTERED 
			(
				[id] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

			GO
			*/
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
	
		public function selectByUsuario($usuario)
		{			
			try {

				if(empty($usuario))
					throw new Exception("No se selecciono el Usuario");		

				$query="SELECT TOP 1 * FROM tickets WHERE id_usuario=".$usuario;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Tickets);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function enviarTickets($id,$reintegro,$aledanio,$operaciones,$aledNombre,$traslado){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Ticket no identificado");

				# Query 			
				$query="UPDATE tickets SET								
								enviado=1,
								rechazado=0,
								importe_reintegro=".$reintegro.",
								aledanio='".$aledanio."',
								traslado='".$traslado."',
								aled_nombre='".$aledNombre."',
								cant_operaciones=".$operaciones."
							WHERE id=".$id;


				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function rechazarTickets($id){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Ticket no identificado");

				# Query 			
				$query="UPDATE tickets SET								
								enviado=0
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function aprobarTickets($id,$reintegro){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Ticket no identificado");

				# Query 			
				$query="UPDATE tickets SET								
								aprobado=1,
								importe_reintegro=".$reintegro."								
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}


		public function editarTickets($id,$reintegro){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Ticket no identificado");

				# Query 			
				$query="UPDATE tickets SET
								importe_reintegro=".$reintegro."								
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function desaprobarTickets($id){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Ticket no identificado");

				# Query 			
				$query="UPDATE tickets SET								
								aprobado=0
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function rechazarTicketsAprob($id,$obsRechazo){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Ticket no identificado");

				# Query 			
				$query="UPDATE tickets SET								
								enviado=1,
								rechazado = 'true',
								obsRechazo='".$obsRechazo."'
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}


		public function seleccionarByFiltros($fdesde,$fhasta,$usuario,$festados,$enviada){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (tickets.fecha_hora AS DATE) = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (tickets.fecha_hora AS DATE) =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (tickets.fecha_hora AS DATE) >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (tickets.fecha_hora AS DATE) <=  '".$tmp."' AND ";
					}
				}
											
				$filtro_usuario="";
				if(!empty($usuario))								
					$filtro_usuario = "tickets.id_usuario = ".$usuario." AND ";

				$filtro_enviada="";
				if(!empty($enviada))								
					$filtro_enviada = "tickets.enviado = ".$enviada." AND ";

				$filtro_estados="";
				if(!empty($festados))
				   switch ($festados) {
				   		case '1':
				   	      $filtro_estados = "tickets.aprobado = 'true' AND ";							
				   			break;
				   		case '2':
				   	      $filtro_estados = "tickets.aprobado = 'false' AND ";
				   	        break;	
				   		case '3':
				   		  $filtro_enviada = "";
				   	      $filtro_estados = "tickets.rechazado = 'true' AND ";
				   	        break;							
				   						
				   					};

				$filtro_estado = "tickets.estado = 'true'";


				$query="SELECT * FROM tickets 
								WHERE
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_usuario."
									".$filtro_enviada."
									".$filtro_estados."
									".$filtro_estado;
				# Ejecucion 					
				$result = SQL::selectObject($query, new Tickets);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}			
		}

		public function resumenGestor($idGestor, $fdesde, $fhasta){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (tickets.fecha_hora AS DATE) = '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (tickets.fecha_hora AS DATE) =  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (tickets.fecha_hora AS DATE) >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (tickets.fecha_hora AS DATE) <=  '".$tmp."' AND ";
					}
				}
											
				$filtro_usuario="";
				if(!empty($idGestor))								
					$filtro_usuario = "tickets.id_usuario = ".$idGestor." AND ";

				$filtro_estados = "tickets.aprobado = 'true' AND ";
				$filtro_estado = "tickets.estado = 'true'";


				$query="SELECT * FROM tickets 
								WHERE
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_usuario."
									".$filtro_estados."
									".$filtro_estado;
				# Ejecucion 					
				$result = SQL::selectObject($query, new Tickets);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}			
		}

		public function updateTicket($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Ticket no identificado");

				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario Vacio");			

				# Query 			
				$query="UPDATE tickets SET
								tipo='".$this->getTipo()."',
								punto_vta='".$this->getPuntoVenta()."',
								numero='".$this->getNumero()."',
								razon_social='".$this->getRazonSocial()."',
								cuit='".$this->getCuit()."',
								iibb='".$this->getIibb()."',
								domicilio='".$this->getDomicilio()."',
								condicion_fiscal='".$this->getCondFiscal()."',
								importe=".$this->getImporte().",
								adjunto='".$this->getAdjunto()."',		
								importe_reintegro=".$this->getImporteReintegro().",
								aledanio='".$this->getAledanio()."',
								aled_nombre='".$this->getAledNombre()."',
								cant_operaciones=".$this->getCantOperaciones().",
								concepto='".$this->getConcepto()."'
							WHERE id=".$this->getId();

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

	}
?>