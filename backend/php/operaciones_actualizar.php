<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['id_operation']);


    /*== Verificando categoria ==*/
	$check_operation=conexion();
	$check_operation=$check_operation->query("SELECT * FROM operacion_inmobiliaria WHERE id_operation='$id'");

    if($check_operation->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La operación no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_operation->fetch();
    }
    $check_operation=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['operation_name']);
   


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
    if($nombre!=$datos['operation_name']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT operation_name FROM operacion_inmobiliaria WHERE operation_name='$nombre'");
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
    $actualizar_operation=conexion();
    $actualizar_operation=$actualizar_operation->prepare("UPDATE operacion_inmobiliaria SET operation_name=:nombre WHERE id_operation=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":id"=>$id
    ];

    if($actualizar_operation->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡OPERACIÓN ACTUALIZADA!</strong><br>
                La operación se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar la operación, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_operation=null;
