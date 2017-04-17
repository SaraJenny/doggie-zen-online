<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Ändra lösenord
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['password'])) {
    $password = $_POST['password'];
    $result = $user->changePassword($userId, $password);
    // Om lösenordet kunde uppdateras returneras "true"
    if ($result == true) {
    	echo true;
    }
    // Om lösenordet inte kunde uppdateras returneras "false"
    else {
    	echo false;
    }
}