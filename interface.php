<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Web service calcul d'IMC</title>
  <link rel="stylesheet" href="interface_style.css">
</head>
<body>
<h1>Calcul de l'IMC</h1>

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
