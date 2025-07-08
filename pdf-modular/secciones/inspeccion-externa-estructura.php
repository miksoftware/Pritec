<?php
/**
 * Inspección Visual Externa - Estructura
 * Contiene la inspección visual de la estructura del vehículo
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección inspección visual externa - estructura");
}

if (!isset($estructura)) {
    throw new Exception("Variable \$estructura no está disponible en la sección inspección visual externa - estructura");
}

if (!isset($tiposVehiculos)) {
    throw new Exception("Variable \$tiposVehiculos no está disponible en la sección inspección visual externa - estructura");
}

// Solo mostrar si no es motocicleta
if (str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")) {
    return;
}

// Incluir funciones helper
require_once __DIR__ . '/../helpers/funciones.php';
?>

<section class="inspeccion-visual">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">INSPECCIÓN VISUAL EXTERNA</div>
        <div class="inspeccion-detalle">
            <div class="fondo-amarillo sub-titulo w-100">
                VEHÍCULO: <?php echo htmlspecialchars($peritaje["tipo_vehiculo"] ?? ''); ?>
            </div>
            <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
            <div class="fondo-amarillo sub-titulo ms-4 mb-0">ESTRUCTURA</div>
            <div class="d-flex gap-2 w-100 altura-inspeccion">
                <img 
                    src="<?php echo htmlspecialchars($tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlEstructura ?? ''); ?>"
                    class="imagen-vehiculo"
                    alt="Estructura del vehículo">
                <div class="tabla-inspeccion">
                    <div class="fila-tabla-header">
                        <div class="header-descripcion">Descripción pieza</div>
                        <div class="header-concepto">Concepto</div>
                    </div>
                    <?php if (!empty($estructura)): ?>
                        <?php foreach ($estructura as $fila): ?>
                            <div class="fila-tabla-datos">
                                <div class="celda-descripcion">
                                    <?php 
                                    $descripcion = $fila["descripcion_pieza"] ?? '';
                                    // Mostrar número y descripción (ej: "1. PANEL FRONTAL SUPERIOR")
                                    echo htmlspecialchars(obtenerDescripcionConNumero($descripcion, $descripcionesPiezasEstructura));
                                    ?>
                                </div>
                                <div class="celda-concepto">
                                    <?php 
                                    $concepto = $fila["concepto"] ?? '';
                                    // Mostrar solo el concepto sin número
                                    echo htmlspecialchars(formatearConceptoSinNumero($concepto));
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="observaciones">
                OBSERVACIONES: <br/> 
                <?php echo htmlspecialchars($peritaje["observaciones_inspeccion"] ?? ''); ?>
            </div>
        </div>
    </div>
</section>
