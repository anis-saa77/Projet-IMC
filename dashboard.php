<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur connecté

// Fonction pour lire les données de historic.csv
function getIMCHistory($user_id) {
    $filename = "includes/historic.csv";
    $history = [];

    if (($handle = fopen($filename, 'r')) !== false) {
        fgetcsv($handle); // Ignorer la première ligne (en-têtes)

        // Lire chaque ligne du fichier CSV
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (count($data) == 5) { // Vérifier que la ligne a 5 colonnes
                // Si l'ID correspond à l'utilisateur connecté, ajouter l'entrée à l'historique
                if (trim($data[4]) == $user_id) {
                    $history[] = [
                        'date' => $data[0],
                        'taille' => $data[1],
                        'poids' => $data[2],
                        'imc' => $data[3]
                    ];
                }
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard - Historique de l'IMC</h1>

        <?php if (count($imcHistory) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Taille (cm)</th>
                        <th>Poids (kg)</th>
                        <th>IMC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($imcHistory as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                            <td><?php echo htmlspecialchars($record['taille']); ?></td>
                            <td><?php echo htmlspecialchars($record['poids']); ?></td>
                            <td><?php echo htmlspecialchars($record['imc']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun enregistrement d'IMC trouvé.</p>
        <?php endif; ?>

        <a href="logout.php" class="btn">Se déconnecter</a>
    </div>
</body>
</html>
