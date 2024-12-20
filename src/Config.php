<?php
// Define the base directory of the project
if (!defined('BASE_URI_PATH')) {
    define('BASE_URI_PATH', dirname(__DIR__));
}

// Define the base URL path dynamically
if (!defined('BASE_URL_PATH')) {
    $projectFolder = basename(BASE_URI_PATH);

    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];

    // Use the dynamically determined project folder
    define('BASE_URL_PATH', $protocol . '://' . $host . '/' . $projectFolder);
}

if (!defined('DOCTORS_DB_PATH')) {
    define('DOCTORS_DB_PATH', BASE_URI_PATH . '/includes/doctors.csv');
}
if (!defined('PATIENTS_DB_PATH')) {
    define('PATIENTS_DB_PATH', BASE_URI_PATH . '/includes/users.csv');
}

