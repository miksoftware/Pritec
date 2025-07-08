<?php
/**
 * Página 3 - PDF Modular de Peritaje Vehicular
 * Contiene las secciones de batería
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la página 3");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peritaje Vehicular - Página 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pdf-modular/css/estilos.css">
</head>
<body>
    <div class="pagina">
        <!-- Sección de Actuación de la Batería -->
        <?php include __DIR__ . '/../secciones/actuacion-bateria.php'; ?>
        
        <!-- Sección de Prueba de Scanner -->
        <?php include __DIR__ . '/../secciones/prueba-scanner.php'; ?>
    </div>
</body>
</html>
