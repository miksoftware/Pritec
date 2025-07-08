<?php
/**
 * Inspección Visual Interna - Estructura (para motocicletas)
 * Contiene la inspección visual interna específica para motocicletas
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección inspección visual interna");
}

if (!isset($estructura)) {
    throw new Exception("Variable \$estructura no está disponible en la sección inspección visual interna");
}

if (!isset($tiposVehiculos)) {
    throw new Exception("Variable \$tiposVehiculos no está disponible en la sección inspección visual interna");
}

// Solo mostrar si es motocicleta
if (!str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")) {
    return;
}

// Incluir funciones helper
require_once __DIR__ . '/../helpers/funciones.php';
?>

<section class="inspeccion-visual">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">INSPECCIÓN VISUAL INTERNA</div>
        <div class="inspeccion-detalle">
            <div class="fondo-amarillo sub-titulo w-100">
                VEHÍCULO: <?php echo htmlspecialchars($peritaje["tipo_vehiculo"] ?? ''); ?>
            </div>
            <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
            <div>
                <div class="fondo-amarillo sub-titulo ms-4 mb-0">ESTRUCTURA</div>
                <div class="d-flex gap-2 w-100">
                    <img 
                        src="<?php echo htmlspecialchars($tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlEstructura ?? ''); ?>"
                        class="imagen-vehiculo" 
                        style="max-height: 200px"
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
                                        $descripcion = htmlspecialchars($fila["descripcion_pieza"] ?? '');
                                        echo $descripcion;
                                        ?>
                                    </div>
                                    <div class="celda-concepto">
                                        <?php 
                                        $concepto = htmlspecialchars($fila["concepto"] ?? '');
                                        echo formatearConceptoConNumero($concepto, $conceptosEstructura);
                                        ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="observaciones" style="height: fit-content">
                OBSERVACIONES: <br/> 
                <?php echo htmlspecialchars($peritaje["observaciones_estructura"] ?? ''); ?>
            </div>
        </div>
    </div>
</section>
