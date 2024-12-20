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

// function getUserFromData($social_security_number, $password, $isDoctor) {
//     $filename = $isDoctor ? "../includes/doctors.csv" : "../includes/users.csv"; // Determine the correct file
//     $users = [];

//     if (($handle = fopen($filename, 'r')) !== false) {
//         fgetcsv($handle); // Ignore the first line (headers)

        // Read each line from the CSV file
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if ($isDoctor && count($data) == 9) {  // Doctor CSV has 8 fields
                $users[] = [
                    'id' => $data[0],
                    'doctor_pro_identifier' => $data[1],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'password' => $data[4],
                    'birthday' => $data[5],
                    'phone_number' => $data[6],
                    'email' => $data[7],
                    'postal_code' => $data[8],

                    // Note: No postal_code for doctors in this CSV structure
                ];
            } elseif (!$isDoctor && count($data) == 10) {  // User CSV has 9 fields
                $users[] = [
                    'id' => $data[0],
                    'social_security_number' => $data[1],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'password' => $data[4],
                    'birthday' => $data[5],
                    'phone_number' => $data[6],
                    'email' => $data[7],
                    'postal_code' => $data[8],
                    'doctor_id' => $data[9],
                ];
            }
        }
        fclose($handle);
    } else {
        echo "Erreur : Impossible d'ouvrir le fichier.";
    }

//     // Search for the user by their social security number
//     foreach ($users as $u) {
//         if (!$isDoctor && trim((string)$u['social_security_number']) === trim((string)$social_security_number)) {
//             return $u; // Match found, return the user
//         }
//         if($isDoctor && trim((string)$u['doctor_pro_identifier']) === trim((string)$social_security_number)){
//             return $u;
//         }
//     }

//     return null; // Return null if no match is found
// }
?>
