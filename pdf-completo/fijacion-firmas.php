<?php
/**
 * Sección: Fijación Fotográfica y Firmas
 * Parte del sistema modular de peritaje completo
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje)) {
  return;
}
?>

<section>
  <div class="d-flex gap-2">
    <div class="yellow-background sub-title-vertical">FIJACIÓN FOTOGRÁFICA</div>
    <div class="d-flex flex-column w-100">
      <p>Observación y clasificación de las características del automotor de acuerdo al punto 1</p>
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); gap: 8px;">
        <?php for ($i = 0; $i < 6; $i++) {
          $name = "fijacion_fotografica_" . ($i + 1);
          $url = $peritaje[$name];
          if ($url) {
            echo '<div style="border: 1px solid var(--main-color);border-radius: 8px;padding: 5px">
                    <img src="uploads/' . $url . '" style="object-fit: contain; width: 100%">
                  </div>';
          }
        } ?>
      </div>
    </div>
  </div>
</section>

<div class="d-flex justify-content-between my-2" style="gap: 40px">
  <div>
    <p class="mb-3">Firma Inspector estructura vehicular:</p>
    <p>______________________________________</p>
    <p>CC:</p>
  </div>
  <div>
    <p class="mb-3">Firma cliente:</p>
    <p>______________________________________</p>
    <p>CC:</p>
  </div>
</div>
<div class="d-flex justify-content-center my-2" style="gap: 40px">
  <div>
    <p class="mb-3">Firma Inspector estructura vehicular:</p>
    <p>______________________________________</p>
    <p>CC:</p>
  </div>
</div>

<small style="font-size: 10px; font-weight: bold; margin-top: 1rem">
  AVISO LEGAL: Pritec Informa que la revisión realizada corresponde al estado del vehículo en la fecha y hora
  de la misma y con el recorrido del
  kilometraje que revela el odómetro en el momento, se advierte que, debido a la vulnerabilidad a que se ven
  expuestos este tipo de bienes, en
  cuanto a la afectación, modificación, avería, deterioro y desgaste de cualquiera de sus componentes, el
  informe que se pone de presente no
  garantiza de ningún modo que el estado del vehiculo sea el mismo en fechas posteriores a la fecha de la
  revisión.
</small>
