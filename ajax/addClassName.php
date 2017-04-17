<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till nytt kursnamn
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['newClassName'])) {
    $newClassName = $_POST['newClassName'];
    $newClassName = $class->addClassName($newClassName);
    // Om namnet inte kunde läggas till
    if ($newClassName == false) {
        echo false;
    }
    // Om namnet kunde läggas till skickas classId tillbaka
    else {
        echo $newClassName;
    }
}