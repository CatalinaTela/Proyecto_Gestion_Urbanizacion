<?php 
    require_once "main.php";
    
    //Almacenando datos
    $nombre = limpiar_cadena($_POST['inmobiliaria_nombre']);
    $sitioweb = limpiar_cadena($_POST['website']);
    $email = limpiar_cadena($_POST['inmobiliaria_email']);
    $telefono = limpiar_cadena($_POST['inmobiliaria_telefono']);
    
    
    //Verificando campos obligatorios
    if($nombre=="" || $email=="" ){
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
    
    
    if(verificar_datos("\+?[1-9][0-9]{1,3}[0-9 ]{6,12}", $telefono)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El teléfono no coincide con el formato internacional solicitado
            </div>
            ';
        exit();
    }
   
       
    
  //Verificando email
    if($email!=""){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email= conexion();
            $check_email=$check_email->query("SELECT mail_agency FROM inmobiliarias WHERE mail_agency='$email'");
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
    
    // Verificando sitio web
    if($sitioweb != "") {
        if(filter_var($sitioweb, FILTER_VALIDATE_URL)) {
            // Comprobación si el sitio web ya está registrado
            $check_website = conexion();
            $check_website = $check_website->query("SELECT website FROM inmobiliarias WHERE website = '$sitioweb'");
            if($check_website->rowCount() > 0) {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        El sitio web ya está registrado
                    </div>
                ';
                exit();
            }
            $check_website = null;
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    El sitio web no es válido
                </div>
            ';
            exit();
        }
    }

    
    
  //Guardando datos en BD
    $guardar_inmobiliaria=conexion();
    $guardar_inmobiliaria=$guardar_inmobiliaria->prepare("INSERT INTO "
            . "inmobiliarias(name_agency,mail_agency,phone_agency,website) "
            . "VALUES(:nombre,:email,:telefono,:sitioweb)");
    
    $marcadores=[
        ":nombre"=>$nombre,
        ":email"=>$email,
        ":telefono"=>$telefono,
        ":sitioweb"=>$sitioweb,
    ];
    
    $guardar_inmobiliaria->execute($marcadores);
    
    if($guardar_inmobiliaria->rowCount()==1){
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
    $guardar_inmobiliaria=null;