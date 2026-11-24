<?php
require_once "../modelos/Estudiante.php"; // Se incluye el archivo que contiene la clase Estudiante

$estudiante = new Estudiante(); // Se instancia un objeto de la clase Estudiante

// Se obtienen los datos del formulario y se limpian para evitar inyección de código
$estudiante_id = isset($_POST["estudiante_id"]) ? limpiarCadena($_POST["estudiante_id"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$apellidos = isset($_POST["apellidos"]) ? limpiarCadena($_POST["apellidos"]) : "";
$documento_numero = isset($_POST["documento_numero"]) ? limpiarCadena($_POST["documento_numero"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";

// Se ejecuta un switch para determinar la acción a realizar según el parámetro 'op' enviado por GET
switch ($_GET["op"]) {
    case 'guardaryeditar': // Caso para guardar o editar un estudiante
        if (empty($estudiante_id)) { // Si el ID del estudiante está vacío, se inserta un nuevo estudiante
            $rspta = $estudiante->insertar($nombre, $apellidos, $documento_numero, $telefono, $codigo);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        } else { // Si el ID del estudiante no está vacío, se edita el estudiante existente
            $rspta = $estudiante->editar($estudiante_id, $nombre, $apellidos, $documento_numero, $telefono, $codigo);
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;

    case 'mostrar': // Caso para mostrar los datos de un estudiante específico
        $rspta = $estudiante->mostrar($estudiante_id);
        echo json_encode($rspta); // Se devuelve la información del estudiante en formato JSON
        break;

    case 'listar': // Caso para listar todos los estudiantes
        $rspta = $estudiante->listar();
        $data = array(); // Se crea un array para almacenar los datos de los estudiantes

        while ($reg = $rspta->fetch_object()) { // Se recorre el resultado de la consulta
            $data[] = array( // Se agregan los datos de cada estudiante al array
                "0" => '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->id . ')"><i class="fa fa-pencil"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->apellidos,
                "3" => $reg->documento_numero,
                "4" => $reg->telefono,
                "5" => $reg->codigo
            );
        }

        // Se crea un array con la información necesaria para DataTables
        $results = array(
            "sEcho" => 1, // Información para DataTables
            "iTotalRecords" => count($data), // Total de registros para DataTables
            "iTotalDisplayRecords" => count($data), // Total de registros a mostrar en DataTables
            "aaData" => $data // Datos de los estudiantes para DataTables
        );
        echo json_encode($results); // Se devuelve la información en formato JSON
        break;

    case 'select_estudiante': // Caso para generar un select con la lista de estudiantes
        $rspta = $estudiante->select();

        while ($reg = $rspta->fetch_object()) { // Se recorre el resultado de la consulta
            echo '<option value="' . $reg->id . '">' . $reg->nombre . ' ' . $reg->apellidos . '</option>'; // Se generan las opciones del select
        }
        break;
}
?>