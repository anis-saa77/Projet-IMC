<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $ssn = filter_input(INPUT_POST, 'ssn', FILTER_SANITIZE_STRING);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate required fields
    if (empty($ssn) || empty($firstName) || empty($lastName) || empty($dob) || empty($phone) || empty($email) || empty($postalCode) || empty($password) || empty($confirmPassword)) {
        $error = "Tous les champs sont requis.";
    }

    // Validate SSN format
    if (!isset($error) && !preg_match('/^\d{3}-\d{2}-\d{4}$/', $ssn)) {
        $error = "Format de N° de sécurité sociale invalide.";
    }

    // Check if passwords match
    if (!isset($error) && $password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    }

    // If no error, process the form
    if (!isset($error)) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Find the next ID
        $filePath = '../includes/users.csv';
        $nextId = 1;

        if (file_exists($filePath)) {
            $file = fopen($filePath, 'r');
            while (($row = fgetcsv($file)) !== false) {
                $lastRow = $row;
            }
            fclose($file);

            // If there is a last row, increment the ID
            if (isset($lastRow)) {
                $nextId = (int)$lastRow[0] + 1;
            }
        }

        // Prepare user data with the new ID
        $userData = [
            $nextId,           // Auto-incremented ID
            $ssn,
            $firstName,
            $lastName,
            $hashedPassword,
            $dob,
            $phone,
            $email,
            $postalCode,
        ];

        // Write to CSV
        $file = fopen($filePath, 'a');
        if ($file) {
            fputcsv($file, $userData);
            fclose($file);
            $success = "Inscription réussie !";
        } else {
            $error = "Erreur lors de l'ouverture du fichier.";
        }
    }
}
?>
