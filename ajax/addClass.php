<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till ny kurs i kursplanen
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['classId']) && isset($_POST['classCode']) && isset($_POST['startDate']) && isset($_POST['endDate']) && isset($_POST['closingDate']) && isset($_POST['teacherId'])) {
    $classId = intval($_POST['classId']);
    $classCode = $_POST['classCode'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $closingDate = $_POST['closingDate'];
    $teacherId = $_POST['teacherId'];
    $newClass = $class->addClass($classId, $classCode, $startDate, $endDate, $closingDate, $teacherId);
    if ($newClass == true) {
    	echo true;
    }
    else {
    	echo false;
    }
}