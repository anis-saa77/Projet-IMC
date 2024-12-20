<?php

class CsvHandler{


    public static function getUserFromData($social_security_number, $password, $isDoctor) {
        $filename = $isDoctor ? DOCTORS_DB_PATH : PATIENTS_DB_PATH; // Determine the correct file
        $users = [];
    
        if (($handle = fopen($filename, 'r')) !== false) {
            fgetcsv($handle); // Ignore the first line (headers)
    
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
                } elseif (!$isDoctor && count($data) == 9) {  // User CSV has 9 fields
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
                        'family_doctor' => $data[9]
                    ];
                }
            }
            fclose($handle);
        } else {
            echo "Erreur : Impossible d'ouvrir le fichier.";
        }
    
        // Search for the user by their social security number
        foreach ($users as $u) {
            if (!$isDoctor && trim((string)$u['social_security_number']) === trim((string)$social_security_number)) {
                return $u; // Match found, return the user
            }
            if($isDoctor && trim((string)$u['doctor_pro_identifier']) === trim((string)$social_security_number)){
                return $u;
            }
        }
    
        return null; // Return null if no match is found
    }

    public static function patientExists($social_security_number):bool {
        $filename = PATIENTS_DB_PATH; // The file where patient data is stored
    
        if (($handle = fopen($filename, 'r')) !== false) {
            fgetcsv($handle); // Skip header line
    
            // Loop through the CSV file to find if the social security number exists
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) == 10 && trim((string)$data[1]) === trim((string)$social_security_number)) {
                    fclose($handle);
                    return true; // Patient found
                }
            }
            fclose($handle);
        } else {
            echo "Erreur : Impossible d'ouvrir le fichier.";
        }
    
        return false; // Return false if no patient found
    }

    public static function getAllPatients():array {
        $filename = PATIENTS_DB_PATH; // The file where patient data is stored
        $patients = [];
    
        if (($handle = fopen($filename, 'r')) !== false) {
            fgetcsv($handle); // Skip header line
    
            // Loop through the CSV file to read patient data
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) == 10) { // Only process patient rows
                    $patients[] = [
                        'id' => $data[0],
                        'social_security_number' => $data[1],
                        'firstname' => $data[2],
                        'lastname' => $data[3],
                        'password' => $data[4],
                        'birthday' => $data[5],
                        'phone_number' => $data[6],
                        'email' => $data[7],
                        'postal_code' => $data[8],
                        'family_doctor' => $data[9]
                    ];
                }
            }
            fclose($handle);
        } else {
            echo "Erreur : Impossible d'ouvrir le fichier.";
        }
    
        return $patients;
    }

    public static function updatePatient($social_security_number, $updatedData) {
        $filename = PATIENTS_DB_PATH; // The file where patient data is stored
        $patients = [];
        $patientFound = false;

        // Read the CSV file
        if (($handle = fopen($filename, 'r')) !== false) {
            $header = fgetcsv($handle); // Read and store the header
            // Loop through each record
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) == 10 && trim($data[1]) === trim($social_security_number)) {
                    // Update the patient data if a match is found
                    $data = $updatedData;
                    $patientFound = true; // Flag to indicate that a match was found and updated
                }
                $patients[] = $data; // Add the row (updated or not) to the patients array
            }
            fclose($handle);
        } else {
            echo "Erreur : Impossible d'ouvrir le fichier.";
            return false;
        }

        if (!$patientFound) {
            echo "Patient not found.";
            return false;
        }

        // Rewrite the CSV file with the updated data
        if (($handle = fopen($filename, 'w')) !== false) {
            // Write the header first
            fputcsv($handle, $header);
            // Write all patient records back to the file
            foreach ($patients as $patient) {
                fputcsv($handle, $patient);
            }
            fclose($handle);
            echo "Patient record updated successfully.";
            return true;
        } else {
            echo "Erreur : Impossible d'ouvrir le fichier pour l'écriture.";
            return false;
        }
    }

    public static function getPatientBySocialSecurityNumber($social_security_number) {
        $filename = PATIENTS_DB_PATH; // The file where patient data is stored
        $patient = null;

        // Open the CSV file
        if (($handle = fopen($filename, 'r')) !== false) {
            fgetcsv($handle); // Skip the header row

            // Loop through each record
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) == 10 && trim($data[1]) === trim($social_security_number)) {
                    // Patient found, store the data
                    $patient = [
                        'id' => $data[0],
                        'social_security_number' => $data[1],
                        'firstname' => $data[2],
                        'lastname' => $data[3],
                        'password' => $data[4],
                        'birthday' => $data[5],
                        'phone_number' => $data[6],
                        'email' => $data[7],
                        'postal_code' => $data[8],
                        'family_doctor' => $data[9]
                    ];
                    break; // No need to continue searching once found
                }
            }
            fclose($handle);
        } else {
            echo "Erreur : Impossible d'ouvrir le fichier.";
        }

        return $patient; // Return the patient data or null if not found
    }
}

