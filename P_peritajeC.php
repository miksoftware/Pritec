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
    header('Location: L_peritajeC.php');
    exit;
}

require_once dirname(__FILE__) . '/peritaje_completo/Getid.php';
require_once dirname(__FILE__) . '/Enums/SeguroEnum.php';
require_once dirname(__FILE__) . '/Enums/ImprontaEnum.php';

// Obtener datos del peritaje
$peritaje = obtenerPeritajePorId($id);

if (!$peritaje) {
    $_SESSION['error'] = "Peritaje no encontrado";
    header('Location: L_peritajeC.php');
    exit;
}

// Calcular promedio de porcentajes
$porcentajes = [
    $peritaje['llanta_anterior_izquierda'],
    $peritaje['llanta_anterior_derecha'],
    $peritaje['llanta_posterior_izquierda'],
    $peritaje['llanta_posterior_derecha'],
    $peritaje['amortiguador_anterior_izquierdo'],
    $peritaje['amortiguador_anterior_derecho'],
    $peritaje['amortiguador_posterior_izquierdo'],
    $peritaje['amortiguador_posterior_derecho'],
];

$promedio = array_sum($porcentajes) / count($porcentajes);

include 'layouts/empty_header.php';
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
            background: url('img/background.png') repeat-y center center;
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

    .sub-title-vertical {
        text-align: center;
        margin: 0 1rem;
        width: fit-content;
        padding: 1.5rem .2rem;
        writing-mode: sideways-lr;
    }

    .label {
        width: 50%;
        padding: .2rem .5rem;
        align-self: center;
    }

    .input {
        width: 50%;
        padding: .2rem .5rem;
        border: 1px var(--main-color) solid;
        border-radius: 8px;
    }

    .remarks {
        border: 1px solid var(--main-color);
        padding: .5rem 1rem;
        border-radius: 8px;
        height: 50px;
        font-size: .8rem
    }
</style>

