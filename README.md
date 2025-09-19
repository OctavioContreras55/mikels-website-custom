# Mikels Website Custom - Sitio E-commerce de Herramientas

Este repositorio contiene todas las personalizaciones para el sitio web e-commerce de Mikels, construido con WordPress, tema Blocksy y WooCommerce.

## 📁 Estructura de Carpetas

```
├── css/                     # Estilos CSS personalizados
│   ├── custom/             # CSS personalizado general
│   ├── theme-overrides/    # Sobreescribir estilos del tema Blocksy
│   └── woocommerce/        # Estilos específicos de WooCommerce
├── html/                    # Bloques y plantillas HTML
│   ├── blocks/             # Bloques HTML personalizados
│   ├── templates/          # Plantillas de página
│   └── widgets/            # Widgets personalizados
├── js/                      # JavaScript personalizado
│   ├── custom/             # Scripts personalizados
│   └── plugins/            # Plugins JS externos
├── php/                     # Código PHP personalizado
│   ├── functions/          # Funciones personalizadas
│   ├── hooks/              # Hooks de WordPress
│   └── shortcodes/         # Shortcodes personalizados
├── screenshots/             # Capturas de pantalla
│   ├── before/             # Estado anterior a cambios
│   ├── after/              # Estado posterior a cambios
│   └── features/           # Funcionalidades implementadas
└── docs/                    # Documentación
    ├── setup/              # Guías de instalación
    ├── customizations/     # Documentación de personalizaciones
    └── maintenance/        # Guías de mantenimiento
```

## 🚀 Configuración Inicial

### Requisitos Previos
- WordPress 6.0 o superior
- PHP 8.0 o superior
- Tema Blocksy activado
- Plugin WooCommerce instalado y configurado

### Instalación de Personalizaciones

1. **Clonar el repositorio** en tu directorio de trabajo local
2. **Revisar documentación** en `/docs/setup/` antes de implementar cambios
3. **Tomar screenshots** del estado actual en `/screenshots/before/`
4. **Implementar cambios** siguiendo las guías específicas
5. **Documentar cambios** en `/screenshots/after/` y `/docs/customizations/`

## 🎨 Personalizaciones CSS

### Tema Blocksy
- Los overrides del tema van en `/css/theme-overrides/`
- Usar selectores específicos para evitar conflictos
- Mantener compatibilidad con actualizaciones del tema

### WooCommerce
- Estilos específicos de tienda en `/css/woocommerce/`
- Personalizar páginas de producto, carrito y checkout
- Mantener responsive design

### CSS Personalizado
- Estilos generales del sitio en `/css/custom/`
- Seguir metodología BEM para nomenclatura
- Comentar código para facilitar mantenimiento

## 🧩 Bloques y Plantillas HTML

### Bloques Personalizados
- Crear en `/html/blocks/` con estructura modular
- Incluir documentación de uso
- Optimizar para SEO y accesibilidad

### Plantillas
- Plantillas de página en `/html/templates/`
- Mantener compatibilidad con Blocksy
- Documentar variables y hooks disponibles

## ⚙️ Funciones PHP

### Functions.php
- Funciones personalizadas en `/php/functions/`
- Separar por funcionalidad (e-commerce, SEO, performance)
- Incluir comentarios descriptivos

### Hooks de WordPress
- Hooks personalizados en `/php/hooks/`
- Documentar prioridad y parámetros
- Evitar conflictos con plugins

### Shortcodes
- Shortcodes personalizados en `/php/shortcodes/`
- Incluir ejemplos de uso
- Validar parámetros de entrada

## 📜 JavaScript Personalizado

### Scripts Personalizados
- JavaScript del sitio en `/js/custom/`
- Minificar para producción
- Considerar compatibilidad cross-browser

### Plugins Externos
- Librerías externas en `/js/plugins/`
- Mantener versiones actualizadas
- Documentar dependencias

## 📸 Gestión de Screenshots

### Organización
- **Before**: Estado previo a cambios
- **After**: Resultado de implementación
- **Features**: Capturas de nuevas funcionalidades

### Nomenclatura
```
YYYY-MM-DD_descripcion-del-cambio_before.png
YYYY-MM-DD_descripcion-del-cambio_after.png
YYYY-MM-DD_nueva-funcionalidad_feature.png
```

## 📚 Documentación

### Setup
- Guías de instalación inicial
- Configuración de entorno de desarrollo
- Lista de plugins requeridos

### Customizations
- Documentar cada personalización
- Incluir código de ejemplo
- Explicar impacto en funcionalidad

### Maintenance
- Procedimientos de backup
- Actualización de tema y plugins
- Resolución de problemas comunes

## 🛠️ Flujo de Trabajo Recomendado

1. **Análisis**: Revisar requerimiento y documentación existente
2. **Planificación**: Definir alcance y archivos afectados
3. **Backup**: Crear respaldo del estado actual
4. **Desarrollo**: Implementar cambios siguiendo estándares
5. **Testing**: Probar en entorno de desarrollo
6. **Documentación**: Actualizar docs y screenshots
7. **Deploy**: Implementar en producción
8. **Validación**: Verificar funcionamiento correcto

## 🔧 Mejores Prácticas

### Código
- Seguir estándares de WordPress Codex
- Comentar código complejo
- Usar prefijos únicos para evitar conflictos
- Validar y sanitizar inputs

### Seguridad
- No hardcodear credenciales
- Validar permisos de usuario
- Escapar outputs correctamente
- Mantener plugins actualizados

### Performance
- Optimizar imágenes antes de subir
- Minificar CSS y JS para producción
- Usar cache cuando sea posible
- Cargar scripts solo donde sean necesarios

### SEO
- Mantener estructura semántica HTML
- Optimizar meta tags
- Implementar schema markup
- Considerar Core Web Vitals

## 📞 Soporte y Contacto

Para consultas sobre este proyecto:
- Revisar documentación en `/docs/`
- Verificar issues conocidos
- Contactar al equipo de desarrollo

## 📝 Changelog

Mantener registro de cambios importantes en cada actualización:
- Fecha de cambio
- Descripción de la modificación
- Archivos afectados
- Impacto en funcionalidad

---

**Nota**: Este repositorio está optimizado para el sitio e-commerce de herramientas Mikels con tema Blocksy y WooCommerce. Adaptar según necesidades específicas del proyecto.
