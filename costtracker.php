<?php

session_start();

require('controller_user.php');
require('model_user.php');
require('controller_purchase.php');
require('model_purchase.php');

//Tegevused submittimisel

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST['action'])) {

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
                    if(c_purchase_rows_add()) {
                        if(!isset($_SESSION['message'])) {
                            $_SESSION['message'] = "Ost edukalt salvestatud";
                        }
                        header('Location: ' . $_SERVER['PHP_SELF']);
                    }
                    break;

                case 'logout':
                    if(c_user_logout()) {
                        header('Location: ' . $_SERVER['PHP_SELF']);
                    }
                    break;

                default:
                    $errors=array();
                    $errors['view']='Sellist tegevust ei eksisteeri, palun vali, mida teha soovid:';
                    include_once('view/head.html');
                    include_once('view/foot.html');
                    exit;
        }
    }

    exit; //Vahet pole, mis siin toimub, view-d kunagi ei näita
}

//Tegevused lingist minekul

if(!empty($_GET['view'])) {
    switch($_GET['view']) {

        case 'log':
            include_once('view/head.html');
            include_once('view/log.html');
            include_once('view/foot.html');
            break;

        case 'reg':
            include_once('view/head.html');
            include_once('view/reg.html');
            include_once('view/foot.html');
            break;

        case 'new':
            if(c_user_logged()) {
                include_once('view/head.html');
                include_once('view/purchase.html');
                include_once('view/foot.html');
            } else {
                header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
                exit;
            }

            break;

        default:
            $errors=array();
            $errors['view']='Sellist vaadet ei eksisteeri, palun vali, mida teha soovid:';
            include_once('view/head.html');
            include_once('view/foot.html');
            exit;
    }
} else {
    if(!c_user_logged()) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?view=log');
        exit;

    } else {
        include_once('view/head.html');
        include_once('view/program.html');
        include_once('view/foot.html');
    }
}

?>
