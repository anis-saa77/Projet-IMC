<?php
require_once '../src/Config.php';//get project constants

$pageTitle = "Dashboard";
include '../handlers/dashboard.php'; // Assurez-vous que ce chemin est correct
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



// Commencer la capture du contenu
ob_start();
?>

<div>
    <h2>Formulaire de Sécurité du Patient</h2>

    <?= $_SESSION["notification"] ?? ""; ?>
    
    <form action="<?= BASE_URL_PATH . '/handlers/handle_patient_registration.php'; ?>" method="post" onsubmit="return validateForm()">
        <label for="patient_security_number">Numéro de Sécurité du Patient :</label>
        <input type="text" id="patient_security_number" name="patient_security_number" required>
        <br><br>
        <label for="patient_email">Email :</label>
        <input type="text" id="patient_email" name="patient_email" ><br>
        <small>If patient dont exist, send them an invite via email!</small>
        <br><br>

        <input type="submit" value="Ajouter">
    </form>
</div>

<?php
// Fin de la capture, récupérer le contenu dans une variable
$content = ob_get_clean();

// Inclure le template de base
include 'base.php';
?>
