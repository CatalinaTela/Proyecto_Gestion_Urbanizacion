<?php
	/*== Almacenando datos ==*/
    $email=limpiar_cadena($_POST['login_email']);
    $clave=limpiar_cadena($_POST['login_clave']);


    /*== Verificando campos obligatorios ==*/
    if($email=="" || $clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El correo electrónico no tiene un formato válido
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9$@.-]{4,100}",$clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CLAVE no coinciden con el formato solicitado
            </div>
        ';
        exit();
    }


    $check_user=conexion();
    $check_user=$check_user->query("SELECT * FROM usuarios WHERE mail='$email'");
    if($check_user->rowCount()==1){

    	$check_user=$check_user->fetch();
       
    	if($check_user['mail']==$email && password_verify($clave, $check_user['password'])){

    		$_SESSION['id']=$check_user['id_user'];
    		$_SESSION['nombre']=$check_user['name'];
    		$_SESSION['apellido']=$check_user['lastname'];
    		$_SESSION['telefono']=$check_user['phone'];
            $_SESSION['role']=$check_user['role'];

            // Redirigir según el rol
            if ($check_user['role'] == 'admin') {
                $redirect_url = "index.php?vista=home"; // Vista inicial para admin
            } else {
                $redirect_url = "index.php?vista=home_public"; // Vista inicial para usuarios
            }

    		if(headers_sent()){
				echo "<script> window.location.href=$redirect_url; </script>";
			}else{
				header("Location: $redirect_url");
			}

    	}else{
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                Correo o clave incorrectos
	            </div>
	        ';
    	}
    }else{
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Correo o clave incorrectos 2
            </div>
        ';
    }
    $check_user=null;