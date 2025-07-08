<?php

/**
 * Sección de Prueba de Observación y Diagnóstico Scanner
 * Contiene información sobre el scanner automotriz
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección prueba scanner");
}
?>

<section class="inspeccion-visual">

    <div class="fondo-amarillo sub-titulo w-100 text-center" style="margin-bottom: var(--spacing-small);">
        PRUEBA DE OBSERVACIÓN Y DIAGNOSTICO SCANNER
    </div>

    <div style="padding: var(--spacing-small) var(--spacing-medium); font-size: var(--font-size-small); line-height: 1.4; text-align: justify; color: #000 !important;">
        El scanner automotriz es una herramienta que se utiliza para diagnosticar las fallas registradas en la computadora del vehículo. La computadora se encarga de regular las funciones del auto a través de distintos sensores que monitorean y registran todos los errores con un código.
    </div>

    <div class="observaciones">
        OBSERVACIONES: <br />
        <?php echo htmlspecialchars($peritaje["prueba_escaner"] ?? ''); ?>
    </div>


</section>