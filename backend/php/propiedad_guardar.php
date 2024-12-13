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
    $pictures = [];

    // Comprobando si se seleccionaron imágenes
    if (isset($_FILES['pictures']) && count($_FILES['pictures']['name']) > 0) {
        foreach ($_FILES['pictures']['name'] as $index => $name) {
            $file_name = $img_dir . uniqid() . '_' . $name;
            $file_tmp = $_FILES['pictures']['tmp_name'][$index];
            $file_size = $_FILES['pictures']['size'][$index];
            $file_ext = pathinfo($name, PATHINFO_EXTENSION);

            // Validar tamaño y formato de la imagen
            if ($file_size > 0 && $file_size <= 3145728 && in_array($file_ext, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($file_tmp, $file_name)) {
                    $pictures[] = str_replace('../../', '', $file_name); // Guardar ruta relativa
                }
            }
        }
    }
	
    // Serializar imágenes para guardar en la base de datos
    $pictures_serialized = json_encode($pictures);


	/*== Guardando en la base de datos ==*/
    $guardar_propiedad=conexion();
    $guardar_propiedad=$guardar_propiedad->prepare("INSERT INTO propiedades(title,description,observations,ubication,value,picture,id_type,id_operation) VALUES(:titulo,:descripcion,:observacion,:ubicacion,:precio,:picture,:tipo,:operacion)");

    $marcadores=[
        ":titulo"=>$titulo,
        ":descripcion"=>$descripcion,
        ":observacion"=>$observacion,
        ":ubicacion"=>$ubicacion,
        ":precio"=>$precio,
        ":picture"=>$pictures_serialized,
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

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar la propiedad, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_propiedad=null;