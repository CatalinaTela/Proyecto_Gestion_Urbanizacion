<?php  
    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
    $tabla = "";

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

    // Encabezado de la tabla HTML
    $tabla = '
    <table class="table is-fullwidth is-striped">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Título</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Operación</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>';

    // Recorrido de los datos y generación de filas de la tabla
    $contador = $inicio + 1;
    foreach ($datos as $rows) {
        $tabla .= '<tr>';
        

        // Foto de la propiedad
        $pictures = json_decode($rows['picture'], true);
        $fotoPath = is_file($pictures[0]) 
                    ? $pictures[0] 
                    : './assets/img/logo.jpg';
        $tabla .= '<td><img src="' . $fotoPath . '" alt="Foto" width="64" height="64"></td>';

        // Datos de la propiedad
        $tabla .= '<td>' . $rows['title'] . '</td>';
        $tabla .= '<td>USD' . number_format($rows['value'], 2) . '</td>';
        $tabla .= '<td>' . $rows['type_name'] . '</td>';
        $tabla .= '<td>' . $rows['operation_name'] . '</td>';
        $tabla .= '<td>' . $rows['ubication'] . '</td>';

        // Botones de acciones
        $tabla .= '
            <td>
                <a href="index.php?vista=property_img&id_property_up=' . $rows['id_property'] . '" class="button is-link is-rounded is-small">Imagen</a>
                <a href="index.php?vista=property_update&id_property_up=' . $rows['id_property'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                <a href="' . $url . $pagina . '&id_property_del=' . $rows['id_property'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
            </td>
        ';
        $tabla .= '</tr>';

        $contador++;
    }

    $tabla .= '</tbody></table>'; // Cierre de la tabla

    // Mostrar mensaje si no hay registros
    if ($total < 1) {
        $tabla = '<p class="has-text-centered">No hay registros en el sistema</p>';
    } elseif ($total >= 1 && $pagina <= $Npaginas) {
        $tabla .= '<p class="has-text-right">Mostrando propiedades <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
    }

    // Cierre de la conexión y salida de la tabla
    $conexion = null;
    echo $tabla;

    // Mostrar paginador si es necesario
    if ($total >= 1 && $pagina <= $Npaginas) {
        echo paginador_tablas($pagina, $Npaginas, $url, 7);
    }
?>
