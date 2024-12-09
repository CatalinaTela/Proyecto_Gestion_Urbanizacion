<?php
    require_once "../inc/session_start.php";
    require_once "main.php";

    /*== Almacenando id ==*/
    $id = limpiar_cadena($_POST['id_agency']);

    /*== Verificando usuario ==*/
    $check_inmobiliaria = conexion();
    $check_inmobiliaria = $check_inmobiliaria->query("SELECT * FROM inmobiliarias WHERE id_agency='$id'");

    if ($check_inmobiliaria->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La inmobiliaria no existe en el sistema
            </div>
        ';
        exit();
    } else {
        $datos = $check_inmobiliaria->fetch();
    }
    $check_inmobiliaria = null;

    /*== Almacenando datos del usuario ==*/
    $nombre = limpiar_cadena($_POST['inmobiliaria_nombre']);
    $sitioweb = limpiar_cadena($_POST['website']);
    $email = limpiar_cadena($_POST['inmobiliaria_email']);
    $telefono = limpiar_cadena($_POST['inmobiliaria_telefono']);

    /*== Verificando campos obligatorios ==*/
    if ($nombre == "" || $email == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos (nombre y teléfono) ==*/
    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("\+?[1-9][0-9]{1,3}[0-9 ]{6,12}", $telefono)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El teléfono no coincide con el formato internacional solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando email ==*/
    if ($email != "" && $email != $datos['mail_agency']) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check_email = conexion();
            $check_email = $check_email->query("SELECT mail_agency FROM inmobiliarias WHERE mail_agency='$email'");
            if ($check_email->rowCount() > 0) {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        El correo electrónico ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email = null;
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no válido
                </div>
            ';
            exit();
        }
    }

    /*== Verificando sitio web ==*/
    if ($sitioweb != "" && $sitioweb != $datos['website']) {
        if (filter_var($sitioweb, FILTER_VALIDATE_URL)) {
            $check_website = conexion();
            $check_website = $check_website->query("SELECT website FROM inmobiliarias WHERE website = '$sitioweb'");
            if ($check_website->rowCount() > 0) {
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

    /*== Guardar solo campos modificados ==*/
    $nombre_final = ($nombre != "") ? $nombre : $datos['name_agency'];
    $sitioweb_final = ($sitioweb != "") ? $sitioweb : $datos['website'];
    $email_final = ($email != "") ? $email : $datos['mail_agency'];
    $telefono_final = ($telefono != "") ? $telefono : $datos['phone_agency'];

    /*== Actualizar datos ==*/
    $actualizar_inmobiliaria = conexion();
    $actualizar_inmobiliaria = $actualizar_inmobiliaria->prepare("UPDATE inmobiliarias SET name_agency=:nombre, website=:website, phone_agency=:telefono, mail_agency=:email WHERE id_agency=:id");

    $marcadores = [
        ":nombre" => $nombre_final,
        ":website" => $sitioweb_final,
        ":telefono" => $telefono_final,
        ":email" => $email_final,
        ":id" => $id
    ];

    if ($actualizar_inmobiliaria->execute($marcadores)) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡INMOBILIARIA ACTUALIZADA!</strong><br>
                La inmobiliaria se actualizó con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar la inmobiliaria, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_inmobiliaria = null;
?>
