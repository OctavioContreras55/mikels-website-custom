# Guía de Instalación - Mikels E-commerce

## Requisitos del Sistema

### Servidor
- **WordPress**: Versión 6.0 o superior
- **PHP**: Versión 8.0 o superior
- **MySQL**: 5.6 o superior / MariaDB 10.0 o superior
- **Memoria**: Mínimo 512MB, recomendado 1GB
- **Almacenamiento**: Mínimo 1GB disponible

### Tema y Plugins Requeridos
- **Tema Principal**: Blocksy (versión gratuita o Pro)
- **E-commerce**: WooCommerce
- **Cache**: Plugin de cache (WP Rocket, W3 Total Cache, etc.)
- **SEO**: Yoast SEO o RankMath
- **Seguridad**: Wordfence o similar

## Proceso de Instalación

### 1. Preparación del Entorno
```bash
# Crear backup de la instalación actual
wp db export backup-$(date +%Y%m%d).sql

# Verificar versiones
wp core version
wp plugin list
wp theme list
```

### 2. Instalación del Tema Blocksy
1. Descargar tema desde WordPress.org o sitio oficial
2. Instalar vía admin de WordPress o FTP
3. Activar el tema
4. Configurar opciones básicas en Customizer

### 3. Configuración de WooCommerce
1. Instalar y activar WooCommerce
2. Ejecutar wizard de configuración inicial
3. Configurar métodos de pago
4. Configurar opciones de envío
5. Establecer páginas principales (shop, cart, checkout, account)

### 4. Implementación de Personalizaciones

#### CSS Personalizado
```php
// Agregar en functions.php del tema hijo
function mikels_custom_styles() {
    wp_enqueue_style(
        'mikels-custom-css',
        get_stylesheet_directory_uri() . '/css/custom/main.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'mikels_custom_styles');
```

#### Funciones Personalizadas
```php
// Crear archivo en /php/functions/mikels-custom-functions.php
// Incluir en functions.php del tema hijo
require_once get_stylesheet_directory() . '/php/functions/mikels-custom-functions.php';
```

### 5. Configuración del Tema Hijo
```php
// style.css del tema hijo
/*
Theme Name: Blocksy Child - Mikels
Description: Tema hijo de Blocksy para Mikels E-commerce
Template: blocksy
Version: 1.0.0
*/

@import url("../blocksy/style.css");

/* Personalizaciones CSS aquí */
```

```php
// functions.php del tema hijo
<?php
function mikels_child_theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'mikels_child_theme_enqueue_styles');

// Incluir funciones personalizadas
require_once get_stylesheet_directory() . '/php/functions/mikels-custom-functions.php';
?>
```

## Configuraciones Recomendadas

### WordPress Admin
- **Permalinks**: Estructura personalizada `/%category%/%postname%/`
- **Escritura**: Desactivar editor clásico, usar Gutenberg
- **Lectura**: Página estática como inicio
- **Discusión**: Configurar moderación de comentarios

### WooCommerce Settings
- **General**: Configurar moneda, ubicación de tienda
- **Productos**: Habilitar reseñas, administrar stock
- **Envío**: Configurar zonas y métodos
- **Pagos**: Activar métodos requeridos
- **Cuentas**: Permitir registro en checkout

### Blocksy Customizer
- **Colores**: Establecer paleta de marca
- **Tipografía**: Configurar fuentes del sitio
- **Layout**: Definir estructura de páginas
- **Header/Footer**: Personalizar elementos
- **WooCommerce**: Ajustar páginas de tienda

## Verificación Post-Instalación

### Checklist Técnico
- [ ] Sitio web carga correctamente
- [ ] Tema hijo activado y funcionando
- [ ] CSS personalizado aplicándose
- [ ] Funciones PHP sin errores
- [ ] WooCommerce configurado completamente
- [ ] Páginas principales creadas
- [ ] Menús configurados
- [ ] Widgets en su lugar

### Checklist de Funcionalidad
- [ ] Navegación del sitio intuitiva
- [ ] Páginas de producto funcionando
- [ ] Proceso de checkout completo
- [ ] Formularios de contacto operativos
- [ ] Búsqueda de productos eficiente
- [ ] Carrito de compras funcional
- [ ] Responsive design correcto

## Solución de Problemas Comunes

### Error: Tema no aplica estilos
```php
// Verificar enqueue correcto en functions.php
wp_enqueue_style('theme-style', get_stylesheet_uri());
```

### Error: JavaScript no funciona
```php
// Verificar jQuery dependency
wp_enqueue_script('custom-js', 'path/to/script.js', array('jquery'));
```

### Error: WooCommerce páginas en blanco
1. Verificar configuración de permalinks
2. Limpiar cache del sitio
3. Re-salvar configuración de WooCommerce

## Contacto de Soporte
Para asistencia técnica durante la instalación, contactar al equipo de desarrollo con:
- Descripción detallada del problema
- Screenshots del error
- Información del entorno (PHP, WordPress, plugins)