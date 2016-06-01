var row = 0;

function row_amount() {
//Arvutab sisestatavatele ridadele summad ning kogu ostu summa
//Kasutatud õpetust http://www.javascript-coder.com/javascript-form/javascript-calculator-script.phtml
    var purchase_amount = 0;
    for (var i = 0; i < row+1; i++) {
        var form = document.forms["add_purchase"];

        var cell_quantity = form.elements["data[".concat(i,"][quantity]")];
        var quantity = 0;
        if(cell_quantity.value!="") {
            quantity = (cell_quantity.value);
        }

        var cell_price = form.elements["data[".concat(i,"][price]")];
        var price = 0;
        if(cell_price.value!="") {
            price = (cell_price.value);
        }

        var amount = (Number(quantity) * Number(price)).toFixed(2);
        purchase_amount = (Number(purchase_amount) + Number(amount)).toFixed(2);

        document.getElementById("purchase_amount").innerHTML = purchase_amount;

        if (amount != 0) {
            document.getElementById("data[".concat(i,"][amount]")).innerHTML = amount;
        } else {
            document.getElementById("data[".concat(i,"][amount]")).innerHTML = "";
        }
    }
}

function new_row() {
//Loob kauba väljale klikkimisel uue rea
//Kasutatud õpetust http://www.w3schools.com/jsref/met_table_insertrow.asp
//Nutikam massiiviväljade nimetamise viis kui see, mille peale ise tulin, pärineb:
//http://stackoverflow.com/questions/2433727/submitting-a-multidimensional-array-via-post-with-php

    row = row + 1;
    var purchase_basket = document.getElementById("purchase_basket");
    var basket_row = purchase_basket.insertRow(row+1);
    basket_row.setAttribute("id", "basket_row[".concat(row,"]"));
    basket_row.setAttribute("name", "basket_row[".concat(row,"]"));
    var cell = new Array();
    var sisu = new Array();

    for (var i = 0; i < 5; i++) {
        cell[i] = basket_row.insertCell(i);

        if(i<4) {
            sisu[i] = document.createElement("input");
        } else {
            sisu[i] = document.createElement("div");
        }

        if(i<2) {
            sisu[i].setAttribute("type", "text");
        } else if(i<4) {
            sisu[i].setAttribute("type", "number");
            switch (i) {
                case 2:
                    sisu[i].setAttribute("step", "0.001");
                    break;
                default:
                    sisu[i].setAttribute("step", "0.01");
            }
        }

        if(2<=i<=3) {
            sisu[i].setAttribute("oninput", "row_amount()");
        }

        cell[i].appendChild(sisu[i]);
    }

    sisu[0].setAttribute("name", "data[".concat(row,"][item]"));
    sisu[1].setAttribute("name", "data[".concat(row,"][category]"));
    sisu[2].setAttribute("name", "data[".concat(row,"][quantity]"));
    sisu[3].setAttribute("name", "data[".concat(row,"][price]"));

    sisu[0].setAttribute("id", "data[".concat(row,"][item]"));
    sisu[1].setAttribute("id", "data[".concat(row,"][category]"));
    sisu[2].setAttribute("id", "data[".concat(row,"][quantity]"));
    sisu[3].setAttribute("id", "data[".concat(row,"][price]"));
    sisu[4].setAttribute("id", "data[".concat(row,"][amount]"));

    sisu[4].setAttribute("class", "amount");

    sisu[0].setAttribute("onclick", "new_row()");

}
