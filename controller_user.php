<?php

function c_user_register() {

    $errors = array();

    if(empty($_POST['firstname']) || empty($_POST['lastname']) ||
    empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2'])) {

        $errors[]='Registreerimiseks peavad olema kõik väljad täidetud.';

        include_once('view/head.html');
        include_once('view/reg.html');
        include_once('view/foot.html');

        return false;

    } else {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if($password != $password2) {
            $errors[] = 'Parooli kontrollsisestus ei klapi, palun sisesta uuesti.';
            include_once('view/head.html');
            include_once('view/reg.html');
            include_once('view/foot.html');

            return false;

        } else {
            if(model_user_exists($username)) {
                $errors[]='Kasutajanimi juba olemas, palun vali uus.';
                include_once('view/head.html');
                include_once('view/reg.html');
                include_once('view/foot.html');

                return false;

            } else {
                return model_user_add($firstname, $lastname, $username, $password);
            }
        }
    }
}

function c_user_login() {
    $errors = array();

    if(empty($_POST['username']) || empty($_POST['password'])) {
        $errors[]='Kasutajanimi ja/või parool täitmata';
        include_once('view/head.html');
        include_once('view/log.html');
        include_once('view/foot.html');

        return false;
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $id = model_user_get($username, $password);

        if(!$id) {
            $errors[] = "Kasutajanimi ja/või parool vale";
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
