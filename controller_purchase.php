<?php

$errors = array();

function c_purchase_header_add() {

    if(check_insertion_correctness()) {
        $buyer = $_POST['buyer'];
        $store = $_POST['store'];
        $date = $_POST['date'];
        $purchase_amount = $_POST['purchase_amount'];
        return model_purchase_header_add($buyer, $store, $date, $purchase_amount);
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

    if(!check_insertion_correctness() || $purchase_id == false) { //Lisaks ka, kas päise lisamine õnnestus
        return false;

    } else {

        print_r($_POST);
        foreach ($_POST['data'] as $data) {
            $item = $data['item'];
            $category = $data['category'];
            $quantity = $data['quantity'];
            $price = $data['price'];
            $amount = $data['amount'];
            if(!empty($item) && !empty($category) && !empty($quantity) && !empty($price) && !empty($amount)) {
                return model_purchase_rows_add($purchase_id, $item, $category, $quantity, $price, $amount);
            }
        }
    }
}


?>
