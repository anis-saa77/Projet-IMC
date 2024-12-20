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

function addPatientBySocialSecurity($doctor_id, $social_security_number) {
    $filename = '../includes/users.csv';
    $temp_filename = '../includes/temp_users.csv'; // Fichier temporaire pour la mise à jour

    // Ouvrir le fichier CSV en lecture
    if (($handle = fopen($filename, 'r')) !== false) {
        // Créer un fichier temporaire en écriture
        if (($temp_handle = fopen($temp_filename, 'w')) !== false) {
            // Lire l'en-tête du CSV et enlever les espaces autour des clés
            $header = fgetcsv($handle);
            $header = array_map('trim', $header); // Applique trim() à chaque clé du header

            // Écrire l'en-tête dans le fichier temporaire
            fputcsv($temp_handle, $header);

            $patient_found = false;
            $patient_already_assigned = false; // Nouveau flag pour vérifier si le patient est déjà assigné

            // Lire chaque ligne du fichier
            while (($data = fgetcsv($handle)) !== false) {
                // Nettoyer les espaces autour des données
                $data = array_map('trim', $data); // Applique trim() à chaque champ

                $user_data = array_combine($header, $data);

                // Vérifier si le numéro de sécurité sociale correspond (en tenant compte des espaces)
                if (trim($user_data['social_security_number']) === trim($social_security_number)) {
                    // Vérifier si le doctor_id est déjà le bon
                    if ($user_data['doctor_id'] === $doctor_id) {
                        $patient_already_assigned = true; // Le patient est déjà assigné à ce médecin
                    } else {
                        // Mettre à jour le doctor_id du patient
                        $user_data['doctor_id'] = $doctor_id;
                        $patient_found = true;
                    }
                }

                // Écrire la ligne dans le fichier temporaire (mise à jour si nécessaire)
                fputcsv($temp_handle, $user_data);
            }

            fclose($handle);
            fclose($temp_handle);

            // Si le patient a été trouvé et ajouté, remplacer le fichier original par le fichier temporaire
            if ($patient_found) {
                rename($temp_filename, $filename); // Remplacer l'ancien fichier par le mis à jour
                return true; // Patient ajouté avec succès
            } elseif ($patient_already_assigned) {
                // Le patient est déjà attribué à ce médecin
                unlink($temp_filename); // Supprimer le fichier temporaire
                return 'Le patient est déjà assigné à ce médecin.';
            } else {
                // Supprimer le fichier temporaire si le patient n'a pas été trouvé
                unlink($temp_filename);
                return false; // Patient non trouvé
            }
        } else {
            // Erreur d'ouverture du fichier temporaire
            fclose($handle);
            return false;
        }
    } else {
        // Erreur d'ouverture du fichier original
        return false;
    }
}

// Obtenir l'historique de l'utilisateur connecté
$imcHistory = getIMCHistory($user_id);
?>