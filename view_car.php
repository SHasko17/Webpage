<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$sql_query = "SELECT * FROM autok";
$query = $pdo->prepare($sql_query);
$query->execute();
$cars = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autók</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Autók</h2>
    <table>
        <tr>
            <th>Rendszám</th>
            <th>Modell</th>
            <th>Szín</th>
            <th>Gyártási év</th>
            <th>Műveletek</th>
        </tr>
        <?php foreach ($cars as $car): ?>
        <tr>
            <td><?php echo htmlspecialchars($car['rendszam']); ?></td>
            <td><?php echo htmlspecialchars($car['model']); ?></td>
            <td><?php echo htmlspecialchars($car['szin']); ?></td>
            <td><?php echo htmlspecialchars($car['evjarat']); ?></td>
            <td>
            <?php if ($_SESSION['username'] == 'admin'): ?>
                    <a href="edit_car.php?id=<?php echo $car['id']; ?>">Szerkesztés</a><br><br>
                    <a href="delete_car.php?id=<?php echo $car['id']; ?>" onclick="return confirm('Biztosan törölni szeretnéd?')">Törlés</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><a href="index.php">Vissza a főoldalra</a>
</body>
</html>
