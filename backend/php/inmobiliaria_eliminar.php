<?php

	/*== Almacenando datos ==*/
    $id_agency_del=limpiar_cadena($_GET['id_agency_del']);

    /*== Verificando usuario ==*/
    $check_inmobiliaria=conexion();
    $check_inmobiliaria=$check_inmobiliaria->query("SELECT id_agency FROM inmobiliarias WHERE id_agency='$id_agency_del'");
    
    if($check_inmobiliaria->rowCount()==1){

    		
	    	$eliminar_inmboliaria=conexion();
	    	$eliminar_inmboliaria=$eliminar_inmboliaria->prepare("DELETE FROM inmobiliarias WHERE id_agency=:id");

	    	$eliminar_inmboliaria->execute([":id"=>$id_agency_del]);

	    	if($eliminar_inmboliaria->rowCount()==1){
		        echo '
		            <div class="notification is-info is-light">
		                <strong>¡INMOBILIARIA ELIMINADA!</strong><br>
		                Los datos de la inmobiliaria se eliminaron con exito
		            </div>
		        ';
		    }else{
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                No se pudo eliminar la inmobiliaria, por favor intente nuevamente
		            </div>
		        ';
		    }
		    $eliminar_inmboliaria=null;
    	
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La inmobiliaria que intenta eliminar no existe
            </div>
        ';
    }
    $check_inmobiliaria=null;
