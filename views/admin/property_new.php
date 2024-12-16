<div class="container is-fluid mb-6">
	<h1 class="title">Propiedades</h1>
	<h2 class="subtitle">Nueva propiedad</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		require_once "./backend/php/main.php";
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./backend/php/propiedad_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Título</label>
				  	<input class="input" type="text" name="title" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70"  >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
                                        <label>Ubicación</label>
				  	<input class="input" type="text" name="ubication" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,700}" maxlength="70"  >
				</div>
		  	</div>
		</div>
                <div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Descripción</label>
                                        <input class="input" type="text" name="description" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,200}" maxlength="200"  >
				</div>
		  	</div>
		</div>
            
                <div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Observaciones</label>
				  	<input class="input" type="text" name="observations" pattern="[a-zA-Z0-9- ]{1,200}" maxlength="200"  >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Precio</label>
				  	<input class="input" type="text" name="value" pattern="[0-9.]{1,25}" maxlength="25"  >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
				<label>Categoría</label><br>
		    	<div class="select is-rounded">
				  	<select name="id_type" >
				    	<option value="" selected="" >Seleccione una opción</option>
				    	<?php
    						$tipo=conexion();
    						$tipo=$tipo->query("SELECT * FROM tipo_propiedad");
    						if($tipo->rowCount()>0){
    							$tipo=$tipo->fetchAll();
    							foreach($tipo as $row){
    								echo '<option value="'.$row['id_type'].'" >'.$row['type_name'].'</option>';
				    			}
				   			}
				   			$tipo=null;
				    	?>
				  	</select>
				</div>
		  	</div>
            <div class="column">
				<label>Operación</label><br>
		    	<div class="select is-rounded">
				  	<select name="id_operation" >
				    	<option value="" selected="" >Seleccione una opción</option>
				    	<?php
    						$operacion=conexion();
    						$operacion=$operacion->query("SELECT * FROM operacion_inmobiliaria");
    						if($operacion->rowCount()>0){
    							$operacion=$operacion->fetchAll();
    							foreach($operacion as $row){
    								echo '<option value="'.$row['id_operation'].'" >'.$row['operation_name'].'</option>';
				    			}
				   			}
				   			$operacion=null;
				    	?>
				  	</select>
				</div>
		  	</div>
		</div>
		<div class="columns">
			<div class="column">
				<label>Fotos o imágenes del producto</label><br>
				<div class="file is-small has-name">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="pictures[]" accept=".jpg, .png, .jpeg" multiple>
				    	<span class="file-cta">
				      		<span class="file-label">Seleccionar imágenes</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
			</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>