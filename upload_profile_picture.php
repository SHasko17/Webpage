<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; 
        $upload_dir = 'uploads/';

        // Ellenőrizzük, hogy létezik-e a könyvtár, ha nem, akkor hozzuk létre
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp_path = $_FILES['profile_picture']['tmp_name'];
        $file_name = basename($_FILES['profile_picture']['name']);
        $file_size = $_FILES['profile_picture']['size'];
        $file_type = mime_content_type($file_tmp_path);

        
        error_log("File type: " . $file_type);
        error_log("File size: " . $file_size);

        // Ellenőrizzük a fájl típusát és méretét
        if (in_array($file_type, $allowed_types)) {
            if ($file_size <= $max_size) {
                // Új fájlnév generálása a biztonság érdekében
                $new_file_name = uniqid('profile_picture', true) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
                $dest_path = $upload_dir . $new_file_name;

                // Feltöltés a megadott könyvtárba
                if (move_uploaded_file($file_tmp_path, $dest_path)) {
                    try {
                        $pdo = new PDO('mysql:host=localhost;dbname=beadando', 'root', '');
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $user_id = $_SESSION['id'];

                        // Profilkép URL frissítése az adatbázisban
                        $sql_query = "UPDATE tulaj SET profil_kep = :profil_kep WHERE id = :id";
                        $query = $pdo->prepare($sql_query);

                        $query->execute([
                            ':profil_kep' => $new_file_name,
                            ':id' => $user_id
                        ]);

                        $_SESSION['message'] = "Profilkép sikeresen feltöltve.";
                        header("Location: profile.php");
                        exit();
                    } catch (PDOException $e) {
                        die("Adatbázis kapcsolati hiba: " . $e->getMessage());
                    }
                } else {
                    die("A fájl feltöltése nem sikerült.");
                }
            } else {
                die("A fájl mérete túl nagy.");
            }
        } else {
            die("Érvénytelen fájltípus: " . $file_type);
        }
    } else {
        die("Nincs fájl kiválasztva vagy feltöltési hiba történt. Hiba kód: " . $_FILES['profile_picture']['error']);
    }
}
?>
