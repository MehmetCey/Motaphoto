document.addEventListener("DOMContentLoaded", function () {
    let monBouton = document.querySelector(".popup-close");
    let monPopupbackdrop = document.querySelector(".contact-backdrop");
    let monPopup = document.querySelector(".contact-overlay");
    let monBoutonContact = document.querySelector(".contact-button");
    let monBoutonContactMenu = document.querySelectorAll(".contact-popup");

    /* fermeture sur croix */
if (monBouton && monPopup) {
        monBouton.addEventListener("click", function () {
            monPopup.classList.add("popup-display-none");
            monPopupbackdrop.classList.add("popup-display-none");
        });
      }
/* fermeture au clic en dehors de l'overlay */

        monPopupbackdrop.addEventListener("click", function () {
            monPopup.classList.add("popup-display-none");
            monPopupbackdrop.classList.add("popup-display-none");
        });
/* ouverture sur bouton dans single page */
if (monBoutonContact && monPopup) {
        monBoutonContact.addEventListener("click", function () {
            monPopup.classList.remove("popup-display-none");
            monPopupbackdrop.classList.remove("popup-display-none");
        });
      }
/* ouverture au clic sur contact dans menu */
monBoutonContactMenu.forEach(function(bouton) {
    bouton.addEventListener("click", function (e) {
        e.preventDefault(); // évite le scroll en haut
        monPopup.classList.remove("popup-display-none");
        monPopupbackdrop.classList.remove("popup-display-none");
    });
});

    jQuery(document).ready(function($) {
    $('#ref-photo').val(photoRef);
    });


});

document.addEventListener("DOMContentLoaded", () => {
  const openBtn = document.getElementById("burger-menu");
  const closeBtn = document.getElementById("burger-close");
  const overlay = document.getElementById("mobile-menu-overlay");

  openBtn.addEventListener("click", () => {
    overlay.classList.remove("popup-display-none");
    openBtn.classList.add("popup-display-none");
    closeBtn.classList.remove("popup-display-none");
  });

  closeBtn.addEventListener("click", () => {
    overlay.classList.add("popup-display-none");
    closeBtn.classList.add("popup-display-none");
    openBtn.classList.remove("popup-display-none");
  });
});


jQuery(document).ready(function($){
  let page = 2;

  function loadPhotos(paged = 1, append = true) {
    let categorie = $('#filtre-categorie').val();
    let format    = $('#filtre-format').val();
    let tri       = $('#tri-photos').val();

    $.ajax({
      url: mon_ajax_obj.ajaxurl,
      type: 'POST',
      dataType: 'json', // on attend du JSON
      data: {
        action: 'charger_toutes_photos',
        categorie: categorie,
        format: format,
        tri: tri,
        paged: paged
      },
      success: function(response) {
        if (append) {
          $('.related-photos-container').append(response.html);
        } else {
          $('.related-photos-container').html(response.html);
        }

        if (response.remaining <= 0) {
          $('#charger-plus').hide();
        } else {
          $('#charger-plus').show();
        }
      }
    });
  }

  $('#charger-plus').on('click', function(){
    loadPhotos(page);
    page++;
  });

  $('#filtre-categorie, #filtre-format, #tri-photos').on('change', function(){
    page = 2;
    loadPhotos(1, false);
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

