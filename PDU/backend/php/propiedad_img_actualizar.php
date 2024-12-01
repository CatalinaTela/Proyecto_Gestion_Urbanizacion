<?php
    require_once "main.php";

	/*== Almacenando datos ==*/
    $id_property=limpiar_cadena($_POST['img_up_id']);

    /*== Verificando producto ==*/
    $check_propiedad=conexion();
    $check_propiedad=$check_propiedad->query("SELECT * FROM propiedades WHERE id_property='$id_property'");

    if($check_propiedad->rowCount()==1){
        $datos=$check_propiedad->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen de la PROPIEDAD que intenta actualizar no existe
            </div>
        ';
        exit();
    }
    $check_propiedad=null;


    /*== Comprobando si se ha seleccionado una imagen ==*/
    if($_FILES['picture']['name']=="" || $_FILES['picture']['size']==0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No ha seleccionado ninguna imagen o foto
            </div>
        ';
        exit();
    }


    /* Directorios de imagenes */
    $img_dir='../../assets/img/propiedad/';


    /* Creando directorio de imagenes */
    if(!file_exists($img_dir)){
        if(!mkdir($img_dir,0777)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Error al crear el directorio de imagenes
                </div>
            ';
            exit();
        }
    }


    /* Cambiando permisos al directorio */
    chmod($img_dir, 0777);


    /* Comprobando formato de las imagenes */
    if(mime_content_type($_FILES['picture']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['picture']['tmp_name'])!="image/png"){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado es de un formato que no está permitido
            </div>
        ';
        exit();
    }


    /* Comprobando que la imagen no supere el peso permitido */
    if(($_FILES['picture']['size']/1024)>3072){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La imagen que ha seleccionado supera el límite de peso permitido
            </div>
        ';
        exit();
    }


    /* extencion de las imagenes */
    switch(mime_content_type($_FILES['picture']['tmp_name'])){
        case 'image/jpeg':
          $img_ext=".jpg";
        break;
        case 'image/png':
          $img_ext=".png";
        break;
    }

    /* Nombre de la imagen */
    $img_nombre=renombrar_fotos($datos['picture']);

    /* Nombre final de la imagen */
    $foto=$img_nombre.$img_ext;

    /* Moviendo imagen al directorio */
    if(!move_uploaded_file($_FILES['picture']['tmp_name'], $img_dir.$foto)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
            </div>
        ';
        exit();
    }


    /* Eliminando la imagen anterior */
    if(is_file($img_dir.$datos['picture']) && $datos['picture']!=$foto){

        chmod($img_dir.$datos['picture'], 0777);
        unlink($img_dir.$datos['picture']);
    }


    /*== Actualizando datos ==*/
    $actualizar_propiedad=conexion();
    $actualizar_propiedad=$actualizar_propiedad->prepare("UPDATE propiedades SET picture=:foto WHERE id_property=:id");

    $marcadores=[
        ":foto"=>$foto,
        ":id"=>$id_property
    ];

    if($actualizar_propiedad->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN O FOTO ACTUALIZADA!</strong><br>
                La imagen de la propiedad ha sido actualizada exitosamente, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=property_img&id_property_up='.$id_property.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }else{

        if(is_file($img_dir.$foto)){
            chmod($img_dir.$foto, 0777);
            unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-warning is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_propiedad=null;
