<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

function model_purchase_header_add($buyer, $store, $date, $amount) {
    global $conn;

    $query = 'INSERT INTO mkeerus_pr_ostud (buyer, store, purchase_date, amount) VALUES (?,?,?,?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'sssd', $buyer, $store, $date, $amount);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function model_purchase_rows_add($purchase_id, $item, $category, $quantity, $price, $amount) {
    global $conn;

    $query = 'INSERT INTO mkeerus_pr_purchase_rows (purchase_id, item, category, quantity, price, amount) VALUES (?,?,?,?,?,?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'issddd', $purchase_id, $item, $category, $quantity, $price, $amount);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}


?>
