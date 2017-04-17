<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till kursdeltagare till en kurs
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['userId']) && isset($_POST['classChoice']) && isset($_POST['type'])) {
    $studentId = intval($_POST['userId']);
    $classChoice = $_POST['classChoice'];
    $type = intval($_POST['type']);
    $result = $class->addStudentToClass($studentId, $classChoice, $type);
    // Om kursdeltagaren kunde läggas till returneras "true"
    if ($result == true) {
        echo true;
    }
    // Om kursdeltagaren inte kunde läggas till returneras "false"
    else {
        echo false;
    }
}