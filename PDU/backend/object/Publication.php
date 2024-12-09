<?php
    require_once "main.php";

    $id = limpiar_cadena($_POST['id_property']);

    $check_propiedad = conexion();
    $check_propiedad = $check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id'");

    if($check_propiedad->rowCount() <= 0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La propiedad no existe en el sistema
            </div>
        ';
        exit();
    } else {
        $datos = $check_propiedad->fetch();
        
    }
    $check_propiedad = null;

  
?>
