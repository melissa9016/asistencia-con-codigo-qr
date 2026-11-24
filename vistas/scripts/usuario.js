var tabla;

// Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
}

function limpiar() {
    $("#nombre").val("");
    $("#apellidos").val("");
    $("#email").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val("");
    $("#idusuario").val("");
}

// Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

// Cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}

// Función listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, // Activamos el procedimiento del datatable
        "aServerSide": true, // Paginación y filtrado realizados por el server
        dom: 'Bfrtip', // Definimos los elementos del control de la tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../controlador/Usuario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, // Paginación
        "order": [[0, "desc"]] // Ordenar (columna, orden)
    }).DataTable();
}

// Función para guardaryeditar
function guardaryeditar(e) {
    e.preventDefault(); // No se activará la acción predeterminada
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/Usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idusuario) {
    $.post("../controlador/Usuario.php?op=mostrar", { idusuario: idusuario },
        function (data, status) {
            data = JSON.parse(data);
            mostrarform(true);
            $("#nombre").val(data.nombre);
            $("#apellidos").val(data.apellidos);
            $("#email").val(data.email);
            $("#login").val(data.login);
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen);
            $("#imagenactual").val(data.imagen);
            $("#idusuario").val(data.idusuario);
        });
}

// Función para desactivar
function desactivar(idusuario) {
    bootbox.confirm("¿Está seguro de desactivar este dato?", function (result) {
        if (result) {
            $.post("../controlador/Usuario.php?op=desactivar", { idusuario: idusuario }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

function activar(idusuario) {
    bootbox.confirm("¿Está seguro de activar este dato?", function (result) {
        if (result) {
            $.post("../controlador/Usuario.php?op=activar", { idusuario: idusuario }, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

$(document).ready(function () {
    init();
});