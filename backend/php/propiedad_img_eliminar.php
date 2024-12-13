<?php
require_once "main.php";

$id_property = limpiar_cadena($_POST['img_del_id']);
$images_to_delete = $_POST['images_to_delete'] ?? [];

// Verificar si la propiedad existe
$check_propiedad = conexion();
$check_propiedad = $check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id_property'");

if ($check_propiedad->rowCount() == 1) {
    $datos = $check_propiedad->fetch();
    $images = json_decode($datos['picture'], true) ?: [];
} else {
    header("Location: ../../index.php?vista=property_img&id_property_up=$id_property&status=error");
    exit();
}

// Ruta de imágenes
$img_dir = '../../assets/img/propiedad/';

foreach ($images_to_delete as $index) {
    if (isset($images[$index])) {
        $file_path = $img_dir . $images[$index];
        if (is_file($file_path)) {
            unlink($file_path); // Eliminar archivo físico
        }
        unset($images[$index]); // Eliminar del array
    }
}

// Actualizar imágenes en la base de datos
$images = array_values($images);
$update_query = conexion()->prepare("UPDATE propiedades SET picture=:images WHERE id_property=:id");
if ($update_query->execute([":images" => json_encode($images), ":id" => $id_property])) {
    header("Location: ../../index.php?vista=property_img&id_property_up=$id_property&status=success");
} else {
    header("Location: ../../index.php?vista=property_img&id_property_up=$id_property&status=error");
    
}

exit();
