<?php

$errors = array();

function c_purchase_header_add() {
//Annab mudelile korralduse ostupäis andmbaasi lisada

    if(c_user_logged() && check_insertion_correctness()) { //Täidetuse kontroll on tehtud juba sisestuse õigsuse kontrolliga

        $buyer = $_POST['buyer'];
        $store = $_POST['store'];
        $date = date('Y-m-d',strtotime($_POST['date'])); //Kuupäeva formaadi muutmine mysql jaoks: http://stackoverflow.com/questions/12120433/php-mysql-insert-date-format
        $purchase_amount = $_POST['purchase_amount'];
        $user_id =  $_SESSION['login'];
        return model_purchase_header_add($buyer, $store, $date, $purchase_amount, $user_id);

    } else {
        return false;
    }
}

function check_insertion_correctness() {
//Kontrollib, kas väljad on õigesti täidetud

    if(empty($_POST['buyer']) || empty($_POST['store']) ||
    empty($_POST['date']) || empty($_POST['purchase_amount'])) {

        $errors[]='Päises peavad olema kõik väljad täidetud.';
        include_once('view/head.html');
        include_once('view/purchase.html');
        include_once('view/foot.html');
        return false;

    } elseif (empty($_POST['data'])) {

        $errors[]='Ostukorvi sisu puudu, palun lisa.';
        include_once('view/head.html');
        include_once('view/purchase.html');
        include_once('view/foot.html');
        return false;

    } else {
        foreach ($_POST['data'] as $data) {

            $item = $data['item'];
            $category = $data['category'];
            $quantity = $data['quantity'];
            $price = $data['price'];
            $amount = $data['amount'];

            if(empty($item) && empty($category) && empty($quantity) && empty($price) && empty($amount) ||
            !empty($item) && !empty($category) && !empty($quantity) && !empty($price) && !empty($amount)) {
            //...Kui on ainult ridu, mis täielikult tühjad või täielikult täidetud

            } else {
                $errors[] = 'Read poolikult täidetud. Palun täida poolikud või kustuta ebavajalikud andmed.';
                include_once('view/head.html');
                include_once('view/purchase.html');
                include_once('view/foot.html');
                return false;
                }
                return true;
            }

        }
    }

function c_purchase_query() {
//Annab mudelile korralduse leida valitud ostja ostud ja valitud kategooriasse kuuluvad kaubad
    $errors = array();
    if(c_user_logged() && !empty($_POST['buyer2']) && !empty($_POST['category2']))  {
        $buyer2 = $_POST['buyer2'];
        $category2 = $_POST['category2'];
        $user = c_user_logged();
        $pid = model_purchase_id($user, $buyer2);
        $list = array();
        foreach ($pid as $p) {
            $list[] = model_purchase_query($p, $category2);
        }
        return $list;

    } else {
        $errors[] = 'Palun vali nii ostja kui kategooria';
        include_once('view/head.html');
        include_once('view/query.html');
        include_once('view/foot.html');
        return false;
    }
}


function c_purchase_rows_add() {
//Annab mudelile korralduse osturead andmebaasi lisada
    $errors = array();
    $purchase_id = c_purchase_header_add();

    if(!check_insertion_correctness() || $purchase_id == false || !c_user_logged()) { //Lisaks ka, kas päise lisamine õnnestus
        return false;

    } else {

        foreach ($_POST['data'] as $data) { //Täidetuse kontroll on tehtud juba sisestuse õigsuse kontrolliga
            $item = $data['item'];
            $category = $data['category'];
            $quantity = $data['quantity'];
            $price = $data['price'];
            $amount = $data['amount'];
            $user_id =  $_SESSION['login'];

            if(!empty($item) && !empty($category) && !empty($quantity) && !empty($price) && !empty($amount)) { //Tühje kirjeid ei lisata
                model_purchase_rows_add($purchase_id, $item, $category, $quantity, $price, $amount, $user_id);

                if(!c_purchase_item_exists($item)) {
                    model_purchase_item_add($item, $category, $user_id);
                }
            }
        }
        return true;
    }
}

function c_purchase_item_exists($item) {
//Kontrollib, kas toodet ostetakse esimest korda, sel juhul lisab toote andmebaasi (vajalik hilisemaks automaatseks kategooria täitmiseks)
    if(!check_insertion_correctness() || !c_user_logged()) { //Lisaks ka, kas päise lisamine õnnestus
        return false;

    } else {
        return model_purchase_item_exists($item);
    }
}



?>
