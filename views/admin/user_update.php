<?php
	require_once "./backend/php/main.php";

    $id = (isset($_GET['id_user_up'])) ? $_GET['id_user_up'] : 0;
    $id=limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
	<?php if($id==$_SESSION['id']){ ?>
		<h1 class="title">Mi cuenta</h1>
		<h2 class="subtitle">Actualizar datos de cuenta</h2>
	<?php }else{ ?>
		<h1 class="title">Usuarios</h1>
		<h2 class="subtitle">Actualizar usuario</h2>
	<?php } ?>
</div>

<div class="container pb-6 pt-6">
	<?php

		include "./backend/inc/btn_back.php";

        /*== Verificando usuario ==*/
    	$check_usuario=conexion();
    	$check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE id_user='$id'");

        if($check_usuario->rowCount()>0){
        	$datos=$check_usuario->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./backend/php/usuario_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="id_user" value="<?php echo $datos['id_user']; ?>"  >
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombres</label>
				  	<input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40"  value="<?php echo $datos['name']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellidos</label>
				  	<input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40"  value="<?php echo $datos['lastname']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $datos['mail']; ?>" >
				</div>
		  	</div>
                        <div class="column">
		    	<div class="control">
					<label>Telefono</label>
				  	<input class="input" type="text" name="usuario_telefono" pattern="\+?[1-9][0-9]{1,3}[0-9 ]{6,12}" maxlength="15"  value="<?php echo $datos['phone']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
			<div class="column">
                <label>Rol</label><br>
                <div class="select is-rounded">
					<select name="usuario_role">
						<?php
						// Definir los roles posibles
						$roles_disponibles = ['user', 'admin'];
						
						// Obtener el rol actual del usuario
						$rol_actual = isset($datos['role']) ? $datos['role'] : 'user'; // Valor predeterminado 'user'

						// Crear opciones del menú desplegable
						foreach ($roles_disponibles as $rol) {
							echo '<option value="'.$rol.'" '.($rol_actual == $rol ? 'selected' : '').'>'.$rol.'</option>';
						}
						?>
					</select>
                </div>
            </div>
        </div>
		<br><br>
		<p class="has-text-centered">
			SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
		</p>
		<br>
		<div class="columns">
			<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{4,100}" maxlength="100" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir clave</label>
				  	<input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{4,100}" maxlength="100" >
				</div>
		  	</div>
		</div>
		<br><br><br>
		<p class="has-text-centered">
			Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="text" name="administrador_email"  maxlength="70"  >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{4,100}" maxlength="100"  >
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
		$check_usuario=null;
	?>
</div>