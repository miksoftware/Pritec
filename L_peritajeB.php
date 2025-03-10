<?php
session_start();
include 'layouts/header.php';
?>

<div id="content" class="container-fluid">
    <div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Listado de Peritajes</h3>
        <a href="C_peritajeB.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo
        </a>
    </div>
        <div class="card-body">
            <table id="tablaPeriajes" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre y Apellidos</th>
                        <th>Identificación</th>
                        <th>Placa</th>
                        <th>Teléfono</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tablaPeriajes').DataTable({
        "ajax": {
            "url": "peritaje_basico/List.php",
            "dataSrc": function(json) {
                console.log('Datos recibidos:', json);
                return json;
            }
        },
        "columns": [
            {"data": "nombre_apellidos"},
            {"data": "identificacion"},
            {"data": "placa"},
            {"data": "telefono"},
            {"data": "fecha"},
            {
                "data": "id",
                "render": function(data) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-primary" onclick="editarPeritaje(${data})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarPeritaje(${data})">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-success" onclick="imprimirPeritaje(${data})">
                                <i class="fas fa-print"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        }
    });
});

function editarPeritaje(id) {
    window.location.href = `E_peritajeB.php?id=${id}`;
}

function eliminarPeritaje(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'peritaje_basico/UpdateStatus.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            response.message,
                            'success'
                        ).then(() => {
                            $('#tablaPeriajes').DataTable().ajax.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al procesar la solicitud',
                        'error'
                    );
                }
            });
        }
    });
}

function imprimirPeritaje(id) {
    window.open(`P_peritajeB.php?id=${id}`, '_blank');
}
</script>

<?php include 'layouts/footer.php'; ?>