<?php
// Conexión a la base de datos
require_once './backend/php/main.php';

//Obtener listado de inmobiliarias
$conexion=conexion();
$query_inmobiliarias = $conexion->prepare("SELECT id_agency, name_agency, mail_agency FROM inmobiliarias");
$query_inmobiliarias->execute();
$inmobiliarias = $query_inmobiliarias->fetchAll(PDO::FETCH_ASSOC);


// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Capturar y limpiar los datos del formulario
    $name = limpiar_cadena($_POST['name'] ?? '');
    $phone = limpiar_cadena($_POST['phone'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = limpiar_cadena($_POST['subject'] ?? '');
    $message = limpiar_cadena($_POST['message'] ?? '');

    // Validar datos
    $errors = [];
    if (empty($name)) $errors[] = "El nombre es obligatorio.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "El email no es válido.";
    if (empty($message)) $errors[] = "El mensaje es obligatorio.";

    if (empty($errors)) {
        // Guardar en la base de datos
        $conexion = conexion();
        $query = $conexion->prepare("
            INSERT INTO mensajes_contacto (name, phone, email, subject, message) 
            VALUES (:name, :phone, :email, :subject, :message)
        ");
        $query->bindParam(':name', $name);
        $query->bindParam(':phone', $phone);
        $query->bindParam(':email', $email);
        $query->bindParam(':subject', $subject);
        $query->bindParam(':message', $message);

        if ($query->execute()) {
            $success = "Mensaje enviado con éxito.";
        } else {
            $errors[] = "Ocurrió un error al enviar el mensaje. Inténtalo de nuevo.";
        }
    }
}
?>
