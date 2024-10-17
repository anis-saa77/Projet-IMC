<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $ssn = filter_input(INPUT_POST, 'ssn', FILTER_SANITIZE_STRING);
    $doctor_pro_identifier = filter_input(INPUT_POST, 'doctor_pro_identifier', FILTER_SANITIZE_STRING);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $registerAsDoctor = isset($_POST['registerAsDoctor']);

    // Validate required fields
    if ((empty($ssn) && empty($doctor_pro_identifier)) || empty($firstName) || empty($lastName) || empty($dob) || empty($phone) || empty($email) || empty($postalCode) || empty($password) || empty($confirmPassword)) {
        $error = "Tous les champs sont requis.";
    }

    // Validate SSN format
    if (!empty($ssn) && !isset($error) && !preg_match('/^\d{3}-\d{2}-\d{4}$/', $ssn)) {
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

        // Prepare user data
        if ($registerAsDoctor) {
            // Find the next ID for doctors
            $filePath = '../includes/doctors.csv';
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

            // Prepare doctor data
            $userData = [
                $nextId,           // Auto-incremented ID
                $doctor_pro_identifier,
                $firstName,
                $lastName,
                $hashedPassword,
                $dob,
                $phone,
                $email,
                $postalCode,
            ];
        } else {
            // Find the next ID for users
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

            // Prepare user data
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
        }

        // Write to the appropriate CSV file
        $file = fopen($registerAsDoctor ? $filePath : '../includes/users.csv', 'a');
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