<main class="w-100 m-4">
    <h4 class="text-center">SALA TÉCNICA EN AUTOMOTORES</h4>
    <h6 class="text-center mb-3">CERIFICACIÓN TÉCNICA EN IDENTIFICACIÓN DE AUTOMOTORES</h6>
    <header class="d-flex gap-4 mb-4 align-items-center mx-auto">
        <img src="img/pritec.png" style="width: 150px;object-fit: contain;" />
        <div class="me-5">
            <p>Dirección: Carrera 16 No. 18-197 Barrio Tenerife</p>
            <p>Teléfono: 3132049245-3158928492</p>
            <p>Web: peritos.pritec.co</p>
            <p>Peritos e inspecciones técnicas vehiculares Neiva-Huila</p>
        </div>
        <div>
            <p>Fecha: <?php echo $peritaje['fecha'] ?></p>
            <p>No. Servicio: <?php echo $peritaje['no_servicio'] ?></p>
            <p>Servicio para: <?php echo $peritaje['servicio_para'] ?></p>
            <p>Convenio: <?php echo $peritaje['convenio'] ?></p>
        </div>
    </header>
    <section class="d-flex gap-2 my-4">
        <div class="w-50 d-flex">
            <div class="yellow-background sub-title-vertical">
                DATOS DEL VEHÍCULO
            </div>
            <div class="d-flex flex-column gap-2 w-100">
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Clase</div>
                    <div class="input">
                        <?php echo $peritaje['clase'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Marca</div>
                    <div class="input">
                        <?php echo $peritaje['marca'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Línea</div>
                    <div class="input">
                        <?php echo $peritaje['linea'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Cilindraje</div>
                    <div class="input">
                        <?php echo $peritaje['cilindraje'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Servicio</div>
                    <div class="input">
                        <?php echo $peritaje['servicio'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Modelo</div>
                    <div class="input">
                        <?php echo $peritaje['modelo'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Color</div>
                    <div class="input">
                        <?php echo $peritaje['color'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de chasis</div>
                    <div class="input">
                        <?php echo $peritaje['no_chasis'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de motor</div>
                    <div class="input">
                        <?php echo $peritaje['no_motor'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de serie</div>
                    <div class="input">
                        <?php echo $peritaje['no_serie'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Tipo de carrocería</div>
                    <div class="input">
                        <?php echo $peritaje['tipo_carroceria'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Organismo de tránsito</div>
                    <div class="input">
                        <?php echo $peritaje['organismo_transito'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Kilometraje</div>
                    <div class="input">
                        <?php echo $peritaje['kilometraje'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Código fasecolda</div>
                    <div class="input">
                        <?php echo $peritaje['codigo_fasecolda'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Valor fasecolda</div>
                    <div class="input">
                        <?php echo $peritaje['valor_fasecolda'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Valor sugerido</div>
                    <div class="input">
                        <?php echo $peritaje['valor_sugerido'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Valor accesorios</div>
                    <div class="input">
                        <?php echo $peritaje['valor_accesorios'] ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-50 me-4">
            <div class="plate"><?php echo $peritaje['placa'] ?></div>
            <div class="yellow-background sub-title">DATOS DEL SOLICITANTE</div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Nombres y apellidos</div>
                    <div class="input">
                        <?php echo $peritaje['nombre_apellidos'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Identificación</div>
                    <div class="input">
                        <?php echo $peritaje['identificacion'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Teléfono</div>
                    <div class="input">
                        <?php echo $peritaje['telefono'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Dirección</div>
                    <div class="input">
                        <?php echo $peritaje['direccion'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Correo</div>
                    <div class="input">
                        <?php echo $peritaje['email'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL EXTERNA</div>
            <div class="d-flex flex-column w-100">
                <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                <div class="yellow-background sub-title ms-4 mb-0">CARROCERÍA</div>
                <div class="d-flex gap-2 w-100">
                    <img src="img/carroceria.png" class="w-50" style="object-fit: contain;">
                    <div class="d-flex flex-column gap-2 w-50 h-100">
                        <div class="d-flex gap-2">
                            <div class="yellow-background label text-center">Descripción pieza</div>
                            <div class="input text-center">
                                Concepto
                            </div>
                        </div>
                        <?php
                        for ($i = 0; $i < 10; $i++) {
                            echo '<div class="d-flex gap-2">
                                <div class="yellow-background label">&nbsp;</div>
                                <div class="input">&nbsp;</div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="remarks">
        OBSERVACIONES:
    </div>
    <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL EXTERNA</div>
            <div class="d-flex flex-column w-100">
                <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                <div>
                    <div class="yellow-background sub-title ms-4 mb-0">ESTRUCTURA</div>
                    <div class="d-flex gap-2 w-100">
                        <img src="img/estructura.png" class="w-50" height="200" style="object-fit: contain;">
                        <div class="d-flex flex-column gap-2 w-50 h-100">
                            <div class="d-flex gap-2">
                                <div class="yellow-background label text-center">Descripción pieza</div>
                                <div class="input text-center">
                                    Concepto
                                </div>
                            </div>
                            <?php
                            for ($i = 0; $i < 5; $i++) {
                                echo '<div class="d-flex gap-2">
                                <div class="yellow-background label">&nbsp;</div>
                                <div class="input">&nbsp;</div>
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="yellow-background sub-title ms-4 mb-0">CHASIS</div>
                    <div class="d-flex gap-2 w-100">
                        <img src="img/chasis.png" class="w-50" height="200" style="object-fit: contain;">
                        <div class="d-flex flex-column gap-2 w-50 h-100">
                            <div class="d-flex gap-2">
                                <div class="yellow-background label text-center">Descripción pieza</div>
                                <div class="input text-center">
                                    Concepto
                                </div>
                            </div>
                            <?php
                            for ($i = 0; $i < 5; $i++) {
                                echo '<div class="d-flex gap-2">
                                <div class="yellow-background label">&nbsp;</div>
                                <div class="input">&nbsp;</div>
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="remarks">
        OBSERVACIONES:
    </div>
    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">LLANTAS Y AMORTIGUADORES</div>
            <div class="d-flex flex-column w-100">
                <div class="d-flex gap-2 w-100">
                    <img src="img/llantas.png" style="object-fit: contain;width: 30%;">
                    <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
                        <div class="d-flex gap-2">
                            <div class="yellow-background label text-center">Ítem</div>
                            <div class="yellow-background label text-center">Concepto</div>
                            <div class="yellow-background label text-center">Porcentaje</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta anterior izquierda</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['llanta_anterior_izquierda'] ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta anterior derecha</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['llanta_anterior_derecha'] ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta posterior izquierda</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['llanta_posterior_izquierda'] ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta posterior derecha</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['llanta_posterior_derecha'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 w-100">
                    <img src="img/amortiguadores.png" style="object-fit: contain;width: 30%; height: 180px">
                    <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
                        <div class="d-flex gap-2">
                            <div class="yellow-background label text-center">Ítem</div>
                            <div class="yellow-background label text-center">Concepto</div>
                            <div class="yellow-background label text-center">Porcentaje</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador anterior izquierdo</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['amortiguador_anterior_izquierdo'] ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador anterior derecho</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['amortiguador_anterior_derecho'] ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador posterior izquierdo</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['amortiguador_posterior_izquierdo'] ?>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador posterior derecho</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">
                                <?php echo $peritaje['amortiguador_posterior_derecho'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 w-100">
                    <div style="object-fit: contain;width: 30%;"></div>
                    <div style="width: 70%;" class="d-flex justify-content-around">
                        <span style="font-weight: bold;font-size: 1.2rem;-webkit-text-stroke: .4px var(--main-color);">RESULTADOS</span>
                        <div style="width: 50%; padding: .2rem .5rem;border: 1px var(--main-color) solid;border-radius: 8px; background-color: #fef9cb">
                            <?php echo $promedio ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="remarks">
        OBSERVACIONES: <br> <?php echo $peritaje['observaciones_llantas'] ?>
    </div>
    <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">PRUEBA DE OBSERVACIÓN Y DIAGNÓSTICO SCANER</div>
            <div class="d-flex flex-column w-100">
                <p>El scanner automotriz es una herramienta que se utiliza para diagnosticar las fallas registradas
                    en la computadora del vehículo. La computadora se encarga de regular las funciones del auto
                    a través de distintos sensores que monitorean y registran todos los errores con un código:</p>
            </div>
        </div>
    </section>
    <div class="remarks">
        OBSERVACIONES: <br> <?php echo $peritaje['observaciones2'] ?>
    </div>

    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2 w-100">
            <div class="d-flex flex-column gap-2 w-50 h-100">
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">ÍTEM</div>
                    <div class="input text-center" style="width: 30%">
                        RESPUESTA
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;" style="width: 70%;">Fuga aceite de motor</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fuga_aceite_motor'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga aceite caja velocidades</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fuga_aceite_caja_velocidades'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga aceite caja de trasmisión</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fuga_aceite_caja_transmision'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga líquido de frenos</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fuga_liquido_frenos'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga aceite dirección hidráulica</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fuga_aceite_direccion_hidraulica'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fugas líquido bomba embrague</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fugas_liquido_bomba_embrague'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fugas aceite por amortiguadores</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fugas_aceite_amortiguadores'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fugas tanque combustible</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['fugas_tanque_combustible'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado brazos dirección rotulas</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_brazos_direccion_rotulas'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tanque silenciador</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_tanque_silenciador'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tubo exhosto</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_tubo_exhosto'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tanque catalizador de gases</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_tanque_catalizador_gases'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado cauchos suspensión</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_cauchos_suspension'] ?>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column gap-2 w-50 h-100">
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">ÍTEM</div>
                    <div class="input text-center" style="width: 30%">
                        RESPUESTA
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;" style="width: 70%;">Estado tijeras</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_tijeras'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado guardapolvos ejes</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_guardapolvos_ejes'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado carter</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_carter'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado protectores inferiores</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_protectores_inferiores'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado guarda polvo caja dirección</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_guardapolvo_caja_direccion'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tuberías frenos</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_tuberias_frenos'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado mangueras radiador</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_mangueras_radiador'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado correas</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_correas'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Tensión correas</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['tension_correas'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado filtro de aire</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_filtro_aire'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado cables instalación de alta</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_cables_instalacion_alta'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado externo batería</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_externo_bateria'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado radiador</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_tubo_exhosto'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2 w-100">
            <div class="d-flex flex-column gap-2 w-50 h-100">
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">ÍTEM</div>
                    <div class="input text-center" style="width: 30%">
                        RESPUESTA
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;" style="width: 70%;">Estado radiador A/A</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_radiador_aa'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado soporte motor</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_soporte_motor'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado carcasa caja de velocidades</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['estado_carcasa_caja_velocidades'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Viscosidad aceite de motor</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['viscosidad_aceite_motor'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel refrigerante motor</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['nivel_refrigerante_motor'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel líquido de frenos</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['nivel_liquido_frenos'] ?>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column gap-2 w-50 h-100">
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">ÍTEM</div>
                    <div class="input text-center" style="width: 30%">
                        RESPUESTA
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;" style="width: 70%;">Nivel agua limpiavidrios</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['nivel_agua_limpiavidrios'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel aceite dirección hidráulica</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['nivel_aceite_direccion_hidraulica'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel líquido embrague</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['nivel_liquido_embrague'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel aceite de motor</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['nivel_aceite_motor'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Funcionamiento A/A</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['funcionamiento_aa'] ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Soporte caja de velocidades</div>
                    <div class="input" style="width: 30%">
                        <?php echo $peritaje['soporte_caja_velocidades'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">FIJACIÓN FOTOGRÁFICA</div>
            <div class="d-flex flex-column w-100">
                <p>Observación y clasificación de las características del automotor de acuerdo al punto 1</p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); gap: 8px;">
                    <?php
                    for ($i = 0; $i < 4; $i++) {
                        $name = 'fijacion_fotografica_' . $i + 1;
                        $url = $peritaje[$name];
                        if ($url) {
                            echo '<div style="border: 1px solid var(--main-color);border-radius: 8px;padding: 5px">	
                                    <img src="uploads/' . $url . '" style="object-fit: contain; width: 100%">
                                </div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <div class="d-flex my-4" style="gap: 40px">
        <div>
            <p class="mb-3">Firma perito encargado:</p>
            <p>______________________________________</p>
            <p>CC:</p>
        </div>
        <div>
            <p class="mb-3">Firma cliente:</p>
            <p>______________________________________</p>
            <p>CC:</p>
        </div>
    </div>

    <small style="font-size: 10px; font-weight: bold; margin-top: 1rem">
        AVISO LEGAL: Pritec Informa que la revisión realizada corresponde al estado del vehículo en la fecha y hora de la misma y con el recorrido del
        kilometraje que revela el odómetro en el momento, se advierte que, debido a la vulnerabilidad a que se ven expuestos este tipo de bienes, en
        cuanto a la afectación, modificación, avería, deterioro y desgaste de cualquiera de sus componentes, el informe que se pone de presente no
        garantiza de ningún modo que el estado del vehiculo sea el mismo en fechas posteriores a la fecha de la revisión.
    </small>


    <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.print()
    })
</script>

<?php include 'layouts/empty_footer.php'; ?>