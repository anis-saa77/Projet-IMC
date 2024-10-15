<?php
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $ssn = $_POST['ssn'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $postalCode = $_POST['postalCode'];

    $password = $_POST['password'];

    // Valider que toutes les informations sont présentes
    if (empty($ssn) || empty($firstName) || empty($lastName) || empty($dob) || empty($phone) || empty($email) || empty($postalCode) || empty($password)) {
        die("Tous les champs sont requis.");
    }

    // Créer une nouvelle ligne pour l'utilisateur
    $id = getLastUserId('includes/users.csv') + 1;

    $userData = [
        $id,
        $ssn,
        $firstName,
        $lastName,
        password_hash($password, PASSWORD_DEFAULT),
        $dob,
        $phone,
        $email,
        $postalCode,
    ];

    // Ouvrir le fichier users.csv en mode ajout
    $file = fopen('includes/users.csv', 'a');

    // Vérifier si le fichier s'est ouvert avec succès
    if ($file) {
        // Écrire les données dans le fichier
        fputcsv($file, $userData);
        fclose($file);
        echo "Inscription réussie !"; // Message de confirmation
    } else {
        echo "Erreur lors de l'ouverture du fichier.";
    }
}

function getLastUserId($filename) {
    $lastId = 0;

    if (($handle = fopen($filename, 'r')) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $lastId = $data[0]; // La première colonne contient l'ID
        }
        fclose($handle);
    }

    return $lastId;
}

// Générer un nouvel ID
?>
