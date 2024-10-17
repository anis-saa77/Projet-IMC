<?php
$pageTitle = "Dashboard";
include '../handlers/dashboard.php'; // Assurez-vous que ce chemin est correct
session_start();
// Commencer la capture du contenu
ob_start();
?>

<div class="container">
    <h1>Dashboard - Historique de l'IMC</h1>

    <?php if (isset($imcHistory)) : ?>
        <?php if (count($imcHistory) > 0) : ?>
            <table id="customers">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Taille (cm)</th>
                        <th>Poids (kg)</th>
                        <th>IMC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($imcHistory as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                            <td><?php echo htmlspecialchars($record['taille']); ?></td>
                            <td><?php echo htmlspecialchars($record['poids']); ?></td>
                            <td><?php echo htmlspecialchars($record['imc']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Aucun enregistrement d'IMC trouvé.</p>
        <?php endif; ?>
    <?php else : ?>
        <p>Erreur : données introuvables.</p> <!-- Aide à identifier si $imcHistory est bien chargé -->
    <?php endif; ?>
</div>

<?php
// Fin de la capture, récupérer le contenu dans une variable
$content = ob_get_clean();

// Inclure le template de base
include 'base.php';
?>
