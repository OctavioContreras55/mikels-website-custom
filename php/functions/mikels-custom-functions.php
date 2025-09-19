<?php
/**
 * Funciones personalizadas para Mikels E-commerce
 * 
 * @package Mikels WordPress Custom
 * @author Mikels Dev Team
 * @version 1.0.0
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Configuración inicial del tema hijo
 */
function mikels_theme_setup() {
    // Soporte para logos personalizados
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Soporte para imágenes destacadas
    add_theme_support('post-thumbnails');

    // Soporte para HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Soporte para colores personalizados en el editor
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => 'Azul Mikels',
            'slug'  => 'mikels-primary',
            'color' => '#007cba',
        ),
        array(
            'name'  => 'Naranja Mikels',
            'slug'  => 'mikels-secondary',
            'color' => '#ff6b35',
        ),
        array(
            'name'  => 'Turquesa Mikels',
            'slug'  => 'mikels-accent',
            'color' => '#4ecdc4',
        ),
    ));

    // Tamaños de imagen personalizados
    add_image_size('mikels-product-thumb', 300, 300, true);
    add_image_size('mikels-hero-banner', 1200, 600, true);
    add_image_size('mikels-blog-thumb', 400, 250, true);
}
add_action('after_setup_theme', 'mikels_theme_setup');

/**
 * Enqueue estilos y scripts personalizados
 */
function mikels_enqueue_assets() {
    // CSS personalizado
    wp_enqueue_style(
        'mikels-custom-css',
        get_stylesheet_directory_uri() . '/css/custom/main.css',
        array(),
        '1.0.0'
    );

    // CSS específico de WooCommerce
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'mikels-woocommerce-css',
            get_stylesheet_directory_uri() . '/css/woocommerce/woocommerce-custom.css',
            array('woocommerce-layout'),
            '1.0.0'
        );
    }

    // JavaScript personalizado
    wp_enqueue_script(
        'mikels-custom-js',
        get_stylesheet_directory_uri() . '/js/custom/main.js',
        array('jquery'),
        '1.0.0',
        true
    );

    // Localizar script para Ajax
    wp_localize_script('mikels-custom-js', 'mikels_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('mikels_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'mikels_enqueue_assets');

/**
 * Agregar CSS personalizado al admin
 */
function mikels_admin_styles() {
    wp_enqueue_style(
        'mikels-admin-css',
        get_stylesheet_directory_uri() . '/css/custom/admin.css',
        array(),
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'mikels_admin_styles');

/**
 * Personalizar el footer de WordPress
 */
function mikels_custom_footer() {
    $current_year = date('Y');
    echo '<p>&copy; ' . $current_year . ' Mikels Herramientas. Todos los derechos reservados.</p>';
}

/**
 * Agregar clases CSS personalizadas al body
 */
function mikels_body_classes($classes) {
    // Agregar clase para páginas de WooCommerce
    if (class_exists('WooCommerce')) {
        if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
            $classes[] = 'mikels-woocommerce-page';
        }
    }

    // Agregar clase para móviles
    if (wp_is_mobile()) {
        $classes[] = 'mikels-mobile';
    }

    return $classes;
}
add_filter('body_class', 'mikels_body_classes');

/**
 * Personalizar excerpt length
 */
function mikels_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'mikels_excerpt_length');

/**
 * Personalizar excerpt more
 */
function mikels_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '" class="mikels-read-more">Leer más</a>';
}
add_filter('excerpt_more', 'mikels_excerpt_more');

/**
 * Agregar meta box personalizado para páginas
 */
