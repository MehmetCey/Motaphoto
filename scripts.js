document.addEventListener("DOMContentLoaded", function () {
    let monBouton = document.querySelector(".popup-close");
    let monPopupbackdrop = document.querySelector(".contact-backdrop");
    let monPopup = document.querySelector(".contact-overlay");
    let monBoutonContact = document.querySelector(".contact-button");
    let monBoutonContactMenu = document.querySelector(".contact-popup");

    if (monBouton && monPopup) {
        monBouton.addEventListener("click", function () {
            monPopup.classList.add("popup-display-none");
            monPopupbackdrop.classList.add("popup-display-none");
        });
    }

    if (monBoutonContact && monPopup) {
        monBoutonContact.addEventListener("click", function () {
            monPopup.classList.remove("popup-display-none");
            monPopupbackdrop.classList.remove("popup-display-none");
        });
    }

    if (monBoutonContactMenu && monPopup) {
        monBoutonContactMenu.addEventListener("click", function () {
            monPopup.classList.remove("popup-display-none");
            monPopupbackdrop.classList.remove("popup-display-none");
        });
    }

    jQuery(document).ready(function($) {
    $('#ref-photo').val(photoRef);
    });

});

jQuery(document).ready(function($){
  $('#charger-plus').on('click', function(){
    let categorie = $('#filtre-categorie').val();
    let format    = $('#filtre-format').val();
    let tri       = $('#tri-photos').val();

    $.ajax({
      url: mon_ajax_obj.ajaxurl,
      type: 'POST',
      data: {
        action: 'charger_toutes_photos',
        categorie: categorie,
        format: format,
        tri: tri
      },
      success: function(response) {
        if (response.trim() !== '') {
          $('.related-photos-container').append(response); // append au lieu de remplacer
          if (typeof buildPhotos === "function") {
            buildPhotos(); // reconstruire la liste pour fullscreen
          }
        } else {
          $('#charger-plus').hide(); // rien à charger → on cache le bouton
        }
      },
    });
  });
});


jQuery(document).ready(function($) {
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
            }
        });
    }

    // Déclencher la mise à jour quand un select change
    $('#filtre-categorie, #filtre-format, #tri-photos').on('change', updatePhotos);
});

