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

    // Méthode pour afficher le résultat
    public function displayResult() {
        try {
            $imc = $this->calculateIMC();
            echo "Votre IMC est : " . $imc;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}

?>
