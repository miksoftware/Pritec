<?php
/**
 * Sección: Niveles
 * Parte del sistema modular de peritaje completo
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje, $campos_nivel)) {
  return;
}
?>

<section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
  <div class="d-flex flex-column gap-2 w-100 mb-3">
    <div class="yellow-background sub-title w-100">NIVELES</div>
    <div class="d-flex flex-column gap-2 w-100 h-100">
      <div class="d-flex gap-2">
        <div class="yellow-background label" style="width: 50%;">SISTEMA</div>
        <div class="input text-center" style="width: 50%">
          ESTADO
        </div>
      </div>
      <?php foreach ($campos_nivel as $campo => $etiqueta): ?>
        <div class="d-flex gap-2">
          <div class="yellow-background label" style="width: 50%;">
            <?= $etiqueta ?>
          </div>
          <div class="input text-center" style="width: 50%">
            <?= $peritaje[$campo] ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="remarks" style="height: fit-content">
    PRUEBA DE RUTA: <br> <?php echo $peritaje["prueba_ruta"]; ?>
  </div>
</section>
