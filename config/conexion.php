```php
<?php
// Incluye el archivo global.php que contiene las constantes de configuración de la base de datos
require_once "global.php";

// Si algo falla, que lance excepción (así podemos capturarla)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $conexion->set_charset(DB_ENCODE);
} catch (mysqli_sql_exception $e) {
    exit("Ups, no se pudo conectar con la base de datos.");
}

date_default_timezone_set(ZONA_HORARIA);

function ejecutarConsulta($sql) {
    global $conexion;
    return $conexion->query($sql);
}

function ejecutarConsultaSimpleFila($sql) {
    global $conexion;
    $query = $conexion->query($sql);
    return $query->fetch_assoc();
}

function ejecutarConsulta_retornarID($sql) {
    global $conexion;
    $conexion->query($sql);
    return $conexion->insert_id;
}

// NUEVA: consulta preparada (la forma segura)
function ejecutarConsultaPreparada($sql, $tipos, $parametros) {
    global $conexion;
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param($tipos, ...$parametros);
    $stmt->execute();
    $resultado = $stmt->get_result();   // solo existe en consultas SELECT
    return $resultado !== false ? $resultado : true;
}

