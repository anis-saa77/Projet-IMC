<?php

class Doctor{

    public function addPatient(){

        //validate post form
        if(!$this->isPostFormValid()) return "Operation failed";

        //lookup patient in db
        

        //if found assign patient to doctor

        //if not found send invitation mail

    }

    public function sendInvitationToPatient(){

    }

    private function isPostFormValid():bool
    {

        if (!isset($_POST['patient_security_number']) || !preg_match('/^\d{3}-\d{2}-\d{4}$/', $_POST['patient_security_number'])) {
            echo "<p style='color:red;'>Format de N° de sécurité sociale invalide.</p>";
            return false;
        }

        return true;
    }


}