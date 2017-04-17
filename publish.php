<?php
/*
* Sara Petersson - Web 2.0, DT091G
* På denna sidan kan användare publicera inlägg
*/
// Undersidans titel
$page_title = "Skapa post";
// Hämtar in headern
include("includes/header.php");
// Kollar så att användaren är inloggad
if (isset($_SESSION["userId"])) {
	// Hämtar alla aktuella kurser
	$currentClasses = $class->getCurrentClasses($date);
	// Hämtar alla aktuella kurser som en viss student deltar med hund
	$studentClass = $class->getStudentCurrentActiveClasses($userId, $date);
	// Skriver ut sidan
?>
    <section id='mainContainer' class='postSection'>
    	<h2>Skapa post</h2>
    	<form class='registerForm' id='publishForm'>
			<label for='class'>Kursnamn</label>
			<select name='class' id='class'>
				<option value='0'>Välj kurs</option>
<?php
				// Om användaren är kursdeltagare ska endast aktuella kurser som användaren är delaktig i skrivas ut (d.v.s. ej observatörer)
				if ($type == 2) {
					foreach ($studentClass as $studentKey) {
						if ($date >= $studentKey['startDate']) {
							echo "<option value='" . $studentKey['classCode'] . "'>" . $studentKey['className'] . "</option>";
						}
					}
				}
				// Om användaren är instruktör ska alla aktuella och kommande kurser skrivas ut
				else {
					foreach ($currentClasses as $classKey) {
						echo "<option value='" . $classKey['classCode'] . "'>" . $classKey['className'] . " " . $classKey['startDate'] . "</option>";
					}
				}
?>
			</select>
			<label for='title'>Rubrik</label>
            <input placeholder='Rubrik' type='text' name='title' id='title'>
            <!-- CKEditor -->
            <textarea name='editor' id='editor' rows='10' cols='80'></textarea>
            <script>CKEDITOR.replace('editor');</script>
<?php
            // Om användaren är instruktör ska ett fält för att fylla i publiceringsdatum visas
            if ($type == 1) {
				echo "<label for='pubDate'>Publiceringsdatum (åååå-mm-dd)</label>
            	<input type='date' name='pubDate' id='pubDate'>";
			}
?>
			<input id='submitPost' type='button' class='button' value='Publicera'>
		</form>
    </section>
<?php
}
// Om användaren inte är inloggad skickas denna till inloggningssidan
else {
    header("Location: login.php");
    exit;
}
include("includes/footer.php");