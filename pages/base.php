<!-- base.php -->
<?php
include '../handlers/base.php';
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
