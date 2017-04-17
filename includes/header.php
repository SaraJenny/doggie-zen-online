<?php
/* Sara Petersson - Web 2.0, DT091G */
// Läser in config-filen
include("includes/config.php");
?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <!-- För äldre IE-versioner -->
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <title><?php echo $site_title . $divider . $page_title; ?></title>
        <meta charset="utf-8">
        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700' rel='stylesheet' type='text/css'>
        <!-- Stilmall -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <!-- CKEditor -->
        <script src="script/ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <!-- Sidhuvud -->
        <header>
            <a href="index.php"><h1>Doggie-Zen</h1></a>
            <div id="logo">
                <a href="index.php"><img src="images/logo.png" alt="Doggie-Zen onlinekurser"></a>
            </div>
            <!-- Meny -->
            <?php include("includes/mainmenu.php");?>
        </header><!-- Sidhuvud slut -->
        <section id="mainContent">