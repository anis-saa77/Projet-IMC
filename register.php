<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $ssn = filter_input(INPUT_POST, 'ssn', FILTER_SANITIZE_STRING);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate required fields
    if (empty($ssn) || empty($firstName) || empty($lastName) || empty($dob) || empty($phone) || empty($email) || empty($postalCode) || empty($password) || empty($confirmPassword)) {
        $error = "Tous les champs sont requis.";
    }

    // Validate SSN format
    if (!isset($error) && !preg_match('/^\d{3}-\d{2}-\d{4}$/', $ssn)) {
        $error = "Format de N° de sécurité sociale invalide.";
    }

    // Check if passwords match
    if (!isset($error) && $password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    }

    // If no error, process the form
    if (!isset($error)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare user data
        $userData = [
            $ssn,
            $firstName,
            $lastName,
            $hashedPassword,
            $dob,
            $phone,
            $email,
            $postalCode,
        ];

        // Write to CSV
        $file = fopen('includes/users.csv', 'a');
        if ($file) {
            fputcsv($file, $userData);
            fclose($file);
            $success = "Inscription réussie !";
        } else {
            $error = "Erreur lors de l'ouverture du fichier.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="interface_style.css">
    <title>Formulaire d'inscription</title>
</head>
<body>

<div id="signupModal" class="modal">
    <div class="modal-content">
        <h2>S'inscrire</h2>

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

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</div>

</body>
</html>
