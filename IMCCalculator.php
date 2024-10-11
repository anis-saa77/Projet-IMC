<?php

// Classe pour calculer l'IMC
class IMCCalculator {
    private $weight;
    private $height;

    // Constructeur pour initialiser le poids et la taille depuis les paramètres GET
    public function __construct() {
        if (isset($_GET['weight']) && isset($_GET['height'])) {
            $this->weight = floatval($_GET['weight']);
            // Convertir la taille de centimètres à mètres (si saisie en cm)
            $this->height = floatval($_GET['height']) / 100;
        } else {
            throw new Exception("Les paramètres du poids et de la taille sont requis.");
        }
    }

    // Méthode pour calculer l'IMC
    public function calculateIMC() {
        if ($this->height > 0) {
            return round($this->weight / ($this->height * $this->height), 2);
        } else {
            throw new Exception("La taille doit être supérieure à zéro.");
        }
    }

    // Méthode pour afficher le résultat avec interprétation
    public function displayResult() {
        try {
            $imc = $this->calculateIMC();
            echo "Votre IMC est : <span class='imc-value'>" . $imc . "</span><br>";

            // Interprétation des résultats selon l'IMC avec des conseils
            if ($imc < 18.5) {
                echo "<span class='imc-underweight'>Vous êtes en insuffisance pondérale (maigreur).</span><br>";
                echo "<span class='advice'>Conseil : Il est important d'adopter un régime alimentaire équilibré et de consulter un professionnel de santé pour s'assurer que vous recevez suffisamment de nutriments. Un suivi médical peut être nécessaire pour retrouver un poids sain.</span>";
            } elseif ($imc >= 18.5 && $imc < 25) {
                echo "<span class='imc-normal'>Vous avez une corpulence normale.</span><br>";
                echo "<span class='advice'>Conseil : Continuez à maintenir un mode de vie sain en suivant une alimentation équilibrée et en faisant régulièrement de l'exercice. Préserver cette stabilité est idéal pour votre santé.</span>";
            } elseif ($imc >= 25 && $imc < 30) {
                echo "<span class='imc-overweight'>Vous êtes en surpoids.</span><br>";
                echo "<span class='advice'>Conseil : Il pourrait être bénéfique d'adopter des habitudes alimentaires plus équilibrées et d'augmenter l'activité physique pour éviter que le surpoids n'évolue vers des problèmes de santé plus graves. Consultez un professionnel de santé pour des conseils personnalisés.</span>";
            } elseif ($imc >= 30 && $imc < 35) {
                echo "<span class='imc-obesity-moderate'>Vous êtes en obésité modérée.</span><br>";
                echo "<span class='advice'>Conseil : Il est recommandé de suivre un programme alimentaire adapté et de pratiquer une activité physique régulière. Un suivi médical est conseillé pour réduire les risques associés à l'obésité.</span>";
            } elseif ($imc >= 35 && $imc < 40) {
                echo "<span class='imc-obesity-severe'>Vous êtes en obésité sévère.</span><br>";
                echo "<span class='advice'>Conseil : Une intervention médicale et des changements significatifs dans votre style de vie sont fortement recommandés. Consultez un médecin ou un nutritionniste pour élaborer un plan adapté à vos besoins.</span>";
            } else {
                echo "<span class='imc-obesity-morbid'>Vous êtes en obésité morbide ou massive.</span><br>";
                echo "<span class='advice'>Conseil : L'obésité morbide présente un risque élevé pour la santé. Il est impératif de consulter un professionnel de santé pour un accompagnement médical. Un suivi régulier, ainsi qu'un programme alimentaire et physique personnalisé, sont essentiels.</span>";
            }

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }


}

?>
