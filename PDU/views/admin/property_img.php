<div class="container is-fluid mb-6">
	<h1 class="title">Propiedades</h1>
	<h2 class="subtitle">Actualizar imagen de la propiedad</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./backend/inc/btn_back.php";

		require_once "./backend/php/main.php";

		$id = (isset($_GET['id_property_up'])) ? $_GET['id_property_up'] : 0;

		/*== Verificando producto ==*/
    	$check_propiedad=conexion();
    	$check_propiedad=$check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id'");

        if($check_propiedad->rowCount()>0){
        	$datos=$check_propiedad->fetch();
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<div class="columns">
		<div class="column is-two-fifths">
			<?php if(is_file("./assets/img/propiedad/".$datos['picture'])){ ?>
			<figure class="image mb-6">
			  	<img src="./assets/img/propiedad/<?php echo $datos['picture']; ?>">
			</figure>
			<form class="FormularioAjax" action="./backend/php/propiedad_img_eliminar.php" method="POST" autocomplete="off" >

				<input type="hidden" name="img_del_id" value="<?php echo $datos['id_property']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar imagen</button>
				</p>
			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img src="./assets/img/propiedad.png">
			</figure>
			<?php } ?>
		</div>
		<div class="column">
			<form class="mb-6 has-text-centered FormularioAjax" action="./backend/php/propiedad_img_actualizar.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<h4 class="title is-4 mb-6"><?php echo $datos['title']; ?></h4>
				
				<label>Foto o imagen del producto</label><br>

				<input type="hidden" name="img_up_id" value="<?php echo $datos['id_property']; ?>">

				<div class="file has-name is-horizontal is-justify-content-center mb-6">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="picture" accept=".jpg, .png, .jpeg" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar</button>
				</p>
			</form>
		</div>
	</div>
	<?php 
		}else{
			include "./backend/inc/error_alert.php";
		}
		$check_propiedad=null;
	?>
</div>
