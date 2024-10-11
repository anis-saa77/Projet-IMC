<?php
//include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hachage du mot de passe

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    try {
        $stmt->execute([$username, $password]);
        header("Location: login.php");
        exit();
    } catch (Exception $e) {
        $error = "Erreur lors de l'inscription. Ce nom d'utilisateur est peut-être déjà pris.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <form action="register.php" method="POST">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="username" required>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" required>
            <button type="submit">S'inscrire</button>
        </form>
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
    </div>
</body>
</html>
