<?php
// db.php : Connexion à la base de données
$host = 'localhost';
$db = 'imc_db';
$user = 'theophong@outlook.fr'; // Remplacez par votre nom d'utilisateur MySQL
$pass = 'Azerty0306&*';     // Remplacez par votre mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
