  <?php 
      include_once "../../../Config/config.ini.php";
	    include_once '../../../Datos/BaseDatos/conexionapp.class.php';
	    include_once '../../../Datos/BaseDatos/sql.class.php';
      include_once "../../../Negocio/Expediciones/handlerexpediciones.class.php";

      $id=$_POST['id_tipo'];
      $query="SELECT * FROM expediciones_items WHERE estado='true' AND num_grupo=".$id ;
     
     // $result= $mysqli->query($query);
     $result = SQL::selectObject($query, new ExpedicionesItem);

	    if(count($result)==1){
			$result = array('' => $result );                   
		}

       if(!empty($result)){
       	echo "<option value=''>Seleccione un ítem...</option>";

         foreach ($result as $key => $value) {
           echo "<option value=".$value->getId().">".$value->getNombre()."</option>";
             }
              } else {
              	echo "<option value=''>No se encontró ningún ítem...</option>";
              }
       ?>