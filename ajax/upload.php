<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till profilbild
*/
header('Content-Type: application/json');

// Läser in config-filen
include("../includes/config.php");

$uploaded = array();

if(!empty($_FILES['file']['name'])) {
	// Hämtar och saniterar bildnamnet
	$name = basename($_FILES['file']['name'][0]);
	// Ersätter ev. mellanslag i filnamnet
	$name = str_replace(" ","-", $name);
	// Kollar om filnamnet redan existerar
	if (file_exists("../images/uploads/" . $name)) {
       	// Skapa ett unikt filnamn
		$name = $image->file_newname('../images/uploads', $_FILES["file"]["name"][0]);
	}
	// Om filen kan flyttas till slutmappen, sparas namn och sökväg
	if(move_uploaded_file($_FILES['file']['tmp_name'][0], '../images/uploads/' . $name)) {
		$uploaded[] = array(
			'name' => $name,
			'file' => 'images/uploads/thumb_' . $name
		);
		// Kollar om uppladdaren redan har en bild uppladdad
        $photo = $image->getPhoto($userId);
        // Om bild redan fanns, raderas den
        if ($photo != NULL) {
        	$result = $image->deletePhoto($userId);
        }
		// Lägger till bilden i databasen
        $result = $image->addPhoto($name, $userId);
        if ($result) {
            echo json_encode($uploaded);
        }
	}
}