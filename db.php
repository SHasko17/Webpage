<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=beadando', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
    die("Adatbázis kapcsolati hiba: " . $e->getMessage());
}


?>