<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $social_security_number = $_POST['social_security_number'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur à partir du fichier CSV
    $user = getUsersFromData($social_security_number, $password);
    // Vérification des informations d'identification
    //TODO  HASHAGE DE MDP : if ($user && password_verify($password, $user['password']))
    if ($user) {
        $_SESSION['user_id'] = $user['social_security_number']; // Vous pouvez utiliser un identifiant unique
        header("Location: imc.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

function getUsersFromData($social_security_number, $password) {
    $filename = "includes/users.csv";
    $users = [];

    // Ouvrir le fichier CSV
    if (($handle = fopen($filename, 'r')) !== false) {
        // Ignore le header
        fgetcsv($handle);

        // Lire chaque ligne du fichier CSV
        while (($data = fgetcsv($handle)) !== false) {
            // Assurez-vous que les données sont bien chargées (8 colonnes attendues)
            if (count($data) == 8) {
                $users[] = [
                    'social_security_number' => $data[0],
                    'firstname' => $data[1],
                    'lastname' => $data[2],
                    'password' => $data[3], // Mot de passe haché
                    'birthday' => $data[4],
                    'phone_number' => $data[5],
                    'email' => $data[6],
                    'postal_code' => $data[7]
                ];
            }
        }
        fclose($handle);
    } else {
        echo "Erreur : Impossible d'ouvrir le fichier.";
    }

    // Rechercher l'utilisateur en fonction du numéro de sécurité sociale
    foreach ($users as $u) {
        // Comparer le numéro de sécurité sociale et le mot de passe
        if ($u['social_security_number'] === $social_security_number) {
            //TODO
            if ($password === $u['password']) {
                return $u;
            } else {
                return null; // Si le mot de passe est incorrect
            }
        }
    }

    return null; // Aucun utilisateur trouvé
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