<?php
/* Sara Petersson - Web 2.0, DT091G 
* På denna sida redigerar användaren sin profil
*/
// Undersidans titel
$page_title = "Min profil";
// Hämtar in headern
include("includes/header.php");
// Kollar om sessionsvariabel är satt
if (isset($_SESSION["userId"])) {
    // Hämtar uppgifter om inloggad användare
    $userInfo = $user->getUserInfo($userId);
    foreach ($userInfo as $key) {
        $firstname = $key['firstname'];
        $lastname = $key['lastname'];
        $email = $key['email'];
    }
    // Hämtar info om profilbild
    $photoURL = $image->getPhoto($userId);
    // Om en bild fanns i databasen
    if ($photoURL != NULL) {
        // Sätter filnamn på pilen som visas vid bilduppladdningen 
        $arrow = "arrow_change";
    }
    else {
        $arrow = "arrow";
    }
?>
    <section class="profile" id="mainContainer">
        <h2>Min profil</h2>
        <img id="arrow" src="images/<?php echo $arrow; ?>.png" alt="Ladda upp profilbild">
        <!-- Ladda upp profilbild -->
        <div class="dropzone" id="dropzone">
<?php
        // Om profilbild finns skrivs den ut
        if ($photoURL != NULL) {
            echo "<img src='images/uploads/thumb_" . $photoURL . "' alt='Profilbild'>";
        }
        // Om användaren inte har laddat upp någon profilbild skrivs text ut
        else {
            echo "Släpp din profilbild här";
        }
?>
        </div>
        <!-- Felmeddelanden för bilduppladdningen -->
        <div id="uploads"></div>
        <!-- Profilformulär -->
        <form class="registerForm">
            <label for="firstname">Förnamn</label>
            <input placeholder="Förnamn" type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
            <label for="lastname">Efternamn</label>
            <input placeholder="Efternamn" type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
            <label for="email">E-postadress</label>
            <input placeholder="E-postadress" type="email" name="email" id="email" value="<?php echo $email; ?>">
            <input id="userButton" type="button" class="button" value="Uppdatera">
        </form><!-- /Profilformulär -->
        <section id="dogs">
<?php
            // Hämtar uppgifter om användarens ev. hund(ar)
            $dogs = $dog->getDogInfo($userId);
            // Om användaren har minst en hund sparas information om dessa
            if ($dogs != NULL) {
                // Loopar igenom alla användarens hundar och skriver ut dessa
                foreach ($dogs as $key) {
                    $dogId = $key['dogId'];
                    $dogname = $key['dogname'];
                    $dob = $key['dob'];
                    $dogInfo = $key['dogInfo'];
?>
                    <div id="dogContainer_<?php echo $dogId; ?>">
                        <h3 id="dognameTitle<?php echo $dogId; ?>"><?php echo $dogname; ?>
                            <img src="images/delete.png" alt="Radera hund" class='delete deleteDog' onclick="deleteDog(<?php echo $dogId; ?>, '<?php echo $dogname; ?>')">
                        </h3>
                        <!-- Hundformulär för existerande hundar -->
                        <form class="registerForm">
                            <label for="dogname<?php echo $dogId; ?>">Hundnamn</label>
                            <input placeholder="Hundnamn" type="text" name="dogname<?php echo $dogId; ?>" id="dogname<?php echo $dogId; ?>" value="<?php echo $dogname; ?>">
                            <label for="dob<?php echo $dogId; ?>">Hundens födelsedatum (åååå-mm-dd)</label>
                            <input type="date" name="dob<?php echo $dogId; ?>" id="dob<?php echo $dogId; ?>" value="<?php echo $dob; ?>">
                            <label for="dogInfo<?php echo $dogId; ?>">Hundinfo</label>
                            <textarea placeholder="Presentera din hund lite kort (ras, vad ni tränar etc.)" name="dogInfo<?php echo $dogId; ?>" id="dogInfo<?php echo $dogId; ?>"><?php echo $dogInfo; ?></textarea>
                            <input id="dogButton<?php echo $dogId; ?>" type="button" class="button" value="Uppdatera" onclick="updateDog(<?php echo $dogId; ?>)">
                        </form><!-- /Hundformulär -->
                    </div><!-- /#dogContainer_ID -->
<?php
                }
            }
?>
                <section id="newDog">
                    <h3>Hund</h3>
                    <!-- Hundformulär för ny hund -->
                    <form class="registerForm">
                        <label for="dogname">Hundnamn</label>
                        <input placeholder="Hundnamn" type="text" name="dogname" id="dogname">
                        <label for="dob">Hundens födelsedatum (åååå-mm-dd)</label>
                        <input type="date" name="dob" id="dob">
                        <label for="dogInfo">Hundinfo</label>
                        <textarea placeholder="Presentera din hund lite kort (ras, vad ni tränar etc.)" name="dogInfo" id="dogInfo"></textarea>
                        <input id="addDogButton" type="button" class="button" value="Lägg till hund" onclick="addDog()">
                    </form><!-- /Hundformulär -->
                </section><!-- /#newDog -->
                <!-- Lägg till ytterligare hund -->
                <div id="addDog">
                    <img src="images/add_13x13.png" alt="Lägg till hund" id="addDogImage">
                    <span>Lägg till hund</span>
                </div>
            </section><!-- /Hundar -->
            <h3>Ändra lösenord</h3>
            <!-- Lösenordsformulär -->
            <form class="registerForm">
                <label for="password">Nytt lösenord</label>
                <input placeholder="Lösenord" type="password" name="password" id="password">
                <label for="passwordCheck">Upprepa lösenord</label>
                <input placeholder="Lösenord" type="password" name="passwordCheck" id="passwordCheck">
                <input id="passwordButton" type="button" class="button" value="Ändra lösenord">
            </form><!-- /Lösenordsformulär -->
        </section><!-- /mainContainer -->
<?php
}
// Om besökaren inte är inloggad skickas hen till inloggningssidan
else {
    header("Location: login.php");
    exit;
}
include("includes/footer.php");