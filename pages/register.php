<!-- register.php -->
<?php
$pageTitle = "Inscription - Calculateur d'IMC";
include '../handlers/register.php';
session_start();

// Commencer la capture du contenu
ob_start();
?>

<div id="signupModal" class="modal">
    <div class="modal-content">
        <h1>Inscription</h1>

        <?php
        if (isset($error)) {
            echo '<div style="color: red;">' . $error . '</div>';
        }
        if (isset($success)) {
            echo '<div style="color: green;">' . $success . '</div>';
        }
        ?>

        <form id="signupForm" method="POST">
            <label for="ssn">N° de sécurité sociale:</label>
            <input type="text" id="ssn" name="ssn" placeholder="Entrez votre N° de sécurité sociale" required value="<?php echo isset($ssn) ? htmlspecialchars($ssn) : ''; ?>">

            <label for="firstName">Prénom:</label>
            <input type="text" id="firstName" name="firstName" placeholder="Entrez votre prénom" required value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>">

            <label for="lastName">Nom:</label>
            <input type="text" id="lastName" name="lastName" placeholder="Entrez votre nom" required value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>">

            <label for="dob">Date de naissance:</label>
            <input type="date" id="dob" name="dob" required value="<?php echo isset($dob) ? htmlspecialchars($dob) : ''; ?>">

            <label for="phone">N° de téléphone:</label>
            <input type="tel" id="phone" name="phone" placeholder="Entrez votre numéro de téléphone" required value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Entrez votre email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

            <label for="postalCode">Code postal:</label>
            <input type="text" id="postalCode" name="postalCode" placeholder="Entrez votre code postal" required value="<?php echo isset($postalCode) ? htmlspecialchars($postalCode) : ''; ?>">

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" placeholder="Créez un mot de passe" required>

            <label for="confirmPassword">Confirmer le mot de passe:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe" required>
            <br></br>
            <button type="submit">S'inscrire</button>
        </form>
    </div>
</div>

<?php
// Fin de la capture, on récupère le contenu dans une variable
$content = ob_get_clean();

// Inclure la base
include 'base.php';
?>