<?php
session_start(); // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $social_security_number = $_POST['social_security_number'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur à partir du fichier CSV
    $user = getUserFromData($social_security_number, $password);

    // Vérification des informations d'identification
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }

}

function getUserFromData($social_security_number) {
    $filename = "../includes/users.csv";
    $users = [];

    if (($handle = fopen($filename, 'r')) !== false) {
        fgetcsv($handle); // Ignore the first line (headers)

        // Lire chaque ligne du fichier CSV
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (count($data) == 9) {  // Assurez-vous que la ligne a le bon nombre de colonnes
                $users[] = [
                    'id' => $data[0],
                    'social_security_number' => $data[1],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'password' => $data[4],  // Password hash is stored here
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

    // Rechercher l'utilisateur par son N° de sécurité sociale
    foreach ($users as $u) {
        if (trim((string)$u['social_security_number']) === trim((string)$social_security_number)) {
            return $u; // Correspondance trouvée, renvoyer l'utilisateur
        }
    }
    
    return null; // Renvoie null si aucune correspondance n'est trouvée
}

?>
