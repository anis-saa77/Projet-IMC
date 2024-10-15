<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calculateur d'IMC</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Calculateur d'IMC</h1>
        <form action="imc_result.php" method="get">
            <label for="weight">Poids (kg) :</label>
            <input type="number" name="weight" required>
            <label for="height">Taille (cm) :</label>
            <input type="number" name="height" required>
            <button type="submit">Calculer</button>
        </form>
        <a href="logout.php">Se déconnecter</a>
    </div>
</body>
</html>
