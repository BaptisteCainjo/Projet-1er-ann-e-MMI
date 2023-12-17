(function () {

"use strict";
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt){
    let boutonMenu = document.querySelector("#mobileMenu");
    boutonMenu.addEventListener("click", interactionMenu);
}

function interactionMenu(evt){
    let menu = document.querySelector(".menu");
    menu.classList.toggle("open");
}

}());