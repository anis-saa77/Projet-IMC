<?php
$pageTitle = "IMC Calculator";
include '../handlers/index.php';

// Commencer à capturer le contenu
ob_start();
?>


    <div class="container">
            <h1>Bienvenue sur le calculateur d'IMC</h1>
            <p style="text-align: center;">Veuillez vous connecter ou vous inscrire pour accéder à votre tableau de bord.</p>
    </div>


    <!-- Formulaire pour saisir le poids et la taille -->
    <form id="imcForm" method="get" action="">
        <label for="weight">Poids(kg) :</label>
        <input type="number" id="weight" name="weight" placeholder="Entrez votre poids en kg" required>

        <label for="height">Taille(cm) :</label>
        <input type="number" id="height" name="height" placeholder="Entrez votre taille en cm" required>

        <button type="submit" onclick="return validateForm()">Calculer l'IMC</button>
    </form>

    <div class="result" id="resultat">
        <?php
            if (isset($_GET['weight']) && isset($_GET['height'])) {
                try {
                    $imcCalculator = new IMCCalculator();
                    $imcCalculator->displayResult();
                } catch (Exception $e) {
                    echo "Erreur : " . $e->getMessage();
                }
            }
        ?>
    </div>

<?php
// Fin de la capture, on récupère le contenu dans une variable
$content = ob_get_clean();

// Inclure la base
include 'base.php';
?>

<script>
    // Validation du formulaire IMC
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