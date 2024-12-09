
<div class="container is-fluid mb-6">
	<h1 class="title">Operaciones inmobiliarias</h1>
	<h2 class="subtitle">Actualizar operación</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./backend/inc/btn_back.php";

		require_once "./backend/php/main.php";

		$id = (isset($_GET['id_operation_up'])) ? $_GET['id_operation_up'] : 0;
		$id=limpiar_cadena($id);

		/*== Verificando categoria ==*/
    	$check_operation=conexion();
    	$check_operation=$check_operation->query("SELECT * FROM operacion_inmobiliaria WHERE id_operation='$id'");

        if($check_operation->rowCount()>0){
        	$datos=$check_operation->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./backend/php/operaciones_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="id_operation" value="<?php echo $datos['id_operation']; ?>"  >

		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="operation_name" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50"  value="<?php echo $datos['operation_name']; ?>" >
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
		$check_operation=null;
	?>
</div>
