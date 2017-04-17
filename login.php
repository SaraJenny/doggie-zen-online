<?php
/*
* Sara Petersson - Web 2.0, DT091G 
* På denna sida loggar användare in
*/
// Undersidans titel
$page_title = "Logga in";
// Hämtar in headern
include("includes/header.php");
// Kollar om sessionsvariabel är satt och skickar i så fall användaren till index.php
if (isset($_SESSION["userId"])) {
    header("Location: index.php");
    exit;
}
// Om inte sessionsvariabel är satt skrivs sidan ut
else {
?>
    <div id="freeContainer">
        <h2>Logga in</h2>
        <!-- Inloggningsformulär -->
        <form id="loginForm">
            <div id="login">
                <fieldset class="icon email">
                    <label for="email">E-postadress</label>
                    <input placeholder="E-postadress" type="email" name="email" id="email">
                </fieldset>
                <fieldset class="icon lock">
                    <label for="password">Lösenord</label>
                    <input placeholder="Lösenord" type="password" name="password" id="password">
                    <!--<a class="forgot" href="forgot.php">Glömt?</a>-->
                </fieldset>
                <input id="loginButton" type="button" class="button" value="Logga in">
            </div>
            <!--<input type="checkbox" name="remember" value="yes">Kom ihåg mig -->
            <p id="register">Har du inte ett konto? <a href="register.php">Registrera dig här</a></p>
        </form><!-- /Inloggningsformulär -->
    </div><!-- /freeContainer -->
<?php
}
include("includes/footer.php");