# Guía de Mantenimiento - Mikels E-commerce

## Rutinas de Mantenimiento Regular

### Diario
- [ ] Verificar funcionamiento del sitio web
- [ ] Revisar órdenes de WooCommerce
- [ ] Monitorear logs de errores
- [ ] Verificar backups automáticos

### Semanal
- [ ] Revisar velocidad del sitio
- [ ] Actualizar contenido si es necesario
- [ ] Verificar funcionalidad de formularios
- [ ] Revisar métricas de Google Analytics
- [ ] Limpiar spam de comentarios

### Mensual
- [ ] Actualizar plugins no críticos
- [ ] Revisar y optimizar base de datos
- [ ] Verificar SSL y seguridad
- [ ] Analizar performance y Core Web Vitals
- [ ] Backup completo manual

### Trimestral
- [ ] Actualizar WordPress core
- [ ] Actualizar tema Blocksy
- [ ] Revisar y actualizar personalizaciones
- [ ] Auditoría de seguridad completa
- [ ] Optimización de imágenes

## Backup y Restauración

### Estrategia de Backup
```bash
#!/bin/bash
# Script de backup completo

# Variables
DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/backups/mikels-website"
DB_NAME="mikels_wordpress"
WP_DIR="/var/www/html"

# Crear directorio de backup
mkdir -p $BACKUP_DIR/$DATE

# Backup de base de datos
wp db export $BACKUP_DIR/$DATE/database_$DATE.sql --path=$WP_DIR

# Backup de archivos
tar -czf $BACKUP_DIR/$DATE/files_$DATE.tar.gz \
    --exclude="wp-content/cache" \
    --exclude="wp-content/logs" \
    $WP_DIR/wp-content

# Backup de personalizaciones
tar -czf $BACKUP_DIR/$DATE/customizations_$DATE.tar.gz \
    $WP_DIR/wp-content/themes/blocksy-child

echo "Backup completado en $BACKUP_DIR/$DATE"
```

### Restauración de Backup
```bash
#!/bin/bash
# Script de restauración

BACKUP_DATE="20240315_143000"
BACKUP_DIR="/backups/mikels-website/$BACKUP_DATE"
WP_DIR="/var/www/html"

# Restaurar base de datos
wp db import $BACKUP_DIR/database_$BACKUP_DATE.sql --path=$WP_DIR

# Restaurar archivos
cd $WP_DIR
tar -xzf $BACKUP_DIR/files_$BACKUP_DATE.tar.gz

# Restaurar personalizaciones
tar -xzf $BACKUP_DIR/customizations_$BACKUP_DATE.tar.gz

echo "Restauración completada desde $BACKUP_DATE"
```

## Actualización de WordPress y Plugins

### Procedimiento de Actualización Segura

#### Pre-actualización
1. **Crear backup completo**
   ```bash
   wp db export pre-update-$(date +%Y%m%d).sql
   tar -czf pre-update-files-$(date +%Y%m%d).tar.gz wp-content/
   ```

2. **Verificar compatibilidad**
   - Revisar changelog de WordPress/plugins
   - Verificar compatibilidad con tema Blocksy
   - Comprobar personalizaciones afectadas

3. **Preparar entorno de staging**
   ```bash
   # Clonar sitio a staging
   wp db search-replace 'https://mikels.com' 'https://staging.mikels.com'
   ```

#### Durante la actualización
1. **Actualizar en staging primero**
   ```bash
   wp core update
   wp plugin update --all
   wp theme update blocksy
   ```

2. **Testing en staging**
   - Verificar funcionamiento general
   - Probar checkout de WooCommerce
   - Validar personalizaciones CSS/JS
   - Revisar formularios de contacto

3. **Aplicar en producción**
   - Solo si staging funciona correctamente
   - Durante horario de bajo tráfico
   - Monitorear durante y después

#### Post-actualización
1. **Verificación inmediata**
   - [ ] Sitio carga correctamente
   - [ ] Login de admin funciona
   - [ ] WooCommerce operativo
   - [ ] Personalizaciones intactas

2. **Testing completo**
   - [ ] Proceso de compra completo
   - [ ] Formularios funcionando
   - [ ] Velocidad del sitio estable
   - [ ] Enlaces no rotos

## Optimización de Performance

