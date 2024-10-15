<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $social_security_number = $_POST['social_security_number'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur à partir du fichier CSV
    $user = getUserFromData($social_security_number, $password);

    // Vérification des informations d'identification
    //TODO  HASHAGE DE MDP : if ($user && password_verify($password, $user['password']))
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: imc.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

function getUserFromData($social_security_number, $password) {
    $filename = "includes/users.csv";
    $users = [];

    if (($handle = fopen($filename, 'r')) !== false) {
        fgetcsv($handle);

        // Lire chaque ligne du fichier CSV avec délimiteur ';'
        while (($data = fgetcsv($handle, 1000, ";")) !== false) {
            if (count($data) == 9) {
                $users[] = [
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
    } else {
        echo "Erreur : Impossible d'ouvrir le fichier.";
    }

    // Rechercher l'utilisateur
    foreach ($users as $u) {
        echo "<pre>";
            print_r($u['social_security_number']);
            print_r($u['password']);
        echo "</pre>";
        if (trim((string)$u['social_security_number']) === trim((string)$social_security_number)) {
            if (trim((string)$password) === trim((string)$u['password'])) {
                return $u; // Correspondance trouvée
            }
        }
    return null;
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
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
    </div>
</body>
</html>
