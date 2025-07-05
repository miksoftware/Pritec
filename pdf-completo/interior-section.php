<?php
// Componente: Interior del automotor
// Incluye: Sección del interior con todos los elementos
?>

<section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
  <div class="d-flex flex-column gap-2 w-100 mb-3">
    <div class="yellow-background sub-title w-100">INTERIOR DEL AUTOMOTOR</div>
    <div class="d-flex flex-column gap-2 w-100 h-100">
      <div class="d-flex gap-2">
        <div class="yellow-background label" style="width: 25%;">SISTEMA</div>
        <div class="input text-center" style="width: 25%">
          ESTADO
        </div>
        <div class="input text-center" style="width: 50%">
          RESPUESTA
        </div>
      </div>
      <?php 
      $tabla3 = getTabla3();
      foreach ($tabla3 as $campo => $etiqueta): ?>
        <?php if (strpos($campo, "estado_") !== false): ?>
          <div class="d-flex gap-2">
            <div class="yellow-background label" style="width: 25%;">
              <?= $etiqueta ?>
            </div>
            <div class="input text-center" style="width: 25%">
              <?= $peritaje[$campo] ?>
            </div>
            <div class="input text-center" style="width: 50%">
              <?= $peritaje[str_replace("estado_", "respuesta_", $campo)] ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="remarks" style="height: fit-content">
    OBSERVACIONES: <br> <?php echo $peritaje["observaciones_interior"]; ?>
  </div>
</section>
