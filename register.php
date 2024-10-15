<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $ssn = $_POST['ssn'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $postalCode = $_POST['postalCode'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

    // Valider les entrées
    $errors = [];
    if (empty($ssn)) $errors[] = "Le N° de sécurité sociale est requis.";
    if (empty($firstName)) $errors[] = "Le prénom est requis.";
    if (empty($lastName)) $errors[] = "Le nom est requis.";
    if (empty($dob)) $errors[] = "La date de naissance est requise.";
    if (empty($phone)) $errors[] = "Le numéro de téléphone est requis.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Un email valide est requis.";
    if (empty($postalCode)) $errors[] = "Le code postal est requis.";
    if (empty($_POST['password'])) $errors[] = "Le mot de passe est requis.";
    if ($_POST['password'] !== $_POST['confirmPassword']) $errors[] = "Les mots de passe ne correspondent pas.";

    // Afficher les erreurs s'il y en a
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit; // Stoppe l'exécution du script si des erreurs sont présentes
    }

    // Chemin du fichier CSV
    $csvFile = 'users.csv';

    // Ouvrir le fichier en mode ajout
    $file = fopen($csvFile, 'a');

    if ($file) {
        // Créer une ligne à écrire dans le fichier
        $data = array($ssn, $firstName, $lastName, $dob, $phone, $email, $postalCode, $password);
        // Écrire la ligne dans le fichier
        fputcsv($file, $data);

        // Fermer le fichier
        fclose($file);

        // Rediriger vers une page de confirmation ou afficher un message
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'ouverture du fichier.";
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
