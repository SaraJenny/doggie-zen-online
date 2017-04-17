<?php
/*
* Sara Petersson - Web 2.0, DT091G
* Sida för alla inlägg - skapas utifrån vilka parametrar som är satta i länken
*/
// Undersidans titel
$page_title = "Inlägg";
// Hämtar in headern
include("includes/header.php");
// Kollar att användaren är inloggad
if (isset($_SESSION["userId"])) {
	// Hämtar användarens för- och efternamn
	$userName = $user->getProfile($userId);
	foreach ($userName as $userKey) {
		$firstname = $userKey['firstname'];
		$lastname = $userKey['lastname'];
	}
	// Kollar om parametrar är satta för att skriva ut sida för en hel kurs
	if (isset($_GET["class"]) && isset($_GET["id"])) {
		$classCode = $_GET["class"];
		$id = $_GET["id"];
		// Om användaren är instruktör hämtas alla inlägg från angiven användare i angiven kurs
		if ($type == 1) {
			$posts = $post->getAllPostsFromUserInClass($classCode, $id);
		}
		// Om användaren är kursdeltagare hämtas alla poster från angiven användare i angiven kurs med datumbegränsning
		else {
			$posts = $post->getAllPostsFromUserInClassDateLimit($classCode, $id, $date, $time);
		}
		// Hämtar stängningsdatum för kursen som inläggen gäller
		$closingDate = $class->getClosingDate($_GET["class"]);
		// Hämtar startdatum för kursen som inlägget gäller
		$startDate = $class->getStartDate($_GET["class"]);
	}
	// Kollar om parametrar är satta för att skriva ut enskilda inlägg
	else if (isset($_GET["post"])) {
		$postId = $_GET["post"];
		// Hämta enskild post
		$posts = $post->getPost($postId);
		foreach ($posts as $key) {
			// Hämtar stängningsdatum för kursen som inlägget gäller
			$closingDate = $class->getClosingDate($key['classCode']);
			// Hämtar startdatum för kursen som inlägget gäller
			$startDate = $class->getStartDate($key['classCode']);
			// Kurskod
			$classCode = $key['classCode'];
		}
	}
	// Om inte parametrar är satta skickas besökaren till index-sidan
	else {
	    header("Location: index.php");
	    exit;
	}
	$counter = 0;
	// Kollar om det finns en matchning mellan den aktuella sidans klasskod och användarens kursrättigheter
	foreach ($classAccess as $accessKey) {
		if ($accessKey['classCode'] == $classCode) {
			$counter++;
		}
	}
	// Om användaren har tillgång till sidan eller är instruktör skrivs den ut
	if ($counter > 0 || $type == 1) {
	    echo "<div id='postContainer'>";
			// Om stängningsdatum har passerat och besökaren inte är administratör, skrivs ett meddelande ut
			if ($date > $closingDate && $type != 1) {
				echo "<p>Kursen har passerat sitt stängningsdatum.</p>";
			}
			// Om kursen inte har startat ännu och besökaren inte är administratör, skrivs ett meddelande ut
			else if ($date < $startDate && $type != 1) {
				echo "<p>Du har inte tillgång till detta material förrän " . $startDate .".</p>";
			}
			// Om inte stängningsdatum passerat skrivs sidan ut för alla kursdeltagare, annars enbart för administratörer
			else {
				echo "<div id='postSection'>";
		    	// Om inga inlägg hittats skrivs ett meddelande ut
		    	if ($posts == NULL) {
		    		echo "<p>Inga inlägg hittades</p>";
		    		$authorType = $user->getUserType($_GET["id"]);
		    	}
		    	// Om inlägg finns skrivs dessa ut
		    	else {
					foreach ($posts as $key) {
		    			// Hämtar id för instruktören för kursen, för att kunna länka till kurssidan
						$teacher = $class->getTeacher($key['classCode']);
						// Hämtar alla posters ev. kommentarer
		    			$comments = $post->getComments($key['postId']);
		    			if ($comments != NULL) {
							// Räknar antalet kommentarer
		    				$numberOfComments = $post->countComments($key['postId']);
		    			}
		    			else {
		    				$numberOfComments = 0;
		    			}
						$authorType = $key['type'];
						$authorId = $key['userId'];
						echo "<article id='post" . $key['postId'] . "'>";
							// Om inläggsförfattaren är instruktör ska endast datumet skrivas ut
							if ($authorType == 1) {
								$postDate = substr($key['postDate'], 0, 10);
							}
							// Om inläggsförfattaren är kursdeltagare ska både datum och tid skrivas ut
							else {
								$postDate = $key['postDate'];
							}
							// Skriver ut datum, inläggstitel och kurslänk
							echo "<p class='postDate'>" . $postDate . "</p>
							<h3 class='postTitle'><a href='post.php?post=" . $key['postId'] . "'>" . $key['title'] . "</a></h3>
							<p class='smallPrint'>Kurs: <a href='post.php?class=" . $key['classCode'] . "&id=" . $teacher . "'>" . $key['className'] . "</a></p>";
							// Avkodar html-entiteter så att de skrivs ut korrekt
							$content = html_entity_decode($key['content']);
							// Skriver ut själva inlägget och kommentarscirkel
							echo "<div class='postContent'>" . $content . "</div>";
							echo "<div class='circle' id='circle_" . $key['postId'] . "' onclick='showComments(" . $key['postId'] . ")'>
								<p>" . $numberOfComments . "</p>
							</div>
							<div class='comment' id='comment_" . $key['postId'] . "'>";
							// Om det finns kommentarer till ett inlägg skrivs dessa ut
							if ($comments != NULL) {
								foreach ($comments as $commentKey) {
									// Avkodar html-entiteter så att de skrivs ut korrekt
									$comContent = html_entity_decode($commentKey['content']);
									echo "<div class='oldComments'>
										<p class='comInfo'>" . $commentKey['firstname'] . " " . $commentKey['lastname'] . "</p>
										<p class='comInfo smallPrint'>" . $commentKey['commentDate'] . "</p>

										<div class='commentP'>" . $comContent . "</div>
									</div>";
								}
							}
	?>
							<!-- Kommentarsformulär -->
							<form class='commentForm registerForm'>
								<label for='commentText_<?php echo $key['postId']; ?>'>Kommentera</label>
					            <textarea placeholder='Skriv din kommentar här' name='comment' id='commentText_<?php echo $key['postId']; ?>' rows='10' cols='80'></textarea>
					            <input id='commentButton<?php echo $key['postId']; ?>' type='button' class='button' value='Skicka' onclick='submitComment(<?php echo $key['postId']; ?>, "<?php echo $firstname; ?>", "<?php echo $lastname; ?>")'>
							</form><!-- Kommentarsformulär -->
							</div><!--/.comment -->
						</article><!-- /#post -->
<?php
					}
		    	}
			echo "</div><!--/#postSection-->";
			// Hämtar inläggsförfattarens profil
			if (isset($_GET['id'])) {
				$profile = $user->getProfile($_GET['id']);
			}
			else {
				$profile = $user->getProfile($authorId);
			}
			foreach ($profile as $profileKey) {
				$firstname = $profileKey['firstname'];
				$lastname = $profileKey['lastname'];
			}
			// Hämtar inläggsförfattarens profilbild
			if (isset($_GET['id'])) {
				$imageURL = $image->getPhoto($_GET['id']);
			}
			else {
				$imageURL = $image->getPhoto($authorId);
			}
		    // Om ingen profilbild har laddats upp visas en default-bild
		    if ($imageURL == NULL) {
		        $imageURL = "user.png";
		    }
			echo "<aside id='postAside'>";
			// Om inläggsförfattaren är instruktör skrivs detta ut
			if ($authorType == 1) {
				echo "<h3>Instruktör</h3>";
			}
			// Skriver ut profilbilden
			echo "<figure>
				<img src='images/uploads/thumb_" . $imageURL . "' alt='" . $firstname . " " . $lastname . "'>
			</figure>
			<h4>" . $firstname . " " . $lastname . "</h4>";
			// Hämtar inläggsförfattarens hundar
			if (isset($_GET['id'])) {
				$dogs = $dog->getDogInfo($_GET['id']);
			}
			else {
				$dogs = $dog->getDogInfo($authorId);
			}
			echo "<h5>Mina hundar</h5>";
			// Skriver ut info om hundarna
			foreach ($dogs as $dog) {
				echo "<h6>" . $dog['dogname'] . "</h6>
				<p class='smallPrint'>Född: " . $dog['dob'] . "</p>
				<p>" . $dog['dogInfo'] . "</p>";
			}
			echo "</aside>";
		}
	    echo "</div><!-- /#postContainer -->";
	}
	// Om användaren inte har tillgång till den aktuella kursen, skickas denna till index.php
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