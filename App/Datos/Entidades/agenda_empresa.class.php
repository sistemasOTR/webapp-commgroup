<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class AgendaEmpresa
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }
		
		private $_nombre;
		public function getNombre(){ return $this->_nombre; }
		public function setNombre($nombre){ $this->_nombre =$nombre; }

		private $_rubro;
		public function getRubro(){ return $this->_rubro; }
		public function setRubro($rubro){ $this->_rubro =$rubro; }
		
		private $_fechaUltContacto;
		public function getFechaUltContacto(){ return $this->_fechaUltContacto; }
		public function setFechaUltContacto($fechaUltContacto){ $this->_fechaUltContacto =$fechaUltContacto; }
		
		private $_fechaAlta;
		public function getFechaAlta(){ return $this->_fechaAlta; }
		public function setFechaAlta($fechaAlta){ $this->_fechaAlta =$fechaAlta; }

		private $_telefono1;
		public function getTelefono1(){ return $this->_telefono1; }
		public function setTelefono1($telefono1){ $this->_telefono1 =$telefono1; }

		private $_perContacto1;
		public function getPerContacto1(){ return $this->_perContacto1; }
		public function setPerContacto1($perContacto1){ $this->_perContacto1 =$perContacto1; }
		
		private $_puesto1;
		public function getPuesto1(){ return $this->_puesto1; }
		public function setPuesto1($puesto1){ $this->_puesto1 =$puesto1; }
		
		private $_email1;
		public function getEmail1(){ return $this->_email1; }
		public function setEmail1($email1){ $this->_email1 =$email1; }

		private $_telefono2;
		public function getTelefono2(){ return $this->_telefono2; }
		public function setTelefono2($telefono2){ $this->_telefono2 =$telefono2; }

		private $_perContacto2;
		public function getPerContacto2(){ return $this->_perContacto2; }
		public function setPerContacto2($perContacto2){ $this->_perContacto2 =$perContacto2; }
		
		private $_puesto2;
		public function getPuesto2(){ return $this->_puesto2; }
		public function setPuesto2($puesto2){ $this->_puesto2 =$puesto2; }
		
		private $_email2;
		public function getEmail2(){ return $this->_email2; }
		public function setEmail2($email2){ $this->_email2 =$email2; }

		private $_web;
		public function getWeb(){ return $this->_web; }
		public function setWeb($web){ $this->_web =$web; }

		private $_domicilio;
		public function getDomicilio(){ return $this->_domicilio; }
		public function setDomicilio($domicilio){ $this->_domicilio =$domicilio; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado =$estado; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setNombre('');
			$this->setRubro(0);
			$this->setFechaUltContacto('');
			$this->setFechaAlta('');
			$this->setTelefono1('');
			$this->setPerContacto1('');
			$this->setPuesto1('');
			$this->setEmail1('');
			$this->setTelefono2('');
			$this->setPerContacto2('');
			$this->setPuesto2('');
			$this->setEmail2('');
			$this->setWeb('');
			$this->setDomicilio('');
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO agenda_empresa (
										nombre,	
		        						rubro,
		        						fecha_ult_contacto,
		        						fecha_alta,
		        						telefono_1,
		        						per_contacto_1,
		        						puesto_1,
		        						email_1,
		        						telefono_2,
		        						per_contacto_2,
		        						puesto_2,
		        						email_2,
		        						web,
		        						domicilio,
		        						estado
		        						
	        			) VALUES (
	        							'".$this->getNombre()."',     	
	        							".$this->getRubro().",
	        							'".$this->getFechaUltContacto()."',
	        							'".$this->getFechaAlta()."',
	        							'".$this->getTelefono1()."',
	        							'".$this->getPerContacto1()."',
	        							'".$this->getPuesto1()."',
	        							'".$this->getEmail1()."',
	        							'".$this->getTelefono2()."',
	        							'".$this->getPerContacto2()."',
	        							'".$this->getPuesto2()."',
	        							'".$this->getEmail2()."',
	        							'".$this->getWeb()."',
	        							'".$this->getDomicilio()."',
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
				$query="UPDATE agenda_empresa SET
								id='".$this->getId()."',
								nombre='".$this->getNombre()."',	
        						rubro=".$this->getRubro().",
        						fecha_ult_contacto='".$this->getFechaUltContacto()."',
        						fecha_alta='".$this->getFechaAlta()."',
        						telefono_1='".$this->getTelefono1()."',
        						per_contacto_1='".$this->getPerContacto1()."',
        						puesto_1='".$this->getPuesto1()."',
        						email_1='".$this->getEmail1()."',
        						telefono_2='".$this->getTelefono2()."',
        						per_contacto_2='".$this->getPerContacto2()."',
        						puesto_2='".$this->getPuesto2()."',
        						email_2='".$this->getEmail2()."',
        						web='".$this->getWeb()."',
        						domicilio='".$this->getDomicilio()."',
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
				$query="UPDATE agenda_empresa SET							
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
					$query = "SELECT * FROM agenda_empresa WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el cliente");		

					$query="SELECT * FROM agenda_empresa WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new AgendaEmpresa);
						
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
				$this->setNombre(trim($filas['nombre']));			
				$this->setRubro($filas['rubro']);			
				$this->setFechaUltContacto($filas['fecha_alta']);			
				$this->setFechaAlta($filas['fecha_ult_contacto']);			
				$this->setTelefono1(trim($filas['telefono_1']));			
				$this->setPerContacto1($filas['per_contacto_1']);			
				$this->setPuesto1($filas['puesto_1']);
				$this->setEmail1($filas['email_1']);			
				$this->setTelefono2($filas['telefono_2']);			
				$this->setPerContacto2($filas['per_contacto_2']);			
				$this->setPuesto2($filas['puesto_2']);
				$this->setEmail2($filas['email_2']);
				$this->setWeb($filas['web']);
				$this->setDomicilio($filas['domicilio']);
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setNombre('');
			$this->setRubro(0);
			$this->setFechaUltContacto('');
			$this->setFechaAlta('');
			$this->setTelefono1('');
			$this->setPerContacto1('');
			$this->setPuesto1('');
			$this->setEmail1('');
			$this->setTelefono2('');
			$this->setPerContacto2('');
			$this->setPuesto2('');
			$this->setEmail2('');
			$this->setWeb('');
			$this->setDomicilio('');
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

			CREATE TABLE [dbo].[agenda_empresa](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[nombre] [varchar](50) NOT NULL,
				[rubro] [int] NOT NULL,
				[telefono_1] [varchar](30) NOT NULL,
				[per_contacto_1] [varchar](50) NOT NULL,
				[puesto_1] [varchar](30) NOT NULL,
				[email_1] [varchar](100) NOT NULL,
				[telefono_2] [varchar](30) NULL,
				[per_contacto_2] [varchar](50) NULL,
				[puesto_2] [varchar](30) NULL,
				[email_2] [varchar](100) NULL,
				[web] [varchar](50) NULL,
				[domicilio] [varchar](100) NULL,
				[fecha_ult_contacto] [datetime] NULL,
				[fecha_alta] [date] NULL,
				[estado] [bit] NOT NULL,
			 CONSTRAINT [PK_agenda_empresa] PRIMARY KEY CLUSTERED 
			(
				[id] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			) ON [PRIMARY]

			GO

			SET ANSI_PADDING OFF
			GO


			*/
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

		public function ultContacto($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE agenda_empresa SET
								fecha_ult_contacto='".$this->getFechaUltContacto()."'
							WHERE id=".$this->getId();

				// var_dump($query);
				// exit();
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function actualizar($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE agenda_empresa SET
								nombre='".$this->getNombre()."',	
        						rubro=".$this->getRubro().",
        						fecha_ult_contacto='".$this->getFechaUltContacto()."',
        						telefono_1='".$this->getTelefono1()."',
        						per_contacto_1='".$this->getPerContacto1()."',
        						puesto_1='".$this->getPuesto1()."',
        						email_1='".$this->getEmail1()."',
        						telefono_2='".$this->getTelefono2()."',
        						per_contacto_2='".$this->getPerContacto2()."',
        						puesto_2='".$this->getPuesto2()."',
        						email_2='".$this->getEmail2()."',
        						web='".$this->getWeb()."',
        						domicilio='".$this->getDomicilio()."',
        						estado='".$this->getEstado()."'
							WHERE id=".$this->getId();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function selectEmpresaByRubro($rubro)
		{			
			try {
											
				# Query
				if($rubro == 0 || empty($rubro))
				{
					$query = "SELECT * FROM agenda_empresa WHERE estado='true'";
				}
				else
				{
					$query="SELECT * FROM agenda_empresa WHERE rubro='".$rubro."'";
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new AgendaEmpresa);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

	}
?>