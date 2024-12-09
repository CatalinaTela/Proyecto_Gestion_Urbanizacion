<?php  
    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
    $cuadricula = ""; // Cambiar la variable $tabla por $cuadricula

    $campos = "propiedades.id_property, propiedades.title, propiedades.description, propiedades.observations, propiedades.ubication, propiedades.value, propiedades.picture, propiedades.id_operation, propiedades.id_type, operacion_inmobiliaria.id_operation, operacion_inmobiliaria.operation_name, tipo_propiedad.id_type, tipo_propiedad.type_name";
    
if (isset($busqueda) && $busqueda != "") {
    // Consulta para obtener los datos con la búsqueda
    $consulta_datos = "SELECT $campos 
                       FROM propiedades 
                       INNER JOIN operacion_inmobiliaria ON propiedades.id_operation = operacion_inmobiliaria.id_operation 
                       INNER JOIN tipo_propiedad ON propiedades.id_type = tipo_propiedad.id_type 
                       WHERE propiedades.title LIKE '%$busqueda%' 
                       OR propiedades.description LIKE '%$busqueda%' 
                       OR propiedades.observations LIKE '%$busqueda%' 
                       OR propiedades.ubication LIKE '%$busqueda%' 
                       OR propiedades.value LIKE '%$busqueda%' 
                       OR tipo_propiedad.type_name LIKE '%$busqueda%' 
                       OR operacion_inmobiliaria.operation_name LIKE '%$busqueda%' 
                       ORDER BY propiedades.title ASC 
                       LIMIT $inicio, $registros";

    // Consulta para contar el total de registros con la búsqueda
    $consulta_total = "SELECT COUNT(id_property) 
                       FROM propiedades 
                       INNER JOIN operacion_inmobiliaria ON propiedades.id_operation = operacion_inmobiliaria.id_operation 
                       INNER JOIN tipo_propiedad ON propiedades.id_type = tipo_propiedad.id_type 
                       WHERE propiedades.title LIKE '%$busqueda%' 
                       OR propiedades.description LIKE '%$busqueda%' 
                       OR propiedades.observations LIKE '%$busqueda%' 
                       OR propiedades.ubication LIKE '%$busqueda%' 
                       OR propiedades.value LIKE '%$busqueda%' 
                       OR tipo_propiedad.type_name LIKE '%$busqueda%' 
                       OR operacion_inmobiliaria.operation_name LIKE '%$busqueda%'";
} elseif ($id_operation > 0) {
    // Si se filtra por operación específica
    $consulta_datos = "SELECT $campos 
                       FROM propiedades 
                       INNER JOIN operacion_inmobiliaria ON propiedades.id_operation = operacion_inmobiliaria.id_operation 
                       INNER JOIN tipo_propiedad ON propiedades.id_type = tipo_propiedad.id_type 
                       WHERE propiedades.id_operation = '$id_operation' 
                       ORDER BY propiedades.title ASC 
                       LIMIT $inicio, $registros";

    // Consulta para contar el total de registros con la operación específica
    $consulta_total = "SELECT COUNT(id_property) 
                       FROM propiedades 
                       WHERE id_operation = '$id_operation'";
} else {
    // Si no hay filtro de búsqueda ni operación, mostrar todas las propiedades
    $consulta_datos = "SELECT $campos 
                       FROM propiedades 
                       INNER JOIN operacion_inmobiliaria ON propiedades.id_operation = operacion_inmobiliaria.id_operation 
                       INNER JOIN tipo_propiedad ON propiedades.id_type = tipo_propiedad.id_type 
                       ORDER BY propiedades.title ASC 
                       LIMIT $inicio, $registros";

    // Consulta para contar el total de todas las propiedades
    $consulta_total = "SELECT COUNT(id_property) 
                       FROM propiedades";
}


    $conexion = conexion();

    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll();

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();

    $Npaginas = ceil($total / $registros);

    // Define las variables $pag_inicio y $pag_final si hay registros y la página está en el rango válido
    if ($total >= 1 && $pagina <= $Npaginas) {
        $pag_inicio = $inicio + 1;
        $pag_final = $inicio + count($datos);
    }

    // Encabezado de la cuadrícula HTML
    $cuadricula = '<div class="columns is-multiline is-centered">'; // Inicia la cuadrícula con soporte para múltiples líneas y centrado

    // Recorrido de los datos y generación de celdas para la cuadrícula
    foreach ($datos as $rows) {
        $fotoPath = is_file("./assets/img/propiedad/" . $rows['picture']) 
                    ? './assets/img/propiedad/' . $rows['picture'] 
                    : './assets/img/propiedad.png';
    
        $cuadricula .= '
        <div class="column is-12-mobile is-6-tablet is-4-desktop is-3-widescreen"> <!-- Responsividad -->
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img src="' . $fotoPath . '" alt="Foto">
                    </figure>
                </div>
                <header class="card-header">
                    <p class="card-header-title">' . strtoupper($rows['title']) . '</p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <p><strong>Valor:</strong> USD ' . number_format($rows['value'], 2) . '</p>
                        <p><strong>Tipo:</strong> ' . $rows['type_name'] . '</p>
                        <p><strong>Operación:</strong> ' . $rows['operation_name'] . '</p>
                        <p><strong>Ubicación:</strong> ' . $rows['ubication'] . '</p>
                    </div>
                </div>
                <footer class="card-footer">
                    <a href="index.php?vista=publicacion&id_property_view=' . $rows['id_property'] . '" class="card-footer-item">Ver más</a>
                    <a href="#' . $rows['id_property'] . '" class="card-footer-item">Guardar</a>
                </footer>    
            </div>
        </div>';
    }
    
    $cuadricula .= '</div>'; // Cierre de las columnas
    

    // Mostrar mensaje si no hay registros
    if ($total < 1) {
        $cuadricula = '<p class="has-text-centered">No hay registros en el sistema</p>';
    } elseif ($total >= 1 && $pagina <= $Npaginas) {
        $cuadricula .= '<p class="has-text-right">Mostrando propiedades <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
    }

    // Cierre de la conexión y salida de la cuadrícula
    $conexion = null;
    echo $cuadricula;

    // Mostrar paginador si es necesario
    if ($total >= 1 && $pagina <= $Npaginas) {
        echo paginador_tablas($pagina, $Npaginas, $url, 7);
    }
?>
