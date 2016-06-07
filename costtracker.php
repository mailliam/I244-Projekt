<?php

//Alusena on põhiliselt kasutatud on 2015. ja 2016. aasta päevaõppe loengute ja praktikumide näited

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(20));
}

require('/home/mkeerus/I244projekt/controller_user.php');
require('/home/mkeerus/I244projekt/model_user.php');
require('/home/mkeerus/I244projekt/controller_purchase.php');
require('/home/mkeerus/I244projekt/model_purchase.php');

//Tegevused erinevate vormide submittimisel

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['action'])) {
        if (!empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

            switch($_POST['action']) {
                case 'reg':
                    if(c_user_register()) {
                        if(!isset($_SESSION['message'])) {
                            $_SESSION['message'] = "Kasutaja edukalt registreeritud. Jätkamiseks logi palun sisse.";
                        }
                        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
                    }
                    break;

                case 'login':
                    if(c_user_login()) {
                        header('Location: ' . $_SERVER['PHP_SELF']);
                    };
                    break;

                case 'purchase':
                    if(c_user_logged()) {
                        if(c_purchase_rows_add()) {
                            if(!isset($_SESSION['message'])) {
                                $_SESSION['message'] = "Ost edukalt salvestatud";
                            }
                            header('Location: ' . $_SERVER['PHP_SELF']);
                        }
                    } else {
                        $errors = array();
                        $errors[]='Ostu sisestamiseks pead olema sisse logitud.';
                        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
                        exit;
                    }
                    break;

                case 'query':
                    if(c_user_logged()) {
                        c_purchase_query();
                        include_once('view/head.html');
                        include_once('view/query.html');
                        include_once('view/foot.html');
                    } else {
                        $errors = array();
                        $errors[]='Päringute sooritamiseks pead olema sisse logitud.';
                        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
                        exit;
                    }
                    break;

                case 'logout':
                    if(c_user_logout()) {
                        header('Location: ' . $_SERVER['PHP_SELF']);
                    }
                    break;

                default:
                    $errors=array();
                    $errors['view']='Sellist tegevust ei eksisteeri, palun vali menüüst, mida teha soovid.';
                    include_once('view/head.html');
                    include_once('view/foot.html');
                    exit;
            }
        } else {
            $errors[]='Vigane päring';
        }
    }
    exit;
}

//Tegevused erinevatest linkidest minekul
if(!empty($_GET['view'])) {
    switch($_GET['view']) {

        case 'log':
            if(!c_user_logged()) {
                $title = 'Sisselogimine';
                include_once('view/head.html');
                include_once('view/log.html');
                include_once('view/foot.html');
            } else {
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
            break;

        case 'reg':
            if(!c_user_logged()) {
                $title = 'Registreerimine';
                include_once('view/head.html');
                include_once('view/reg.html');
                include_once('view/foot.html');
            } else {
                header('Location: ' . $_SERVER['PHP_SELF']);
            }
            break;

        case 'new':
            if(c_user_logged()) {
                $title = 'Uus ost';
                include_once('view/head.html');
                include_once('view/purchase.html');
                include_once('view/foot.html');
            } else {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
                exit;
            }

            break;

        case 'queries':
            if(c_user_logged()) {
                $title = 'Päringud';
                include_once('view/head.html');
                include_once('view/query.html');
                include_once('view/foot.html');
            } else {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
                exit;
            }

            break;

        default:
            $errors=array();
            $errors['view']='Sellist vaadet ei eksisteeri, palun vali menüüst, mida teha soovid.';
            $title = 'Viga!';
            include_once('view/head.html');
            include_once('view/foot.html');
            exit;
    }
} else {
    if(!c_user_logged()) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
        exit;

    } else {
        $title = 'Kuluprogramm';
        include_once('view/head.html');
        include_once('view/program.html');
        include_once('view/foot.html');
    }
}

?>
