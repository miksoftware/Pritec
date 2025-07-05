<?php
// Componente: Batería
// Incluye: Sección de actuación de la batería
?>

<div class="page">
  <section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
    <div class="d-flex gap-2">
      <div class="yellow-background sub-title-vertical">ACTUACIÓN DE LA BATERIA</div>
      <div class="d-flex flex-column w-100">
        <div class="d-flex gap-2 w-100">
          <div class="d-flex flex-column gap-3" style="width: 30%">
            <div class="yellow-background label text-center w-100">BATERÍA</div>
            <img src="img/BATERIA.png" style="object-fit: contain">
          </div>
          <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
            <div class="d-flex gap-2">
              <div class="yellow-background label text-center">Ítem</div>
              <div class="yellow-background label text-center">Concepto</div>
              <div class="yellow-background label text-center">Porcentaje</div>
            </div>
            <div class="d-flex gap-2">
              <div class="input text-center">Carga de batería</div>
              <div class="input text-center">
                <?php echo getStateByPercent($peritaje["carga_bateria"]); ?>
              </div>
              <div class="input text-center">
                <?php echo $peritaje["carga_bateria"]; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
    <div class="d-flex flex-column gap-2">
      <div class="yellow-background sub-title w-100">PRUEBA DE OBSERVACIÓN Y DIAGNÓSTICO SCANNER</div>
      <div class="d-flex flex-column w-100">
        <p>El scanner automotriz es una herramienta que se utiliza para diagnosticar las fallas registradas
          en la computadora del vehículo. La computadora se encarga de regular las funciones del auto
          a través de distintos sensores que monitorean y registran todos los errores con un código:</p>
        <?php echo $peritaje["prueba_escaner"]; ?>
      </div>
    </div>
  </section>
</div>
