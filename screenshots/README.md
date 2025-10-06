# Mikels Website Custom - Screenshot Documentation

Este archivo documenta el uso de screenshots para el proyecto Mikels.

## Convenciones de Nomenclatura

### Formato General
```
YYYY-MM-DD_descripcion-del-cambio_tipo.extension
```

### Ejemplos
- `2024-03-15_header-personalizado_before.png`
- `2024-03-15_header-personalizado_after.png`
- `2024-03-16_carrito-ajax_feature.png`

## Tipos de Screenshots

### Before (Antes)
Capturas del estado original antes de implementar cambios:
- Layout existente
- Funcionalidad previa
- Problemas identificados

### After (Después)
Capturas del resultado final después de los cambios:
- Nuevo diseño implementado
- Funcionalidad mejorada
- Problemas resueltos

### Features (Funcionalidades)
Capturas de nuevas funcionalidades:
- Características añadidas
- Mejoras de UX/UI
- Integraciones especiales

## Mejores Prácticas

### Calidad
- Resolución mínima: 1920x1080
- Formato preferido: PNG para UI, JPG para fotos
- Comprimir imágenes antes de subir

### Contenido
- Mostrar contexto completo
- Incluir elementos relevantes
- Evitar información sensible

### Organización
- Crear carpetas por proyecto si es necesario
- Mantener nombres descriptivos
- Incluir fecha en el nombre del archivo

### Herramientas Recomendadas
- Lightshot
- Snagit
- Screenshot nativo del navegador
- Tools de desarrollo (F12)

## Uso en Documentación

### README Principal
```markdown
![Antes](screenshots/before/2024-03-15_homepage_before.png)
![Después](screenshots/after/2024-03-15_homepage_after.png)
```

### Documentación de Cambios
```markdown
## [2024-03-15] - Rediseño Homepage

### Screenshots
- **Antes**: [Ver imagen](screenshots/before/2024-03-15_homepage_before.png)
- **Después**: [Ver imagen](screenshots/after/2024-03-15_homepage_after.png)
- **Feature**: [Carrito Ajax](screenshots/features/2024-03-15_ajax-cart_feature.png)
```

## Checklist para Screenshots

### Antes de Capturar
- [ ] Limpiar cache del navegador
- [ ] Usar datos de prueba consistentes
- [ ] Verificar zoom del navegador (100%)
- [ ] Cerrar herramientas de desarrollo

### Durante la Captura
- [ ] Incluir suficiente contexto
- [ ] Evitar contenido personal/sensible
- [ ] Usar ventana de tamaño estándar
- [ ] Capturar en diferentes dispositivos si es responsive

### Después de Capturar
- [ ] Optimizar tamaño de archivo
- [ ] Verificar claridad de la imagen
- [ ] Guardar con nomenclatura correcta
- [ ] Actualizar documentación relacionada

## Automatización

### Script para Renombrado Masivo
```bash
#!/bin/bash
# Renombrar screenshots con fecha actual
DATE=$(date +"%Y-%m-%d")
for file in *.png; do
    mv "$file" "${DATE}_${file}"
done
```

### Template para Documentación
```markdown
## [FECHA] - TITULO_DEL_CAMBIO

### Descripción
[Descripción del cambio]

### Screenshots
- **Before**: ![Before](screenshots/before/FECHA_descripcion_before.png)
- **After**: ![After](screenshots/after/FECHA_descripcion_after.png)
- **Feature**: ![Feature](screenshots/features/FECHA_descripcion_feature.png)

### Archivos Modificados
- [Lista de archivos]
```

---

**Nota**: Mantener este archivo actualizado con nuevas convenciones según evolucione el proyecto.