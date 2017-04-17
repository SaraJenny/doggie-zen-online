<?php
/*
* Sara Petersson - Web 2.0, DT091G 
* Denna sida loggar ut användare
*/
// Startar session
session_start();
// Förstör session
session_destroy();
// Skicka till inloggningssidan
header("Location: login.php");
exit;