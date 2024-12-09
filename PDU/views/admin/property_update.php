<?php
    include "./backend/inc/btn_back.php";
    require_once "./backend/php/main.php";

    $id = (isset($_GET['id_property_up'])) ? $_GET['id_property_up'] : 0;
    $id = limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
    <h1 class="title">Propiedades</h1>
    <h2 class="subtitle">Actualizar propiedad</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    /*== Verificando producto ==*/
    $check_propiedad = conexion();
    $check_propiedad = $check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id'");

    if($check_propiedad->rowCount() > 0){
        $datos = $check_propiedad->fetch();
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <h2 class="title has-text-centered"><?php echo $datos['title']; ?></h2>

    <form action="./backend/php/propiedad_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

        <input type="hidden" name="id_property" value="<?php echo $datos['id_property']; ?>"  >

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Título</label>
                    <input class="input" type="text" name="title" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" value="<?php echo $datos['title']; ?>" >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Ubicación</label>
                    <input class="input" type="text" name="ubication" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,700}" maxlength="70" value="<?php echo $datos['ubication']; ?>" >
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Descripción</label>
                    <input class="input" type="text" name="description" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,200}" maxlength="200" value="<?php echo $datos['description']; ?>" >
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Observaciones</label>
                    <input class="input" type="text" name="observations" pattern="[a-zA-Z0-9- ]{1,200}" maxlength="200" value="<?php echo $datos['observations']; ?>" >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Precio</label>
                    <input class="input" type="text" name="value" pattern="[0-9.]{1,25}" maxlength="25" value="<?php echo $datos['value']; ?>" >
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <label>Tipo</label><br>
                <div class="select is-rounded">
                    <select name="id_type">
                        <?php
                        $tipo = conexion();
                        $tipo = $tipo->query("SELECT * FROM tipo_propiedad");
                        if($tipo->rowCount() > 0){
                            $tipo = $tipo->fetchAll();
                            foreach($tipo as $row){
                                echo '<option value="'.$row['id_type'].'" '.($datos['id_type'] == $row['id_type'] ? 'selected' : '').'>'.$row['type_name'].' '.($datos['id_type'] == $row['id_type'] ? '(Actual)' : '').'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="column">
                <label>Operación</label><br>
                <div class="select is-rounded">
                    <select name="id_operation">
                        <?php
                        $operacion = conexion();
                        $operacion = $operacion->query("SELECT * FROM operacion_inmobiliaria");
                        if($operacion->rowCount() > 0){
                            $operacion = $operacion->fetchAll();
                            foreach($operacion as $row){
                                echo '<option value="'.$row['id_operation'].'" '.($datos['id_operation'] == $row['id_operation'] ? 'selected' : '').'>'.$row['operation_name'].' '.($datos['id_operation'] == $row['id_operation'] ? '(Actual)' : '').'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>
    <?php
    } else {
        include "./backend/inc/error_alert.php";
    }
    $check_propiedad = null;
    ?>
</div>
