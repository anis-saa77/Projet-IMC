<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Calculateur d'IMC</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="interface_style.css">
</head>
<body>

    <!-- Navigation -->
    <ul>
        <li><a href="login.php" class="btn">Se connecter</a></li>
        <li><a class="btn" href="javascript:void(0);" onclick="openModal()">S'inscrire</a></li>
    </ul>

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

    <!-- Fenêtre modale pour l'inscription -->
    <div id="signupModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>S'inscrire</h2>
            <form id="signupForm" method="post" action="register.php">
                <label for="ssn">N° de sécurité sociale:</label>
                <input type="text" id="ssn" name="ssn" placeholder="Entrez votre N° de sécurité sociale" required>

                <label for="firstName">Prénom:</label>
                <input type="text" id="firstName" name="firstName" placeholder="Entrez votre prénom" required>

                <label for="lastName">Nom:</label>
                <input type="text" id="lastName" name="lastName" placeholder="Entrez votre nom" required>

                <label for="dob">Date de naissance:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="phone">N° de téléphone:</label>
                <input type="tel" id="phone" name="phone" placeholder="Entrez votre numéro de téléphone" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required>

                <label for="postalCode">Code postal:</label>
                <input type="text" id="postalCode" name="postalCode" placeholder="Entrez votre code postal" required>

                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" placeholder="Créez un mot de passe" required>

                <label for="confirmPassword">Confirmer le mot de passe:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe" required>

                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>

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

        // Fonction pour ouvrir la modale
        function openModal() {
            document.getElementById("signupModal").style.display = "block"; // Afficher la modale
        }

        // Fonction pour fermer la modale
        function closeModal() {
            document.getElementById("signupModal").style.display = "none"; // Masquer la modale
        }

        // Fermer la modale si l'utilisateur clique en dehors de celle-ci
        window.onclick = function(event) {
            let modal = document.getElementById("signupModal");
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>

</body>
</html>
