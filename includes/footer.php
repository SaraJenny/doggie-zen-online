<!-- Sara Petersson - Web 2.0, DT091G -->
			</section><!-- Section slut -->
			<!-- Sidfot -->
			<footer>
<?php
				// Kollar om sessionsvariabel är satt och skriver i så fall ut "Logga ut"
				if (isset($_SESSION["userId"])) {
					echo "<p><a href='logout.php'>Logga ut</a></p>";
				}
?>
				<p id="author">Sara Petersson <span class="divider">|</span> Web 2.0</p>
			</footer><!-- Sidfot slut -->
		<!-- jQuery -->
		<script src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
        <!-- JS-fil -->
        <script src="script/script.js"></script>
	</body>
</html>