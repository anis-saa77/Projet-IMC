<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web service calcul d'IMC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f0f8ff;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        label {
            display: block;
            margin: 15px 0 5px;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .result {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h1>Calcul de l'IMC</h1>

<form id="imcForm" method="get" action="">
    <label for="weight">Poids (kg) :</label>
    <input type="number" id="weight" name="weight" placeholder="Entrez votre poids en kg" required>

    <label for="height">Taille (cm) :</label>
    <input type="number" id="height" name="height" placeholder="Entrez votre taille en cm" required>

    <button type="submit" onclick="return validateForm()">Calculer l'IMC</button>
</form>

<div class="result" id="resultat">
    <?php
    if (isset($_GET['weight']) && isset($_GET['height'])) {
        // Inclure la classe IMCCalculator pour traiter les données
        include 'IMCCalculator.php';
        try {
            // Créer une instance de la classe et afficher le résultat
            $imcCalculator = new IMCCalculator();
            $imcCalculator->displayResult();
    } catch (Exception $e) {
    // Afficher un message d'erreur en cas de problème
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
