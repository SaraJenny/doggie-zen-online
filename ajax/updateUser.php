<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Uppdaterar användaruppgifter
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
    $userUpdate = $user->updateUser($userId, $firstname, $lastname, $email);
    // Om användarens uppgifter kunde uppdateras returneras "true"
    if ($userUpdate == true) {
    	echo true;
    }
    // Om användarens uppgifter inte kunde uppdateras returneras "false"
    else {
    	echo false;
    }
}