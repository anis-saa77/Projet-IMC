<!-- login.php -->
<?php
$pageTitle = "Connexion - Calculateur d'IMC";
include '../handlers/login.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Start output buffering
ob_start();
?>

<div class="container">
    <h1>Connexion</h1>
    <form action="login.php" method="POST">
        <label for="social_security_number">N° de sécurité sociale/Numéro professionnelle médecin</label>
        <input type="text" name="social_security_number" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" required>

        <label for="is_doctor">Je suis un médecin</label>
        <input type="checkbox" name="is_doctor" value="1"> <!-- Checkbox for doctor login -->

        <br></br>
        <button type="submit">Se connecter</button>
    </form>

    <?php
    // Display the error if it exists
    if (!empty($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
</div>

<?php
// End output buffering and get the content
$content = ob_get_clean();

// Include the base
include 'base.php';
?>
