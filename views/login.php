<div class="main-container">

	<form class="box login" action="" method="POST" autocomplete="off">
		<h5 class="title is-5 has-text-centered is-uppercase">Sistema de inventario</h5>

		<div class="field">
			<label class="label">Email</label>
			<div class="control">
			    <input class="input" type="text" name="login_email"  maxlength="70"  >
			</div>
		</div>

		<div class="field">
		  	<label class="label">Clave</label>
		  	<div class="control">
		    	<input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{4,100}" maxlength="100"  >
		  	</div>
		</div>

		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-rounded">Iniciar sesion</button>
		</p>

		<?php
			if(isset($_POST['login_email']) && isset($_POST['login_clave'])){
				require_once "./backend/php/main.php";
				require_once "./backend/php/iniciar_sesion.php";
			}
		?>
	</form>


</div>
