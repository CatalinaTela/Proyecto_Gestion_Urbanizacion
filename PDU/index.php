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
        
        if(!isset($_GET['vista']) || $_GET['vista']==""){
            $_GET['vista']="login";
        }
        
         // Sanitizar el nombre de la vista para evitar rutas maliciosas
         $vista = preg_replace('/[^a-zA-Z0-9_\/]/', '', $_GET['vista']); // Permite letras, números y guiones bajos

         // Construir la ruta completa de la vista
     //    $vista_ruta = "./views/admin/" . $vista . ".php";
           $vista_ruta = "./views/public/" . $vista . ".php";

        // Comprobar si el archivo existe
      /*  if (is_file($vista_ruta) && $vista != "login" && $vista != "404") {
            // Verificar si el usuario tiene una sesión activa
            if (!isset($_SESSION['id']) || $_SESSION['id'] == "") {
                include "./views/shared/logout.php";
                exit();
            }*/
            include "./backend/inc/navbar_public.php";
            include "./views/public/".$_GET['vista'].".php";
         //   include "./backend/inc/navbar.php";
         //   include "./views/admin/".$_GET['vista'].".php";
            include "./backend/inc/script.php";
      /*  }else{
            if($_GET['vista']=="login"){
                include "./views/shared/login.php";
            }else{
                include "./views/shared/404.php";
            }
        }  */
         ?>
    </body>
</html>

<?php ob_end_flush(); // Finaliza y limpia el búfer de salida ?>