<?php
/**
 * Pie de página del PDF
 * Contiene el texto del pie de página y numeración
 */

// Definir número de página si no está definido
if (!isset($numeroPagina)) {
    $numeroPagina = 1;
}
?>

<div class="pie-pagina">
    <div class="contenido-pie">
        <p class="texto-pie">
            LA MEJOR FORMA DE COMPRAR UN CARRO USADO
        </p>
        <p class="numero-pagina">
            Página <?php echo $numeroPagina; ?>
        </p>
    </div>
</div>
