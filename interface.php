<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web service calcul d'IMC</title>
    <link rel="stylesheet" href="interface_style.css">
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f0f8ff; /* Bleu clair apaisant */
        }

        /* Titre principal */
        h1 {
            color: #333; /* Texte foncé pour la lisibilité */
            text-align: center;
            font-size: 36px; /* Grande taille pour le titre */
        }

        /* Formulaire */
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff; /* Fond blanc pour le formulaire */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Ombre douce */
            border-radius: 8px;
        }

        /* Étiquettes */
        label {
            display: block;
            margin: 15px 0 5px;
            color: #555; /* Texte secondaire */
        }

        /* Champs de saisie */
        input[type="number"],
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc; /* Bordure grise */
            border-radius: 4px;
        }

        /* Bouton */
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745; /* Vert frais */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transition douce */
        }

        button:hover {
            background-color: #218838; /* Vert foncé au survol */
        }

        /* Résultats */
        .result {
            text-align: center;
            margin-top: 20px;
            font-size: 18px; /* Taille de texte normale */
            font-weight: bold; /* Gras pour le texte de résultats */
            background-color: #e0f7fa; /* Fond très clair */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Ombre douce */
        }

        /* Style pour le bouton S'inscrire */
        .signup-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 10px; /* Réduire la taille du bouton */
            background-color: #007bff; /* Couleur bleue pour le bouton */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s; /* Transition douce */
            font-size: 14px; /* Taille de police plus petite */
        }

        .signup-button:hover {
            background-color: #0056b3; /* Couleur bleue foncée au survol */
        }

        /* Style pour la fenêtre modale */
        .modal {
            display: none; /* Masquer par défaut */
            position: fixed; /* Rester au même endroit lors du défilement */
            z-index: 1000; /* Au-dessus de tout le reste */
            left: 0;
            top: 0;
            width: 100%; /* Plein écran */
            height: 100%; /* Plein écran */
            overflow: auto; /* Activer le défilement si nécessaire */
            background-color: rgb(0,0,0); /* Couleur de fond noire */
            background-color: rgba(0,0,0,0.4); /* Avec opacité */
        }

        /* Contenu de la modale */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* Centrer la modale */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Largeur de la modale */
            max-width: 500px; /* Largeur maximale */
            border-radius: 8px; /* Coins arrondis */
        }

        /* Bouton pour fermer la modale */
        .close {
            color: #aaa;
            float: right; /* À droite */
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black; /* Change la couleur au survol */
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1>Calcul de l'IMC</h1>

<!-- Formulaire pour calculer l'IMC -->
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

<!-- Bouton S'inscrire -->
<button class="signup-button" onclick="openModal()">S'inscrire</button>

<!-- Fenêtre modale pour l'inscription -->
<div id="signupModal" class="modal">
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
