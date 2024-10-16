<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Détruire la session
    session_unset(); // Supprimer toutes les variables de session
    session_destroy(); // Détruire la session
}

// Rediriger l'utilisateur vers la page d'accueil ou la page de connexion
header("Location: ../pages/index.php"); // Vous pouvez rediriger vers index.php ou une autre page
exit(); // Terminer le script pour s'assurer qu'aucun code ne s'exécute après la redirection
?>

