<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Administrationssida - endast tillgänglig för administratörer - där kursrättigheter tilldelas och nya kurser skapas
*/

// Undersidans titel
$page_title = "Administration";
// Hämtar in headern
include("includes/header.php");
// Kollar om sessionsvariabel med användarid är satt
if (isset($_SESSION["userId"])) {
	// Om användaren är administratör skrivs sidan ut
	if ($type == 1) {
?>
		<section id="mainContainer">
			<h2>Administration</h2>
			<h3 id="addNewClass">Lägg till ny kurs »</h3>
			<!-- Formulär för att skapa ett nytt kursnamn -->
		    <form id="addClassNameForm" class="registerForm">
            	<label for="newClassName">Nytt kursnamn</label>
	            <input placeholder="Kursnamn" type="text" name="newClassName" id="newClassName">
	            <input id="addNewClassName" type="button" class="button" value="Lägg till">
            </form><!-- /#addClassNameForm -->
            <!-- Lägg till ny kurs -->
			<div id="addClass" class="registerForm">
				<form id="addClassForm">
					<label for="className">Kursnamn</label>
            		<select name="className" id="className">
            			<option value="0">Välj kurs</option>
<?php
						// Hämtar alla kursnamn
						$classes = $class->getClassList();
						// Hämtar alla instruktörer
						$teacher = $class->getTeacherList();
						// Loopar igenom alla kursnamn och skriver ut dem som <option>
						foreach ($classes as $key) {
									echo "<option value='" . $key['classId'] . "'>" . $key['className'] . "</option>";
								}
?>
            		</select>
	                <!-- Lägg till nytt kursnamn -->
	                <div id="addClassName">
	                    <img src="images/add_13x13.png" alt="Lägg till nytt kursnamn" id="addDogImage">
	                    <span>Lägg till kursnamn</span>
	                </div>
            		<label for="classCode">Kurskod (ex. FB1605)</label>
		            <input placeholder="Kurskod" type="text" name="classCode" id="classCode">
		            <label for="startDate">Startdatum</label>
		            <input type="date" name="startDate" id="startDate">
		            <label for="endDate">Slutdatum</label>
		            <input type="date" name="endDate" id="endDate">
		            <label for="closingDate">Stängningsdatum</label>
		            <input type="date" name="closingDate" id="closingDate">
<?php
					// Loopar igenom alla instruktörer och skriver ut dem som radio-input
					foreach ($teacher as $teacherKey) {
						echo "<input type='radio' name='teacher' value='" . $teacherKey['userId'] . "'>" . $teacherKey['firstname'] . " " . $teacherKey['lastname'] . "<br>";
					}
?>
		            <input id="addClassButton" type="button" class="button" value="Skapa kurs">
				</form>
			</div><!-- /#addClass -->
			<!-- Sektion för kursdeltagare -->
			<div class="admin">
				<h3>Kursdeltagare</h3>
				<h4>Nyregistrerade användare</h4>
<?php
				// Hämtar alla nyregistrerade användare
				$newStudent = $class->getNewStudents();
				// Om inga nyregistrerade användare finns skrivs ett meddelande ut
				if ($newStudent == NULL) {
					echo "<p>Inga nya registreringar</p>";
				}
				// Hämtar alla aktuella kurser
				$currentClasses = $class->getCurrentClasses($date);
				// Loopar igenom alla nyregistrerade användare och skriver ut ett formulär för att kunna lägga till kursdeltagande
				foreach ($newStudent as $key) {
					echo "<div id='newStudentDiv" . $key['userId'] . "'>";
						echo "<p>" . $key['firstname'] . " " . $key['lastname'] . "</p>";
						echo "<form id='newStudentForm" . $key['userId'] . "'>
							<select name='class' id='class_" . $key['userId'] . "'>
								<option value='0'>Välj kurs</option>";
								// Loopar igenom alla aktuella kurser och skriver ut dem som <option>
								foreach ($currentClasses as $classKey) {
									echo "<option value='" . $classKey['classCode'] . "'>" . $classKey['className'] . " " . $classKey['startDate'] . "</option>";
								}
							echo "</select>
							<input type='radio' name='type' value='3'>Observatör
							<input type='radio' name='type' value='4'>Deltagare
				  			<input type='button' value='OK' id='submitStudent" . $key['userId'] . "' onclick='submitStudent(" . $key['userId'] . ", &#39;" . $key['firstname'] . "&#39;, &#39;" . $key['lastname'] . "&#39;)'>
						</form>
					</div>";
				}
				echo "<div id='oldStudents'>";
				echo "<h4>Kursdeltagare</h4>";
				// Hämtar alla kursdeltagare som deltagit på minst en kurs
				$student = $class->getStudentList();
				// Loopar igenom alla dessa kursdeltagare och skriver ut info om denna
				foreach ($student as $studentKey) {
					// Hämtar info om de kurser den aktuella studenten har deltagit/deltar i
					$userClass = $class->getClasses($studentKey['userId']);
					echo "<p><img src='images/add_13x13.png' alt='Mer info om " . $studentKey['firstname'] . " " . $studentKey['lastname'] . "' class='info' onclick=showInfo(" . $studentKey['userId'] . ")>" . $studentKey['firstname'] . " " . $studentKey['lastname'] . "</p>
					<div id='oldStudentField_" . $studentKey['userId'] . "' class='oldStudentField'>
						<form id='newStudentForm" . $studentKey['userId'] . "' class='oldStudentForm'>
							<select name='class' id='class_" . $studentKey['userId'] . "'>
								<option value='0'>Välj kurs</option>";
								// Loopar igenom alla aktuella kurser och skriver ut dem som <option>
								foreach ($currentClasses as $classKey) {
									echo "<option value='" . $classKey['classCode'] . "'>" . $classKey['className'] . " " . $classKey['startDate'] . "</option>";
								}
							echo "</select>
							<input type='radio' name='type' value='3'>Observatör
							<input type='radio' name='type' value='4'>Deltagare
				  			<input type='button' value='OK' id='submitStudent" . $studentKey['userId'] . "' onclick='submitStudent(" . $studentKey['userId'] . ", &#39;" . $studentKey['firstname'] . "&#39;, &#39;" . $studentKey['lastname'] . "&#39;)'>
						</form>
						<h5>Aktuella kurser</h5>
						<ul id='currentClassList_" . $studentKey['userId'] . "'>";
						// Loopar igenom alla kurser kursdeltagaren deltagit i
						foreach ($userClass as $userClassKey) {
							// Hämtar lärarens id för den specifikt kursen
							$teacherId = $class->getTeacher($userClassKey['classCode']);
							// Skriver endast ut kurser som fortfarande pågår
							if ($date <= $userClassKey['endDate']) {
								echo "<li><a href='post.php?class=" . $userClassKey['classCode'] . "&id=" . $teacherId . "'>" . $userClassKey['className'] . "</a> " . $userClassKey['startDate'] . " - " . $userClassKey['endDate'] . "</li>";
							}
						}
						echo "</ul>
						<h5>Avslutade kurser</h5>
						<ul class='endedClasses'>";
						// Loopar igenom alla kurser kursdeltagaren deltagit i
						foreach ($userClass as $userClassKey) {
							// Hämtar lärarens id för den specifikt kursen
							$teacherId = $class->getTeacher($userClassKey['classCode']);
							// Skriver endast ut kurser som har avslutats
							if ($date > $userClassKey['endDate']) {
								echo "<li><a href='post.php?class=" . $userClassKey['classCode'] . "&id=" . $teacherId . "'>" . $userClassKey['className'] . "</a> " . $userClassKey['startDate'] . " - " . $userClassKey['endDate'] . "</li>";
							}
						}
						echo "</ul>
					</div><!-- #oldStudentField_ -->";
	}
?>
				</div><!-- /#oldStudents -->
			</div><!-- /Sektion för kursdeltagare -->
			<!-- Sektion för instruktörer -->
			<div class="admin">
				<h3>Instruktörer</h3>
<?php
				// Loopar igenom och skriver ut alla instruktörer
				foreach ($teacher as $tKey) {
					echo "<p>" . $tKey['firstname'] . " " . $tKey['lastname'] . "<p>";
				}
?>
			</div><!-- /Sektion för instruktörer -->
    	</section><!-- /#mainContainer -->
<?php
	}
	// Om användaren inte är administratör skickas denna till index-sidan
	else {
		header("Location: index.php");
    	exit;
	}
}
// Om användaren inte är inloggad skickas denna till inloggningssidan
else {
    header("Location: login.php");
    exit;
}
include("includes/footer.php");