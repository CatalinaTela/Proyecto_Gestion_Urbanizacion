
<?php
	/*== Almacenando datos ==*/
    $id_operation_del=limpiar_cadena($_GET['id_operation_del']);

    /*== Verificando usuario ==*/
    $check_operation=conexion();
    $check_operation=$check_operation->query("SELECT id_operation FROM operacion_inmobiliaria WHERE id_operation='$id_operation_del'");
    
    if($check_operation->rowCount()==1){

    	$check_propiedades=conexion();
    	$check_propiedades=$check_propiedades->query("SELECT id_operation FROM propiedades WHERE id_operation='$id_operation_del' LIMIT 1");

    	if($check_propiedades->rowCount()<=0){

    		$eliminar_operacion=conexion();
	    	$eliminar_operacion=$eliminar_operacion->prepare("DELETE FROM operacion_inmobiliaria WHERE id_operation=:id");

	    	$eliminar_operacion->execute([":id"=>$id_operation_del]);

	    	if($eliminar_operacion->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡OPERACIÓN ELIMINADA!</strong><br>
		                Los datos de la operación se eliminaron con exito
		            </div>
		        ';
                         echo '<meta http-equiv="refresh" content="2;url=index.php?vista=operation_list">';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar la operación, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_operacion=null;
    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos eliminar la operación ya que tiene productos asociados
	            </div>
	        ';
    	}
    	$check_propiedades=null;
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La operación que intenta eliminar no existe
            </div>
        ';
    }
    $check_operation=null;

