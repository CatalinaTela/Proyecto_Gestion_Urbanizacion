<div class="container is-fluid mb-6">
    <h1 class="title">Inmobiliarias</h1>
    <h2 class="subtitle">Lista de inmobiliarias</h2>
</div>

<div class="container pb-6 pt-6">  
    <?php
        require_once "././backend/php/main.php";

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=inmobiliarias&page=";
        $registros=15;
        $busqueda="";

        # Paginador usuario #
        require_once "./backend/object/Agency.php";
    ?>
</div>