function mikels_add_custom_meta_box() {
    add_meta_box(
        'mikels-page-options',
        'Opciones de Página Mikels',
        'mikels_page_options_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mikels_add_custom_meta_box');

/**
 * Callback para meta box personalizado
 */
function mikels_page_options_callback($post) {
    wp_nonce_field('mikels_page_options_nonce', 'mikels_page_options_nonce_field');
    
    $show_hero = get_post_meta($post->ID, '_mikels_show_hero', true);
    $hero_image = get_post_meta($post->ID, '_mikels_hero_image', true);
    $hero_title = get_post_meta($post->ID, '_mikels_hero_title', true);
    
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="mikels_show_hero">Mostrar Hero Banner</label></th>';
    echo '<td><input type="checkbox" id="mikels_show_hero" name="mikels_show_hero" value="1" ' . checked(1, $show_hero, false) . ' /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="mikels_hero_title">Título del Hero</label></th>';
    echo '<td><input type="text" id="mikels_hero_title" name="mikels_hero_title" value="' . esc_attr($hero_title) . '" style="width:100%;" /></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th><label for="mikels_hero_image">Imagen del Hero</label></th>';
    echo '<td>';
    echo '<input type="text" id="mikels_hero_image" name="mikels_hero_image" value="' . esc_attr($hero_image) . '" style="width:70%;" />';
    echo '<button type="button" class="button" onclick="mikelsSelectImage()">Seleccionar Imagen</button>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    
    // JavaScript para selector de medios
    echo '<script>
    function mikelsSelectImage() {
        var mediaUploader = wp.media({
            title: "Seleccionar Imagen Hero",
            button: { text: "Usar esta imagen" },
            multiple: false
        });
        
        mediaUploader.on("select", function() {
            var attachment = mediaUploader.state().get("selection").first().toJSON();
            document.getElementById("mikels_hero_image").value = attachment.url;
        });
        
        mediaUploader.open();
    }
    </script>';
}

/**
 * Guardar meta box personalizado
 */
function mikels_save_page_options($post_id) {
    if (!isset($_POST['mikels_page_options_nonce_field']) || 
        !wp_verify_nonce($_POST['mikels_page_options_nonce_field'], 'mikels_page_options_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    $show_hero = isset($_POST['mikels_show_hero']) ? 1 : 0;
    update_post_meta($post_id, '_mikels_show_hero', $show_hero);
    
    if (isset($_POST['mikels_hero_title'])) {
        update_post_meta($post_id, '_mikels_hero_title', sanitize_text_field($_POST['mikels_hero_title']));
    }
    
    if (isset($_POST['mikels_hero_image'])) {
        update_post_meta($post_id, '_mikels_hero_image', esc_url_raw($_POST['mikels_hero_image']));
    }
}
add_action('save_post', 'mikels_save_page_options');

/**
 * Crear widget area personalizada
 */
function mikels_register_sidebars() {
    register_sidebar(array(
        'name'          => 'Sidebar Tienda Mikels',
        'id'            => 'mikels-shop-sidebar',
        'description'   => 'Widgets para páginas de tienda y productos',
        'before_widget' => '<div id="%1$s" class="mikels-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="mikels-widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => 'Footer Mikels',
        'id'            => 'mikels-footer',
        'description'   => 'Widgets para el footer del sitio',
        'before_widget' => '<div id="%1$s" class="mikels-footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="mikels-footer-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'mikels_register_sidebars');

/**
 * Optimización: Eliminar query strings de archivos estáticos
 */
function mikels_remove_query_strings($src) {
    $rqp = strpos($src, '?');
    if ($rqp !== false) {
        return substr($src, 0, $rqp);
    }
    return $src;
}
add_filter('script_loader_src', 'mikels_remove_query_strings', 15, 1);
add_filter('style_loader_src', 'mikels_remove_query_strings', 15, 1);

/**
 * Optimización: Defer parsing of JavaScript
 */
function mikels_defer_parsing_js($url) {
    if (is_admin()) return $url;
    if (FALSE === strpos($url, '.js')) return $url;
    if (strpos($url, 'jquery.js')) return $url;
    return str_replace(' src', ' defer src', $url);
}
add_filter('script_loader_tag', 'mikels_defer_parsing_js', 10);

/**
 * Función helper: Obtener productos destacados
 */
function mikels_get_featured_products($limit = 4) {
    if (!class_exists('WooCommerce')) {
        return array();
    }

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'   => '_featured',
                'value' => 'yes'
            )
        ),
        'post_status' => 'publish'
    );

    return get_posts($args);
}

/**
 * Función helper: Formatear precio
 */
function mikels_format_price($price) {
    if (!class_exists('WooCommerce')) {
        return '$' . number_format($price, 2);
    }
    
    return wc_price($price);
}

/**
 * Ajax handler: Añadir producto al carrito
 */
function mikels_ajax_add_to_cart() {
    check_ajax_referer('mikels_nonce', 'nonce');

    if (!class_exists('WooCommerce')) {
        wp_die('WooCommerce no está activo');
    }

    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']) ?: 1;

    $result = WC()->cart->add_to_cart($product_id, $quantity);

    if ($result) {
        wp_send_json_success(array(
            'message' => 'Producto añadido al carrito',
            'cart_count' => WC()->cart->get_cart_contents_count()
        ));
    } else {
        wp_send_json_error('Error al añadir producto al carrito');
    }
}
add_action('wp_ajax_mikels_add_to_cart', 'mikels_ajax_add_to_cart');
add_action('wp_ajax_nopriv_mikels_add_to_cart', 'mikels_ajax_add_to_cart');

/**
 * Personalizar login de WordPress
 */
function mikels_login_logo() {
    echo '<style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(' . get_stylesheet_directory_uri() . '/images/mikels-logo.png);
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 30px;
            width: 100%;
        }
    </style>';
}
add_action('login_enqueue_scripts', 'mikels_login_logo');

/**
 * Debug helper: Log personalizado
 */
function mikels_log($message, $data = null) {
    if (WP_DEBUG === true) {
        if ($data) {
            error_log('MIKELS DEBUG: ' . $message . ' - ' . print_r($data, true));
        } else {
            error_log('MIKELS DEBUG: ' . $message);
        }
    }
}

/**
 * Añadir soporte para WebP
 */
function mikels_enable_webp_upload($mime_types) {
    $mime_types['webp'] = 'image/webp';
    return $mime_types;
}
add_filter('upload_mimes', 'mikels_enable_webp_upload');

/**
 * Mostrar aviso si falta WooCommerce
 */
function mikels_woocommerce_notice() {
    if (!class_exists('WooCommerce')) {
        echo '<div class="notice notice-error"><p>';
        echo '<strong>Mikels Custom:</strong> Este tema requiere WooCommerce para funcionar correctamente. ';
        echo '<a href="' . admin_url('plugin-install.php?s=woocommerce&tab=search&type=term') . '">Instalar WooCommerce</a>';
        echo '</p></div>';
    }
}
add_action('admin_notices', 'mikels_woocommerce_notice');