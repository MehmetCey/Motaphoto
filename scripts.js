document.addEventListener("DOMContentLoaded", function () {
    let monBouton = document.querySelector(".popup-close");
    let monPopup = document.querySelector(".contact-overlay");
    let monBoutonContact = document.querySelector(".contact-button");

    if (monBouton && monPopup) {
        monBouton.addEventListener("click", function () {
            monPopup.classList.add("popup-display-none");
        });
    }

    if (monBoutonContact && monPopup) {
        monBoutonContact.addEventListener("click", function () {
            monPopup.classList.remove("popup-display-none");
        });
    }

    jQuery(document).ready(function($) {
    $('#ref-photo').val(photoRef);
    });

});

