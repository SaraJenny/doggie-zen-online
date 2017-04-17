<?php
/* Sara Petersson - Web 2.0, DT091G 
Skapar objekt som hämtar och sparar information om kurser */

	class Classes {
		// Skapar array för alla användare
		private $classList = array();
		private $teacherList = array();

		// Konstruerare
		public function __construct(){ 
			$this->db = new Database();
			// Hämtar in allt innehåll från kurser
			$this->classList = $this->db->select("SELECT * FROM class ORDER BY className");
			// Hämtar alla instruktörer
			$this->teacherList = $this->db->select("SELECT userId, firstname, lastname FROM users WHERE type = 1");
		}

		// Hämtar en students deltagartyp (observatör eller deltagare med hund) för en specifik kurs
		public function getStudentType($userId, $classCode) {
			$userId = intval($userId);
			$classCode = $this->db->sanitize($classCode);
			$result = $this->db->select("SELECT typeId FROM userclass
			WHERE userId = $userId
			AND classCode = '$classCode'");
			foreach ($result as $key) {
				$studentType = $key['typeId'];
			}
			return $studentType;
		}

		// Hämtar stängningsdatum för en kurs
		public function getClosingDate($classCode) {
			$classCode = $this->db->sanitize($classCode);
			$result = $this->db->select("SELECT closingDate FROM curriculum WHERE classCode = '$classCode'");
			foreach ($result as $key) {
				$closingDate = $key['closingDate'];
			}
			return $closingDate;
		}

		// Hämtar startdatum för en kurs
		public function getStartDate($classCode) {
			$classCode = $this->db->sanitize($classCode);
			$result = $this->db->select("SELECT startDate FROM curriculum WHERE classCode = '$classCode'");
			foreach ($result as $key) {
				$startDate = $key['startDate'];
			}
			return $startDate;
		}

		// Hämtar kurskoder för alla kurser en kursdeltagare har deltagit i
		public function getUserAccess($userId) {
			$userId = intval($userId);
			$result = $this->db->select("SELECT classCode FROM userclass WHERE userId = $userId");
			return $result;
		}

		// Lägger till ny kurs i kursplanen
		public function addClass($classId, $classCode, $startDate, $endDate, $closingDate, $teacherId) {
			$classId = intval($classId);
			$teacherId = intval($teacherId);
			$classCode = $this->db->sanitize($classCode);
			$startDate = $this->db->sanitize($startDate);
			$endDate = $this->db->sanitize($endDate);
			$closingDate = $this->db->sanitize($closingDate);
			$result = $this->db->query("INSERT INTO curriculum VALUES ('$classCode', $classId, '$startDate', '$endDate', '$closingDate')");
			// Om kursen lagts till läggs även instruktörs-id till dessa
			if ($result) {
				$sql = $this->db->query("INSERT INTO userclass VALUES ('$classCode', $teacherId, 1)");
				if ($sql) {
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}

		// Lägg till nytt kursnamn
		public function addClassName($newClassName) {
			$newClassName = $this->db->sanitize($newClassName);
			$result = $this->db->query("INSERT INTO class (className) VALUES ('$newClassName')");
			if ($result) {
				$classId = $this->db->getId();
				return $classId;
			}
			else {
				return false;
			}
		}

		// Returnerar kurslista
		public function getClassList() {
			return $this->classList;
		}

		// Returnerar instruktörslista
		public function getTeacherList() {
			return $this->teacherList;
		}

		// Hämtar kurser som en användare deltar i
		public function getClasses($userId) {
			$result = $this->db->select("SELECT className, curriculum.classCode, startDate, endDate, closingDate, typeId FROM class, userclass, curriculum
				WHERE userId = $userId
				AND class.classId = curriculum.classId
				AND userclass.classCode = curriculum.classCode
				ORDER BY curriculum.startDate DESC");
			return $result;
		}

		// Hämtar instruktör för en kurs
		public function getTeacher($classCode) {
			$classCode = $this->db->sanitize($classCode);
			$result = $this->db->select("SELECT userId FROM userclass
				WHERE classCode = '$classCode'
				AND typeId = 1");
			if ($result) {
				foreach ($result as $key) {
					$teacher = $key['userId'];
				}
				return $teacher;
			}
			else {
				return false;
			}
		}

		// Hämtar alla aktuella kurser
		public function getCurrentClasses($date) {
			$date = $this->db->sanitize($date);
			$result = $this->db->select(
				"SELECT className, classCode, startDate
				FROM class, curriculum
				WHERE class.classId = curriculum.classId
				AND endDate > '$date'
				ORDER BY startDate DESC");
			return $result;
		}

		// Hämtar en students aktuella kurser där de deltar med hund
		public function getStudentCurrentActiveClasses($userId, $date) {
			$date = $this->db->sanitize($date);
			$result = $this->db->select(
				"SELECT className, userclass.classCode, startDate
				FROM class, userclass, curriculum
				WHERE class.classId = curriculum.classId
				AND userclass.classCode = curriculum.classCode
				AND startDate <= '$date'
				AND endDate > '$date'
				AND userId = $userId
				AND typeId = 4
				ORDER BY startDate");
			return $result;
		}

		// Hämtar studenter som går en viss kurs
		public function getStudents($userId) {
			$result = $this->db->select(
				"SELECT users.userId, firstname, lastname, type, curriculum.classCode, startDate, className
				FROM users, curriculum, userclass, class
				WHERE userclass.classcode IN
					(SELECT classCode FROM userclass WHERE userId = $userId)
					AND users.userId = userclass.userId
					AND users.userId != $userId
					AND type != 1
					AND curriculum.classId = class.classId
					AND curriculum.classCode = userclass.classCode");
			return $result;
		}

		// Hämtar alla studenter som går/har gått minst en kurs
		public function getStudentList() {
			$result = $this->db->select("SELECT DISTINCT users.userId, email, firstname, lastname FROM users, userclass
				WHERE users.userId IN
				(SELECT userclass.userId FROM userclass)
				AND type != 1
				ORDER BY firstname");
			return $result;
		}

		// Hämtar alla studenter som ännu inte fått rättigheter till någon kurs
		public function getNewStudents() {
			$result = $this->db->select("SELECT DISTINCT users.userId, email, firstname, lastname FROM users, userclass
				WHERE users.userId NOT IN
				(SELECT userclass.userId FROM userclass)
				AND type != 1");
			return $result;
		}

		// Lägger till kursdeltagare till kurs
		public function addStudentToClass($userId, $classChoice, $type) {
			$result = $this->db->query("INSERT INTO userclass VALUES ('$classChoice', $userId, $type)");
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}
	}