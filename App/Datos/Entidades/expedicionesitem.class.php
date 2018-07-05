<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	class ExpedicionesItem
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }


		private $_nombre;
		public function getNombre(){ return $this->_nombre; }
		public function setNombre($nombre){ $this->_nombre=$nombre; }

		private $_descripcion;
		public function getDescripcion(){ return $this->_descripcion; }
		public function setDescripcion($descripcion){ $this->_descripcion=$descripcion; }

		private $_grupo;
		public function getGrupo(){ return $this->_grupo; }
		public function setGrupo($grupo){ $this->_grupo=$grupo; }

		private $_gruponum;
		public function getGruponum(){ return $this->_gruponum; }
		public function setGruponum($gruponum){ $this->_gruponum=$gruponum; }

		private $_stock;
		public function getStock(){ return $this->_stock; }
		public function setStock($stock){ $this->_stock=$stock; }

		private $_ptopedido;
		public function getPtopedido(){ return $this->_ptopedido; }
		public function setPtopedido($ptopedido){ $this->_ptopedido=$ptopedido; }
       

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		private $_apedir;
		public function getApedir(){ return var_export($this->_apedir,false); }
		public function setApedir($apedir){ $this->_apedir=$apedir; }		

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);			
			$this->setNombre('');			
			$this->setDescripcion('');			
			$this->setGrupo('');		
			$this->setGruponum(0);				
			$this->setStock(0);				
			$this->setPtopedido(0);				
			$this->setEstado(true);
			$this->setApedir(false);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 			
				
				
				# Query 			
				$query="INSERT INTO expediciones_items (		        						
		        						nombre_items,
		        						descripcion,
		        						num_grupo,		        		
		        						stock,		        		
		        						pto_pedido,		        		
		        						estado,
		        						a_pedir
	        			) VALUES (	        							
	        							  	
	        							'".$this->getNombre()."',   		        			
	        							'".$this->getDescripcion()."',   		       				
	        							 ".$this->getGruponum().",   		       							
	        							 ".$this->getStock().",   		       							
	        							 ".$this->getPtopedido().",   		       							
	        							'".$this->getEstado()."',
	        							'".$this->getApedir()."'
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
					throw new Exception("Tipo de expedición no identificado");

				if(empty($this->getGruponum()))
					throw new Exception("Grupo Vacio");								
				# Query 			
				$query="UPDATE expediciones_items SET								
								nombre_items='".$this->getNombre()."',
								descripcion='".$this->getDescripcion()."',
								num_grupo='".$this->getGruponum()."',
								stock=".$this->getStock().",
								pto_pedido=".$this->getPtopedido().",
								estado = '".$this->getEstado()."',	
								a_pedir = '".$this->getApedir()."'	
																	
							WHERE item_id=".$this->getId();

                  
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
					throw new Exception("Tipo de expedición no identificado");
			
				# Query 			
				$query="UPDATE expediciones_items SET							
								estado='false'
							WHERE item_id=".$this->getId();

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
				$query="SELECT item_id,stock,pto_pedido,a_pedir,nombre_items,num_grupo,descripcion,expediciones_tipo2.nombre_grupo,expediciones_items.estado FROM expediciones_items  inner join expediciones_tipo2 on expediciones_items.num_grupo=expediciones_tipo2.tipo_id WHERE expediciones_items.estado='true'" ;
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesItem);
						
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
				$this->setId(trim($filas['item_id']));
				$this->setNombre(trim($filas['nombre_items']));
				$this->setDescripcion(trim($filas['descripcion']));
				$this->setGrupo(trim($filas['nombre_grupo']));
				$this->setGruponum(trim($filas['num_grupo']));	
				$this->setStock(trim($filas['stock']));	
				$this->setPtopedido(trim($filas['pto_pedido']));	
			   	$this->setEstado($filas['estado']);
			   	$this->setApedir($filas['a_pedir']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);			
			$this->setNombre('');			
			$this->setDescripcion('');			
			$this->setGrupo('');		
			$this->setGruponum(0);				
			$this->setStock(0);				
			$this->setPtopedido(0);				
			$this->setEstado(true);					
		    $this->setApedir(false);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';

			// USE [Prueba_AppWeb]
			// GO

			// /****** Object:  Table [dbo].[expediciones_items]    Script Date: 03.07.18 12:01:20 ******/
			// SET ANSI_NULLS ON
			// GO

			// SET QUOTED_IDENTIFIER ON
			// GO

			// SET ANSI_PADDING ON
			// GO

			// CREATE TABLE [dbo].[expediciones_items](
			// 	[item_id] [int] IDENTITY(1,1) NOT NULL,
			// 	[nombre_items] [varchar](50) NOT NULL,
			// 	[descripcion] [varchar](50) NOT NULL,
			// 	[num_grupo] [int] NOT NULL,
			// 	[estado] [bit] NULL,
			//  CONSTRAINT [PK_nom_grupo] PRIMARY KEY CLUSTERED 
			// (
			// 	[item_id] ASC
			// )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			// ) ON [PRIMARY]

			// GO

			// SET ANSI_PADDING OFF
			// GO


		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
		

		public function selectById($item)
		{			
			try {
											
				# Query
				$query="SELECT item_id,nombre_items,num_grupo,a_pedir,stock,pto_pedido,descripcion,expediciones_tipo2.nombre_grupo,expediciones_items.estado FROM expediciones_items  inner join expediciones_tipo2 on expediciones_items.num_grupo=expediciones_tipo2.tipo_id WHERE expediciones_items.estado='true' AND item_id = ".$item ;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesItem);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}
         public function selectApedir()
		{			
			try {
											
				# Query
				$query="SELECT * FROM expediciones_items inner join expediciones_tipo2 on expediciones_items.num_grupo=expediciones_tipo2.tipo_id WHERE expediciones_items.estado='true' AND a_pedir='true'";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesItem);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function updateStock($iditem,$actualizarstock)
		{
			try {    
				    $conexion=false;

				
				# Query 			
				$query="UPDATE expediciones_items SET								
								
								stock=".$actualizarstock."
								
																	
							WHERE item_id=".$iditem;

			// var_dump($query);
			// exit();				

                  
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
	}
?>