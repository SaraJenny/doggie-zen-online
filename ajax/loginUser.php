<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Logga in användare
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['email']) && isset($_POST['password'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
    // Hämtar uppgifter om användaren
    $userInfo = $user->controlUser($email);
    // Om inga användaruppgifter hittas skrivs ett felmeddelande ut
    if ($userInfo == NULL) {
        echo "Felaktig e-post";
    }
    // Om användaruppgifter hittats kontrolleras att lösenordet stämmer
    else {
        foreach ($userInfo as $key) {
            $userId = $key['userId'];
            $email = $key['email'];
            $stored_password = $key['password'];
        }
        $result = $user->controlPassword($email, $password, $stored_password);
        // Stämmer lösenordet sätts userId som sessionsvariabel
        if ($result == true) {
            $_SESSION["userId"] = $userId;
            echo true;
        }
        // Om lösenordet inte stämmer skrivs ett felmeddelande ut
        else {
            echo "Felaktigt lösenord";
        }
    }
}