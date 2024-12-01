<?php 
include_once(__DIR__ . '/../../backend/php/main.php');
include('././backend/object/propertiesManager.php');  // Incluir el archivo donde manejas las propiedades

// Suponiendo que $conexion es tu conexión a la base de datos
$properties = getProperties($conexion);  // Obtener todas las propiedades
$properties = sortPropertiesByValue($properties);  // Ordenar las propiedades por precio

?>
<div class="container is-fluid">
    <h1 class="title">Home</h1>
    <h2 class="subtitle">¡Bienvenido!
        <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>
    </h2>
</div>
<div class="columns is-multiline">
        <?php foreach ($properties as $property): ?>
            <?php echo $property->toHtml(); ?>
        <?php endforeach; ?>
</div>