<?php  
ob_start(); // Inicia el búfer de salida
require "./backend/inc/session_start.php"; 
?>
<!doctype html>
<html lang="es">
    <head>
        <?php include "./backend/inc/head.php";?>
    </head>
    <body>
        <?php
        // Establecer vista por defecto
        if(!isset($_GET['vista']) || $_GET['vista'] == ""){
            $_GET['vista'] = "login";
        }
        
        // Permitir rutas con símbolos seguros
        $vista = preg_replace('/[^a-zA-Z0-9_\/]/', '', $_GET['vista']); // Limpiar caracteres peligrosos
        
        // Verificar si la vista pertenece a las vistas especiales
        $vistas_especiales = ["login", "logout", "404"];
        if (in_array($vista, $vistas_especiales)) {
            $vista_ruta = "./views/{$vista}.php";
        } else {
            // Verificar si el usuario tiene una sesión activa
            if (!isset($_SESSION['id']) || $_SESSION['id'] == "") {
                if ($vista != "login") {
                    include "./views/logout.php";
                    exit();
                }
            }

            // Determinar carpeta según rol
            $carpeta_base = "public";
            $navegacion = "./backend/inc/navbar_public.php";
            if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                $carpeta_base = "admin";
                $navegacion = "./backend/inc/navbar.php";
            }
            
            // Construir la ruta completa de la vista
            $vista_ruta = "./views/{$carpeta_base}/{$vista}.php";
        }
        
        // Comprobar si el archivo existe
        if (is_file($vista_ruta)) {
            if (!in_array($vista, $vistas_especiales)) {
                include $navegacion; // Incluir barra de navegación si no es vista especial
            }
            include $vista_ruta;
            include "./backend/inc/script.php";
        } else {
            include "./views/404.php";
        }
        ?>
    </body>
</html>
<?php ob_end_flush(); // Finaliza y limpia el búfer de salida ?>
