<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['new_email']; 

    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        die("Érvénytelen email cím.");
    }

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=beadando', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $user_id = $_SESSION['id']; 

        $sql_query = "UPDATE tulaj SET email = :new_email WHERE id = :id";
        $query = $pdo->prepare($sql_query);

        $query->execute([
            ':new_email' => $new_email, 
            ':id' => $user_id
        ]);

        $_SESSION['message'] = "Sikeresen megváltoztattad az email címedet.";
        
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        die("Adatbázis kapcsolati hiba: " . $e->getMessage());
    }
}
?>

