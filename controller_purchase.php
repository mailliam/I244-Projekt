<?php

function c_purchase_header_add() {

    $errors = array();

    if(empty($_POST['buyer']) || empty($_POST['store']) ||
    empty($_POST['date']) || empty($_POST['purchase_amount'])) {

        $errors[]='Päises peavad olema kõik väljad täidetud.';

        include_once('view/head.html');
        include_once('view/purchase.html');
        include_once('view/foot.html');

        return false;

    } else {
        $buyer = $_POST['buyer'];
        $store = $_POST['store'];
        $date = $_POST['date'];
        $purchase_amount = $_POST['purchase_amount'];

        return model_purchase_header_add($buyer, $store, $date, $purchase_amount);
    }
}

function c_purchase_rows_add() { //See funktsioon on hetkel jama, testin
    $errors = array();
    $purchase_id = c_purchase_header_add();

    if(empty($_POST['data']) || $purchase_id == false) { //Lisaks ka, kas päise lisamine õnnestus
        $errors[]='Ostukorvi sisu puudu, palun lisa.';

        include_once('view/head.html');
        include_once('view/purchase.html');
        include_once('view/foot.html');

        return false;

    } else {

        print_r($_POST);
        foreach ($_POST['data'] as $data) {
            $item = $data['item'];
            $category = $data['category'];
            $quantity = $data['quantity'];
            $price = $data['price'];
            $amount = $data['amount'];

            if(!model_purchase_rows_add($purchase_id, $item, $category, $quantity, $price, $amount)) {
                $errors[] = 'Täitmisel tekkis viga.';
            }
        }
        if(empty($errors)) {
            return true;
        } else {
            return false;
        }
    }
}


?>
