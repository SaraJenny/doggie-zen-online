<?php
/* Sara Petersson - Web 2.0, DT091G 
Skapar objekt som hämtar och sparar information om hundar */

	class Dog {

		public function __construct() {
			$this->db = new Database();
		}

		// Hämtar information om användarens hundar
		public function getDogInfo($userId) {
			$dog = $this->db->select("SELECT * FROM dog WHERE userId = $userId
				ORDER BY dob DESC");
			return $dog;
		}

		// Saniterar hundinformation och lägger till hund i databasen. Hundens id returneras
		public function addDog($dogname, $dob, $dogInfo, $userId) {
			// Inga taggar får skickas med
			$dogname = strip_tags($dogname);
			$dob = strip_tags($dob);
			$dogInfo = strip_tags($dogInfo);
			$dogname = $this->db->sanitize($dogname);
			$dob = $this->db->sanitize($dob);
			$dogInfo = $this->db->sanitize($dogInfo);
			$result = $this->db->query("INSERT INTO dog (dogname, dob, dogInfo, userId) VALUES ('$dogname', '$dob', '$dogInfo', $userId)");
			if ($result) {
				$dogId = $this->db->getId();
				return $dogId;
			}
			else {
				return false;
			}
		}

		// Uppdaterar vald hund
		public function updateDog($dogId, $dogname, $dob, $dogInfo) {
			// Inga taggar får skickas med
			$dogname = strip_tags($dogname);
			$dob = strip_tags($dob);
			$dogInfo = strip_tags($dogInfo);
			$dogname = $this->db->sanitize($dogname);
			$dob = $this->db->sanitize($dob);
			$dogInfo = $this->db->sanitize($dogInfo);
			$result = $this->db->query("UPDATE dog SET dogname = '$dogname', dob = '$dob', dogInfo = '$dogInfo' WHERE dogId = $dogId");
			if ($result) {
				echo true;
			}
		}

		// Raderar vald hund
		public function deleteDog($dogId) {
			$result = $this->db->query("DELETE FROM dog WHERE dogId = $dogId");
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}
	}