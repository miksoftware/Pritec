<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
    exit;
}

require_once dirname(__FILE__) . '/../Enums/SeguroEnum.php';
require_once dirname(__FILE__) . '/../Enums/ImprontaEnum.php';

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

        .no-print {
            display: none !important;
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

    .print-button {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        z-index: 1000;
    }
</style>

<button onclick="window.print()" class="print-button no-print">
    <i class="fas fa-print"></i> Imprimir
</button>

<main class="w-100 m-4">
    <h4 class="text-center">SALA TÉCNICA EN AUTOMOTORES</h4>
    <h6 class="text-center mb-3">CERIFICACIÓN TÉCNICA EN IDENTIFICACIÓN DE AUTOMOTORES</h6>
    <header class="d-flex gap-4 mb-4 align-items-center mx-auto">
        <img src="../img/pritec.png" style="width: 150px;object-fit: contain;" />
        <div class="me-5">
            <p>Dirección: Carrera 16 No. 18-197 Barrio Tenerife</p>
            <p>Teléfono: 3132049245-3158928492</p>
            <p>Web: peritos.pritec.co</p>
            <p>Peritos e inspecciones técnicas vehiculares Neiva-Huila</p>
        </div>
        <div>
            <p>Fecha: ______________________</p>
            <p>No. Servicio: ______________________</p>
            <p>Servicio para: ______________________</p>
            <p>Convenio: ______________________</p>
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
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Marca</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Línea</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Cilindraje</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Servicio</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Modelo</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Color</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de chasis</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de motor</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">No. de serie</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Tipo de carrocería</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Organismo de tránsito</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Kilometraje</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Código fasecolda</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Valor fasecolda</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Valor sugerido</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Valor accesorios</div>
                    <div class="input">&nbsp;</div>
                </div>
            </div>
        </div>
        <div class="w-50 me-4">
            <div class="plate">__________</div>
            <div class="yellow-background sub-title">DATOS DEL SOLICITANTE</div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Nombres y apellidos</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Identificación</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Teléfono</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Dirección</div>
                    <div class="input">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label">Correo</div>
                    <div class="input">&nbsp;</div>
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
                    <img src="../img/carroceria.png" class="w-50" style="object-fit: contain;">
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
    <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL EXTERNA</div>
            <div class="d-flex flex-column w-100">
                <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                <div>
                    <div class="yellow-background sub-title ms-4 mb-0">ESTRUCTURA</div>
                    <div class="d-flex gap-2 w-100">
                        <img src="../img/estructura.png" class="w-50" height="200" style="object-fit: contain;">
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
                        <img src="../img/chasis.png" class="w-50" height="200" style="object-fit: contain;">
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
                    <img src="../img/llantas.png" style="object-fit: contain;width: 30%;">
                    <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
                        <div class="d-flex gap-2">
                            <div class="yellow-background label text-center">Ítem</div>
                            <div class="yellow-background label text-center">Concepto</div>
                            <div class="yellow-background label text-center">Porcentaje</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta anterior izquierda</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta anterior derecha</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta posterior izquierda</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center">Llanta posterior derecha</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 w-100">
                    <img src="../img/amortiguadores.png" style="object-fit: contain;width: 30%; height: 180px">
                    <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
                        <div class="d-flex gap-2">
                            <div class="yellow-background label text-center">Ítem</div>
                            <div class="yellow-background label text-center">Concepto</div>
                            <div class="yellow-background label text-center">Porcentaje</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador anterior izquierdo</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador anterior derecho</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador posterior izquierdo</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="input text-center" style="width: 70%">Amortiguador posterior derecho</div>
                            <div class="input text-center">B-R-M</div>
                            <div class="input text-center">&nbsp;</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 w-100">
                    <div style="object-fit: contain;width: 30%;"></div>
                    <div style="width: 70%;" class="d-flex justify-content-around">
                        <span style="font-weight: bold;font-size: 1.2rem;-webkit-text-stroke: .4px var(--main-color);">RESULTADOS</span>
                        <div style="width: 50%; padding: .2rem .5rem;border: 1px var(--main-color) solid;border-radius: 8px; background-color: #fef9cb">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        OBSERVACIONES:
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
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga aceite caja velocidades</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga aceite caja de trasmisión</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga líquido de frenos</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fuga aceite dirección hidráulica</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fugas líquido bomba embrague</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fugas aceite por amortiguadores</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Fugas tanque combustible</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado brazos dirección rotulas</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tanque silenciador</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tubo exhosto</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tanque catalizador de gases</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado cauchos suspensión</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
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
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado guardapolvos ejes</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado carter</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado protectores inferiores</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado guarda polvo caja dirección</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado tuberías frenos</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado mangueras radiador</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado correas</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Tensión correas</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado filtro de aire</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado cables instalación de alta</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado externo batería</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado radiador</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
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
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado soporte motor</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Estado carcasa caja de velocidades</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Viscosidad aceite de motor</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel refrigerante motor</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel líquido de frenos</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
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
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel aceite dirección hidráulica</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel líquido embrague</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Nivel aceite de motor</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Funcionamiento A/A</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%;">Soporte caja de velocidades</div>
                    <div class="input" style="width: 30%">&nbsp;</div>
                </div>
            </div>
        </div>
    </section>

    <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">FIJACIÓN FOTOGRÁFICA</div>
            <div class="d-flex flex-column w-100">
                <p class="mb-3">Observación y clasificación de las características del automotor de acuerdo al punto 1</p>
                <div class="w-100" style="display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); gap: 8px;height: 500px">
                    <div class="w-100 h-100" style="border: 1px solid var(--main-color);border-radius: 8px;padding: 5px"></div>
                    <div class="w-100 h-100" style="border: 1px solid var(--main-color);border-radius: 8px;padding: 5px"></div>
                    <div class="w-100 h-100" style="border: 1px solid var(--main-color);border-radius: 8px;padding: 5px"></div>
                    <div class="w-100 h-100" style="border: 1px solid var(--main-color);border-radius: 8px;padding: 5px"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="d-flex mt-5 mb-4" style="gap: 40px">
        <div>
            <p class="mb-4">Firma perito encargado:</p>
            <p>______________________________________</p>
            <p>CC:</p>
        </div>
        <div>
            <p class="mb-4">Firma cliente:</p>
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