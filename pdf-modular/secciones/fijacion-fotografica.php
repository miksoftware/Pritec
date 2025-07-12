<?php
/**
 * Sección de Fijación Fotográfica
 * Muestra las imágenes del vehículo y prueba de ruta
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección fijación fotográfica");
}
?>

<section class="seccion-fijacion-fotografica">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">FIJACIÓN FOTOGRÁFICA</div>
        
        <div class="contenido-fotografico">
            <p class="descripcion-fotografica">
                Observación y clasificación de las características del automotor de acuerdo al punto 1
            </p>
            
            <!-- Grid de imágenes -->
            <div class="grid-fotografias">
                <?php
                // Generar las 6 imágenes de fijación fotográfica
                for ($i = 1; $i <= 6; $i++) {
                    $campo_imagen = "fijacion_fotografica_" . $i;
                    $url_imagen = $peritaje[$campo_imagen] ?? '';
                    
                    if (!empty($url_imagen)) {
                        echo '<div class="contenedor-imagen">';
                        echo '<img src="uploads/' . htmlspecialchars($url_imagen) . '" alt="Fijación fotográfica ' . $i . '" class="imagen-fijacion">';
                        echo '</div>';
                    } else {
                        echo '<div class="contenedor-imagen contenedor-vacio">';
                        echo '<div class="placeholder-imagen">Sin imagen</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    
    <!-- Prueba de ruta -->
    <div class="prueba-ruta">
        <strong>PRUEBA DE RUTA:</strong><br>
        <?php echo htmlspecialchars($peritaje["prueba_ruta"] ?? ''); ?>
    </div>
</section>