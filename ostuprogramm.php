<?php

session_start();
require('model_view.php');
require('controller_user.php');
require('model_user.php');


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = false;
    switch($_POST['action']) {
        case 'reg':
            $eesnimi = $_POST['eesnimi'];
            $perekonnanimi = $_POST['perekonnanimi'];
            $kasutajanimi = $_POST['kasutajanimi'];
            $parool = $_POST['parool'];
            $sugu = $_POST['sugu'];
            $result = c_user_register($eesnimi, $perekonnanimi, $kasutajanimi, $parool, $sugu);
            break;
    }

    if($result) {
        header('Location:' . $_SERVER['PHP_SELF']); //Kui lehte ümber ei suuna, siis ta jätkab kogu aeg samade andmete saatmist
    } //else {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=' . $_POST['action']);
    //}

    exit; //Vahet pole, mis siin toimub, view-d kunagi ei näita
}

if(!empty($_GET['view'])) {
    switch($_GET['view']) {
        case 'log':
            kuva_logimine();
            break;

        case 'reg':
            kuva_registreerimine();
            break;

        default:
            $errors=array();
            $errors[]='Sellist vaadet ei eksisteeri, palun vali, mida teha soovid:';
            include('view/head.html');
            include('view/foot.html');
            //echo 'Sellist vaadet ei eksisteeri, palun vali, mida teha soovid:';
            exit;
    }
} else {
    if(2!=1) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
        exit; //tuleb panna kindlasti exit, muidu muutuks allolev view.php nähtavaks, sest programm jätkab tööd
                //Brauser küll ei näita seda välja, aga konsoolist on võimalik järgmist osa näha
    }

}

?>
