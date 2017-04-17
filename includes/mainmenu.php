<!-- Sara Petersson - Web 2.0, DT091G -->
		<nav>
		    <ul>
<?php
				// Hem
				echo "<li";
				if (getPath() == "/index.php") {
					echo " class='active'";
				}
				echo "><a href='index.php'>Hem</a></li>";
				// Min profil
				echo "<li";
				if (getPath() == "/profile.php") {
					echo " class='active'";
				}
				echo "><a href='profile.php'>Min profil</a></li>";
				// Skapa post
				echo "<li";
				if (getPath() == "/publish.php") {
					echo " class='active'";
				}
				echo "><a href='publish.php'>Skapa post</a></li>";
				// Användaren måste vara inloggad som administratör för att se detta menyalternativ
				if (isset($_SESSION['userId']) && $type == 1) {
					// Admin
					echo "<li";
					if (getPath() == "/admin.php") {
						echo " class='active'";
					}
					echo "><a href='admin.php'>Admin</a></li>";
				}
				if (isset($_SESSION['userId'])) {
					echo "<li id='logout'><a href='logout.php'>Logga ut</a></li>";
				}
?>
		    </ul>
		</nav>