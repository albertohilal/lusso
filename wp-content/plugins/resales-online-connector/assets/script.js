/**
 * JavaScript para el conector de Resales Online
 */

jQuery(document).ready(function($) {
    
    // Funcionalidad para filtros dinámicos (si se implementa)
    $('.resales-filter-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $container = $('.resales-properties-grid');
        var $loader = $('<div class="resales-loader"></div>');
        
        // Mostrar loader
        $container.html($loader);
        
        // Obtener datos del formulario
        var formData = {
            action: 'resales_filter_properties',
            nonce: resales_ajax.nonce,
            location: $form.find('[name="location"]').val(),
            property_type: $form.find('[name="property_type"]').val(),
            min_price: $form.find('[name="min_price"]').val(),
            max_price: $form.find('[name="max_price"]').val(),
            bedrooms: $form.find('[name="bedrooms"]').val(),
        };
        
        // Hacer petición AJAX
        $.post(resales_ajax.ajax_url, formData, function(response) {
            if (response.success) {
                $container.html(response.data.html);
            } else {
                $container.html('<div class="resales-error">Error al cargar las propiedades</div>');
            }
        }).fail(function() {
            $container.html('<div class="resales-error">Error de conexión</div>');
        });
    });
    
    // Lazy loading para imágenes (mejora de rendimiento)
    if ('IntersectionObserver' in window) {
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(function(img) {
            imageObserver.observe(img);
        });
    }
    
    // Funcionalidad para favoritos (opcional)
    $('.btn-favorite').on('click', function(e) {
        e.preventDefault();
        
        var $btn = $(this);
        var propertyId = $btn.data('property-id');
        
        $.post(resales_ajax.ajax_url, {
            action: 'resales_toggle_favorite',
            nonce: resales_ajax.nonce,
            property_id: propertyId
        }, function(response) {
            if (response.success) {
                $btn.toggleClass('favorited');
                $btn.find('i').toggleClass('fas far');
            }
        });
    });
    
    // Tooltip para características de propiedades
    $('.feature[title]').each(function() {
        $(this).tooltip({
            position: { my: "center bottom-20", at: "center top" }
        });
    });
    
    // Animación smooth para cards
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            once: true
        });
    }
    
    // Función para formatear precios
    function formatPrice(price) {
        return new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'EUR'
        }).format(price);
    }
    
    // Modal para galería de imágenes (opcional)
    $('.property-image').on('click', function() {
        var propertyId = $(this).closest('.resales-property-card').data('property-id');
        if (propertyId) {
            openImageGallery(propertyId);
        }
    });
    
    function openImageGallery(propertyId) {
        // Implementar modal para galería de imágenes
        // Esto requeriría una petición adicional a la API para obtener todas las imágenes
    }
    
});
