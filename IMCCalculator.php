<?php

class IMCCalculator {
    private $weight;
    private $height;

    // Constructor to initialize weight and height from GET parameters
    public function __construct() {
        if (isset($_GET['weight']) && isset($_GET['height'])) {
            $this->weight = floatval($_GET['weight']);
            $this->height = floatval($_GET['height']);
        } else {
            throw new Exception("Weight and height parameters are required.");
        }
    }

    // Method to calculate IMC
    public function calculateIMC() {
        if ($this->height > 0) {
            return round($this->weight / ($this->height * $this->height), 2);
        } else {
            throw new Exception("Height must be greater than zero.");
        }
    }

    // Method to display the result
    public function displayResult() {
        try {
            $imc = $this->calculateIMC();
            echo "Your IMC is: " . $imc;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Create an instance of IMCCalculator and display the result
// try {
//     $imcCalculator = new IMCCalculator();
//     $imcCalculator->displayResult();
// } catch (Exception $e) {
//     echo "Error: " . $e->getMessage();
// }
