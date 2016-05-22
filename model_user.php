<?php

$host = 'localhost';
$user = 'test';
$pass = 't3st3r123';
$db = 'test';

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, 'SET CHARACTER SET UTF8') or
    die('Error, ei saa andmebaasi charsetti seatud');

function model_user_add($eesnimi, $perekonnanimi, $kasutajanimi, $parool, $sugu) {
    global $conn;
    $hash = password_hash($parool, PASSWORD_DEFAULT); //password_hash kujutab endast sellist räsi, mida peetakse parasjagu turvalisek, ei ole staatilines
    $query = 'INSERT INTO mkeerus_pr_kasutajad (eesnimi, perekonnanimi, kasutajanimi, parool, sugu) VALUES (?,?,?,?,?)';
    $stmt = mysqli_prepare($conn, $query);
    if(mysqli_error($conn)) {
        echo mysqli_error($conn);
        exit;
    }
    mysqli_stmt_bind_param($stmt, 'sssss', $eesnimi, $perekonnanimi, $kasutajanimi, $hash, $sugu);
    mysqli_stmt_execute($stmt);
    $id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return $id;
}

?>
