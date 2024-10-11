<?php
session_start();

// Si l'utilisateur est déjà connecté, rediriger vers la page de calcul d'IMC
if (isset($_SESSION['user_id'])) {
    header("Location: imc.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Calculateur d'IMC</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur le calculateur d'IMC</h1>
        <p>Veuillez vous connecter ou vous inscrire pour accéder au calculateur d'IMC.</p>

        <div class="actions">
            <a href="login.php" class="btn">Se connecter</a>
            <a href="register.php" class="btn">S'inscrire</a>
        </div>
    </div>
</body>
</html>
