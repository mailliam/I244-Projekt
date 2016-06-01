<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

function model_purchase_header_add($buyer, $store, $date, $amount, $user_id) {
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
    global $conn;

    if(!empty($_SESSION['login'])) {
        $id = $_SESSION['login'];
    }

    $query = "SELECT * FROM mkeerus_pr_purchase WHERE user_id = $id";
    $result = mysqli_query($conn, $query); //Kursorobjekt

    $rows = array(); //UUs massiiv ja loeme kõik tulemused sinna RecursiveCachingIterator

    if($result) {
        while($row = mysqli_fetch_assoc($result)) { //Kui annab väljundi, siis on true
            $rows[] = $row;
        }
    }
    return $rows;
}

function model_purchase_buyer_get($id) {
    global $conn;

    if(!empty($_SESSION['login'])) {
        $id = $_SESSION['login'];
    }

    $query = "SELECT DISTINCT buyer FROM mkeerus_pr_purchase WHERE user_id = $id ORDER BY buyer ASC";
    $result = mysqli_query($conn, $query); //Kursorobjekt

    $rows = array(); //UUs massiiv ja loeme kõik tulemused sinna RecursiveCachingIterator

    if($result) {
        while($row = mysqli_fetch_assoc($result)) { //Kui annab väljundi, siis on true
            $rows[] = $row;
        }
    }
    return $rows;
}

function model_purchase_category_get($id) {
    global $conn;

    if(!empty($_SESSION['login'])) {
        $id = $_SESSION['login'];
    }

    $query = "SELECT DISTINCT category FROM mkeerus_pr_items WHERE user_id = $id ORDER BY category ASC";
    $result = mysqli_query($conn, $query); //Kursorobjekt

    $rows = array(); //UUs massiiv ja loeme kõik tulemused sinna RecursiveCachingIterator

    if($result) {
        while($row = mysqli_fetch_assoc($result)) { //Kui annab väljundi, siis on true
            $rows[] = $row;
        }
    }
    return $rows;
}


?>
