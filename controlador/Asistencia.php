<?php
require_once "../modelos/Asistencia.php"; // Se incluye el archivo que contiene la clase Asistencia

$asistencia = new Asistencia(); // Se instancia un objeto de la clase Asistencia

$estudiante_id = isset($_POST["estudiante_id"]) ? limpiarCadena($_POST["estudiante_id"]) : ""; // Se obtiene el ID del estudiante de la solicitud

// Se ejecuta un switch para determinar la acción a realizar según el parámetro 'op' enviado por GET
switch ($_GET["op"]) {
    case 'listar': // Caso para listar todas las asistencias
        $rspta = $asistencia->listar(); // Se obtienen todas las asistencias
        $data = array(); // Se crea un array para almacenar los datos de las asistencias

        $item = 0; // Variable para contar los items en el listado
        while ($reg = $rspta->fetch_object()) { // Se recorre el resultado de la consulta
            $data[] = array( // Se agregan los datos de cada asistencia al array
                "0" => $item,
                "1" => $reg->codigo,
                "2" => $reg->estudiante,
                "3" => $reg->fecha,
                "4" => $reg->hora,
                "5" => ($reg->tipo == 'Entrada') ? '<span class="label bg-green">' . $reg->tipo . '</span>' : '<span class="label bg-orange">' . $reg->tipo . '</span>'
            );
            $item++; // Se incrementa el contador de items
        }

        // Se crea un array con la información necesaria para DataTables
        $results = array(
            "sEcho" => 1, // Información para DataTables
            "iTotalRecords" => count($data), // Total de registros para DataTables
            "iTotalDisplayRecords" => count($data), // Total de registros a mostrar en DataTables
            "aaData" => $data // Datos de las asistencias para DataTables
        );
        echo json_encode($results); // Se devuelve la información en formato JSON
        break;

    case 'listar_asistencia': // Caso para listar las asistencias dentro de un rango de fechas y para un estudiante específico
        $fecha_inicio = $_REQUEST["fecha_inicio"]; // Se obtiene la fecha de inicio del rango
        $fecha_fin = $_REQUEST["fecha_fin"]; // Se obtiene la fecha de fin del rango
        $estudiante_id = $_REQUEST["estudiante_id"]; // Se obtiene el ID del estudiante
        $rspta = $asistencia->listar_reporte($fecha_inicio, $fecha_fin, $estudiante_id); // Se obtienen las asistencias según el rango de fechas y el estudiante
        $data = array(); // Se crea un array para almacenar los datos de las asistencias

        $item = 0; // Variable para contar los items en el listado
        while ($reg = $rspta->fetch_object()) { // Se recorre el resultado de la consulta
            $data[] = array( // Se agregan los datos de cada asistencia al array
                "0" => $item,
                "1" => $reg->codigo,
                "2" => $reg->estudiante,
                "3" => $reg->fecha,
                "4" => $reg->hora,
                "5" => ($reg->tipo == 'Entrada') ? '<span class="label bg-green">' . $reg->tipo . '</span>' : '<span class="label bg-orange">' . $reg->tipo . '</span>'
            );
            $item++; // Se incrementa el contador de items
        }

        // Se crea un array con la información necesaria para DataTables
        $results = array(
            "sEcho" => 1, // Información para DataTables
            "iTotalRecords" => count($data), // Total de registros para DataTables
            "iTotalDisplayRecords" => count($data), // Total de registros a mostrar en DataTables
            "aaData" => $data // Datos de las asistencias para DataTables
        );
        echo json_encode($results); // Se devuelve la información en formato JSON
        break;
}
?>


