<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql_query = "SELECT * FROM autok WHERE id = :id";
$query = $pdo->prepare($sql_query);
$query->execute([':id' => $id]);
$car = $query->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Autó nem található.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rendszam = $_POST['rendszam'];
    $model = $_POST['model'];
    $szin = $_POST['szin'];
    $evjarat = $_POST['evjarat'];

    $stmt = $pdo->prepare("UPDATE autok SET rendszam = :rendszam, model = :model, szin = :szin, evjarat = :evjarat WHERE id = :id");
    $stmt->execute([':rendszam' => $rendszam, ':model' => $model, ':szin' => $szin, ':evjarat' => $evjarat, ':id' => $id]);

    header("Location: view_car.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autó szerkesztése</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <h2>Autó szerkesztése</h2>
    <form method="post">
        <label>Rendszám: <input type="text" name="rendszam" value="<?php echo htmlspecialchars($car['rendszam']); ?>" required></label><br>
        <label>Modell: <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required></label><br>
        <label>Szín: <input type="text" name="szin" value="<?php echo htmlspecialchars($car['szin']); ?>" required></label><br>
        <label>Gyártási év: <input type="number" name="evjarat" value="<?php echo htmlspecialchars($car['evjarat']); ?>" required></label><br>
        <button type="submit">Mentés</button>
    </form>
</body>
</html>
