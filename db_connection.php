<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "desarrollo_urbanistico";  

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos!";
?>
