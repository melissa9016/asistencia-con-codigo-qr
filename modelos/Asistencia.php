<?php
//incluir la conexion de base de datos
require "../config/conexion.php";
class Asistencia
{

    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //listar registros
    public function listar()
    {
        $sql = "SELECT a.*, CONCAT(e.nombre,' ',e.apellidos) AS estudiante ,e.codigo FROM asistencias a INNER JOIN estudiantes e ON a.estudiante_id=e.id ORDER BY a.id DESC";
        return ejecutarConsulta($sql);
    }

    public function listar_reporte($fecha_inicio, $fecha_fin, $estudiante_id)
    {
        $sql = "SELECT a.*, CONCAT(e.nombre,' ',e.apellidos) AS estudiante, e.codigo FROM asistencias a INNER JOIN estudiantes e ON a.estudiante_id=e.id WHERE DATE(a.fecha)>='$fecha_inicio' AND DATE(a.fecha)<='$fecha_fin' AND a.estudiante_id='$estudiante_id'";
        return ejecutarConsulta($sql);
    }
} 
