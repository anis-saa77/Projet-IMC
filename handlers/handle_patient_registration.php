<?php

require_once "../src/Config.php";
require_once "../src/CsvHandler.php";
require_once BASE_URI_PATH . "/src/Mailer.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



class patientDoctorRegistrationController
{

    private string $socialSec;
    private string $newPatientEmail;

    private function abort(int $existCode, string $msg)
    {
        if($existCode === 1){
            $_SESSION['notification'] = "<div style='background-color:red;border-radius:5px;color:white;padding: 15px auto;max-width:200px;text-align:center; margin:10px auto;'> $msg </div>";

        }
        if($existCode === 0){
            $_SESSION['notification'] = "<div style='background-color:green;border-radius:5px;color:white;padding: 15px auto;max-width:200px;text-align:center; margin:10px auto;'> $msg </div>";
        }

        header('Location: ' . BASE_URL_PATH . '/pages/assignPatientToDoctor.php'); // Replace with your URL
        exit;
    }
    function __construct($socialSec, $newPatientEmail)
    {
        if (!$socialSec) {
            $this->abort(1, "must provide valid social security number!");
        } else {
            $this->newPatientEmail = $newPatientEmail;
            $this->socialSec = $socialSec;
        }
    }

      function sendInviteLink(){
        //send mail
        $registrationLink = BASE_URL_PATH . "/pages/register.php";
        $message = "<h4>Follow this <a href='$registrationLink'>Link</a> </h4>";
        $mailer = new Mailer($this->newPatientEmail, "Invite to register", $message);
        
        $mailer->send() ? $this->abort(0, 'Invitation sent successfully!') : $this->abort(1, 'Invitation mail failed to reach Patient!');

      }

    function registerPatient()
    {
        if (!CsvHandler::patientExists($this->socialSec) && !$this->newPatientEmail) $this->abort(1, "Patient does not exist!");
        if (!CsvHandler::patientExists($this->socialSec) && $this->newPatientEmail) $this->sendInviteLink();

        $patient = CsvHandler::getPatientBySocialSecurityNumber($this->socialSec);

        if (!$patient || !isset($_SESSION['user']['doctor_pro_identifier'])) $this->abort(1, "Patient does not exist/Could not get doctors data!");

        $patient['family_doctor'] = $_SESSION['user']['doctor_pro_identifier'];

        CsvHandler::updatePatient($this->socialSec, $patient);


        $this->abort(0, "Success");
    }
}


$patientDoctorRegController  = new patientDoctorRegistrationController($_POST['patient_security_number'] ?? null, $_POST['patient_email'] ?? null);
$patientDoctorRegController->registerPatient();
