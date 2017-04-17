<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till ny hund
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['dogname']) && isset($_POST['dob']) && isset($_POST['dogInfo'])) {
    $dogname = $_POST['dogname'];
    $dob = $_POST['dob'];
    $dogInfo = $_POST['dogInfo'];
    $dogId = $dog->addDog($dogname, $dob, $dogInfo, $userId);
    // Om hunden kunde läggas till skickas dess id tillbaka
    if ($dogId != false) {
    	echo $dogId;
    }
    // Om hunden inte kunde läggas till returneras "false"
    else {
    	return false;
    }
}