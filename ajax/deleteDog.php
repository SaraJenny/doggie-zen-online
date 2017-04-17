<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Raderar hund
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['dogId'])) {
    $dogId = intval($_POST['dogId']);
    $result = $dog->deleteDog($dogId);
    // Om hunden kunde raderas returneras "true"
    if ($result == true) {
        echo true;
    }
    // Om hunden inte kunde raderas returneras "false"
    else {
        echo false;
    }
}