# Sistema Modular de Peritajes - Documentación

## Estructura del Sistema Modular

El sistema ha sido refactorizado para facilitar el mantenimiento dividiendo el contenido en componentes reutilizables.

### Archivos Principales

- **P_peritajeC_modular.php** - Archivo principal que utiliza los componentes
- **P_peritajeC.php** - Archivo original (mantener como respaldo)

### Componentes Creados

#### 1. `/pdf-completo/config.php`
- Funciones utilitarias comunes
- Configuración de tipos de vehículos
- Funciones de formateo y validación

#### 2. `/pdf-completo/header-section.php`
- Cabecera del documento
- Datos del vehículo (columnas 1 y 2)
- Datos del solicitante (columna 3)
- Inspección visual externa (para vehículos no motocicletas)

#### 3. `/pdf-completo/inspeccion-visual-interna.php`
- Inspección visual interna específica para motocicletas
- Incluye estructura y chasis
- Observaciones de estructura

#### 4. `/pdf-completo/llantas-amortiguadores.php`
- Sección completa de llantas y amortiguadores
- Imágenes diferenciadas para motocicletas y otros vehículos
- Porcentajes y conceptos automáticos

## Ventajas del Sistema Modular

### 1. **Mantenimiento Simplificado**
- Cada sección está en su propio archivo
- Cambios localizados sin afectar otras secciones
- Fácil identificación de problemas

### 2. **Reutilización de Código**
- Componentes reutilizables en diferentes contextos
- Funciones comunes centralizadas en `config.php`
- Menos duplicación de código

### 3. **Escalabilidad**
- Fácil agregar nuevas secciones
- Modificar secciones existentes sin riesgo
- Estructura clara para nuevos desarrolladores

### 4. **Organización**
- Separación clara de responsabilidades
- Estructura de carpetas lógica
- Documentación integrada

## Cómo Usar el Sistema

### Para Agregar una Nueva Sección:

1. Crear un nuevo archivo en `/pdf-completo/`
2. Incluir el archivo en `P_peritajeC_modular.php`
3. Documentar el propósito del componente

### Para Modificar una Sección Existente:

1. Localizar el archivo del componente
2. Realizar los cambios necesarios
3. Verificar que no afecte otros componentes

### Para Migrar Funcionalidad:

1. Identificar la sección en el archivo original
2. Crear el componente correspondiente
3. Incluir en el archivo modular
4. Probar funcionalidad

## Próximos Pasos Sugeridos

1. **Crear componentes faltantes:**
   - Batería
   - Prueba de scanner
   - Motor
   - Interior del automotor
   - Fugas
   - Firmas y certificaciones

2. **Optimizar el archivo principal:**
   - Eliminar código duplicado
   - Mejorar la estructura de includes
   - Agregar validaciones

3. **Documentar cada componente:**
   - Comentarios en código
   - Propósito de cada sección
   - Dependencias

## Ejemplo de Uso

```php
// En P_peritajeC_modular.php
require_once dirname(__FILE__) . "/pdf-completo/config.php";

// Configurar variables globales
$tiposVehiculos = getTiposVehiculos();

// Incluir componentes
include dirname(__FILE__) . "/pdf-completo/header-section.php";
include dirname(__FILE__) . "/pdf-completo/inspeccion-visual-interna.php";
include dirname(__FILE__) . "/pdf-completo/llantas-amortiguadores.php";
```

## Notas Importantes

- El archivo original `P_peritajeC.php` se mantiene como respaldo
- Los componentes utilizan las mismas variables del archivo original
- La estructura CSS y HTML se mantiene intacta
- Todas las funcionalidades existentes están preservadas

## Migración Recomendada

1. Probar `P_peritajeC_modular.php` con los componentes existentes
2. Crear componentes faltantes gradualmente
3. Una vez completo, renombrar archivos:
   - `P_peritajeC.php` → `P_peritajeC_backup.php`
   - `P_peritajeC_modular.php` → `P_peritajeC.php`
