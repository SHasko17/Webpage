<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rendszam_tabla = $_POST['rendszam'];
    $model = $_POST['model'];
    $szine = $_POST['szin'];
    $ev = $_POST['evjarat'];

    if (isset($pdo)) {
        $stmt = $pdo->prepare("INSERT INTO autok (rendszam, model, szin, evjarat) VALUES (:rendszam, :model, :szin, :evjarat)");
        $stmt->execute([':rendszam' => $rendszam_tabla, ':model' => $model, ':szin' => $szine, ':evjarat' => $ev]);

        header("Location: view_car.php");
        exit();
    } else {
        echo "Adatbázis kapcsolódási hiba.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autó hozzáadása</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<style>
        form {
            width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px solid black;
            border-radius: 10px;
            background-color: #f2f2f2;
        }
        input{
            width: 90%;
        }
        button {
            background-color: #696969;
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }
        button:hover{
            background-color: #A9A9A9;
        }
    </style>
    <?php if ($_SESSION['username'] == 'admin'): ?>
    <h2 style="text-align: center;">Autó hozzáadása</h2>    
    <form method="post">
        <label>Rendszám: <input type="text" name="rendszam" required></label><br>
        <label>Modell: <input type="text" name="model" required></label><br>
        <label>Szín: <input type="text" name="szin" required></label><br>
        <label>Gyártási év: <input type="number" name="evjarat" required></label><br>
        <button type="submit">Hozzáadás</button>
    </form>
    <?php endif; ?>
   <br><a href="index.php">Vissza a főoldalra</a>
</body>
</html>
