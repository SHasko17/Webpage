<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

$sql_query = "SELECT felhasznalo.username, tulaj.nev, tulaj.email, tulaj.profil_kep FROM felhasznalo JOIN tulaj ON felhasznalo.id = tulaj.id WHERE felhasznalo.id = :id";
$query = $pdo->prepare($sql_query);
$query->execute(array(':id' => $user_id));
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Felhasználó nem található.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Profil</h1>

    <a href="index.php">Vissza a főoldalra</a>
    <?php
    echo "<h2>";
    if (isset($_SESSION['message'])) {
        echo '<p>' . htmlspecialchars($_SESSION['message']) . '</p>';
        unset($_SESSION['message']);
    }
    echo "</h2>";
    ?>

    <?php if (isset($user['profil_kep']) && !empty($user['profil_kep'])): ?>
        <p>Profilkép:</p>
        <img src="uploads/<?php echo htmlspecialchars($user['profil_kep']); ?>" alt="Profilkép" width="150" height="150">
    <?php else: ?>
        <p>Nincs profilkép feltöltve.</p>
    <?php endif; ?>

    <p>Felhasználónév: <?php echo htmlspecialchars($user['username']); ?></p>
    <p>Név: <?php echo htmlspecialchars($user['nev']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>


    <style>
        form {
            width: 300px;
            margin-left: 20px; 
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


    <h2 style="margin-left: 80px;">Email módosítása</h2>
    <form method="post" action="change_email.php">
        <input type="email" name="new_email" required>
        <button type="submit">Módosítás</button>
    </form>

    <h2 style="margin-left: 80px;">Jelszó módosítása</h2>
    <form method="post" action="change_password.php">
        <input type="password" name="current_password" placeholder="Jelenlegi jelszó" required>
        <input type="password" name="new_password" placeholder="Új jelszó" required>
        <button type="submit">Módosítás</button>
    </form>

    <h2 style="margin-left: 80px;">Profilkép módosítása</h2>
    <form method="post" action="upload_profile_picture.php" enctype="multipart/form-data">
        <input type="file" name="profile_picture" accept="image/*" required>
        <button type="submit">Feltöltés</button>
    </form>
</body>
</html>
