<?php
    require_once "./backend/php/main.php";

    $id = limpiar_cadena($_POST['id_property']);

    $check_propiedad = conexion();
    $check_propiedad = $check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id'");

    if ($check_propiedad->rowCount() == 1) {
        $datos = $check_propiedad->fetch();
        $images = json_decode($datos['picture'], true) ?: []; // Si no existen imágenes, inicializa un array vacío
    } else {
        echo '<div class="notification is-danger is-light">¡Error! La propiedad no existe.</div>';
        exit();
    }
    
 ?>
    
    