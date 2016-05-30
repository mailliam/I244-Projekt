<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

function model_user_add($firstname, $lastname, $username, $password) {
    global $conn;
    $hash = password_hash($password, PASSWORD_DEFAULT); //password_hash kujutab endast sellist räsi, mida peetakse parasjagu turvalisek, ei ole staatilines
    $query = 'INSERT INTO mkeerus_pr_users (firstname, lastname, username, password) VALUES (?,?,?,?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'ssss', $firstname, $lastname, $username, $hash);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function model_user_get($username, $password) {
    global $conn;

    $query = 'SELECT id, password FROM mkeerus_pr_users WHERE username=? LIMIT 1';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if(password_verify($password, $hash)) {
        return $id;
    } else {
        return false;
    }
}

function model_user_exists($username) {
    global $conn;
    $query = 'SELECT id FROM mkeerus_pr_users WHERE username=? LIMIT 1';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}


?>
