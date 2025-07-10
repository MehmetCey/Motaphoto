let monBouton = document.querySelector(".popup-close");
let monPopup = document.querySelector(".contact-overlay");
monBouton.addEventListener("click", function() {
    monPopup.classList.add("popup-display-none")
})