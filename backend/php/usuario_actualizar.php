<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

    /*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['id_user']);

    /*== Verificando usuario ==*/
	$check_usuario=conexion();
	$check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE id_user='$id'");

    if($check_usuario->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El usuario no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_usuario->fetch();
    }
    $check_usuario=null;


    /*== Almacenando datos del administrador ==*/
    $admin_email=limpiar_cadena($_POST['administrador_email']);
    $admin_clave=limpiar_cadena($_POST['administrador_clave']);


    /*== Verificando campos obligatorios del administrador ==*/
    if($admin_email=="" || $admin_clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha llenado los campos que corresponden a su CORREO o CLAVE
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos (admin) ==*/
    if(!filter_var($admin_email, FILTER_VALIDATE_EMAIL)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su correo no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{4,100}",$admin_clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su CLAVE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando el administrador en DB ==*/
    $check_admin=conexion();
    $check_admin=$check_admin->query("SELECT mail,password FROM usuarios WHERE mail='$admin_email' AND id_user='".$_SESSION['id']."'");
    if($check_admin->rowCount()==1){

    	$check_admin=$check_admin->fetch();

    	if($check_admin['mail']!=$admin_email || !password_verify($admin_clave, $check_admin['password'])){
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                CORREO o CLAVE de administrador incorrectos
	            </div>
	        ';
	        exit();
    	}

    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                USUARIO o CLAVE de administrador incorrectos
            </div>
        ';
        exit();
    }
    $check_admin=null;


    /*== Almacenando datos del usuario ==*/
    $nombre=limpiar_cadena($_POST['usuario_nombre']);
    $apellido=limpiar_cadena($_POST['usuario_apellido']);

    $email=limpiar_cadena($_POST['usuario_email']);
    $telefono=limpiar_cadena($_POST['usuario_telefono']);

    $clave_1=limpiar_cadena($_POST['usuario_clave_1']);
    $clave_2=limpiar_cadena($_POST['usuario_clave_2']);
     
    $role=limpiar_cadena($_POST['usuario_role']);


    /*== Verificando campos obligatorios del usuario ==*/
    if($nombre=="" || $apellido=="" || $email==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos (usuario) ==*/
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    
    if(verificar_datos("\+?[1-9][0-9]{1,3}[0-9 ]{6,12}", $telefono)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El teléfono no coincide con el formato internacional solicitado
            </div>
            ';
        exit();
    }
    
    /*== Verificando email ==*/
    if($email!="" && $email!=$datos['mail']){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT mail FROM usuarios WHERE mail='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no valido
                </div>
            ';
            exit();
        } 
    }



    /*== Verificando claves ==*/
    if($clave_1!="" || $clave_2!=""){
    	if(verificar_datos("[a-zA-Z0-9$@.-]{4,100}",$clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{4,100}",$clave_2)){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Las CLAVES no coinciden con el formato solicitado
	            </div>
	        ';
	        exit();
	    }else{
		    if($clave_1!=$clave_2){
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrio un error inesperado!</strong><br>
		                Las CLAVES que ha ingresado no coinciden
		            </div>
		        ';
		        exit();
		    }else{
		        $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
		    }
	    }
    }else{
    	$clave=$datos['password'];
    }

    //Validar el rol
    if ($role != "user" && $role != "admin") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El rol seleccionado no es válido.
            </div>
        ';
        exit();
    }


    /*== Actualizar datos ==*/
    $actualizar_usuario=conexion();
    $actualizar_usuario=$actualizar_usuario->prepare("UPDATE usuarios SET name=:nombre,lastname=:apellido,phone=:telefono,password=:clave,mail=:email,role=:role WHERE id_user=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":telefono"=>$telefono,
        ":clave"=>$clave,
        ":email"=>$email,
        ":id"=>$id,
        ":role"=>$role
    ];

    if($actualizar_usuario->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO ACTUALIZADO!</strong><br>
                El usuario se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el usuario, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_usuario=null;
