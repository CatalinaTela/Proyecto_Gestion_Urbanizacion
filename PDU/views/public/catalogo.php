<div class="container is-fluid mb-6">
    <h1 class="title">Catálogo</h1>
    <h2 class="subtitle">Lista de propiedades</h2>
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

        $id_operation = (isset($_GET['id_operation'])) ? $_GET['id_operation'] : 0;
        $id_type = (isset($_GET['id_type'])) ? $_GET['id_type'] : 0;

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=catalogo&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador producto #
        require_once "././backend/object/Property.php";
    ?>
</div>

