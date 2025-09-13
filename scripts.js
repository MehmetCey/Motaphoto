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

/* burger menu */

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

/* charger plus */

// jQuery(document).ready(function($){
//   let page = 2;

//   function getFilters() {
//     return {
//       categorie: $('.custom-dropdown[data-name="categorie"] .dropdown-selected').data('value') || '',
//       format: $('.custom-dropdown[data-name="format"] .dropdown-selected').data('value') || '',
//       tri: $('.custom-dropdown[data-name="tri"] .dropdown-selected').data('value') || ''
//     };
//   }

//   function loadPhotos(paged = 1, append = true) {
//     let filters = getFilters();

//     $.ajax({
//       url: mon_ajax_obj.ajaxurl,
//       type: 'POST',
//       dataType: 'json',
//       data: {
//         action: 'charger_toutes_photos',
//         categorie: filters.categorie,
//         format: filters.format,
//         tri: filters.tri,
//         paged: paged
//       },
//       success: function(response) {
//         if (append) {
//           $('.related-photos-container').append(response.html);
//         } else {
//           $('.related-photos-container').html(response.html);
//         }

//         if (response.remaining <= 0) {
//           $('#charger-plus').hide();
//         } else {
//           $('#charger-plus').show();
//         }
//       }
//     });
//   }

//   // Bouton "Charger plus"
//   $('#charger-plus').on('click', function(){
//     loadPhotos(page);
//     page++;
//   });

//   // Filtrage → reset page + recharge
//   $('.custom-dropdown .dropdown-options li').on('click', function(){
//     page = 2;
//     loadPhotos(1, false);
//   });
// });


// /* filtrage */

// jQuery(document).ready(function($) {
//     function updatePhotos() {
//         var categorie = $('.custom-dropdown[data-name="categorie"] .dropdown-selected').data('value') || '';
//         var format    = $('.custom-dropdown[data-name="format"] .dropdown-selected').data('value') || '';
//         var tri       = $('.custom-dropdown[data-name="tri"] .dropdown-selected').data('value') || '';

//         $.ajax({
//             url: mon_ajax_obj.ajaxurl,
//             type: 'POST',
//             data: {
//                 action: 'filtrer_photos',
//                 categorie: categorie,
//                 format: format,
//                 tri: tri
//             },
//             success: function(response) {
//                 $('.related-photos-container').html(response);
//             }
//         });
//     }

//     // Gestion du clic sur une option
//     $('.custom-dropdown .dropdown-options li').on('click', function() {
//         var $dropdown = $(this).closest('.custom-dropdown');
//         var $selected = $dropdown.find('.dropdown-selected');

//         // mettre à jour le texte et la valeur
//         $selected.text($(this).text());
//         $selected.data('value', $(this).data('value'));

//         $dropdown.removeClass('open');

//         // déclencher le filtrage
//         updatePhotos();
//     });

//     // Ouverture/fermeture du dropdown
//     $('.dropdown-selected').on('click', function(e) {
//         e.stopPropagation();
//         var $dropdown = $(this).closest('.custom-dropdown');
//         $('.custom-dropdown').not($dropdown).removeClass('open'); // ferme les autres
//         $dropdown.toggleClass('open');
//     });

//     // Fermer en cliquant à l’extérieur
//     $(document).on('click', function() {
//         $('.custom-dropdown').removeClass('open');
//     });
// });

jQuery(document).ready(function($) {
  let currentIndex = -1;
  let photos = [];
  let page = 1;

  // -------- buildPhotos (reconstruit la liste pour la lightbox) --------
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

  // -------- ouverture lightbox --------
  function openLightbox(index) {
    currentIndex = index;
    $('#lightbox-img').attr('src', photos[index].src);
    $('#lightbox-ref').text(photos[index].ref || '');
    $('#lightbox-cat').text(photos[index].cat || '');
    $('#lightbox-overlay').css('display', 'flex');
  }

  $(document).on('click', '.fullscreen-icon', function(e) {
    e.preventDefault();
    let img = $(this).closest('.related-thumbnail').find('img');
    let src = img.data('full');

    // On cherche l'image cliquée dans le tableau photos[]
    let index = photos.findIndex(p => p.src === src);
    if (index !== -1) openLightbox(index);
  });

  $('.lightbox-close, #lightbox-overlay').on('click', function(e) {
    if ($(e.target).is('#lightbox-overlay, .lightbox-close')) {
      $('#lightbox-overlay').hide();
    }
  });

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

  // -------- getFilters (valeurs des faux dropdowns) --------
  function getFilters() {
    return {
      categorie: $('.custom-dropdown[data-name="categorie"] .dropdown-selected').data('value') || '',
      format: $('.custom-dropdown[data-name="format"] .dropdown-selected').data('value') || '',
      tri: $('.custom-dropdown[data-name="tri"] .dropdown-selected').data('value') || ''
    };
  }

  // -------- loadPhotos (filtrage + pagination) --------
  function loadPhotos(paged = 1, append = false) {
    let filters = getFilters();

    $.ajax({
      url: mon_ajax_obj.ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'charger_toutes_photos',
        categorie: filters.categorie,
        format: filters.format,
        tri: filters.tri,
        paged: paged
      },
      success: function(response) {
        if (append) {
          $('.related-photos-container').append(response.html);
        } else {
          $('.related-photos-container').html(response.html);
        }

        // rebuild la liste des photos pour lightbox
        buildPhotos();

        // gestion du bouton charger plus
        if (response.remaining <= 0) {
          $('#charger-plus').hide();
        } else {
          $('#charger-plus').show();
        }
      }
    });
  }

  // -------- Dropdown : sélection d'une option --------
  $(document).on('click', '.custom-dropdown .dropdown-options li', function() {
    let $dropdown = $(this).closest('.custom-dropdown');
    let $selected = $dropdown.find('.dropdown-selected');

    // Mettre à jour texte et valeur
    $selected.text($(this).text());
    $selected.data('value', $(this).data('value'));

    $dropdown.removeClass('open');

    // Filtrage dès le premier clic
    page = 1;
    loadPhotos(1, false);
  });

  // -------- Dropdown : ouverture/fermeture --------
  $(document).on('click', '.dropdown-selected', function(e) {
    e.stopPropagation();
    let $dropdown = $(this).closest('.custom-dropdown');
    $('.custom-dropdown').not($dropdown).removeClass('open');
    $dropdown.toggleClass('open');
  });

  // Fermer dropdown en cliquant à l’extérieur
  $(document).on('click', function() {
    $('.custom-dropdown').removeClass('open');
  });

  // -------- Bouton "Charger plus" --------
  $('#charger-plus').on('click', function() {
    page++;
    loadPhotos(page, true);
  });

  // -------- Initialisation --------
  buildPhotos();
});
