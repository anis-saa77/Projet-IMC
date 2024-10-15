<?php
session_start(); // Démarrer la session

$error = ""; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $social_security_number = $_POST['social_security_number'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur à partir du fichier CSV
    $user = getUserFromData($social_security_number, $password);
    echo "<pre>";
        echo "user : " .$user  . "<br>";
        echo "Mot de passe enregistré : " .$user['password']  . "<br>";
        echo "Mot de passe saisi : " . $password . "<br>";
    echo "</pre>";
    // Vérification des informations d'identification
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true); // Regenerate session ID for security
        $_SESSION['user_id'] = $user['id'];
        header("Location: imc.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

function getUserFromData($social_security_number, $password) {
    $filename = "includes/users.csv";

    if (!file_exists($filename)) {
        // Log error and show friendly message
        error_log("Erreur : Impossible d'ouvrir le fichier $filename.");
        return null; // or handle error differently
    }

    if (($handle = fopen($filename, 'r')) !== false) {
        fgetcsv($handle); // Ignore header
        // Lire chaque ligne du fichier CSV avec délimiteur ';'
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            echo "<pre>";
                echo "data : "  .$data[2] . "<br>";
            echo "</pre>";
                // Check the social security number
            echo "<pre>";
                echo "ssn : "  .trim($data[1]) . "<br>";
                echo "ssn : "  .trim($social_security_number) . "<br>";
            echo "</pre>";
            if (trim($data[1]) === trim($social_security_number)) {

                // Return user data if social security number matches
                return [
                    'id' => $data[0],
                    'social_security_number' => $data[1],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'password' => $data[4],
                    'birthday' => $data[5],
                    'phone_number' => $data[6],
                    'email' => $data[7],
                    'postal_code' => $data[8]
                ];
            }

        }
        fclose($handle);
    }

    return null; // User not found
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <form action="login.php" method="POST">
            <label for="social_security_number">Numéro de Sécurité Social</label>
            <input type="text" name="social_security_number" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
        <?php if (!empty($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
    </div>
</body>
</html>
