<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM felhasznalo WHERE username = :username AND password = :password");
    $stmt->execute([':username' => $username, ':password' => $password]);

    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id'] = $user['id'];
        header("Location: index.php");
    } else {
        $error = "Érvénytelen felhasználónév vagy jelszó!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bejelentkezés</title>
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
    <h2 style="text-align: center;">Bejelentkezés</h2>
    <form method="post">
        <label>Felhasználónév: <input type="text" name="username" required></label><br>
        <label>Jelszó: <input type="password" name="password" required></label><br>
        <button type="submit">Bejelentkezés</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
