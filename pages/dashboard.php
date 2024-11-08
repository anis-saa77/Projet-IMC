<?php
$pageTitle = "Dashboard";
include '../handlers/dashboard.php'; // Assurez-vous que ce chemin est correct

// Démarrer la session si elle n'est pas déjà commencée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Commencer la capture du contenu
ob_start();
?>

<div class="container">
    <?php
    // Initialisation des variables
    $user = $_SESSION['user'];
    $isDoctor = isset($user["doctor_pro_identifier"]);
    ?>

    <?php if ($isDoctor): ?>
        <?php
            $doctor_id = $user["id"];
            $patients = getPatientsByDoctorID($doctor_id);
        ?>
        <h1>Liste des Patients</h1>

        <?php if (isset($patients) && count($patients) > 0): ?>
            <table id="customers">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Date de naissance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($patient['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($patient['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($patient['birthday']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Vous n'avez aucun patient.</p>
        <?php endif; ?>

    <?php else: ?>
        <?php
            // Afficher le nom du médecin traitant pour les utilisateurs non-docteurs
            $doctors_name = getDoctorFullNameByID($user['doctor_id']);
            if (isset($doctors_name)) {
                echo "<p>Mon Médecin traitant : $doctors_name </p>";
            } else {
                echo "<p>Vous n'avez pas de médecin traitant !</p>";
            }
        ?>

        <h1>Dashboard - Historique de l'IMC</h1>
        <?php if (isset($imcHistory)): ?>
            <?php if (count($imcHistory) > 0): ?>
                <table id="customers">
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
        <?php else: ?>
            <p>Erreur : données introuvables.</p> <!-- Aide à identifier si $imcHistory est bien chargé -->
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
// Fin de la capture, récupérer le contenu dans une variable
$content = ob_get_clean();

// Inclure le template de base
include 'base.php';
?>
