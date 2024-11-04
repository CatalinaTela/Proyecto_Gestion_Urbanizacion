<?php require "./backend/inc/session_start.php"; ?>
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
            
        if(is_file("./backend/views/".$_GET['vista'].".php") && $_GET['vista']
        !="login" && $_GET['vista']!="404"){
            
            /*== Cerrar sesion ==*/
            if((!isset($_SESSION['id']) || $_SESSION['id']=="")) {
                include "./backend/views/logout.php";
                exit();
            }
        
            include "./backend/inc/navbar.php";
            include "./backend/views/".$_GET['vista'].".php";
            include "./backend/inc/script.php";
        }else{
            if($_GET['vista']=="login"){
                include "./backend/views/login.php";
            }else{
                include "./backend/views/404.php";
            }
        }
         ?>
    </body>
</html>

