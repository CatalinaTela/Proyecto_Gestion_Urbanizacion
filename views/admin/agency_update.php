<?php
	require_once "./backend/php/main.php";

    $id = (isset($_GET['id_agency_up'])) ? $_GET['id_agency_up'] : 0;
    $id=limpiar_cadena($id);
?>
<div class="container is-fluid mb-6">
	<?php if($id==$_SESSION['id']){ ?>
		<h1 class="title">Inmobiliaria</h1>
		<h2 class="subtitle">Actualizar datos de la inmobiliaria</h2>
	<?php } ?>
</div>

<div class="container pb-6 pt-6">
	<?php

		include "./backend/inc/btn_back.php";

        /*== Verificando usuario ==*/
    	$check_inmobiliaria=conexion();
    	$check_inmobiliaria=$check_inmobiliaria->query("SELECT * FROM inmobiliarias WHERE id_agency='$id'");

        if($check_inmobiliaria->rowCount()>0){
        	$datos=$check_inmobiliaria->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./backend/php/inmobiliaria_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" name="id_agency" value="<?php echo $datos['id_agency']; ?>"  >
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombres</label>
				  	<input class="input" type="text" name="inmobiliaria_nombre"  maxlength="40" value="<?php echo $datos['name_agency']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Sitio Web</label>
				  	<input class="input" type="text" name="website"  maxlength="40"  value="<?php echo $datos['website']; ?>" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="inmobiliaria_email" maxlength="70" value="<?php echo $datos['mail_agency']; ?>" >
				</div>
		  	</div>
                        <div class="column">
		    	<div class="control">
					<label>Telefono</label>
				  	<input class="input" type="text" name="inmobiliaria_telefono"  maxlength="15"  value="<?php echo $datos['phone_agency']; ?>" >
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
		$check_inmobiliaria=null;
	?>
</div>