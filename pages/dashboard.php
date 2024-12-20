<?php
require_once '../src/Config.php';//get project constants

$pageTitle = "Dashboard";
include '../handlers/dashboard.php'; // Assurez-vous que ce chemin est correct

// Démarrer la session si elle n'est pas déjà commencée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ob_start();
?>

<?php
// Initialisation des variables
$user = $_SESSION['user'];
$isDoctor = isset($user["doctor_pro_identifier"]);
?>

<div class="container">
    <!-- Affichage des patients du docteur -->
    <?php if ($isDoctor) : ?>
        <?php
            $doctor_id = $user["id"];
            $patients = getPatientsByDoctorID($doctor_id);
        ?>

        <h1>Liste des Patients</h1>

        <!-- Formulaire pour ajouter un patient par numéro de sécurité sociale -->
        <form id="add-patient-form" method="POST" action="">
            <input type="text" id="social_security_number" name="social_security_number" placeholder="Numéro de sécurité sociale" required>
            <button type="submit" name="add_patient">Ajouter</button>
        </form>

        <?php
        if (isset($_POST['add_patient'])) {
            $social_security_number = $_POST['social_security_number'];
            $result = addPatientBySocialSecurity($doctor_id, $social_security_number);

            if ($result === true) {
                echo "<p>Le patient a été ajouté avec succès.</p>";
                $patients = getPatientsByDoctorID($doctor_id);
            } elseif ($result === 'Le patient est déjà assigné à ce médecin.') {
                echo "<p>Le patient est déjà assigné à ce médecin.</p>";
            } else {
                echo "<p>Erreur : le patient n'a pas été trouvé ou le numéro de sécurité sociale est incorrect.</p>";
            }
        }
        ?>

        <!-- Affichage de la liste des patients -->
        <?php if (isset($patients) && count($patients) > 0) : ?>
            <table id="patients-table" >
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Date de naissance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr class="patient-row">
                            <td><?php echo htmlspecialchars($patient['firstname']); ?></td>
                            <td><?php echo htmlspecialchars($patient['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($patient['birthday']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p id="no-patients">Vous n'avez aucun patient.</p>
        <?php endif; ?>
    <?php else : ?>   <!-- Affichage de l'historique du patient -->
        <h1>Dashboard - Historique de l'IMC</h1>
            <?php if (isset($imcHistory)) : ?>
                <?php if (count($imcHistory) > 0) : ?>
                    <table id="historic_table">
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
                <?php else : ?>
                    <p>Aucun enregistrement d'IMC trouvé.</p>
                <?php endif; ?>
            <?php else : ?>
                <p>Erreur : données introuvables.</p>
            <?php endif; ?>
    <?php endif; ?>
</div>


<?php
$content = ob_get_clean();
include 'base.php';
?>
