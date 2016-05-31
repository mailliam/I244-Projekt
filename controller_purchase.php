<?php

$errors = array();

function c_purchase_header_add() {

    if(c_user_logged() && check_insertion_correctness()) {

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
            return true;
            } else {
                $errors[] = 'Read poolikult täidetud. Palun täida või kustutad poolikud andmed.';
                include_once('view/head.html');
                include_once('view/purchase.html');
                include_once('view/foot.html');
                return false;
                }
            }
        }
    }



function c_purchase_rows_add() { //See funktsioon on hetkel jama, testin
    $errors = array();
    $purchase_id = c_purchase_header_add();

    if(!check_insertion_correctness() || $purchase_id == false || !c_user_logged()) { //Lisaks ka, kas päise lisamine õnnestus
        return false;

    } else {

        print_r($_POST);
        foreach ($_POST['data'] as $data) {
            $item = $data['item'];
            $category = $data['category'];
            $quantity = $data['quantity'];
            $price = $data['price'];
            $amount = $data['amount'];
            $user_id =  $_SESSION['login'];

            if(!empty($item) && !empty($category) && !empty($quantity) && !empty($price) && !empty($amount)) {
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
    if(!check_insertion_correctness() || !c_user_logged()) { //Lisaks ka, kas päise lisamine õnnestus
        return false;

    } else {
        return model_purchase_item_exists($item);
    }
}



?>
