/**
 * Script de prueba para datos de batería
 * Ejecutar este script en la consola del navegador para establecer datos de prueba para la batería
 */

// Función para asignar valores aleatorios a los campos de batería
function generarDatosBateria() {
    // Valores aleatorios para las diferentes mediciones de batería
    const porcentajes = [15, 30, 60, 85, 95, 45, 70];
    
    // Datos simulados para batería
    const datosBateria = {
        bateria_voltaje: porcentajes[Math.floor(Math.random() * porcentajes.length)],
        bateria_amperaje: porcentajes[Math.floor(Math.random() * porcentajes.length)],
        bateria_estado_fisico: porcentajes[Math.floor(Math.random() * porcentajes.length)],
        bateria_terminales: porcentajes[Math.floor(Math.random() * porcentajes.length)],
        bateria_carga: porcentajes[Math.floor(Math.random() * porcentajes.length)],
        observaciones_bateria: "Observaciones de prueba para la batería del vehículo. Se recomienda revisar la conexión de los terminales."
    };
    
    console.log('Datos de batería generados:', datosBateria);
    return datosBateria;
}

// Función para mostrar los valores en la página (si los campos existen)
function mostrarDatosBateria() {
    const datos = generarDatosBateria();
    
    for (const [campo, valor] of Object.entries(datos)) {
        const elemento = document.querySelector(`[name="${campo}"]`);
        if (elemento) {
            elemento.value = valor;
            console.log(`Campo ${campo} actualizado con valor: ${valor}`);
        } else {
            console.log(`Campo ${campo} no encontrado en la página`);
        }
    }
}

// Ejecutar automáticamente
console.log('=== SCRIPT DE DATOS DE PRUEBA PARA BATERÍA ===');
console.log('Generando datos aleatorios para la batería...');
mostrarDatosBateria();
console.log('=== FIN DEL SCRIPT ===');
