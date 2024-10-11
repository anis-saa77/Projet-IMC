<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Calculateur d'IMC</title>
    <link rel="stylesheet" href="css/styles.css">
     <ul>
        <li><a href="login.php" class="btn">Se connecter</a></li>
        <li><a href="register.php" class="btn">S'inscrire</a></li>
    </ul>
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur le calculateur d'IMC</h1>
        <p style="text-align: center;">Veuillez vous connecter ou vous inscrire pour accéder à votre tableau de bord.</p>


    </div>

    <!-- Formulaire pour saisir le poids et la taille -->
    <form id="imcForm" method="get" action="">
  <label for="weight">Poids (kg):</label>
  <input type="number" id="weight" name="weight" placeholder="Entrez votre poids en kg" required>

  <label for="height">Taille (cm):</label>
  <input type="number" id="height" name="height" placeholder="Entrez votre taille en cm" required>

  <button type="submit" onclick="return validateForm()">Calculer l'IMC</button>
</form>

    <div class="result" id="resultat">
        <?php
            if (isset($_GET['weight']) && isset($_GET['height'])) {
                include 'IMCCalculator.php';
                try {
                    $imcCalculator = new IMCCalculator();
                    $imcCalculator->displayResult();
                } catch (Exception $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }

        ?>
</div>

    <script>
        function validateForm() {
            let weight = document.getElementById("weight").value;
            let height = document.getElementById("height").value;

            if (weight <= 0 || height <= 0) {
                alert("Le poids et la taille doivent être des valeurs positives.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
