jQuery(document).ready(function($) {
    let currentIndex = -1;
    let photos = [];

    // lightbox.js
window.buildPhotos = function() {
  photos = [];
  jQuery('.related-thumbnail img').each(function() {
    photos.push({
      src: jQuery(this).data('full'),
      ref: jQuery(this).data('reference'),
      cat: jQuery(this).data('category')
    });
  });
  window.photos = photos; // accessible globalement
};


    // Construire au premier chargement
    buildPhotos();

    // ouvrir lightbox
    function openLightbox(index) {
        currentIndex = index;
        $('#lightbox-img').attr('src', photos[index].src);
        $('#lightbox-ref').text(photos[index].ref || '');
        $('#lightbox-cat').text(photos[index].cat || '');
        $('#lightbox-overlay').css('display', 'flex');
    }

    // clic sur fullscreen
    $(document).on('click', '.fullscreen-icon', function(e) {
        e.preventDefault();
        let img = $(this).closest('.related-thumbnail').find('img');
        let index = $('.related-thumbnail img').index(img);
        openLightbox(index);
    });

    // fermer
    $('.lightbox-close, #lightbox-overlay').on('click', function(e) {
        if ($(e.target).is('#lightbox-overlay, .lightbox-close')) {
            $('#lightbox-overlay').hide();
        }
    });

    // navigation
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

    // Filtrage
    function updatePhotos() {
        var categorie = $('#filtre-categorie').val();
        var format    = $('#filtre-format').val();
        var tri       = $('#tri-photos').val();

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
                buildPhotos();
                $('#charger-plus').hide();
            }
        });
    }
    $('#filtre-categorie, #filtre-format, #tri-photos').on('change', updatePhotos);
});

