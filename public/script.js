console.log('iaidfgdfgdfgdfgdf');

const txtAnim = document.getElementById('prendre_rdv_accueil_id');


new Typewriter(txtAnim, {
        deleteSpeed: 20
})

.changeDelay(80)
.typeString('Réservez votre consultation chez ')
.pauseFor(200)
.typeString('<span class="flex">un professionnel de santé</span>')
.start()

$(document).ready(function(){
    $("#fmfmc2").fadeIn(1000);
    $("#fmfmc3").fadeIn(2000);

    });