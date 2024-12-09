
<?php
	require_once "main.php";

	/*== Almacenando datos ==*/
    $id_property=limpiar_cadena($_POST['img_del_id']);

    /*== Verificando producto ==*/
    $check_propiedad=conexion();
    $check_propiedad=$check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id_property'");

    if($check_propiedad->rowCount()==1){
    	$datos=$check_propiedad->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen de la PROPIEDAD que intenta eliminar no existe
            </div>
        ';
        exit();
    }
    $check_propiedad=null;


    /* Directorios de imagenes */
	$img_dir='../../assets/img/propiedad/';

	/* Cambiando permisos al directorio */
	chmod($img_dir, 0777);


	/* Eliminando la imagen */
	if(is_file($img_dir.$datos['picture'])){

		chmod($img_dir.$datos['picture'], 0777);

		if(!unlink($img_dir.$datos['picture'])){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Error al intentar eliminar la imagen de la propiedad, por favor intente nuevamente
	            </div>
	        ';
	        exit();
		}
	}


	/*== Actualizando datos ==*/
    $actualizar_propiedad=conexion();
    $actualizar_propiedad=$actualizar_propiedad->prepare("UPDATE propiedades SET picture=:foto WHERE id_property=:id");

    $marcadores=[
        ":foto"=>"",
        ":id"=>$id_property
    ];

    if($actualizar_propiedad->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                La imagen de la propiedad ha sido eliminada exitosamente, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=property_img&id_property_up='.$id_property.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }else{
        echo '
            <div class="notification is-warning is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                Ocurrieron algunos inconvenientes, sin embargo la imagen de la propiedad ha sido eliminada, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=property_img&id_property_up='.$id_property.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }
    $actualizar_propiedad=null;

