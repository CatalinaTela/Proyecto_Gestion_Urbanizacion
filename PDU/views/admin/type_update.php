
<div class="container is-fluid mb-6">
	<h1 class="title">Tipos de Propiedades</h1>
	<h2 class="subtitle">Actualizar categorías</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./backend/inc/btn_back.php";

		require_once "./backend/php/main.php";

		$id = (isset($_GET['id_type_up'])) ? $_GET['id_type_up'] : 0;
		$id=limpiar_cadena($id);

		/*== Verificando categoria ==*/
    	$check_type=conexion();
    	$check_type=$check_type->query("SELECT * FROM tipo_propiedad WHERE id_type='$id'");

        if($check_type->rowCount()>0){
        	$datos=$check_type->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./backend/php/tipos_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="id_type" value="<?php echo $datos['id_type']; ?>"  >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="type_name" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50"  value="<?php echo $datos['type_name']; ?>" >
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
		}else{
			include "./backend/inc/error_alert.php";
		}
		$check_type=null;
	?>
</div>
