<!-- base.php -->
<?php
require_once '../src/Config.php';//get project constants
include '../handlers/base.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// echo "<pre>" . print_r(array($_SESSION, BASE_URL_PATH, BASE_URI_PATH,
// DOCTORS_DB_PATH, PATIENTS_DB_PATH), true) . "</pre>";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

   <!-- Navigation -->
   <ul id="navigation_bar">
       <?php if (isset($_SESSION['user'])): ?>
           <!-- Si l'utilisateur est connecté, afficher son prénom et nom -->
           <li><a href="../handlers/logout.php" class="btn">Déconnexion</a></li>
           <li><a href="profile.php" class="btn"><?php echo htmlspecialchars($_SESSION['user']['firstname']) . ' ' . htmlspecialchars($_SESSION['user']['lastname']); ?></a></li>
            <li><a href="../pages/dashboard.php" class="btn">DashBoard</a></li>
            <?php if(isset($_SESSION['user']['doctor_pro_identifier'])): ?>
                <li><a href="../pages/assignPatientToDoctor.php" class="btn">Ajouter Patient</a></li>
            <?php endif; ?>

       <?php else: ?>
           <!-- Sinon, afficher les boutons de connexion et d'inscription -->
           <li><a href="login.php" class="btn">Se connecter</a></li>
           <li><a href="register.php" class="btn">S'inscrire</a></li>

       <?php endif; ?>
   </ul>

    <div class="container">
        <!-- Contenu dynamique ici (Varie selon la page où l'on se trouve) -->
        <?php echo $content; ?>
    </div>

    <footer>
        <p>&copy; 2024 - Calculateur d'IMC</p>
    </footer>
</body>
</html>
