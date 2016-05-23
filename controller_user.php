<?php

function c_user_register() {

    $errors = array();

    if(empty($_POST['eesnimi']) || empty($_POST['perekonnanimi']) ||
    empty($_POST['kasutajanimi']) || empty($_POST['parool'])) {

        $errors['valjad_taitmata']='Registreerimiseks peavad olema kõik väljad täidetud';

        include_once('view/head.html');
        include_once('view/reg.html');
        include_once('view/foot.html');

        return false;
    } else {
        $eesnimi = $_POST['eesnimi'];
        $perekonnanimi = $_POST['perekonnanimi'];
        $kasutajanimi = $_POST['kasutajanimi'];
        $parool = $_POST['parool'];

        if(model_user_exists($kasutajanimi)) {
            $errors['probleem_kasutajanimega']=model_user_exists($kasutajanimi);
            include_once('view/head.html');
            include_once('view/reg.html');
            include_once('view/foot.html');

            return false;

        } else {
            return model_user_add($eesnimi, $perekonnanimi, $kasutajanimi, $parool);
        }
    }
}

function c_user_login() {
    $errors = array();

    if(empty($_POST['kasutajanimi']) || empty($_POST['parool'])) {
        $errors['valjad_taitmata']='Kasutajanimi ja/või parool täitmata';
        include_once('view/head.html');
        include_once('view/log.html');
        include_once('view/foot.html');

        return false;
    } else {
        $kasutajanimi = $_POST['kasutajanimi'];
        $parool = $_POST['parool'];

        $id = model_user_get($kasutajanimi, $parool);

        if(!$id) {
            $errors['valed_andmed'] = "Kasutajanimi ja/või parool vale";
            include_once('view/head.html');
            include_once('view/log.html');
            include_once('view/foot.html');

            return false;
        } else {
            session_regenerate_id();
            $_SESSION['login'] = $id;
            return $id;
        }
    }
}

function c_user_logged() {
    if(empty($_SESSION['login'])) {
        return false;
    }
    return $_SESSION['login'];
}


function c_user_logout() {
    if(isset($_COOKIE[session_name()])) { //Kui cookie on seatud sessiooni nimega
        setcookie(session_name(), '', time()-42000, '/');
    }
    $_SESSION = array();
    session_destroy();
    return true;
}


?>
