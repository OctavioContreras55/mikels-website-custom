# Documentación de Personalizaciones

## Registro de Cambios Implementados

### [TEMPLATE] - Formato para nuevas entradas
```markdown
## [YYYY-MM-DD] - Nombre de la Personalización

### Descripción
Breve descripción del cambio o funcionalidad implementada.

### Archivos Modificados
- `/path/to/file1.php`
- `/css/custom/file.css`
- `/js/custom/script.js`

### Código Implementado
```php
// Código de ejemplo aquí
```

### Screenshots
- Before: `/screenshots/before/YYYY-MM-DD_descripcion_before.png`
- After: `/screenshots/after/YYYY-MM-DD_descripcion_after.png`

### Notas Adicionales
- Consideraciones especiales
- Dependencias
- Posibles conflictos
```

---

## Personalizaciones del Tema Blocksy

### Override de Estilos Base
- **Archivo**: `/css/theme-overrides/blocksy-overrides.css`
- **Propósito**: Modificar estilos predeterminados del tema sin perder cambios en actualizaciones
- **Selectores importantes**:
  ```css
  /* Header personalizado */
  .site-header { }
  
  /* Footer personalizado */
  .site-footer { }
  
  /* Botones del tema */
  .wp-block-button__link { }
  ```

### Colores Personalizados
- **Archivo**: `/css/custom/colors.css`
- **Variables CSS** para mantener consistencia:
  ```css
  :root {
    --mikels-primary: #007cba;
    --mikels-secondary: #ff6b35;
    --mikels-accent: #4ecdc4;
    --mikels-dark: #2c3e50;
    --mikels-light: #ecf0f1;
  }
  ```

## Personalizaciones de WooCommerce

### Páginas de Producto
- **Archivo**: `/css/woocommerce/product-pages.css`
- **Modificaciones**:
  - Layout de galería de imágenes
  - Estilo de botones "Añadir al carrito"
  - Información de producto mejorada
  - Tabs de descripción personalizadas

### Proceso de Checkout
- **Archivo**: `/css/woocommerce/checkout.css`
- **Mejoras implementadas**:
  - Formulario de checkout simplificado
  - Indicadores de progreso
  - Validación visual de campos
  - Resumen de pedido mejorado

## Funciones PHP Personalizadas

### Sistema de Hooks
- **Archivo**: `/php/hooks/woocommerce-hooks.php`
- **Funcionalidades**:
  ```php
  // Personalizar texto de botones
  add_filter('woocommerce_product_add_to_cart_text', 'mikels_custom_add_to_cart_text');
  
  // Modificar emails de WooCommerce
  add_action('woocommerce_email_header', 'mikels_custom_email_header');
  
  // Agregar campos personalizados en checkout
  add_action('woocommerce_after_order_notes', 'mikels_custom_checkout_fields');
  ```

### Shortcodes Personalizados
- **Archivo**: `/php/shortcodes/mikels-shortcodes.php`
- **Shortcodes disponibles**:
  ```php
  // Mostrar productos destacados
  [mikels_featured_products limit="4"]
  
  // Formulario de contacto personalizado
  [mikels_contact_form]
  
  // Banner promocional
  [mikels_promo_banner title="Oferta Especial" image="url"]
  ```

## Bloques HTML Personalizados

### Bloque de Herramientas Destacadas
- **Archivo**: `/html/blocks/featured-tools.html`
- **Uso**: Página de inicio para mostrar herramientas principales
- **Variables**: Título, descripción, enlaces de productos

### Widget de Ofertas
- **Archivo**: `/html/widgets/special-offers.html`
- **Ubicación**: Sidebar de páginas de producto
- **Funcionalidad**: Mostrar ofertas relacionadas automáticamente

## JavaScript Personalizado

### Carrito Ajax Mejorado
- **Archivo**: `/js/custom/cart-ajax.js`
- **Funcionalidad**: Actualización del carrito sin recargar página
- **Dependencias**: jQuery, WooCommerce

### Búsqueda en Tiempo Real
- **Archivo**: `/js/custom/live-search.js`
- **Implementación**: Búsqueda de productos con sugerencias
- **API**: Utiliza REST API de WordPress

## Optimizaciones de Performance

### Compresión de Imágenes
- **Configuración**: Automática para uploads
- **Formatos**: WebP cuando sea posible
- **Tamaños**: Múltiples para responsive

### Carga Condicional de Scripts
```php
// Cargar scripts solo donde sean necesarios
function mikels_conditional_scripts() {
    if (is_shop() || is_product()) {
        wp_enqueue_script('mikels-shop-js');
    }
}
add_action('wp_enqueue_scripts', 'mikels_conditional_scripts');
```

## SEO y Structured Data

### Schema Markup para Productos
- **Implementación**: Automática en páginas de producto
- **Tipo**: Product, Offer, Organization
- **Validación**: Google Rich Results Test

### Meta Tags Personalizados
- **Open Graph**: Para redes sociales
- **Twitter Cards**: Optimización para Twitter
- **JSON-LD**: Datos estructurados

## Mantenimiento y Actualizaciones

### Backup Antes de Cambios
```bash
# Comando para backup completo
wp db export backup-pre-update-$(date +%Y%m%d).sql
tar -czf files-backup-$(date +%Y%m%d).tar.gz wp-content/
```

### Testing de Compatibilidad
1. Verificar en staging antes de producción
2. Probar con última versión de WordPress
3. Validar compatibilidad con plugins actualizados
4. Revisar responsive en dispositivos múltiples

### Procedimiento de Rollback
En caso de problemas:
1. Restaurar backup de base de datos
2. Restaurar archivos desde backup
3. Verificar funcionalidad básica
4. Documentar problema para futuras referencias

---

**Nota**: Mantener esta documentación actualizada con cada nueva personalización implementada.