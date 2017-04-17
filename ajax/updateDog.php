<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Uppdaterar hunduppgifter
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['dogId']) && isset($_POST['dogname']) && isset($_POST['dob']) && isset($_POST['dogInfo'])) {
    $dogId = intval($_POST['dogId']);
	$dogname = $_POST['dogname'];
	$dob = $_POST['dob'];
	$dogInfo = $_POST['dogInfo'];
    $result = $dog->updateDog($dogId, $dogname, $dob, $dogInfo);
    // Om hundens uppgifter kunde uppdateras returneras "true"
    if ($result == true) {
    	echo true;
    }
    // Om hundens uppgifter inte kunde uppdateras returneras "false"
    else {
    	echo false;
    }
}