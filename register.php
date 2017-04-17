<?php
/*
* Sara Petersson - Web 2.0, DT091G 
* På denna sida registrerar sig nya användare
*/
// Undersidans titel
$page_title = "Registrering";
// Hämtar in headern
include("includes/header.php");
// Kollar om personen är inloggad och skickar till index.php
if (isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit;
}
// Om personen inte är inloggad skrivs sidan ut
else {
?>
    <div class="profile" id="mainContainer">
        <h2>Skapa konto</h2>
        <!-- Registreringsformulär -->
        <form class="registerForm">
            <label for="firstname">Förnamn</label>
            <input placeholder="Förnamn" type="text" name="firstname" id="firstname">
            <label for="lastname">Efternamn</label>
            <input placeholder="Efternamn" type="text" name="lastname" id="lastname">
            <label for="email">E-postadress</label>
            <input placeholder="E-postadress" type="email" name="email" id="email">
            <label for="password">Lösenord</label>
            <input placeholder="Lösenord" type="password" name="password" id="password">
            <label for="passwordCheck">Upprepa lösenord</label>
            <input placeholder="Lösenord" type="password" name="passwordCheck" id="passwordCheck">
            <input id="registerButton" type="button" class="button" value="Skapa konto">
        </form><!-- /Registreringsformulär -->
    </div><!-- /mainContainer -->
<?php
}
include("includes/footer.php");