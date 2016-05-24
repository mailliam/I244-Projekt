var rida = 0;

function reaSumma() {
//Kasutatud õpetust http://www.javascript-coder.com/javascript-form/javascript-calculator-script.phtml

    for (var i = 0; i < rida+1; i++) {
        var vorm = document.forms["ostulisamine"];

        var koguseLahter = vorm.elements["kogus[".concat(i,"]")];
        var kogus = 0;
        if(koguseLahter.value!="") {
            kogus = (koguseLahter.value);
        }

        var hinnaLahter = vorm.elements["hind[".concat(i,"]")];
        var hind = 0;
        if(hinnaLahter.value!="") {
            hind = (hinnaLahter.value);
        }

        var ostusumma = 0;
        var summa = (kogus * hind).toFixed(2);

        ostusumma = ostusumma + summa;

        document.getElementById("ostusumma").innerHTML = ostusumma;
        document.getElementById("summa[".concat(i,"]")).innerHTML = summa;
        alert(kogus);
        //alert(hind);

    }

}

function uusRida() {
//Kasutatud õpetust http://www.w3schools.com/jsref/met_table_insertrow.asp
    rida = rida + 1;
    var ostukorv = document.getElementById("ostukorv");
    var osturida = ostukorv.insertRow(rida);
    osturida.setAttribute("id", "osturida[".concat(rida,"]"));
    var cell = new Array();
    var sisu = new Array();

    for (var i = 0; i < 5; i++) {
        cell[i] = osturida.insertCell(i);
        if(i<4) {
            sisu[i] = document.createElement("input");
        } else {
            sisu[i] = document.createElement("div");
        }
        if(i<2) {
            sisu[i].setAttribute("type", "text");
        } else if(i<4) {
            sisu[i].setAttribute("type", "text");
        }

        cell[i].appendChild(sisu[i]);
    }

    sisu[0].setAttribute("name", "kaup[".concat(rida,"]"));
    sisu[1].setAttribute("name", "kategooria[".concat(rida,"]"));
    sisu[2].setAttribute("name", "kogus[".concat(rida,"]"));
    sisu[3].setAttribute("name", "hind[".concat(rida,"]"));
    sisu[4].setAttribute("name", "summa[".concat(rida,"]"));

    sisu[0].setAttribute("id", "kaup[".concat(rida,"]"));
    sisu[1].setAttribute("id", "kategooria[".concat(rida,"]"));
    sisu[2].setAttribute("id", "kogus[".concat(rida,"]"));
    sisu[3].setAttribute("id", "hind[".concat(rida,"]"));
    sisu[4].setAttribute("id", "summa[".concat(rida,"]"));

    sisu[0].setAttribute("onclick", "uusRida()");

}
