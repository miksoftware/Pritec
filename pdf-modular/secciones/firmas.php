<?php
/**
 * Sección de Firmas
 * Muestra las firmas del inspector, cliente y mecánico automotriz
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección firmas");
}
?>

<section class="seccion-firmas">
    <!-- Firmas principales -->
    <div class="contenedor-firmas">
        <div class="firma-izquierda">
            <p class="titulo-firma">Firma Inspector estructura vehicular:</p>
            <div class="linea-firma"></div>
            <p class="campo-cc">CC:</p>
        </div>
        
        <div class="firma-derecha">
            <p class="titulo-firma">Firma Cliente:</p>
            <div class="linea-firma"></div>
            <p class="campo-cc">CC:</p>
        </div>
    </div>
    
    <!-- Firma del mecánico (centrada) -->
    <div class="contenedor-firma-mecanico">
        <div class="firma-mecanico">
            <p class="titulo-firma">Firma Mecánico Automotriz</p>
            <div class="linea-firma"></div>
            <p class="campo-cc">CC:</p>
        </div>
    </div>
    
    <!-- Aviso legal -->
    <div class="aviso-legal">
        <p><strong>AVISO LEGAL:</strong> Pritec Informa que la revisión realizada corresponde al estado del vehículo en la fecha y hora de la misma y con el recorrido del kilometraje que revela el odómetro en el momento, se advierte que, debido a la vulnerabilidad a que se ven expuestos este tipo de bienes, en cuanto a la afectación, modificación, avería, deterioro y desgaste de cualquiera de sus componentes, el informe que se pone de presente no garantiza de ningún modo que el estado del vehículo sea el mismo en fechas posteriores a la fecha de la revisión.</p>
    </div>
</section>