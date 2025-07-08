<?php
/**
 * Header del PDF de Peritaje
 * Contiene el encabezado con logo, información de la empresa y datos del peritaje
 */

// Verificar que $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección header");
}
?>

<section class="header-peritaje">
    <h4>SALA TÉCNICA EN AUTOMOTORES</h4>
    <h6>CERIFICACIÓN TÉCNICA EN IDENTIFICACIÓN DE AUTOMOTORES</h6>
    
    <header class="informacion-empresa">
        <img src="img/pritec.png" class="logo-empresa" alt="Logo Pritec"/>
        
        <div class="datos-empresa">
            <p>Dirección: Carrera 16 No. 18-197 Barrio Tenerife</p>
            <p>Teléfono: 3132049245-3158928492</p>
            <p>Web: peritos.pritec.co</p>
            <p>Peritos e inspecciones técnicas vehiculares Neiva-Huila</p>
        </div>
        
        <div class="datos-peritaje">
            <p>Fecha: <?php echo htmlspecialchars($peritaje["fecha"] ?? ''); ?></p>
            <p>No. Servicio: <?php echo htmlspecialchars($peritaje["no_servicio"] ?? ''); ?></p>
            <p>Servicio para: <?php echo htmlspecialchars($peritaje["servicio_para"] ?? ''); ?></p>
            <p>Convenio: <?php echo htmlspecialchars($peritaje["convenio"] ?? ''); ?></p>
        </div>
    </header>
</section>
