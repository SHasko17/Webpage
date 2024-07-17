<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $name = $_POST['nev'];
    $email = $_POST['email'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO felhasznalo (username, password) VALUES (:username, :password)");
        $stmt->execute([':username' => $username, ':password' => $password]);

        $user_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO tulaj (id, nev, email) VALUES (:id, :nev, :email)");
        $stmt->execute([':id' => $user_id, ':nev' => $name, ':email' => $email]);

        $pdo->commit();

        echo "Sikeres regisztráció!";
        header("Location: login.php");
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Hiba történt: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Regisztráció</title>
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

    <h2 style="text-align: center;">Regisztráció</h2>
    <form method="post">
        <label>Név: <input type="text" name="nev" required></label><br>
        <label>Felhasználónév: <input type="text" name="username" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Jelszó: <input type="password" name="password" required></label><br>

        <button type="submit">Regisztráció</button>
    </form>
</body>
</html>