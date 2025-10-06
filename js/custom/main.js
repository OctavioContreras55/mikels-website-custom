/**
 * JavaScript personalizado para Mikels E-commerce
 * 
 * @package Mikels WordPress Custom
 * @author Mikels Dev Team
 * @version 1.0.0
 */

(function($) {
    'use strict';

    // Variables globales
    const Mikels = {
        ajax_url: mikels_ajax.ajax_url,
        nonce: mikels_ajax.nonce,
        cart_count: 0,
        
        // Inicialización
        init: function() {
            this.bindEvents();
            this.initComponents();
            console.log('Mikels Custom JS iniciado');
        },

        // Event listeners
        bindEvents: function() {
            $(document).on('click', '.mikels-add-to-cart', this.addToCart);
            $(document).on('click', '.mikels-quick-view', this.quickView);
            $(document).on('input', '.mikels-search-input', this.liveSearch);
            $(window).on('scroll', this.handleScroll);
            $(window).on('resize', this.handleResize);
        },

        // Inicializar componentes
        initComponents: function() {
            this.initProductGallery();
            this.initMobileMenu();
            this.initScrollAnimations();
            this.initLazyLoading();
        },

        // Añadir al carrito con Ajax
        addToCart: function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const productId = $button.data('product-id');
            const quantity = $button.data('quantity') || 1;
            const originalText = $button.text();

            // Estado de carga
            $button.prop('disabled', true)
                   .addClass('mikels-loading')
                   .text('Añadiendo...');

            $.ajax({
                url: Mikels.ajax_url,
                type: 'POST',
                data: {
                    action: 'mikels_add_to_cart',
                    product_id: productId,
                    quantity: quantity,
                    nonce: Mikels.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $button.removeClass('mikels-loading')
                               .addClass('mikels-success')
                               .text('✓ Añadido');
                        
                        // Actualizar contador del carrito
                        Mikels.updateCartCount(response.data.cart_count);
                        
                        // Mostrar notificación
                        Mikels.showNotification('Producto añadido al carrito', 'success');
                        
                        // Restaurar botón después de 2 segundos
                        setTimeout(() => {
                            $button.prop('disabled', false)
                                   .removeClass('mikels-success')
                                   .text(originalText);
                        }, 2000);
                    } else {
                        Mikels.showNotification('Error al añadir producto', 'error');
                        $button.prop('disabled', false)
                               .removeClass('mikels-loading')
                               .text(originalText);
                    }
                },
                error: function() {
                    Mikels.showNotification('Error de conexión', 'error');
                    $button.prop('disabled', false)
                           .removeClass('mikels-loading')
                           .text(originalText);
                }
            });
        },

        // Vista rápida de producto
        quickView: function(e) {
            e.preventDefault();
            
            const productId = $(this).data('product-id');
            
            // Crear modal
            const modalHtml = `
                <div class="mikels-modal-overlay" id="mikels-quick-view">
                    <div class="mikels-modal">
                        <div class="mikels-modal-header">
                            <h3>Vista Rápida</h3>
                            <button class="mikels-modal-close">&times;</button>
                        </div>
                        <div class="mikels-modal-content">
                            <div class="mikels-loading-spinner">Cargando...</div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modalHtml);
            
            // Cargar contenido del producto
            $.ajax({
                url: Mikels.ajax_url,
                type: 'POST',
                data: {
                    action: 'mikels_quick_view',
                    product_id: productId,
                    nonce: Mikels.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $('#mikels-quick-view .mikels-modal-content').html(response.data.html);
                    }
                }
            });
            
            // Cerrar modal
            $(document).on('click', '.mikels-modal-close, .mikels-modal-overlay', function(e) {
                if (e.target === this) {
                    $('#mikels-quick-view').remove();
                }
            });
        },

        // Búsqueda en tiempo real
        liveSearch: function() {
            const searchTerm = $(this).val();
            const $results = $('.mikels-search-results');
            
            if (searchTerm.length < 3) {
                $results.hide();
                return;
            }
            
            // Debounce
            clearTimeout(Mikels.searchTimeout);
            Mikels.searchTimeout = setTimeout(() => {
                $.ajax({
                    url: Mikels.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'mikels_live_search',
                        search_term: searchTerm,
                        nonce: Mikels.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            $results.html(response.data.html).show();
                        }
                    }
                });
            }, 300);
        },

        // Manejar scroll
        handleScroll: function() {
            const scrollTop = $(window).scrollTop();
            
            // Header sticky
            if (scrollTop > 100) {
                $('.mikels-header').addClass('mikels-sticky');
            } else {
                $('.mikels-header').removeClass('mikels-sticky');
            }
            
            // Botón scroll to top
            if (scrollTop > 500) {
                $('.mikels-scroll-top').fadeIn();
            } else {
                $('.mikels-scroll-top').fadeOut();
            }
        },

        // Manejar resize
        handleResize: function() {
            // Ajustar altura de elementos si es necesario
            Mikels.adjustElementHeights();
        },

        // Galería de productos
        initProductGallery: function() {
            $('.mikels-product-gallery').each(function() {
                const $gallery = $(this);
                const $thumbnails = $gallery.find('.mikels-thumbnail');
                const $mainImage = $gallery.find('.mikels-main-image');
                
                $thumbnails.on('click', function(e) {
                    e.preventDefault();
                    const newSrc = $(this).data('large-image');
                    $mainImage.attr('src', newSrc);
                    $thumbnails.removeClass('active');
                    $(this).addClass('active');
                });
            });
        },

        // Menú móvil
        initMobileMenu: function() {
            $('.mikels-mobile-menu-toggle').on('click', function() {
                $('.mikels-mobile-menu').toggleClass('active');
                $('body').toggleClass('mikels-menu-open');
            });
            
            $('.mikels-mobile-menu-close').on('click', function() {
                $('.mikels-mobile-menu').removeClass('active');
                $('body').removeClass('mikels-menu-open');
            });
        },

        // Animaciones al scroll
        initScrollAnimations: function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('mikels-animate-in');
                    }
                });
            }, observerOptions);
            
            $('.mikels-animate').each(function() {
                observer.observe(this);
            });
        },

        // Lazy loading para imágenes
        initLazyLoading: function() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('mikels-lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });
                
                $('.mikels-lazy').each(function() {
                    imageObserver.observe(this);
                });
            }
        },

        // Actualizar contador del carrito
        updateCartCount: function(count) {
            $('.mikels-cart-count').text(count);
            this.cart_count = count;
        },

        // Mostrar notificaciones
        showNotification: function(message, type = 'info') {
            const notificationHtml = `
                <div class="mikels-notification mikels-notification--${type}">
                    <span class="mikels-notification-message">${message}</span>
                    <button class="mikels-notification-close">&times;</button>
                </div>
            `;
            
            const $notification = $(notificationHtml);
            $('body').append($notification);
            
            // Mostrar con animación
            setTimeout(() => {
                $notification.addClass('mikels-notification--show');
            }, 100);
            
            // Auto cerrar después de 5 segundos
            setTimeout(() => {
                $notification.removeClass('mikels-notification--show');
                setTimeout(() => {
                    $notification.remove();
                }, 300);
            }, 5000);
            
            // Cerrar manualmente
            $notification.find('.mikels-notification-close').on('click', function() {
                $notification.removeClass('mikels-notification--show');
                setTimeout(() => {
                    $notification.remove();
                }, 300);
            });
        },

        // Ajustar alturas de elementos
        adjustElementHeights: function() {
            // Igualar altura de cards en una fila
            $('.mikels-equal-height').each(function() {
                const $container = $(this);
                const $cards = $container.find('.mikels-card');
                let maxHeight = 0;
                
                // Resetear altura
                $cards.css('height', 'auto');
                
                // Encontrar la altura máxima
                $cards.each(function() {
                    const height = $(this).outerHeight();
                    if (height > maxHeight) {
                        maxHeight = height;
                    }
                });
                
                // Aplicar altura máxima
                $cards.css('height', maxHeight);
            });
        },

        // Utilidad: Debounce
        debounce: function(func, wait, immediate) {
            let timeout;
            return function executedFunction() {
                const context = this;
                const args = arguments;
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },

        // Utilidad: Throttle
        throttle: function(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        }
    };

    // Inicializar cuando el DOM esté listo
    $(document).ready(function() {
        Mikels.init();
    });

    // Hacer Mikels disponible globalmente
    window.Mikels = Mikels;

})(jQuery);