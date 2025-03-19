<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require_once dirname(__FILE__) . '/../Enums/SeguroEnum.php';
require_once dirname(__FILE__) . '/../Enums/ImprontaEnum.php';

// Crear objeto peritaje vacío con todos los campos necesarios
$peritaje = [
    'fecha' => date('Y-m-d'),
    'no_servicio' => '',
    'servicio_para' => '',
    'convenio' => '',
    'placa' => '',
    'clase' => '',
    'marca' => '',
    'linea' => '',
    'cilindraje' => '',
    'servicio' => '',
    'modelo' => '',
    'color' => '',
    'no_chasis' => '',
    'no_motor' => '',
    'no_serie' => '',
    'tipo_carroceria' => '',
    'organismo_transito' => '',
    'nombre_apellidos' => '',
    'identificacion' => '',
    'telefono' => '',
    'direccion' => '',
    'tiene_prenda' => false,
    'tiene_limitacion' => false,
    'debe_impuestos' => false,
    'tiene_comparendos' => false,
    'vehiculo_rematado' => false,
    'revision_tecnicomecanica' => '',
    'rtm_fecha_vencimiento' => '',
    'soat' => '',
    'soat_fecha_vencimiento' => '',
    'observaciones' => '',
    'licencia_frente' => '',
    'licencia_atras' => '',
    'estado_motor' => '',
    'estado_chasis' => '',
    'estado_serial' => '',
    'observaciones_finales' => ''
];

include '../layouts/empty_header.php';
?>

<style>
    * {
        box-sizing: border-box;
    }

    html {
        font-size: 12px;
    }

    :root {
        --main-color: #fff280;
        --gray-color: #d8d8d8;
    }

    @media print {
        body {
            background: url('../img/background.png') repeat-y center center;
            background-size: contain;
        }
    }

    p {
        margin: 0;
    }

    .plate {
        background-color: var(--gray-color);
        border: 1px solid var(--main-color);
        text-align: center;
        width: fit-content;
        padding: 2px 1.5rem;
        border-radius: 4px;
        margin: auto;
        letter-spacing: 3px;
        font-weight: bold;
        font-size: 1.5rem;
        -webkit-text-stroke: .8px var(--main-color);
    }

    .yellow-background {
        background: var(--main-color);
        border-radius: 8px;
        text-wrap: nowrap;
        font-size: 1.2rem;
    }

    .sub-title {
        text-align: center;
        margin: 1rem auto;
        width: fit-content;
        padding: .2rem 1.5rem;
    }

    .label {
        width: 50%;
        padding: .2rem .5rem;
    }

    .input {
        width: 50%;
        padding: .2rem .5rem;
        border: 1px var(--main-color) solid;
        border-radius: 8px;
        text-wrap: nowrap;
        min-height: 28px;
    }

    .remarks {
        border: 1px solid var(--main-color);
        padding: .5rem 1rem;
        border-radius: 8px;
        height: 80px;
        font-size: .8rem
    }

    .parent {
        display: grid;
        grid-template-columns: .5fr 1fr .3fr 3fr;
        grid-template-rows: repeat(12, 1fr);
        gap: 8px;
    }

    .div1 {
        grid-column: span 3 / span 3;
    }

    .div2 {
        grid-column-start: 4;
    }

    .div3 {
        grid-row: span 3 / span 3;
        grid-row-start: 2;
    }

    .div4 {
        grid-row-start: 2;
    }

    .div5 {
        grid-row-start: 2;
    }

    .div6 {
        grid-row: span 3 / span 3;
        grid-row-start: 2;
    }

    .div7 {
        grid-column-start: 2;
        grid-row-start: 3;
    }

    .div8 {
        grid-column-start: 3;
        grid-row-start: 3;
    }

    .div9 {
        grid-column-start: 2;
        grid-row-start: 4;
    }

    .div10 {
        grid-column-start: 3;
        grid-row-start: 4;
    }

    .div11 {
        grid-column: span 3 / span 3;
        grid-row-start: 5;
    }

    .div12 {
        grid-column-start: 4;
        grid-row-start: 5;
    }

    .div17 {
        grid-row: span 3 / span 3;
        grid-row-start: 6;
    }

    .div18 {
        grid-row-start: 6;
    }

    .div19 {
        grid-row-start: 6;
    }

    .div20 {
        grid-row: span 3 / span 3;
        grid-row-start: 6;
    }

    .div21 {
        grid-column-start: 2;
        grid-row-start: 7;
    }

    .div22 {
        grid-column-start: 3;
        grid-row-start: 7;
    }

    .div23 {
        grid-column-start: 2;
        grid-row-start: 8;
    }

    .div24 {
        grid-column-start: 3;
        grid-row-start: 8;
    }

    .div25 {
        grid-column: span 3 / span 3;
        grid-row-start: 9;
    }

    .div26 {
        grid-column-start: 4;
        grid-row-start: 9;
    }

    .div27 {
        grid-row: span 3 / span 3;
        grid-row-start: 10;
    }

    .div28 {
        grid-row-start: 10;
    }

    .div29 {
        grid-row-start: 10;
    }

    .div30 {
        grid-row: span 3 / span 3;
        grid-row-start: 10;
    }

    .div31 {
        grid-column-start: 2;
        grid-row-start: 11;
    }

    .div32 {
        grid-column-start: 3;
        grid-row-start: 11;
    }

    .div33 {
        grid-column-start: 2;
        grid-row-start: 12;
    }

    .div34 {
        grid-column-start: 3;
        grid-row-start: 12;
    }

    .div1,
    .div2,
    .div3,
    .div4,
    .div5,
    .div6,
    .div7,
    .div8,
    .div9,
    .div10,
    .div11,
    .div12,
    .div13,
    .div14,
    .div15,
    .div16,
    .div17,
    .div18,
    .div19,
    .div20,
    .div21,
    .div22,
    .div23,
    .div24,
    .div25,
    .div26,
    .div27,
    .div28,
    .div29,
    .div30,
    .div31,
    .div32,
    .div33,
    .div34 {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: .5rem 1rem;
    }
