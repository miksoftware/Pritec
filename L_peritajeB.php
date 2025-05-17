<?php
// filepath: c:\laragon\www\Pritec\l_peritajeB.php
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
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: 'var(--primary-color, #3f51b5)'
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

    <div class="card shadow mt-3 mb-4">
        <div class="card-header bg-black text-white d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h3 class="card-title mb-0 h5">
                <i class="fas fa-clipboard me-2"></i>Listado de Peritajes Básicos
            </h3>
            <a href="c_peritajeB.php" class="btn btn-light btn-sm">
                <i class="fas fa-plus me-1"></i> Nuevo Peritaje
            </a>
        </div>
        <div class="card-body">
            
            <!-- Tabla responsive -->
            <div class="table-responsive">
                <table id="tablaPeriajes" class="table table-sm table-striped table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Solicitante</th>
                            <th class="d-none d-md-table-cell">Identificación</th>
                            <th>Placa</th>
                            <th class="d-none d-md-table-cell">Teléfono</th>
                            <th class="d-none d-lg-table-cell">Marca</th>
                            <th class="d-none d-lg-table-cell">Modelo</th>
                            <th class="d-none d-md-table-cell">Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
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
    // Detectar si es dispositivo móvil
    const isMobile = window.innerWidth < 768;
    
    // Inicializar DataTable con configuración optimizada
    var table = $('#tablaPeriajes').DataTable({
        "ajax": {
            "url": "peritaje_basico/List.php",
            "type": "GET",
            "dataSrc": "",
            "error": function(xhr, error, thrown) {
                console.error('Error en la carga de datos:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al cargar datos',
                    text: 'No se pudieron cargar los peritajes. Por favor, intente nuevamente.'
                });
            }
        },
        "columns": [
            {"data": "id"},
            {"data": "nombre_apellidos"},
            {"data": "identificacion", "className": "d-none d-md-table-cell"},
            {"data": "placa"},
            {"data": "telefono", "className": "d-none d-md-table-cell"},
            {"data": "marca", "className": "d-none d-lg-table-cell"},
            {"data": "modelo", "className": "d-none d-lg-table-cell"},
            {"data": "fecha", "className": "d-none d-md-table-cell"},
            {
                "data": "id",
                "className": "text-center",
                "render": function(data, type, row) {
                    if (isMobile) {
                        // Vista compacta para móviles
                        return `
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="vistaPrevia(${data})" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="eliminarPeritaje(${data})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>`;
                    } else {
                        // Vista completa para desktop
                        return `
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="editarPeritaje(${data})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="vistaPrevia(${data})" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
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
    
    // Optimización de búsqueda (debounce)
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        const value = $(this).val();
        searchTimeout = setTimeout(function() {
            table.search(value).draw();
        }, 300); // Esperar 300ms para reducir el número de búsquedas
    });
    
    // Filtro personalizado
    $('#filterSelect').on('change', function() {
        const orderBy = $(this).val();
        $.ajax({
            url: 'peritaje_basico/List.php',
            type: 'GET',
            data: { order_by: orderBy, order_dir: 'DESC' },
            dataType: 'json',
            success: function(data) {
                table.clear().rows.add(data).draw();
            },
            error: function() {
                Swal.fire('Error', 'No se pudieron actualizar los datos', 'error');
            }
        });
    });
    
    // Adaptar a cambios de tamaño de pantalla
    $(window).resize(function() {
        const newIsMobile = window.innerWidth < 768;
        if (newIsMobile !== isMobile) {
            // Si cambia el tamaño de la pantalla, recargar la tabla
            table.ajax.reload();
        }
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
    $('#previewContent').html('<div class="d-flex justify-content-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
    
    // Configurar el botón de imprimir
    $('#printFromPreview').off('click').on('click', function() {
        imprimirPeritaje(id);
    });
    
    // Cargar datos del peritaje
    $.ajax({
        url: 'peritaje_basico/Getid.php',
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
                        <h5 class="card-title border-bottom pb-2 mb-3">Datos del Peritaje Básico #${data.id}</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card h-100 bg-light">
                                    <div class="card-header bg-primary bg-opacity-10">
                                        <strong><i class="fas fa-user me-2"></i>Información del Solicitante</strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2"><strong>Nombre:</strong> ${data.nombre_apellidos || 'No registrado'}</p>
                                        <p class="mb-2"><strong>Identificación:</strong> ${data.identificacion || 'No registrada'}</p>
                                        <p class="mb-0"><strong>Teléfono:</strong> ${data.telefono || 'No registrado'}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 bg-light">
                                    <div class="card-header bg-primary bg-opacity-10">
                                        <strong><i class="fas fa-car me-2"></i>Información del Vehículo</strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2"><strong>Placa:</strong> ${data.placa ? data.placa.toUpperCase() : 'No registrada'}</p>
                                        <p class="mb-2"><strong>Marca:</strong> ${data.marca || 'No especificada'}</p>
                                        <p class="mb-2"><strong>Modelo:</strong> ${data.modelo || 'No especificado'}</p>
                                        <p class="mb-0"><strong>Color:</strong> ${data.color || 'No especificado'}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="e_peritajeB.php?id=${data.id}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="imprimirPeritaje(${data.id})">
                                <i class="fas fa-print me-1"></i> Imprimir
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            $('#previewContent').html(html);
        },
        error: function() {
            $('#previewContent').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Error al cargar los datos del peritaje</div>');
        }
    });
}

function eliminarPeritaje(id) {
    Swal.fire({
        title: '¿Eliminar peritaje?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-1"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loader mientras se procesa la eliminación
            Swal.fire({
                title: 'Eliminando...',
                html: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
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
    // Mostrar indicador de carga antes de abrir la ventana
    const loadingToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    loadingToast.fire({
        icon: 'info',
        title: 'Generando documento para impresión...'
    });
    
    window.open(`p_peritajeB.php?id=${id}`, '_blank');
}
</script>

<?php include 'layouts/footer.php'; ?>