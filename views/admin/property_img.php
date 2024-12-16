<div class="container is-fluid mb-6">
    <h1 class="title">Propiedades</h1>
    <h2 class="subtitle">Actualizar imágenes de la propiedad</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./backend/inc/btn_back.php";

        require_once "./backend/php/main.php";

        $id = (isset($_GET['id_property_up'])) ? $_GET['id_property_up'] : 0;

        $check_propiedad = conexion();
        $check_propiedad = $check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id'");

        if ($check_propiedad->rowCount() > 0) {
            $datos = $check_propiedad->fetch();
            $images = json_decode($datos['picture'], true) ?: [];
        }
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <h4 class="title is-4 mb-6"><?php echo $datos['title']; ?></h4>

    <form class="mb-6 has-text-centered" action="./backend/php/propiedad_img_actualizar.php" method="POST" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="img_up_id" value="<?php echo $datos['id_property']; ?>">

        <label>Cargar nuevas imágenes</label><br>
        <div class="file has-name is-horizontal is-justify-content-center mb-6">
            <label class="file-label">
                <input class="file-input" type="file" name="new_pictures[]" accept=".jpg, .png, .jpeg" multiple>
                <span class="file-cta">
                    <span class="file-label">Seleccionar imágenes</span>
                </span>
                <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
            </label>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Agregar imágenes</button>
        </p>
    </form>

    <h4 class="title is-4 mb-6">Imágenes actuales</h4>
        <form action="./backend/php/propiedad_img_eliminar.php" method="POST">
            <input type="hidden" name="img_del_id" value="<?php echo $datos['id_property']; ?>">
            <div class="columns is-multiline">
                <?php foreach ($images as $index => $img) { ?>
                    <div class="column is-one-quarter">
                        <figure class="image is-4by3">
                            <img src="<?php echo $img; ?>" alt="Imagen propiedad">
                        </figure>
                        <input type="checkbox" name="images_to_delete[]" value="<?php echo $index; ?>"> Eliminar
                    </div>
                <?php } ?>
            </div>
            <p class="has-text-centered">
                <button type="submit" class="button is-danger is-rounded">Eliminar seleccionadas</button>
            </p>
        </form>

       
</div>
