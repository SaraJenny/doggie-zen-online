<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till ny kommentar
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['postId']) && isset($_POST['content']) && isset($_POST['commentDate'])) {
    $postId = intval($_POST['postId']);
    $content = $_POST['content'];
    $commentDate = $_POST['commentDate'];
    $newComment = $post->addComment($userId, $content, $commentDate, $postId);
    if ($newComment == true) {
    	echo true;
    }
    else {
    	echo false;
    }
}