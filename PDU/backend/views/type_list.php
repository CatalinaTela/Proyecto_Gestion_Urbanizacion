<div class="container is-fluid mb-6">
    <h1 class="title">Tipos de propiedades</h1>
    <h2 class="subtitle">Lista de categorías</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./backend/php/main.php";

       # Eliminar categoria #
        if(isset($_GET['id_type_del'])){
            require_once "./backend/php/tipos_eliminar.php";
        } 

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=type_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador categoria #
        require_once "./backend/php/tipos_lista.php";
    ?>
</div>