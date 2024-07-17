<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql_query = "DELETE FROM autok WHERE id = :id";
$query = $pdo->prepare($sql_query);
$query->execute([':id' => $id]);

header("Location: view_car.php");
?>
