<?php
	/*== Almacenando datos ==*/
    $id_property_del=limpiar_cadena($_GET['id_property_del']);

    /*== Verificando producto ==*/
    $check_propiedad=conexion();
    $check_propiedad=$check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id_property_del'");

    if($check_propiedad->rowCount()==1){

    	$datos=$check_propiedad->fetch();

    	$eliminar_propiedad=conexion();
    	$eliminar_propiedad=$eliminar_propiedad->prepare("DELETE FROM propiedades WHERE id_property=:id");

    	$eliminar_propiedad->execute([":id"=>$id_property_del]);

    	if($eliminar_propiedad->rowCount()==1){

    		if(is_file("./assets/img/propiedad/".$datos['picture'])){
    			chmod("./assets/img/propiedad".$datos['picture'], 0777);
				unlink("./assets/img/propiedad/".$datos['picture']);
    		}
                 header("Location: index.php?vista=property_list"); 
	                     
                exit();

	    }else{
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No se pudo eliminar la propiedad, por favor intente nuevamente
	            </div>
	        ';
	    }
	    $eliminar_propiedad=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La PROPIEDAD que intenta eliminar no existe
            </div>
        ';
    }
    $check_propiedad=null;
