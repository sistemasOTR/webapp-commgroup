<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class KanbanHistoria
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }
		
		private $_titulo;
		public function getTitulo(){ return $this->_titulo; }
		public function setTitulo($titulo){ $this->_titulo =$titulo; }

		private $_descripcion;
		public function getDescripcion(){ return $this->_descripcion; }
		public function setDescripcion($descripcion){ $this->_descripcion =$descripcion; }
		
		private $_idKanban;
		public function getIdKanban(){ return $this->_idKanban; }
		public function setIdKanban($idKanban){ $this->_idKanban =$idKanban; }
		
		private $_idOperador;
		public function getIdOperador(){ return $this->_idOperador; }
		public function setIdOperador($idOperador){ $this->_idOperador =$idOperador; }

		private $_idEnc;
		public function getIdEnc(){ return $this->_idEnc; }
		public function setIdEnc($idEnc){ $this->_idEnc =$idEnc; }

		private $_inicioEst;
		public function getInicioEst(){ return $this->_inicioEst; }
		public function setInicioEst($inicioEst){ $this->_inicioEst =$inicioEst; }
		
		private $_finEst;
		public function getFinEst(){ return $this->_finEst; }
		public function setFinEst($finEst){ $this->_finEst =$finEst; }
		
		private $_estadoKb;
		public function getEstadoKb(){ return $this->_estadoKb; }
		public function setEstadoKb($estadoKb){ $this->_estadoKb =$estadoKb; }

		private $_prioridad;
		public function getPrioridad(){ return $this->_prioridad; }
		public function setPrioridad($prioridad){ $this->_prioridad =$prioridad; }

		// private $_sector;
		// public function getSector(){ return $this->_sector; }
		// public function setSector($sector){ $this->_sector =$sector; }
		
		private $_tipoCambio;
		public function getTipoCambio(){ return $this->_tipoCambio; }
		public function setTipoCambio($tipoCambio){ $this->_tipoCambio =$tipoCambio; }
		
		private $_fechaHora;
		public function getFechaHora(){ return $this->_fechaHora; }
		public function setFechaHora($fechaHora){ $this->_fechaHora =$fechaHora; }
		
		private $_inicioReal;
		public function getInicioReal(){ return $this->_inicioReal; }
		public function setInicioReal($inicioReal){ $this->_inicioReal =$inicioReal; }

		private $_finReal;
		public function getFinReal(){ return $this->_finReal; }
		public function setFinReal($finReal){ $this->_finReal =$finReal; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado =$estado; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setTitulo('');
			$this->setDescripcion('');
			$this->setIdKanban(0);
			$this->setIdOperador(0);
			$this->setIdEnc(0);
			$this->setInicioEst('');
			$this->setFinEst('');
			$this->setEstadoKb(0);
			$this->setPrioridad(0);
			// $this->setSector(0);
			$this->setTipoCambio(0);
			$this->setFechaHora('');
			$this->setInicioReal('');
			$this->setFinReal('');
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO kanban_hist (
										titulo,	
		        						descripcion,
		        						id_kanban,
		        						id_operador,
		        						estado_kb,
		        						prioridad,
		        						fecha_hora,
		        						tipo_cambio,
		        						id_enc,
		        						inicio_est,
		        						fin_est,
		        						inicio_real,
		        						fin_real,
		        						estado
		        						
	        			) VALUES (
	        							'".$this->getTitulo()."',     	
	        							'".$this->getDescripcion()."',
	        							".$this->getIdKanban().",
	        							".$this->getIdOperador().",
	        							".$this->getEstadoKb().",
	        							".$this->getPrioridad().",     	
	        							'".$this->getFechaHora()."',
	        							".$this->getTipoCambio().",
	        							".$this->getIdEnc().",
	        							'".$this->getInicioEst()."',
	        							'".$this->getFinEst()."',
	        							'".$this->getInicioReal()."',
	        							'".$this->getFinReal()."',
	        							'".$this->getEstado()."'

	        							
	        			)";        
		
				// var_dump($query);
				// exit();
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
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE kanban_hist SET
								id='".$this->getId()."',
								titulo='".$this->getTitulo()."',	
        						descripcion='".$this->getDescripcion()."',
        						id_kanban=".$this->getIdKanban().",
        						id_operador=".$this->getIdOperador().",
        						id_enc=".$this->getIdEnc().",
        						inicio_est='".$this->getInicioEst()."',
        						fin_est='".$this->getFinEst()."',
        						estado_kb=".$this->getEstadoKb().",
        						prioridad=".$this->getPrioridad().",
        						tipo_cambio=".$this->getTipoCambio().",
        						fecha_hora='".$this->getFechaHora()."',
        						inicio_real='".$this->getInicioReal()."',
        						fin_real='".$this->getFinReal()."',
        						estado='".$this->getEstado()."'
							WHERE id=".$this->getId();

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
					throw new Exception("Impresora no identificada");
			
				# Query 			
				$query="UPDATE kanban_hist SET							
								estado = '".$this->getEstado()."
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
					$query = "SELECT * FROM kanban_hist WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el solicitud");		

					$query="SELECT * FROM kanban_hist WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new KanbanHistoria);
						
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
				$this->setTitulo(trim($filas['titulo']));			
				$this->setDescripcion($filas['descripcion']);			
				$this->setIdKanban($filas['id_kanban']);			
				$this->setIdOperador($filas['id_operador']);			
				$this->setIdEnc($filas['id_enc']);			
				$this->setInicioEst($filas['inicio_est']);			
				$this->setFinEst($filas['fin_est']);
				$this->setEstadoKb($filas['estado_kb']);			
				$this->setPrioridad($filas['prioridad']);
				$this->setTipoCambio($filas['tipo_cambio']);
				$this->setFechaHora($filas['fecha_hora']);
				$this->setInicioReal($filas['inicio_real']);
				$this->setFinReal($filas['fin_real']);
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setTitulo('');
			$this->setDescripcion('');
			$this->setIdKanban(0);
			$this->setIdOperador(0);
			$this->setIdEnc(0);
			$this->setInicioEst('');
			$this->setFinEst('');
			$this->setEstadoKb(0);
			$this->setPrioridad(0);
			$this->setTipoCambio(0);
			$this->setFechaHora('');
			$this->setInicioReal('');
			$this->setFinReal('');
			$this->setEstado(true);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
			/*
			USE [Prueba_AppWeb]
			GO

			SET ANSI_NULLS ON
			GO

			SET QUOTED_IDENTIFIER ON
			GO

			SET ANSI_PADDING ON
			GO

			CREATE TABLE [dbo].[kanban_hist](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[id_kanban] [int] NOT NULL,
				[titulo] [varchar](100) NOT NULL,
				[descripcion] [text] NOT NULL,
				[id_enc] [int] NULL,
				[inicio_est] [date] NULL,
				[fin_est] [date] NULL,
				[estado_kb] [int] NOT NULL,
				[prioridad] [int] NOT NULL,
				[tipo_cambio] [int] NOT NULL,
				[fecha_hora] [datetime] NOT NULL,
				[id_operador] [int] NOT NULL,
				[inicio_real] [date] NOT NULL,
				[fin_real] [date] NOT NULL,
				[estado] [bit] NOT NULL,
			 CONSTRAINT [PK_kanban_hist] PRIMARY KEY CLUSTERED 
			(
				[id] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

			GO

			SET ANSI_PADDING OFF
			GO



			*/
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

		public function selectHistoricoById($id)
		{			
			try {

				#Query
				$query="SELECT * FROM kanban_hist WHERE id_kanban=".$id;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new KanbanHistoria);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}


	}
?>