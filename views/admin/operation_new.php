<div class="container is-fluid mb-6">
	<h1 class="title">Operaciones Inmobiliarias</h1>
	<h2 class="subtitle">Nueva operación</h2>
</div>

<div class="container pb-6 pt-6">

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./backend/php/operaciones_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre de la operación inmobiliaria</label>
				  	<input class="input" type="text" name="operacion_nombre" maxlength="50" >
				</div>
                        </div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>
