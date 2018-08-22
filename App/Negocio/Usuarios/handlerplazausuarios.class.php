<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/usuario_plaza.class.php';       
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	class HandlerPlazaUsuarios{		

		public function selectTodas(){
			try{			
				$u = new PlazaUsuario;
				return $u->select();				
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());	
			}
		}		

		public function selectAll(){
			try{			
				$u = new PlazaUsuario;
				return $u->selectAll();				
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());	
			}
		}	

		public function selectById($id){
			try{		

			 if(empty($id))
					throw new Exception("No se cargo la plaza");				

				$u = new PlazaUsuario;
				$u->setId($id);
				$plaza = $u->select();				

				return $plaza;
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());	
			}
		}

		public function insert($nombre,$tipo,$fecha){
			try {

				$p = new PlazaUsuario;
				$p->setNombre($nombre);			
				$p->setTipo($tipo);			
				$p->setFechaAlta($fecha);			
				$p->setEstado(true);			

				$p->insert(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}

		public function update ($id,$nombre,$tipo){
			try {

				$p = new PlazaUsuario;
				$p->setId($id);
				$p = $p->select();

				$p->setNombre($nombre);			
				$p->setTipo($tipo);		

				$p->update(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}

		public function delete($id,$fecha){
			try {
				
				$p = new PlazaUsuario;
				$p->setId($id);
				$p->setFechaBaja($fecha);

				$p->delete(null);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());			
			}
		}

		public function reactivar($id,$fecha){
			try {
				
				$p = new PlazaUsuario;
				$p->setId($id);
				$p->setFechaAlta($fecha);
				// var_dump($p);
				// exit();
				$p->reactivar(null);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());			
			}
		}

	}
?>		