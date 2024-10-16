<!-- login.php -->
<?php
$pageTitle = "Connexion - Calculateur d'IMC";
include '../handlers/login.php';

// Commencer la capture du contenu
ob_start();
?>

<div class="container">
    <h1>Connexion</h1>
    <form action="login.php" method="POST">
        <label for="social_security_number">N° de sécurité sociale</label>
        <input type="text" name="social_security_number" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" required>
        <br></br>
        <button type="submit">Se connecter</button>
    </form>

    <?php
    // Affichage de l'erreur si elle existe
    if (!empty($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
</div>

<?php
// Fin de la capture, on récupère le contenu dans une variable
$content = ob_get_clean();

// Inclure la base
include 'base.php';
?>