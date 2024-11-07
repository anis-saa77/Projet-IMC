<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: ../handlers/index.php"); // Redirection vers la page de connexion
    exit();
}

$user_id = $_SESSION['user']['id']; // Récupérer l'ID de l'utilisateur connecté

// Fonction pour lire les données de historic.csv
function getIMCHistory($user_id) {
    $filename = "../includes/historic.csv";
    $history = [];

    if (($handle = fopen($filename, 'r')) !== false) {
        fgetcsv($handle); // Ignorer la première ligne (en-têtes)

        // Lire chaque ligne du fichier CSV
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (count($data) == 5) { // Vérifier que la ligne a 5 colonnes
                
                // Si l'ID correspond à l'utilisateur connecté, ajouter l'entrée à l'historique
                if (trim($data[0]) == $user_id) { // L'ID est dans la première colonne
                    $history[] = [
                        'date' => $data[1],
                        'taille' => $data[2],
                        'poids' => $data[3],
                        'imc' => $data[4]
                    ];

                }
            } else {
                echo "Mauvais format de ligne, attendu 5 colonnes mais reçu " . count($data) . "<br>";
            }
        }
        fclose($handle);
    } else {
        echo "Erreur : Impossible d'ouvrir le fichier.";
    }

    return $history;
}



// Obtenir l'historique de l'utilisateur connecté
$imcHistory = getIMCHistory($user_id);
?>