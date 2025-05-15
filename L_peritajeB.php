<?php
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
                <i class="fas fa-clipboard me-2"></i>Listado de Peritajes Básicos
            </h3>
            <a href="c_peritajeB.php" class="btn btn-light">
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
                            <th>Teléfono</th>
                            <th>Marca</th>
                            <th>Modelo</th>
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
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="previewModalLabel">Vista Previa del Peritaje</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Contenido cargado dinámicamente -->
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
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
            "url": "peritaje_basico/List.php",
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
            {"data": "telefono"},
            {"data": "marca"},
            {"data": "modelo"},
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
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="imprimirPeritaje(${data})" title="Imprimir">
                                <i class="fas fa-print"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarPeritaje(${data})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        "order": [[0, 'desc']], // Ordenar por fecha de creación (columna oculta)
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
    window.location.href = `e_peritajeB.php?id=${id}`;
}

function vistaPrevia(id) {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    
    // Mostrar el modal con spinner de carga
    modal.show();
    
    // Cargar contenido
    $('#previewContent').html('<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
    
    // Configurar el botón de imprimir
    $('#printFromPreview').off('click').on('click', function() {
        imprimirPeritaje(id);
    });
    
    // Cargar datos del peritaje
    $.ajax({
        url: 'peritaje_basico/Get.php',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                $('#previewContent').html(`<div class="alert alert-danger">${data.error}</div>`);
                return;
            }
            
            // Construir vista previa
            let html = `
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Datos del Peritaje Básico #${data.id}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Solicitante:</strong> ${data.nombre_apellidos}</p>
                                <p><strong>Identificación:</strong> ${data.identificacion}</p>
                                <p><strong>Teléfono:</strong> ${data.telefono || 'No registrado'}</p>
                                <p><strong>Fecha:</strong> ${data.fecha}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Placa:</strong> ${data.placa}</p>
                                <p><strong>Marca:</strong> ${data.marca || 'No registrada'}</p>
                                <p><strong>Modelo:</strong> ${data.modelo || 'No registrado'}</p>
                                <p><strong>Color:</strong> ${data.color || 'No registrado'}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-muted">Para ver el reporte completo, haz clic en "Imprimir"</p>
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
                url: 'peritaje_basico/UpdateStatus.php',
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
    window.open(`p_peritajeB.php?id=${id}`, '_blank');
}
</script>

<?php include 'layouts/footer.php'; ?>