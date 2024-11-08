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

function getDoctorFullNameByID($id) {
    // Chemin vers le fichier CSV
    $filename = '../includes/doctors.csv';

    // Ouvrir le fichier CSV en lecture
    if (($handle = fopen($filename, 'r')) !== false) {
        // Lire l'en-tête
        $header = fgetcsv($handle);

        // Parcourir chaque ligne du fichier CSV
        while (($data = fgetcsv($handle)) !== false) {
            // Associer les données de la ligne avec les noms des colonnes
            $doctor_data = array_combine($header, $data);

            // Vérifier si l'ID du docteur correspond à celui passé en paramètre
            if ($doctor_data['id'] == $id) {
                // Retourner le nom complet du docteur (prénom + nom)
                $fullname = $doctor_data['firstname'] . ' ' . $doctor_data['lastname'];
                return $fullname;
            }
        }

        // Fermer le fichier
        fclose($handle);
    }

    // Retourner null si aucun docteur avec cet ID n'est trouvé
    return null;
}

function getPatientsByDoctorID($doctor_id){
    $filename = '../includes/users.csv';
    $patients = [];

    if (($handle = fopen($filename, 'r')) !== false) {
        $header = fgetcsv($handle); // Lire l'en-tête

        while (($data = fgetcsv($handle)) !== false) {
            // Supprime les espaces autour des clés et des valeurs
            $user_data = array_combine(array_map('trim', $header), array_map('trim', $data));

            if (isset($user_data['doctor_id']) && $user_data['doctor_id'] == $doctor_id) {
                $patients[] = [
                    'firstname' => $user_data['firstname'],
                    'lastname' => $user_data['lastname'],
                    'birthday' => $user_data['birthday']
                ];
            }
        }
        fclose($handle);
    } else {
        echo "<p>Erreur : Impossible d'ouvrir le fichier CSV.</p>";
    }
    return $patients;
}

// Obtenir l'historique de l'utilisateur connecté
$imcHistory = getIMCHistory($user_id);
?>