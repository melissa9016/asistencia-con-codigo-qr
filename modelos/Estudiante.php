<?php
// Incluir la conexión a la base de datos
require "../config/conexion.php";

class Estudiante
{
    // Constructor de la clase Estudiante
    public function __construct()
    {
    }

    // Método para insertar un nuevo registro de estudiante
    public function insertar($nombre, $apellidos, $documento_numero, $telefono, $codigo)
    {
        $sql = "INSERT INTO estudiantes (nombre, apellidos, documento_numero, telefono, codigo) VALUES ('$nombre', '$apellidos', '$documento_numero', '$telefono', '$codigo')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de estudiante existente
    public function editar($estudiante_id, $nombre, $apellidos, $documento_numero, $telefono, $codigo)
    {
        $sql = "UPDATE estudiantes SET nombre='$nombre', apellidos='$apellidos', documento_numero='$documento_numero', telefono='$telefono', codigo='$codigo' WHERE id='$estudiante_id'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar los detalles de un estudiante específico
    public function mostrar($estudiante_id)
    {
        $sql = "SELECT * FROM estudiantes WHERE id='$estudiante_id'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de estudiantes
    public function listar()
    {
        $sql = "SELECT * FROM estudiantes";
        return ejecutarConsulta($sql);
    }

    // Método para listar y mostrar en un select los registros de estudiantes
    public function select()
    {
        $sql = "SELECT * FROM estudiantes";
        return ejecutarConsulta($sql);
    }
}

