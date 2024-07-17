<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=cars.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('Rendszam', 'Modell', 'Szin', 'Evjarat'));

$sql_query = "SELECT rendszam, model, szin, evjarat, id FROM autok";
$query = $pdo->prepare($sql_query);
$query->execute();
$cars = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($cars as $car) {
    fputcsv($output, $car);
}

fclose($output);
exit();
?>
