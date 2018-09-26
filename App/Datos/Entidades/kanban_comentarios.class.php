<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class KanbanComentarios
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }
		
		private $_idKanban;
		public function getIdKanban(){ return $this->_idKanban; }
		public function setIdKanban($idKanban){ $this->_idKanban =$idKanban; }

		private $_comentario;
		public function getComentario(){ return $this->_comentario; }
		public function setComentario($comentario){ $this->_comentario =$comentario; }
		
		private $_idOperador;
		public function getIdOperador(){ return $this->_idOperador; }
		public function setIdOperador($idOperador){ $this->_idOperador =$idOperador; }
		
		private $_fechaHora;
		public function getFechaHora(){ return $this->_fechaHora; }
		public function setFechaHora($fechaHora){ $this->_fechaHora =$fechaHora; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado =$estado; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setComentario('');
			$this->setIdKanban(0);
			$this->setIdOperador(0);
			$this->setFechaHora('');
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO kanban_comentarios (
		        						comentario,
		        						id_kanban,
		        						id_user,
		        						fecha_hora,
		        						estado
		        						
	        			) VALUES (    	
	        							'".$this->getComentario()."',
	        							".$this->getIdKanban().",
	        							".$this->getIdOperador().",  	
	        							'".$this->getFechaHora()."',
	        							'true'
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
				$query="UPDATE kanban_comentarios SET
								id='".$this->getId()."',
        						comentario='".$this->getComentario()."',
        						id_kanban=".$this->getIdKanban().",
        						id_user=".$this->getIdOperador().",
        						fecha_hora='".$this->getFechaHora()."',
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
					throw new Exception("Comentario no identificado");
			
				# Query 			
				$query="UPDATE kanban_comentarios SET							
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
					$query = "SELECT * FROM kanban_comentarios WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el solicitud");		

					$query="SELECT * FROM kanban_comentarios WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new KanbanComentarios);
						
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
				$this->setComentario($filas['comentario']);			
				$this->setIdKanban($filas['id_kanban']);			
				$this->setIdOperador($filas['id_user']);
				$this->setFechaHora($filas['fecha_hora']);
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setComentario('');
			$this->setIdKanban(0);
			$this->setIdOperador(0);
			$this->setFechaHora('');
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

			CREATE TABLE [dbo].[kanban_comentarios](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[id_kanban] [int] NOT NULL,
				[titulo] [varchar](100) NOT NULL,
				[comentario] [text] NOT NULL,
				[id_enc] [int] NULL,
				[fin_est] [date] NULL,
				[estado_kb] [int] NOT NULL,
				[prioridad] [int] NOT NULL,
				[tipo_cambio] [int] NOT NULL,
				[fecha_hora] [datetime] NOT NULL,
				[id_user] [int] NOT NULL,
				[fin_real] [date] NOT NULL,
				[estado] [bit] NOT NULL,
			 CONSTRAINT [PK_kanban_comentarios] PRIMARY KEY CLUSTERED 
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

		public function selectComentariosById($id)
		{			
			try {

				#Query
				$query="SELECT * FROM kanban_comentarios WHERE id_kanban=".$id;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new KanbanComentarios);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}


	}
?>