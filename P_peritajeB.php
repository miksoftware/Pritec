<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
  header('Location: login.php');
  exit;
}

// Validar y obtener ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
  $_SESSION['error'] = "ID de peritaje no válido";
  header('Location: L_peritajeB.php');
  exit;
}

require_once dirname(__FILE__) . '/peritaje_basico/Getid.php';

// Obtener datos del peritaje
$peritaje = obtenerPeritajePorId($id);

if (!$peritaje) {
  $_SESSION['error'] = "Peritaje no encontrado";
  header('Location: L_peritajeB.php');
  exit;
}

include 'layouts/empty_header.php';
?>

<style>
  p {
    margin: 0;
  }
</style>

<main class="w-100">
  <h4 class="text-center">SALA TÉCNICA EN AUTOMOTORES</h4>
  <h6 class="text-center mb-3">CERIFICACIÓN TÉCNICA EN IDENTIFICACIÓN DE AUTOMOTORES</h6>
  <header class="d-flex gap-4 mb-4">
    <img src="img/pritec.png" style="width: 150px;object-fit: contain;" />
    <div class="me-4">
      <p>Dirección: Carrera 16 No. 18-197 Barrio Tenerife</p>
      <p>Teléfono: 3132049245-3158928492</p>
      <p>Web: peritos.pritec.co</p>
      <p>Peritos e inspecciones técnicas vehiculares Neiva-Huila</p>
    </div>
    <div>
      <p>Fecha: </p>
      <p>No. Servicio: </p>
      <p>Servicio para: </p>
      <p>Convenio: </p>
    </div>
  </header>
  <section class="d-flex">
    <div class="w-50">
      <div>DATOS DEL VEHÍCULO</div>
      <div>
        <div>
          <div>Clase</div>
          <div></div>
        </div>
        <div>
          <div>Marca</div>
          <div></div>
        </div>
        <div>
          <div>Línea</div>
          <div></div>
        </div>
        <div>
          <div>Cilindraje</div>
          <div></div>
        </div>
        <div>
          <div>Servicio</div>
          <div></div>
        </div>
        <div>
          <div>Modelo</div>
          <div></div>
        </div>
        <div>
          <div>Color</div>
          <div></div>
        </div>
        <div>
          <div>No. de chasis</div>
          <div></div>
        </div>
        <div>
          <div>No. de motor</div>
          <div></div>
        </div>
        <div>
          <div>No. de serie</div>
          <div></div>
        </div>
        <div>
          <div>Tipo de carrocería</div>
          <div></div>
        </div>
        <div>
          <div>Organismo de tránsito</div>
          <div></div>
        </div>
      </div>
      <div class="text-center">ESTADO/DOCUMENTOS</div>
    </div>
    <div class="w-50">
      <div class="text-center">PLA-CA</div>
      <div class="text-center">DATOS DEL SOLICITANTE</div>
      <div>
        <div>Nombres y apellidos</div>
        <div></div>
      </div>
      <div>
        <div>Identificación</div>
        <div></div>
      </div>
      <div>
        <div>Teléfono</div>
        <div></div>
      </div>
      <div>
        <div>Dirección</div>
        <div></div>
      </div>
      <div class="text-center">ESTADO/DOCUMENTOS</div>
      <div>
        <div>Información</div>
        <div>Si</div>
        <div>No</div>
      </div>
      <div>
        <div>Tiene prenda/Gravamen</div>
        <div></div>
        <div></div>
      </div>
      <div>
        <div>Tiene limitación</div>
        <div></div>
        <div></div>
      </div>
      <div>
        <div>Debe impuestos</div>
        <div></div>
        <div></div>
      </div>
      <div>
        <div>Tiene comparendos al tránsito</div>
        <div></div>
        <div></div>
      </div>
      <div>
        <div>Vehículo rematado</div>
        <div></div>
        <div></div>
      </div>
    </div>
  </section>
  <section>
    <div>
      <div>Información</div>
      <div>Vigente</div>
      <div>No vigente</div>
      <div>No aplica</div>
      <div>Fecha de vencimiento</div>
    </div>
    <div>
      <div>Revisión Tecnicomecánica</div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div>
      <div>SOAT</div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
    <div>
      OBSERVACIONES:
    </div>
    <p>
      La información de identificación del rodante se obtiene del contenido de la licencia de 
      tránsito, una vez se realice la validación con el RUNT.
    </p>
    <div></div>
  </section>
  <section>
      <div>CONCEPTOS E IMPRONTAS</div>
    <p>
      Este concepto técnico está basado en la inspección de los sistemas de identificación,
      de acuerdo a patrones efectuados por la casa fabricante correspondiente, el interesado
      debe confirmar la documentación que ampara la matricula y posibles medidas cautelares,
      los sistemas de identificación que posee en la actualidad se dictaminan:
    </p>
    <div>

    </div>
  </section>
</main>

<?php include 'layouts/empty_footer.php'; ?>
