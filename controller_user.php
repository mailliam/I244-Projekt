<?php

function c_user_register($eesnimi, $perekonnanimi, $kasutajanimi, $parool, $sugu) {

    if($kasutajanimi == '' || $parool == '') {
        $errors = array();
        $errors[]='Kasutajanimi ja parool peavad olema täidetud.';
        //kuva_registreerimine();
        return false;
    }
    return model_user_add($eesnimi, $perekonnanimi, $kasutajanimi, $parool, $sugu);
}


?>
