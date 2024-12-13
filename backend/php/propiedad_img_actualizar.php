<?php
require_once "main.php";

$id_property = limpiar_cadena($_POST['img_up_id']);

// Obtener la propiedad existente
$check_propiedad = conexion();
$check_propiedad = $check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id_property'");

if ($check_propiedad->rowCount() == 1) {
    $datos = $check_propiedad->fetch();
    $images = json_decode($datos['picture'], true) ?: []; // Si no existen imágenes, inicializa un array vacío
} else {
    echo '<div class="notification is-danger is-light">¡Error! La propiedad no existe.</div>';
    exit();
}

// Directorio de imágenes
$img_dir = '../../assets/img/propiedad/';
if (!file_exists($img_dir)) mkdir($img_dir, 0777);

// Procesar imágenes nuevas
foreach ($_FILES['new_pictures']['tmp_name'] as $key => $tmp_name) {
    if ($_FILES['new_pictures']['size'][$key] <= 3072 * 1024 && // 3 MB
        in_array(mime_content_type($tmp_name), ["image/jpeg", "image/png"])) {

        $extension = mime_content_type($tmp_name) == "image/jpeg" ? ".jpg" : ".png"; // Asignar extensión
        $file_name = uniqid() . '_' . $_FILES['new_pictures']['name'][$key]; // Nombre único para la imagen
        $file_path = $img_dir . $file_name;

        // Subir imagen
        if (move_uploaded_file($tmp_name, $file_path)) {
            // Agregar nueva imagen al array
            $images[] = str_replace('../../', '', $file_path); // Guardar ruta relativa
        }
    }
}

// Actualizar las imágenes en la base de datos
$update_query = conexion()->prepare("UPDATE propiedades SET picture=:images WHERE id_property=:id");
if ($update_query->execute([":images" => json_encode($images), ":id" => $id_property])) {
    header("Location: ../../index.php?vista=property_img&id_property_up=$id_property&status=success");
    echo '<div class="notification is-info is-light">¡Imágenes actualizadas exitosamente!</div>';
} else {
    echo '<div class="notification is-warning is-light">Error al actualizar imágenes.</div>';
}
?>
