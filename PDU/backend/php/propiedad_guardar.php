<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/
	$titulo=limpiar_cadena($_POST['title']);
        $descripcion=limpiar_cadena($_POST['description']);
        $observacion=limpiar_cadena($_POST['observations']);
        $ubicacion=limpiar_cadena($_POST['ubication']);

	$precio=limpiar_cadena($_POST['value']);
        $tipo=limpiar_cadena($_POST['id_type']);
	$operacion=limpiar_cadena($_POST['id_operation']);


	/*== Verificando campos obligatorios ==*/
    if($titulo=="" || $descripcion=="" || $ubicacion=="" || $precio=="" || $tipo=="" || $operacion==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$titulo)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El TITULO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,200}",$descripcion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La DESCRIPCION no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,200}",$observacion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La OBSERVACION no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$ubicacion)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La UBICACION no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[0-9.]{1,25}",$precio)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El PRECIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }





    /*== Verificando categoria ==*/
    $check_operacion=conexion();
    $check_operacion=$check_operacion->query("SELECT id_operation FROM operacion_inmobiliaria WHERE id_operation='$operacion'");
    if($check_operacion->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La operación seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_operacion=null;

    $check_tipo=conexion();
    $check_tipo=$check_tipo->query("SELECT id_type FROM tipo_propiedad WHERE id_type='$tipo'");
    if($check_tipo->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La categoría seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_tipo=null;

    /* Directorios de imagenes */
	$img_dir='../../assets/img/propiedad/';


	/*== Comprobando si se ha seleccionado una imagen ==*/
	if($_FILES['picture']['name']!="" && $_FILES['picture']['size']>0){

        /* Creando directorio de imagenes */
        if(!file_exists($img_dir)){
            if(!mkdir($img_dir,0777)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        Error al crear el directorio de imagenes
                    </div>
                ';
                exit();
            }
        }

		/* Comprobando formato de las imagenes */
		if(mime_content_type($_FILES['picture']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['picture']['tmp_name'])!="image/png"){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado es de un formato que no está permitido
	            </div>
	        ';
	        exit();
		}


		/* Comprobando que la imagen no supere el peso permitido */
		if(($_FILES['picture']['size']/1024)>3072){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La imagen que ha seleccionado supera el límite de peso permitido
	            </div>
	        ';
			exit();
		}


		/* extencion de las imagenes */
		switch(mime_content_type($_FILES['picture']['tmp_name'])){
			case 'image/jpeg':
			  $img_ext=".jpg";
			break;
			case 'image/png':
			  $img_ext=".png";
			break;
		}

		/* Cambiando permisos al directorio */
		chmod($img_dir, 0777);

		/* Nombre de la imagen */
		$img_nombre=renombrar_fotos($titulo);

		/* Nombre final de la imagen */
		$foto=$img_nombre.$img_ext;

		/* Moviendo imagen al directorio */
		if(!move_uploaded_file($_FILES['picture']['tmp_name'], $img_dir.$foto)){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
	            </div>
	        ';
			exit();
		}

	}else{
		$foto="";
	}


	/*== Guardando datos ==*/
    $guardar_propiedad=conexion();
    $guardar_propiedad=$guardar_propiedad->prepare("INSERT INTO propiedades(title,description,observations,ubication,value,picture,id_type,id_operation) VALUES(:titulo,:descripcion,:observacion,:ubicacion,:precio,:foto,:tipo,:operacion)");

    $marcadores=[
        ":titulo"=>$titulo,
        ":descripcion"=>$descripcion,
        ":observacion"=>$observacion,
        ":ubicacion"=>$ubicacion,
        ":precio"=>$precio,
        ":foto"=>$foto,
        ":tipo"=>$tipo,
        ":operacion"=>$operacion
    ];

    $guardar_propiedad->execute($marcadores);

    if($guardar_propiedad->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PROPIEDAD REGISTRADO!</strong><br>
                La propiedad se registro con exito
            </div>
        ';
    }else{

    	if(is_file($img_dir.$foto)){
			chmod($img_dir.$foto, 0777);
			unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar la propiedad, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_propiedad=null;