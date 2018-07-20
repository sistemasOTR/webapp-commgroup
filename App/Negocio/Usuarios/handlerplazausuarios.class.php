<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/usuario_plaza.class.php';
	
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

		public function insert ($nombre){
			try {

				$p = new PlazaUsuario;
				$p->setNombre($nombre);			

				$p->insert(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}

		public function update ($id,$nombre){
			try {

				$p = new PlazaUsuario;
				$p->setId($id);
				$p = $u->select();

				$p->setNombre($nombre);

				$p->update(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}

		public function delete ($id){
			try {
				
				$p = new PlazaUsuario;
				$p->setId($id);

				$p->delete(null);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());			
			}
		}

	}
?>		