<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Autók Projekt</title>
    <link rel="stylesheet" type="text/css" href="style.css" >
</head>
<body>
    <h1>Üdvözöljük az Autók Projektben!</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Bejelentkezve: <?php echo $_SESSION['username']; ?></p>

        <style>
            ul {
                    list-style-type: none;
                    margin: 0;
                    padding: 0;
                    overflow: hidden;
                    background-color: #333;
                    text-align: center;
                }
  
            li {
                    display: inline-block;
                }

            li a {
                    display: block;
                    color: white;
                    text-align: center;
                    padding: 14px 16px;
                    text-decoration: none;
                }
  
            li a:hover {
                   
                    background-color: #111;
                }
        </style>
        <ul>
        <li><a href="profile.php">Profil</a></li>
        <li><a href="add_car.php">Autó hozzáadása</a></li>
        <li><a href="view_car.php">Autók megtekintése</a></li>
        <li><a href="upload.php">Fájl feltöltése</a></li>
        <li><a href="download.php">Fájl letöltése</a></li>
        <li><a href="logout.php">Kijelentkezés</a></li>
        </ul>

    <?php else: ?>
        <style>
            a:link, a:visited {
            background-color: gray;
            color: white;
            padding: 14px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

            a:hover, a:active {
                background-color: lightgray;
            }
        </style>
        <a href="login.php">Bejelentkezés</a>
        <a href="register.php">Regisztráció</a>
    <?php endif; ?>
</body>
</html>