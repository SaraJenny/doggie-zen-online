<?php
/* Sara Petersson - Web 2.0, DT091G */

// Startar session
session_start();
// Webbplatsens titel
$site_title = "Doggie-Zen";
// Webbplatsens avdelare
$divider = " | ";
//Funktion som hämtar sökväg
function getPath() {
    $path = $_SERVER['PHP_SELF'];
    return $path;
}
// Aktiverar autoload för att snabba upp registrering av klasser
spl_autoload_register(function ($classObject) {
    include __DIR__.'/class/' . $classObject . '.class.php';
});
// Skapar objekt
$user = new User();
$class = new Classes();
$post = new Post();
$dog = new Dog();
$image = new Image();
// Om användaren är inloggad hämtas dess typ (admin/student) och vilka kurser denna har tillgång till, samt dagens datum och tid
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $type = $user->getUserType($userId);
    $classAccess = $class->getUserAccess($userId);
    $date = date('Y-m-d');
    $time = date('H:i:s');
}