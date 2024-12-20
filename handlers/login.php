<?php


require_once BASE_URI_PATH . "/src/CsvHandler.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $social_security_number = $_POST['social_security_number'];
    $password = $_POST['password'];
    $isDoctor = isset($_POST['is_doctor']) ? true : false; // Check if the user is a doctor

    // Retrieve the user from the CSV file based on their type
    $user = CsvHandler::getUserFromData($social_security_number, $password, $isDoctor);

    // Validate the credentials
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
