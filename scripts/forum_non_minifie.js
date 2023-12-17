(function () {

    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);
    
    function initialiser(evt){
        let boutonQuestion = document.querySelector(".cercle");
    boutonQuestion.addEventListener("click", interactionQuestion);

    let boutonCroix = document.querySelector(".fermer");
    boutonCroix.addEventListener("click", interactionCroix);

    let boutonMessage = document.querySelector(".rondMessage");
    boutonMessage.addEventListener("click", interactionMessage);
}

function interactionQuestion(evt){
    let question = document.querySelector(".popup");
    question.classList.toggle("open");
}

function interactionCroix(evt){
    let croix = document.querySelector(".popup");
    croix.classList.toggle("open");
}

function interactionMessage(evt){
    let message = document.querySelector(".publierMessage");
    let rond = document.querySelector(".rondMessage");
    message.classList.toggle("open");
    rond.classList.toggle("open");
    
}


}());