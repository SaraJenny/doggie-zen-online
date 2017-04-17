<?php
/* Sara Petersson - Web 2.0, DT091G 
Skapar objekt som hämtar och sparar information om användare */

	class User {

		public function __construct() {
			$this->db = new Database();
		}

		// Hämtar användarens för- och efternamn
		public function getProfile($userId) {
			$result = $this->db->select("SELECT firstname, lastname FROM users WHERE userId = $userId");
			return $result;
		}

		// Hämtar användarens e-post
		public function getEmail($userId) {
			$result = $this->db->select("SELECT email FROM users WHERE userId = $userId");
			foreach ($result as $key) {
				$email = $key['email'];
			}
			return $email;
		}

        // Saniterar och kontrollerar användarinloggning
        public function controlUser($email) {
			$email = $this->db->sanitize($email);
			$result = $this->db->select("SELECT * FROM users WHERE email = '$email'");
			return $result;
        }

        // Saniterar och jämför det inskrivna lösenordet med det som är sparat i databasen
        public function controlPassword($email, $password, $stored_password) {
	        $password = $this->db->sanitize($password);
            // Kollar om funktionen hash_equals finns, och jämför i så fall det inskrivna lösenordet med det lagrade
            if (function_exists('hash_equals')) {
		        if (hash_equals($stored_password, crypt($password, $stored_password))) {
		        	return true;
		        }
		        else {
		        	return false;
		        }
            }
            // Om funktionen inte existerar, sker fortfarande en jämförelse mellan lösenorden, men på annat vis
            else {
                if ($stored_password == crypt($password, $stored_password)) {
		        	return true;
		        }
		        else {
		        	return false;
		        }
            }
        }

		/* Saniterar användarinformation, krypterar lösenordet och lägger till användare i databasen.
		Funktionen returnerar den nyinlagda användarens userId */
		public function addUser($firstname, $lastname, $email, $password, $type) {
			$firstname = $this->db->sanitize($firstname);
			$lastname = $this->db->sanitize($lastname);
			$email = $this->db->sanitize($email);
			$password = $this->db->sanitize($password);
			$secure_password = $this->db->securePassword($password);
			$result = $this->db->query("INSERT INTO users (firstname, lastname, email, password, type) VALUES ('$firstname', '$lastname', '$email', '$secure_password', $type)");
			$userId = $this->db->getId();
			return $userId;
		}

		// Saniterar användarinformation och uppdaterar användare i databasen
		public function updateUser($userId, $firstname, $lastname, $email) {
			$firstname = $this->db->sanitize($firstname);
			$lastname = $this->db->sanitize($lastname);
			$email = $this->db->sanitize($email);
			$result = $this->db->query("UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email' WHERE userId = $userId");
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}

		// Hämtar information om vald användare
		public function getUserInfo($userId) {
			$user = $this->db->select("SELECT * FROM users WHERE userId = $userId");
			return $user;
		}

		// Hämtar vilken typ användaren är (admin/student)
		public function getUserType($userId) {
			$result = $this->db->select("SELECT type FROM users WHERE userId = $userId");
			foreach ($result as $key) {
				$type = $key['type'];
			}
			return $type;
		}

		// Uppdaterar en användares lösenord, efter att det har saniterats och hashats
		public function changePassword($userId, $password) {
			$password = $this->db->sanitize($password);
			$secure_password = $this->db->securePassword($password);
			$result = $this->db->query("UPDATE users SET password = '$secure_password' WHERE userId = $userId");
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}
	}