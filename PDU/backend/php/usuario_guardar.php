<?php 
    require_once "main.php";
    
    //Almacenando datos
    $nombre = limpiar_cadena($_POST['usuario_nombre']);
    $apellido = limpiar_cadena($_POST['usuario_apellido']);
    $email = limpiar_cadena($_POST['usuario_email']);
    $telefono = limpiar_cadena($_POST['usuario_telefono']);
    $clave_1 = limpiar_cadena($_POST['usuario_clave_1']);
    $clave_2 = limpiar_cadena($_POST['usuario_clave_2']);
    $role = limpiar_cadena($_POST['usuario_role']);
    
    //Verificando campos obligatorios
    if($nombre=="" || $apellido=="" || $clave_1=="" || $clave_2==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
            ';
        exit();
    }
    
    //Verificando integridad de los datos
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El nombre no coincide con el formato solicitado
            </div>
            ';
        exit();
    }
    
    if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El apellido no coincide con el formato solicitado
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
   
    if(verificar_datos("[a-zA-Z0-9$@.-]{4,100}",$clave_1) || 
       verificar_datos("[a-zA-Z0-9$@.-]{4,100}",$clave_2)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las claves no coinciden con el formato solicitado
            </div>
            ';
        exit();
    }
      
    
  //Verificando email
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email= conexion();
            $check_email=$check_email->query("SELECT mail FROM usuarios WHERE mail='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        El email ya esta registrado
                    </div>
                    ';
                exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El email no existe
                </div>
                ';
        exit();
        }
    }
    
 // Verificar que las contraseñas son iguales
    if($clave_1 != $clave_2){
         echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las claves no coinciden 
            </div>
            ';
        exit();
    }else{
        $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
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
    
  //Guardando datos en BD
    $guardar_usuario=conexion();
    $guardar_usuario=$guardar_usuario->prepare("INSERT INTO "
            . "usuarios(name,lastname,mail,password,phone,role) "
            . "VALUES(:nombre,:apellido,:email,:clave,:telefono,:role)");
    
    $marcadores=[
        ":nombre"=>$nombre,
        ":apellido"=>$apellido,
        ":email"=>$email,
        ":clave"=>$clave,
        ":telefono"=>$telefono,
        ":role" => $role,
    ];
    
    $guardar_usuario->execute($marcadores);
    
    if($guardar_usuario->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡Usuario registrado!</strong><br>
                Usuario registrado con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el usuario, por favor intente de nuevo
            </div>
        ';
    }
    $guardar_usuario=null;