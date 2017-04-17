<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Lägger till nytt inlägg
*/

// Läser in config-filen
include("../includes/config.php");

// Kollar att alla parametrar har satts
if(isset($_POST['classCode']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['pubDate'])) {
    $classCode = $_POST['classCode'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $postDate = $_POST['pubDate'];
    $postId = $post->addPost($userId, $postDate, $title, $content, $classCode);
    // Om inlägget kunde läggas till returneras dess id
    if ($postId != false) {
        echo $postId;
    }
    // Om inlägget inte kunde läggas till returneras false
    else {
        echo false;
    }
}