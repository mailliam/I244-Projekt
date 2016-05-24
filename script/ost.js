//window.onload = function() {
//    reaSumma();

//}

//Kasutatud õpetust http://www.javascript-coder.com/javascript-form/javascript-calculator-script.phtml

function reaSumma() {

    var vorm = document.forms["ostulisamine"];

    var koguseLahter = vorm.elements["kogus"];
    var kogus = 0;
    if(koguseLahter.value!="") {
        kogus = (koguseLahter.value);
    }

    var hinnaLahter = vorm.elements["hind"];
    var hind = 0;
    if(hinnaLahter.value!="") {
        hind = (hinnaLahter.value);
    }

    var ostusumma = 0;
    var summa = (kogus * hind).toFixed(2);

    ostusumma = ostusumma + summa;

    document.getElementById("summa").innerHTML = summa;
    document.getElementById("ostusumma").innerHTML = ostusumma;

}
