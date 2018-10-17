<?php 
      include_once "../../../Config/config.ini.php";
	    include_once '../../../Datos/BaseDatos/conexionapp.class.php';
	    include_once '../../../Datos/BaseDatos/sql.class.php';
      include_once "../../../Negocio/Modulos/handlerasistencias.class.php";

      $id=$_POST['id_tipo'];
      $seleccionado=$_POST['seleccionado'];

      $query="SELECT * FROM asistencias_estados WHERE estado='true' AND tipo_perfil=0 OR tipo_perfil=".$id ;
  
     // $result= $mysqli->query($query);
     $result = SQL::selectObject($query, new AsistenciasEstados);

	    if(count($result)==1){
			$result = array('' => $result );                   
		}

       if(!empty($result)){
       	echo "<option value=''>Escoga Estado</option>";
         foreach ($result as $key => $value) { 
         if ($value->getId()==$seleccionado) {
                echo "<option value=".$value->getId()." selected>".$value->getNombre()."</option>";     
                   } else{         
                     
                echo "<option value=".$value->getId().">".$value->getNombre()."</option>";                
                 }  
              } 
            } 
       ?>