<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

function model_purchase_header_add($buyer, $store, $date, $amount, $user_id) {
//Salvetab ostu päise andmebaasi
    global $conn;

    $query = 'INSERT INTO mkeerus_pr_purchase (buyer, store, purchase_date, amount, user_id) VALUES (?,?,?,?,?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'sssdi', $buyer, $store, $date, $amount, $user_id);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function model_purchase_rows_add($purchase_id, $item, $category, $quantity, $price, $amount, $user_id) {
//Lisab osturead andmebaasi
    global $conn;

    $query = 'INSERT INTO mkeerus_pr_purchase_rows (purchase_id, item, category, quantity, price, amount, user_id) VALUES (?,?,?,?,?,?,?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'issdddi', $purchase_id, $item, $category, $quantity, $price, $amount, $user_id);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function model_purchase_item_exists($item) {
//Kontrollib, kas lisatav kaup on juba andmebaasis olemas
    global $conn;
    $query = 'SELECT id FROM mkeerus_pr_items WHERE item=? LIMIT 1';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 's', $item);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function model_purchase_item_add($item, $category, $user_id) {
//Lisab kauba koos kategooria ja kasutaja id-ga andmebaasi
    global $conn;

    $query = 'INSERT INTO mkeerus_pr_items (item, category, user_id) VALUES (?,?,?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'ssi', $item, $category, $user_id);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function model_purchase_header_get($id) {
//Leiab andmebaasist konkreetse kasutaja ostud
    global $conn;

    if(!empty($_SESSION['login'])) {
        $id = mysqli_real_escape_string($conn, $_SESSION['login']);
    }

    $query = "SELECT * FROM mkeerus_pr_purchase WHERE user_id = $id";
    $result = mysqli_query($conn, $query);

    $rows = array();

    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function model_purchase_buyer_get($id) {
//Leiab konkreetse kasutaja poolt sisetatud ostjad
    global $conn;

    if(!empty($_SESSION['login'])) {
        $id = mysqli_real_escape_string($conn, $_SESSION['login']);
    }

    $query = "SELECT DISTINCT buyer FROM mkeerus_pr_purchase WHERE user_id = $id ORDER BY buyer ASC";
    $result = mysqli_query($conn, $query);

    $buyers = array();

    if($result) {
        while($b = mysqli_fetch_assoc($result)) {
            $buyers[] = $b;
        }
    }
    return $buyers;
}

function model_purchase_id($user, $buyer) {
//Leiab konkreetse kasutaja ja ostja ostu id
    global $conn;
    $query = 'SELECT id FROM mkeerus_pr_purchase WHERE user_id = ? AND buyer = ?';

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $user, $buyer);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id);

    $rows = array();
    while(mysqli_stmt_fetch($stmt)) {
        $rows[] = $id;
    }
    return $rows;
}

function model_purchase_query($p, $category) {
//Leiab konkreetse ostja konkreetse kategooria ostud
    global $conn;
    $query = 'SELECT item, amount FROM mkeerus_pr_purchase_rows WHERE purchase_id = ? AND category = ?';

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'is', $p, $category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $item, $amount);

    $rows = array();
    while(mysqli_stmt_fetch($stmt)) {
        $rows[] = array(
            'item' => $item,
            'amount' => $amount,
        );
    }
    return $rows;
}

function model_purchase_category_get($id) {
//Leiab konkreetse kasutaja poolt sisestatud kategooriad
    global $conn;

    if(!empty($_SESSION['login'])) {
        $id = mysqli_real_escape_string($conn, $_SESSION['login']);
    }

    $query = "SELECT DISTINCT category FROM mkeerus_pr_items WHERE user_id = $id ORDER BY category ASC";
    $result = mysqli_query($conn, $query);

    $rows = array();

    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
    }
    return $rows;
}


?>