### Limpieza de Base de Datos
```sql
-- Limpiar revisiones antigas
DELETE FROM wp_posts WHERE post_type = 'revision' AND post_date < DATE_SUB(NOW(), INTERVAL 30 DAY);

-- Limpiar spam y comentarios rechazados
DELETE FROM wp_comments WHERE comment_approved = 'spam' OR comment_approved = 'trash';

-- Limpiar transients expirados
DELETE FROM wp_options WHERE option_name LIKE '_transient_%' AND option_value < UNIX_TIMESTAMP();

-- Optimizar tablas
OPTIMIZE TABLE wp_posts, wp_comments, wp_options, wp_postmeta, wp_commentmeta;
```

### Optimización de Imágenes
```bash
# Script para optimizar imágenes existentes
find wp-content/uploads -name "*.jpg" -exec jpegoptim --max=85 {} \;
find wp-content/uploads -name "*.png" -exec optipng -o2 {} \;

# Convertir a WebP (si soportado)
find wp-content/uploads -name "*.jpg" -exec cwebp -q 85 {} -o {}.webp \;
```

### Cache Management
```php
// Limpiar cache programáticamente
function mikels_clear_all_cache() {
    // WP Rocket
    if (function_exists('rocket_clean_domain')) {
        rocket_clean_domain();
    }
    
    // W3 Total Cache
    if (function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
    
    // Object Cache
    wp_cache_flush();
}
```

## Monitoreo y Alertas

### Logs Importantes
```bash
# Logs de errores de WordPress
tail -f wp-content/debug.log

# Logs del servidor web
tail -f /var/log/apache2/error.log
tail -f /var/log/nginx/error.log

# Logs de PHP
tail -f /var/log/php/error.log
```

### Métricas a Monitorear
- **Tiempo de carga**: < 3 segundos
- **Uptime**: > 99.9%
- **Core Web Vitals**: Todos en verde
- **Errores 404**: Minimizar
- **Uso de memoria**: Mantener bajo control

### Alertas Automáticas
```bash
# Script de monitoreo básico
#!/bin/bash
SITE_URL="https://mikels.com"
STATUS=$(curl -s -o /dev/null -w "%{http_code}" $SITE_URL)

if [ $STATUS -ne 200 ]; then
    echo "ALERTA: Sitio web no responde - Código: $STATUS" | mail -s "Sitio Down" admin@mikels.com
fi

# Verificar espacio en disco
DISK_USAGE=$(df / | awk 'NR==2 {print $5}' | cut -d'%' -f1)
if [ $DISK_USAGE -gt 85 ]; then
    echo "ALERTA: Espacio en disco al $DISK_USAGE%" | mail -s "Espacio en Disco" admin@mikels.com
fi
```

## Seguridad y Hardening

### Checklist de Seguridad
- [ ] WordPress, tema y plugins actualizados
- [ ] Contraseñas fuertes para todos los usuarios
- [ ] Certificado SSL válido y configurado
- [ ] Plugin de seguridad instalado y configurado
- [ ] Backups automáticos funcionando
- [ ] Logs de seguridad revisados
- [ ] Acceso FTP/SSH limitado

### Hardening de WordPress
```php
// wp-config.php security enhancements
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);
define('FORCE_SSL_ADMIN', true);
define('WP_POST_REVISIONS', 3);
define('AUTOSAVE_INTERVAL', 300);
```

### .htaccess Security Rules
```apache
# Proteger wp-config.php
<files wp-config.php>
order allow,deny
deny from all
</files>

# Bloquear acceso a archivos sensibles
<FilesMatch "^(wp-config|install|readme|license|changelog)">
order allow,deny
deny from all
</FilesMatch>

# Limitar intentos de login
<Limit POST>
order allow,deny
allow from all
deny from 192.168.1.1
</Limit>
```

## Resolución de Problemas Comunes

### Sitio en Blanco (White Screen of Death)
1. Verificar logs de errores PHP
2. Activar modo debug en wp-config.php
3. Desactivar plugins uno por uno
4. Cambiar a tema por defecto temporalmente
5. Verificar memoria PHP disponible

### Problemas de WooCommerce
1. Limpiar cache del sitio
2. Re-guardar configuración de permalinks
3. Verificar páginas de WooCommerce configuradas
4. Revisar configuración de métodos de pago
5. Comprobar configuración de shipping

### Lentitud del Sitio
1. Analizar con GTmetrix o PageSpeed Insights
2. Optimizar imágenes grandes
3. Revisar plugins innecesarios
4. Verificar configuración de cache
5. Optimizar base de datos

---

**Recordatorio**: Documentar todos los mantenimientos realizados con fecha, descripción y resultado en el log de mantenimiento.