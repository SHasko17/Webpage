<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Csak CSV fájlok engedélyezése
    if ($fileType != "csv") {
        echo "Csak CSV fájlok engedélyezettek.";
        $uploadOk = 0;
    }

    // Ellenőrizni, hogy a feltöltés sikeres volt-e
    if ($uploadOk == 0) {
        echo "Sajnáljuk, a fájlt nem töltöttük fel.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Fájl beolvasása és adatbázisba beszúrása
            if (($handle = fopen($target_file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $stmt = $pdo->prepare("INSERT INTO autok (rendszam, model, szin, evjarat) VALUES (?, ?, ?, ?)");
                    $stmt->execute($data);
                }
                fclose($handle);
            }

            echo "A fájl feltöltése sikeres volt.";
        } else {
            echo "Sajnáljuk, hiba történt a fájl feltöltésekor.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fájl feltöltése</title>
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
    <h2 style="text-align: center;">Fájl feltöltése</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Feltöltés</button>
    </form>
    <br><a href="index.php">Vissza a főoldalra</a>
</body>
</html>
