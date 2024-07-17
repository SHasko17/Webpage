<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];


    if (empty($new_password)) {
        die("Az új jelszó nem lehet üres.");
    }

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=beadando', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user_id = $_SESSION['id'];


        $sql_query = "SELECT password FROM felhasznalo WHERE id = :id";
        $query = $pdo->prepare($sql_query);
        $query->execute([':id' => $user_id]);

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            
            if (md5($current_password) == $user['password']) { 
                
                $hashed_new_password = md5($new_password); 
                $sql_update = "UPDATE felhasznalo SET password = :new_password WHERE id = :id";
                $query_update = $pdo->prepare($sql_update);

                $query_update->execute([
                    ':new_password' => $hashed_new_password,
                    ':id' => $user_id
                ]);

                $_SESSION['message'] = "Sikeresen megváltoztattad a jelszavad!";

                header("Location: profile.php");
                exit();
            } else {
                die("Helytelen jelenlegi jelszó.");
            }
        } else {
            die("Felhasználó nem található.");
        }
    } catch (PDOException $e) {
        die("Adatbázis kapcsolati hiba: " . $e->getMessage());
    }
}
?>