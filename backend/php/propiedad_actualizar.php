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

    /*== Almacenando los datos ==*/
    $titulo = limpiar_cadena($_POST['title']) ?: $datos['title'];  // Si el campo está vacío, se usa el valor actual
    $descripcion = limpiar_cadena($_POST['description']) ?: $datos['description'];
    $observacion = limpiar_cadena($_POST['observations']) ?: $datos['observations'];
    $ubicacion = limpiar_cadena($_POST['ubication']) ?: $datos['ubication'];
    $precio = limpiar_cadena($_POST['value']) ?: $datos['value'];
    $tipo = limpiar_cadena($_POST['id_type']) ?: $datos['id_type'];
    $operacion = limpiar_cadena($_POST['id_operation']) ?: $datos['id_operation'];

    /*== Actualizando datos ==*/
    $actualizar_propiedad = conexion();
    $actualizar_propiedad = $actualizar_propiedad->prepare("UPDATE propiedades SET title = :titulo, description = :descripcion, observations = :observacion, ubication = :ubicacion, value = :precio, id_type = :tipo, id_operation = :operacion WHERE id_property = :id");

    $marcadores = [
        ":titulo" => $titulo,
        ":descripcion" => $descripcion,
        ":observacion" => $observacion,
        ":ubicacion" => $ubicacion,
        ":precio" => $precio,
        ":tipo" => $tipo,
        ":operacion" => $operacion,
        ":id" => $id
    ];

    if($actualizar_propiedad->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PROPIEDAD ACTUALIZADA!</strong><br>
                La propiedad se actualizó con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar la propiedad, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_propiedad = null;
?>
