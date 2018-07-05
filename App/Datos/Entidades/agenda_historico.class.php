<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class AgendaHistorico
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }
		
		private $_empresaId;
		public function getEmpresaId(){ return $this->_empresaId; }
		public function setEmpresaId($empresaId){ $this->_empresaId =$empresaId; }

		private $_usuarioId;
		public function getUsuarioId(){ return $this->_usuarioId; }
		public function setUsuarioId($usuarioId){ $this->_usuarioId =$usuarioId; }
		
		private $_fechaHora;
		public function getFechaHora(){ return $this->_fechaHora; }
		public function setFechaHora($fechaHora){ $this->_fechaHora =$fechaHora; }
		
		private $_tipoId;
		public function getTipoId(){ return $this->_tipoId; }
		public function setTipoId($tipoId){ $this->_tipoId =$tipoId; }

		private $_contacto;
		public function getContacto(){ return $this->_contacto; }
		public function setContacto($contacto){ $this->_contacto =$contacto; }

		private $_obs;
		public function getObs(){ return $this->_obs; }
		public function setObs($obs){ $this->_obs =$obs; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado =$estado; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setEmpresaId(0);
			$this->setUsuarioId(0);
			$this->setFechaHora('');
			$this->setTipoId('');
			$this->setObs('');
			$this->setContacto('');
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO agenda_historico (
										id_empresa,	
		        						id_usuario,
		        						fecha_hora,
		        						id_tipo,
		        						obs,
		        						contacto,
		        						estado
		        						
	        			) VALUES (
	        							".$this->getEmpresaId().",     	
	        							".$this->getUsuarioId().",
	        							'".$this->getFechaHora()."',
	        							'".$this->getTipoId()."',
	        							'".$this->getObs()."',
	        							'".$this->getContacto()."',
	        							'".$this->getEstado()."'

	        							
	        			)";        
		
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
				$query="UPDATE agenda_historico SET
								id_empresa=".$this->getEmpresaId().",	
        						id_usuario=".$this->getUsuarioId().",
        						fecha_hora='".$this->getFechaHora()."',
        						id_tipo='".$this->getTipoId()."',
        						obs='".$this->getObs()."',
        						contacto='".$this->getContacto()."',
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
					throw new Exception("Empresa no identificada");
			
				# Query 			
				$query="UPDATE agenda_historico SET							
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
					$query = "SELECT * FROM agenda_historico WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el cliente");		

					$query="SELECT * FROM agenda_historico WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new AgendaHistorico);
						
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
				$this->setEmpresaId($filas['id_empresa']);			
				$this->setUsuarioId($filas['id_usuario']);			
				$this->setFechaHora($filas['fecha_hora']);			
				$this->setTipoId($filas['id_tipo']);			
				$this->setObs(trim($filas['obs']));
				$this->setContacto(trim($filas['contacto']));
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setEmpresaId(0);
			$this->setUsuarioId(0);
			$this->setFechaHora('');
			$this->setTipoId('');
			$this->setObs('');
			$this->setContacto('');
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

			CREATE TABLE [dbo].[agenda_historico](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[id_empresa] [int] NOT NULL,
				[id_usuario] [int] NOT NULL,
				[fecha_hora] [datetime] NOT NULL,
				[id_tipo] [varchar](50) NOT NULL,
				[obs] [text] NULL,
				[contacto] [varchar](100) NOT NULL,
				[estado] [bit] NOT NULL,
			 CONSTRAINT [PK_agenda_historico] PRIMARY KEY CLUSTERED 
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


		public function historicoEmpresa($empresaId)
		{			
			try {
											
				# Query
				
					$query="SELECT * FROM agenda_historico WHERE id_empresa=".$empresaId." order by fecha_hora desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new AgendaHistorico);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

	}
?>