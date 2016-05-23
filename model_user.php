<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

function model_user_add($eesnimi, $perekonnanimi, $kasutajanimi, $parool) {
    global $conn;
    $hash = password_hash($parool, PASSWORD_DEFAULT); //password_hash kujutab endast sellist räsi, mida peetakse parasjagu turvalisek, ei ole staatilines
    $query = 'INSERT INTO mkeerus_pr_kasutajad (eesnimi, perekonnanimi, kasutajanimi, parool) VALUES (?,?,?,?)';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 'ssss', $eesnimi, $perekonnanimi, $kasutajanimi, $hash);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

function model_user_get($kasutajanimi, $parool) {
    global $conn;

    $query = 'SELECT id, parool FROM mkeerus_pr_kasutajad WHERE kasutajanimi=? LIMIT 1';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $kasutajanimi);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if(password_verify($parool, $hash)) {
        return $id;
    } else {
        return false;
    }
}

function model_user_exists($kasutajanimi) {
    global $conn;
    $query = 'SELECT id FROM mkeerus_pr_kasutajad WHERE kasutajanimi=? LIMIT 1';
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, 's', $kasutajanimi);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

?>
