<?php
// Componente: Motor
// Incluye: Sección del motor con todos los sistemas
?>

<section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
  <div class="d-flex flex-column gap-2 w-100 mb-3">
    <div class="yellow-background sub-title w-100">MOTOR</div>
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
      $tabla2 = getTabla2();
      foreach ($tabla2 as $campo => $etiqueta): ?>
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
    OBSERVACIONES: <br> <?php echo $peritaje["observaciones_motor"]; ?>
  </div>
</section>
<p class="text-center my-2" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
