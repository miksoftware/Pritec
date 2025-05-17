<?php
// filepath: c:\laragon\www\Pritec\l_peritajeC.php
session_start();
include 'layouts/header.php';
?>

<div id="content" class="container-fluid">
    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if (isset($_SESSION['success'])): ?>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Operación exitosa!',
                        text: '<?php echo $_SESSION["success"]; ?>',
                        confirmButtonText: 'Aceptar'
                    });
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '<?php echo $_SESSION["error"]; ?>',
                        confirmButtonText: 'Aceptar'
                    });
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-black text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fas fa-clipboard-list me-2"></i>Listado de Peritajes Completos
            </h3>
            <a href="c_peritajeC.php" class="btn btn-light">
                <i class="fas fa-plus me-1"></i> Nuevo Peritaje
            </a>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table id="tablaPeriajes" class="table table-striped table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Solicitante</th>
                            <th>Identificación</th>
                            <th>Placa</th>
                            <th>Tipo Vehículo</th>
                            <th>Marca</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargan mediante AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para vista previa -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary bg-opacity-10">
                <h5 class="modal-title" id="previewModalLabel">Vista previa del peritaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Contenido cargado vía AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="printFromPreview">
                    <i class="fas fa-print me-1"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicializar DataTable con configuración mejorada
    var table = $('#tablaPeriajes').DataTable({
        "ajax": {
            "url": "peritaje_completo/List.php",
            "dataSrc": function(json) {
                if (json.error) {
                    Swal.fire('Error', json.error, 'error');
                    return [];
                }
                return json;
            },
            "data": function(d) {
                d.order_by = $('#filterSelect').val();
                d.order_dir = 'DESC';
            }
        },
        "columns": [
            {"data": "id"},
            {"data": "nombre_apellidos"},
            {"data": "identificacion"},
            {"data": "placa"},
            {"data": "tipo_vehiculo"},
            {"data": "marca"},
            {"data": "telefono"},
            {"data": "fecha"},
            {"data": "fecha_creacion"},
            {
                "data": "id",
                "render": function(data) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarPeritaje(${data})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="vistaPrevia(${data})" title="Vista previa">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="imprimirPeritaje(${data})" title="Imprimir">
                                <i class="fas fa-print"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarPeritaje(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        "order": [[0, 'desc']], 
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "pageLength": 10,
        "responsive": true,
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "drawCallback": function() {
            // Añadir clases para filas con hover
            $('tbody tr').hover(
                function() { $(this).addClass('table-hover'); },
                function() { $(this).removeClass('table-hover'); }
            );
        }
    });
    
    // Búsqueda personalizada
    $('#searchInput').on('keyup', function() {
        table.search($(this).val()).draw();
    });
    
    // Filtro personalizado
    $('#filterSelect').on('change', function() {
        table.ajax.reload();
    });
});

function editarPeritaje(id) {
    window.location.href = `e_peritajeC.php?id=${id}`;
}

function vistaPrevia(id) {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    
    // Mostrar el modal con spinner de carga
    modal.show();
    
    // Cargar contenido
    $('#previewContent').html('<div class="d-flex justify-content-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
    
    // Configurar el botón de imprimir
    $('#printFromPreview').off('click').on('click', function() {
        imprimirPeritaje(id);
    });
    
    // Cargar datos del peritaje
    $.ajax({
        url: 'peritaje_completo/Getid.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                $('#previewContent').html(`<div class="alert alert-danger">${data.error}</div>`);
                return;
            }
            
            // Construir vista previa mejorada
            let html = `
                <div class="card border-0 mb-3">
                    <div class="card-body px-0">
                        <h5 class="card-title border-bottom pb-2 mb-3">Datos del Peritaje Completo #${data.id}</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card h-100 bg-light">
                                    <div class="card-header bg-primary bg-opacity-10">
                                        <h6 class="card-title mb-0"><i class="fas fa-user me-2"></i>Información del Solicitante</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Nombre:</span>
                                                <span>${data.nombre_apellidos || 'No especificado'}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Identificación:</span>
                                                <span>${data.identificacion || 'No especificado'}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Teléfono:</span>
                                                <span>${data.telefono || 'No especificado'}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Dirección:</span>
                                                <span>${data.direccion || 'No especificado'}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Fecha:</span>
                                                <span>${data.fecha_formateada || 'No especificado'}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card h-100 bg-light">
                                    <div class="card-header bg-primary bg-opacity-10">
                                        <h6 class="card-title mb-0"><i class="fas fa-car me-2"></i>Información del Vehículo</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-2">
                                            <span class="badge bg-dark fs-6 px-3 py-2">${data.placa || 'S/P'}</span>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Tipo:</span>
                                                <span>${data.tipo_vehiculo || 'No especificado'}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Marca/Línea:</span>
                                                <span>${data.marca || ''} ${data.linea || ''}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Modelo:</span>
                                                <span>${data.modelo || 'No especificado'}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold">Color:</span>
                                                <span>${data.color || 'No especificado'}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3 p-3 bg-light border rounded">
                            <h6 class="border-bottom pb-2">Improntas y Estado</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between my-1">
                                        <span class="fw-bold">Estado Motor:</span>
                                        <span>${data.estado_motor ? data.estado_motor.replace(/_/g, ' ') : 'No especificado'}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between my-1">
                                        <span class="fw-bold">Estado Chasis:</span>
                                        <span>${data.estado_chasis ? data.estado_chasis.replace(/_/g, ' ') : 'No especificado'}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between my-1">
                                        <span class="fw-bold">Estado Serial:</span>
                                        <span>${data.estado_serial ? data.estado_serial.replace(/_/g, ' ') : 'No especificado'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Agregar conclusión si existe
            if (data.conclusiones) {
                html += `
                <div class="alert alert-info">
                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Conclusión:</h6>
                    <p class="small mb-0">${data.conclusiones}</p>
                </div>`;
            }
            
            // Imagen principal si existe
            if (data.foto_frontal) {
                html += `
                <div class="text-center">
                    <img src="uploads/${data.foto_frontal}" alt="Foto frontal" class="img-fluid img-thumbnail" style="max-height: 200px">
                </div>`;
            }
            
            html += `
                <div class="text-center mt-3">
                    <p class="text-muted small">Para ver el reporte completo, haga clic en "Imprimir"</p>
                </div>
            `;
            
            $('#previewContent').html(html);
        },
        error: function() {
            $('#previewContent').html('<div class="alert alert-danger">Error al cargar los datos del peritaje</div>');
        }
    });
}

function eliminarPeritaje(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'peritaje_completo/UpdateStatus.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            text: response.message,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            $('#tablaPeriajes').DataTable().ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'No se pudo eliminar el peritaje',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }
    });
}

function imprimirPeritaje(id) {
    window.open(`p_peritajeC.php?id=${id}`, '_blank');
}
</script>

<?php include 'layouts/footer.php'; ?>