<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['id_type']);


    /*== Verificando categoria ==*/
	$check_type=conexion();
	$check_type=$check_type->query("SELECT * FROM tipo_propiedad WHERE id_type='$id'");

    if($check_type->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La operación no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_type->fetch();
    }
    $check_type=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['type_name']);
   


    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }



    /*== Verificando nombre ==*/
    if($nombre!=$datos['type_name']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT type_name FROM tipo_propiedad WHERE type_name='$nombre'");
	    if($check_nombre->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_nombre=null;
    }


    /*== Actualizar datos ==*/
    $actualizar_type=conexion();
    $actualizar_type=$actualizar_type->prepare("UPDATE tipo_propiedad SET type_name=:nombre WHERE id_type=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":id"=>$id
    ];

    if($actualizar_type->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡CATEGORÍA ACTUALIZADA!</strong><br>
                La categoría se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar la categoría, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_type=null;
