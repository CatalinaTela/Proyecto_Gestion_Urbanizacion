<div class="container is-fluid mb-6">
	<h1 class="title">Inmobiliaria</h1>
	<h2 class="subtitle">Nueva inmobiliaria</h2>
</div>
<div class="container pb-6 pt-6">
        <div class="form-rest mb-6 mt-6"></div>
        <form action="./backend/php/inmobiliaria_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
            <div class="columns">
		<div class="column">
                    <div class="control">
                        <label>Nombre</label>
                        <input class="input" type="text" name="inmobiliaria_nombre"  maxlength="40" >
                    </div>
		</div>
		<div class="column">
		    <div class="control">
			<label>Sitio web</label>
			<input class="input" type="text" name="website" maxlength="40"  >
                    </div>
		</div>
            </div>
            <div class="columns">
		<div class="column">
		    <div class="control">
			<label>Email</label>
                            <input class="input" type="email" name="inmobiliaria_email"  maxlength="70" >
                    </div>
		</div>
		<div class="column">
		    <div class="control">
			<label>Teléfono</label>
                        <input class="input" type="telefono" name="inmobiliaria_telefono" maxlength="15" >
                    </div>
		</div>
            </div>
            
            <p class="has-text-centered">
		<button type="submit" class="button is-info is-rounded">Guardar</button>
            </p>
	</form>   
</div>