</style>

<main class="w-100 m-4">
    <h4 class="text-center">SALA TÉCNICA EN AUTOMOTORES</h4>
    <h6 class="text-center mb-3">CERTIFICACIÓN TÉCNICA EN IDENTIFICACIÓN DE AUTOMOTORES</h6>
    <header class="d-flex gap-4 mb-4 align-items-center">
        <img src="../img/pritec.png" style="width: 150px;object-fit: contain;" />
        <div class="me-5">
            <p>Dirección: Carrera 16 No. 18-197 Barrio Tenerife</p>
            <p>Teléfono: 3132049245-3158928492</p>
            <p>Web: peritos.pritec.co</p>
            <p>Peritos e inspecciones técnicas vehiculares Neiva-Huila</p>
        </div>
        <div>
            <p>Fecha: __________________</p>
            <p>No. Servicio: __________________</p>
            <p>Servicio para: __________________</p>
            <p>Convenio: __________________</p>
        </div>
    </header>
    <section class="d-flex gap-5">
        <div class="w-50 ms-4">
            <div class="yellow-background sub-title">DATOS DEL VEHÍCULO</div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Clase</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Marca</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Línea</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Cilindraje</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Servicio</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Modelo</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Color</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de chasis</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de motor</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de serie</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Tipo de carrocería</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Organismo de tránsito</div>
                    <div class="input"></div>
                </div>
            </div>
            <div class="yellow-background sub-title">ESTADO/DOCUMENTOS</div>
        </div>
        <div class="w-50 me-4">
            <div class="plate">_______</div>
            <div class="yellow-background sub-title">DATOS DEL SOLICITANTE</div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Nombres y apellidos</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Identificación</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Teléfono</div>
                    <div class="input"></div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Dirección</div>
                    <div class="input"></div>
                </div>
                <div class="yellow-background sub-title mt-2 mb-1">ESTADO/DOCUMENTOS</div>
                <div class="d-flex justify-content-between">
                    <div class="yellow-background label">Información</div>
                    <div class="input" style="width: fit-content; padding: .2rem 1rem; background: var(--main-color)">
                        Si
                    </div>
                    <div class="input" style="width: fit-content; padding: .2rem 1rem; background: var(--main-color)">
                        No
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="input">Tiene prenda/Gravamen</div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="input">Tiene limitación</div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="input">Debe impuestos</div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="input">Tiene comparendos al tránsito</div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="input">Vehículo rematado</div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                    <div class="input" style="width: fit-content; padding: .2rem 1.2rem;"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="mx-4 d-flex flex-column gap-2">
        <div class="d-flex gap-2 text-center">
            <div class="input" style="width: 20%;">Información</div>
            <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                <div class="input" style="width: 20%;"><?php echo $label; ?></div>
            <?php endforeach; ?>
            <div class="input" style="width: 20%;">Fecha de vencimiento</div>
        </div>
        <div class="d-flex gap-2 text-center">
            <div class="input" style="width: 20%;">Revisión Tecnicomecánica</div>
            <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                <div class="input" style="width: 20%;"></div>
            <?php endforeach; ?>
            <div class="input" style="width: 20%;"></div>
        </div>
        <div class="d-flex gap-2 text-center">
            <div class="input" style="width: 20%;">SOAT</div>
            <?php foreach (SeguroEnum::getOptions() as $value => $label): ?>
                <div class="input" style="width: 20%;"></div>
            <?php endforeach; ?>
            <div class="input" style="width: 20%;"></div>
        </div>
        <div class="remarks">
            OBSERVACIONES: <br>
        </div>
        <p class="text-center" style="font-size: .9rem;">
            La información de identificación del rodante se obtiene del contenido de la licencia de
            tránsito, una vez se realice la validación con el RUNT.
        </p>
        <div class="remarks" style="height: 200px;">
            <!-- Espacio para imágenes de licencia -->
        </div>
    </section>
    <section class="mx-2">
        <div class="yellow-background sub-title ms-0">CONCEPTOS E IMPRONTAS</div>
        <p>
            Este concepto técnico está basado en la inspección de los sistemas de identificación,
            de acuerdo a patrones efectuados por la casa fabricante correspondiente, el interesado
            debe confirmar la documentación que ampara la matricula y posibles medidas cautelares,
            los sistemas de identificación que posee en la actualidad se dictaminan:
        </p>

        <div class="parent my-4 mx-2">
            <div class="div1 yellow-background">Información</div>
            <div class="div2 yellow-background">Improntas</div>
            <div class="div3 yellow-background"></div>
            <div class="div4 yellow-background">Original</div>
            <div class="div5 yellow-background"></div>
            <div class="div6 input w-100"></div>
            <div class="div7 yellow-background">Regrabado</div>
            <div class="div8 yellow-background"></div>
            <div class="div9 yellow-background">Grabado no original</div>
            <div class="div10 yellow-background"></div>
            <div class="div11 yellow-background">Información</div>
            <div class="div12 yellow-background">Improntas</div>
            <div class="div17 yellow-background"></div>
            <div class="div18 yellow-background">Original</div>
            <div class="div19 yellow-background"></div>
            <div class="div20 input w-100"></div>
            <div class="div21 yellow-background">Regrabado</div>
            <div class="div22 yellow-background"></div>
            <div class="div23 yellow-background">Grabado no original</div>
            <div class="div24 yellow-background"></div>
            <div class="div25 yellow-background">Información</div>
            <div class="div26 yellow-background">Improntas</div>
            <div class="div27 yellow-background"></div>
            <div class="div28 yellow-background">Original</div>
            <div class="div29 yellow-background"></div>
            <div class="div30 input w-100"></div>
            <div class="div31 yellow-background">Regrabado</div>
            <div class="div32 yellow-background"></div>
            <div class="div33 yellow-background">Grabado no original</div>
            <div class="div34 yellow-background"></div>
        </div>
        <div class="remarks" style="height: 120px;"></div>

        <div class="d-flex my-4" style="gap: 40px">
            <div>
                <p class="mb-3">Firma perito encargado:</p>
                <p>______________________________________</p>
                <p>CC:</p>
                <p>Técnico en identificación de automotores</p>
            </div>
            <div>
                <p class="mb-3">Firma cliente:</p>
                <p>______________________________________</p>
                <p>CC:</p>
            </div>
        </div>

        <small style="font-size: .8rem; line-height: 50% ;margin-top: 1rem">
            AVISO LEGAL: El certificado de PRITEC no reemplaza el certificado de tradición que expiden los organismos de tránsito. Se precisa que la
            información suministrada es la que se encuentra en el Registro Único Nacional de Tránsito al momento de la consulta y a su vez la información
            contenida en el registro es producto de los reportes efectuados por los diferentes Organismos de Tránsito, Direcciones Territoriales, entre otros
            actores, quienes son los responsables de reportar información al RUNT y de su actualización. Por lo que la PRITEC. no asume responsabilidad
            alguna de la veracidad de la información
        </small>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.print()
    })
</script>

<?php include '../layouts/empty_footer.php'; ?>