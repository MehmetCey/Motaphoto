jQuery(document).ready(function($) {
    let currentIndex = -1;
    let photos = [];

    // -------------------------
    // Reconstruire la liste photos[]
    // -------------------------
    window.buildPhotos = function() {
        photos = [];
        $('.related-thumbnail img').each(function() {
            photos.push({
                src: $(this).data('full'),
                ref: $(this).data('reference'),
                cat: $(this).data('category')
            });
        });
    };

    // Construire au premier chargement
    buildPhotos();

    // -------------------------
    // Ouvrir la lightbox
    // -------------------------
    function openLightbox(index) {
        currentIndex = index;
        $('#lightbox-img').attr('src', photos[index].src);
        $('#lightbox-ref').text(photos[index].ref || '');
        $('#lightbox-cat').text(photos[index].cat || '');
        $('#lightbox-overlay').css('display', 'flex');
    }

    // -------------------------
    // Clic sur fullscreen
    // -------------------------
    $(document).on('click', '.fullscreen-icon', function(e) {
        e.preventDefault();
        let img = $(this).closest('.related-thumbnail').find('img');
        let src = img.data('full');

        // Important : rebuild à chaque clic, au cas où du contenu a changé
        buildPhotos();

        // Normaliser les URLs pour éviter les soucis de slash ou tailles différentes
        src = decodeURIComponent(src);

        let index = photos.findIndex(p => decodeURIComponent(p.src) === src);

        if (index !== -1) {
            openLightbox(index);
        }
    });

    // -------------------------
    // Fermer lightbox
    // -------------------------
    $('.lightbox-close, #lightbox-overlay').on('click', function(e) {
        if ($(e.target).is('#lightbox-overlay, .lightbox-close')) {
            $('#lightbox-overlay').hide();
        }
    });

    // -------------------------
    // Navigation
    // -------------------------
    $('.lightbox-prev').on('click', function(e) {
        e.stopPropagation();
        if (currentIndex > 0) {
            openLightbox(currentIndex - 1);
        } else {
            openLightbox(photos.length - 1);
        }
    });

    $('.lightbox-next').on('click', function(e) {
        e.stopPropagation();
        if (currentIndex < photos.length - 1) {
            openLightbox(currentIndex + 1);
        } else {
            openLightbox(0);
        }
    });

    // -------------------------
    // Filtrage (Ajax)
    // -------------------------
    function updatePhotos() {
    var categorie = $('#filtre-categorie').val();
    var format    = $('#filtre-format').val();
    var tri       = $('#tri-photos').val();

    // Reset pagination
    page = 2;

    $.ajax({
        url: mon_ajax_obj.ajaxurl,
        type: 'POST',
        data: {
            action: 'filtrer_photos',
            categorie: categorie,
            format: format,
            tri: tri
        },
        success: function(response) {
            $('.related-photos-container').html(response);

            // Toujours rebuild les photos après un rendu Ajax
            buildPhotos();

            // Cacher le bouton charger plus après filtrage
            $('#charger-plus').hide();
        }
    });
}


    $('#filtre-categorie, #filtre-format, #tri-photos').on('change', function(){
        updatePhotos();
    });
});
