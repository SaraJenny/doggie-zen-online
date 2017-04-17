<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till ny användare
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$type = 2;
	// Kontrollerar om e-posten redan existerar
    $userInfo = $user->controlUser($_POST["email"]);
    // Om inga användaruppgifter hittades i databasen, läggs den nya användaren till
    if ($userInfo == NULL) {
        $userId = $user->addUser($firstname, $lastname, $email, $password, $type);
        // Sätter användar-id som sessionsvariabel
        $_SESSION['userId'] = $userId;
        echo true;
    }
    // Om användaruppgifter hittats skrivs felmeddelande ut
    else {
        echo "Den angivna e-posten har redan ett konto kopplat till sig";
    }
}