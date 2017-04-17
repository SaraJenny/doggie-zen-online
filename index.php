<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Samlingssida för användarens alla kurser och länkar till kurskamraters inlägg
*/

// Undersidans titel
$page_title = "Panel";
// Hämtar in headern
include("includes/header.php");
// Om sessionsvariabel med användarid är satt skrivs sidan ut
if (isset($_SESSION["userId"])) {
?>
    <div id="mainContainer">
    	<section id="indexContainer">
<?php
			// Hämtar kurser som den inloggade användaren deltar i
			$classes = $class->getClasses($userId);
			// Om användaren är kursdeltagare skrivs deras olika "kursbloggar" ut, skrivs inte ut om inga kurser hittades
		    if ($type == 2) {
		    	if ($classes != NULL) {
					echo "<h3>Mina plattformar</h3>
					<ul>";
					// Skriver ut länkar till kurser där kursdeltagaren är deltagare med hund, samt att kursen har startat och inte har stängts
					foreach ($classes as $key) {
						if ($date >= $key['startDate'] && $date <= $key['closingDate'] && $key['typeId'] == 4) {
							echo "<li><a href='post.php?class=" . $key['classCode'] . "&id=" . $userId . "'>" . $key['className'] . "</a></li>";
						}
					}
					echo "</ul>";
		    	}
			}
?>
			<h3>Mina kurser</h3>
			<h4>Kommande kurser</h4>
			<ul>
<?php
				// Skriver ut alla kommande kurser
				foreach ($classes as $key) {
					if ($date < $key['startDate']) {
						echo "<li><a href='post.php?class=" . $key['classCode'] . "&id=" . $userId . "'>" . $key['className'] . "</a> " . $key['startDate'] . " - " . $key['endDate'] . "</li>";
					}
				}
			echo "</ul>";
			// Kollar så att användaren har gått minst en kurs
			if ($classes != NULL) {
				echo "<h4>Pågående kurser</h4>
				<ul>";
				// Loopar igenom alla användarens kurser
				foreach ($classes as $key) {
					// Hämtar lärarens id
					$teacherId = $class->getTeacher($key['classCode']);
					// Skriver ut alla kurser som har startat och ännu inte avslutats
					if ($date >= $key['startDate'] && $date <= $key['endDate']) {
						echo "<li><a href='post.php?class=" . $key['classCode'] . "&id=" . $teacherId . "'>" . $key['className'] . "</a> " . $key['startDate'] . " - " . $key['endDate'] . "</li>";
					}
				}
?>
			    </ul>
				<h4>Avslutade kurser</h4>
				<ul>
<?php
				// Loopar igenom alla användarens kurser
				foreach ($classes as $key) {
					// Hämtar lärarens id
					$teacherId = $class->getTeacher($key['classCode']);
					// Om användaren är instruktör skrivs alla avslutade kurser under denna rubrik
					if ($type == 1) {
						if ($date > $key['endDate']) {
							echo "<li><a href='post.php?class=" . $key['classCode'] . "&id=" . $teacherId . "'>" . $key['className'] . "</a> " . $key['startDate'] . " - " . $key['endDate'] . "</li>";
						}
					}
					// Om användaren är kursdeltagare skrivs kurser som är avslutade men inte stängda ut här
					else {
						if ($date > $key['endDate'] && $date <= $key['closingDate']) {
							echo "<p><a href='post.php?class=" . $key['classCode'] . "&id=" . $teacherId . "'>" . $key['className'] . "</a> " . $key['startDate'] . " - " . $key['endDate'] . ". Kursen stängs " . $key['closingDate'] . "</p>";
						}
					}
				}
				echo "</ul>";
				// Om användaren är kursdeltagare skrivs alla stängda kurser ut (ingen länkning)
				if ($type == 2) {
			    echo "<h4>Stängda kurser</h4>";
					// Skriver ut alla stängda kurser
					foreach ($classes as $key) {
						if ($date > $key['closingDate']) {
							echo "<p>" . $key['className'] . " " . $key['startDate'] . " - " . $key['endDate'] . "</p>";
						}
					}
				}
			    echo "<h3>Kursdeltagare</h3>";
			    // Hämtar alla kursdeltagare som går samma kurser som användaren
				$student = $class->getStudents($userId);
				// Loopar igenom användarens alla kurser
				foreach ($classes as $key) {
					// Skriver endast ut kurser som har startat och ännu inte stängts
					if ($date < $key['closingDate'] && $date >= $key['startDate']) {
						echo "<h4>" . $key['className'] . "</h4>
						<ul>";
							// Loopar igenom alla kurskamrater
							foreach ($student as $studentKey) {
								// För de studenter som får en matchning för en viss kurs
								if ($studentKey['classCode'] == $key['classCode']) {
									// Hämta vilken kursdeltagartyp denna är
									$studentType = $class->getStudentType($studentKey['userId'], $studentKey['classCode']);
									// Om denna är kursdeltagare med hund
									if ($studentType == 4) {
										// Hämta kurskamratens senaste inlägg i den aktuella kursen
										$postInfo = $post->getLatestPost($studentKey['classCode'], $studentKey['userId']);
										// Om inga inlägg hittas skrivs det ut
										if ($postInfo == NULL) {
											echo "<li><a href='post.php?class=" . $studentKey['classCode'] . "&id=" . $studentKey['userId'] . "'>" . $studentKey['firstname'] . " " . $studentKey['lastname'] . "</a>: Inga inlägg</li>";
										}
										// Om inlägg hittas hämtas när inlägget publicerades och dess titel
										else {
											foreach ($postInfo as $postKey) {
												$postDate = $postKey['postDate'];
												$title = $postKey['title'];
										 	}
										 	// Skriver ut en länk till inlägget
											echo "<li><a href='post.php?class=" . $studentKey['classCode'] . "&id=" . $studentKey['userId'] . "'>" . $studentKey['firstname'] . " " . $studentKey['lastname'] . "</a>: " . $postKey['title'] . " (" . $postKey['postDate'] . ")</li>";
										}
									}
								}
							}
						echo "</ul>";
					}
				}
			}
			// Om användaren aldrig gått en kurs skrivs ett meddelande ut
			else {
				echo "<p>Just nu har du ingen tillgång till några kurser. Har du anmält dig till en kurs kommer du få ett mejl till " . $user->getEmail($userId) . " då du fått tillgång till kursen.</p>
				<p>Till dess får du gärna ladda upp en profilbild och lägga in information om dina hundar på sidan <a href='profile.php'>Min profil</a></p>";
			}
?>
		</section><!-- /#indexContainer -->
		<aside id="indexAside">
			<h3><a href="#">#doggie-zen</a></h3>
			<!-- SnapWidget -->
			<script src="http://snapwidget.com/js/snapwidget.js"></script>
			<iframe src="http://snapwidget.com/in/?u=ZG9nc29maW5zdGFncmFtfGlufDEwMHwzfDV8fG5vfDV8ZmFkZU91dHxvblN0YXJ0fG5vfHllcw==&ve=110316" title="Instagram Widget" class="snapwidget-widget" style="border:none; overflow:hidden; width:100%;"></iframe>
		</aside>
    </div><!-- /#mainContainer -->
<?php
}
// Om användaren inte är inloggad skickas denna till inloggningssidan
else {
    header("Location: login.php");
    exit;
}
include("includes/footer.php");