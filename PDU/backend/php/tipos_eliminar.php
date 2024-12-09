
<?php
	/*== Almacenando datos ==*/
    $id_type_del=limpiar_cadena($_GET['id_type_del']);

    /*== Verificando usuario ==*/
    $check_type=conexion();
    $check_type=$check_type->query("SELECT id_type FROM tipo_propiedad WHERE id_type='$id_type_del'");
    
    if($check_type->rowCount()==1){

    	$check_propiedades=conexion();
    	$check_propiedades=$check_propiedades->query("SELECT id_type FROM propiedades WHERE id_type='$id_type_del' LIMIT 1");
                if($check_propiedades->rowCount()<=0){

    		$eliminar_tipo=conexion();
	    	$eliminar_tipo=$eliminar_tipo->prepare("DELETE FROM tipo_propiedad WHERE id_type=:id");

	    	$eliminar_tipo->execute([":id"=>$id_type_del]);

	    	if($eliminar_tipo->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡Categoría ELIMINADA!</strong><br>
		                Los datos de la categoría se eliminaron con exito
		            </div>
		        ';
                        echo '<meta http-equiv="refresh" content="2;url=index.php?vista=type_list">';
                }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar la categoría, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_tipo=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar la categoría ya que tiene productos asociados
	            </div>
	        ';
    	}
    	$check_propiedades=null;
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoría que intenta eliminar no existe
            </div>
        ';
    }
    $check_type=null;

