<?php
/* Sara Petersson - Web 2.0, DT091G 
Skapar objekt som hämtar och sparar information om kurser */

	class Post {

		// Konstruerare
		public function __construct(){ 
			$this->db = new Database();
		}

		// Hämtar en användares senaste inlägg i en kurs
		public function getLatestPost($classCode, $userId) {
			$classCode = $this->db->sanitize($classCode);
			$result = $this->db->select("SELECT userId, postDate, title FROM post
				WHERE classCode = '$classCode'
				AND userId = $userId
				ORDER BY postDate
				DESC LIMIT 1");
			return $result;
		}

		// Hämtar alla poster av en specifik användare i en specifik kurs
		public function getAllPostsFromUserInClass($classCode, $userId) {
			$classCode = $this->db->sanitize($classCode);
			$result = $this->db->select("SELECT post.*, type, className FROM post, users, curriculum, class
				WHERE post.classCode = '$classCode'
				AND post.userId = $userId
				AND post.userId = users.userId
				AND post.classCode = curriculum.classCode
				AND curriculum.classId = class.classId
				ORDER BY postDate DESC");
			return $result;
		}

		// Hämtar alla poster med passerat publiceringsdatum av en specifik användare i en specifik kurs 
		public function getAllPostsFromUserInClassDateLimit($classCode, $userId, $date, $time) {
			$classCode = $this->db->sanitize($classCode);
			$date = $this->db->sanitize($date);
			$time = $this->db->sanitize($time);
			$result = $this->db->select("SELECT post.*, type, className FROM post, users, curriculum, class
				WHERE post.classCode = '$classCode'
				AND post.userId = $userId
				AND post.userId = users.userId
				AND post.classCode = curriculum.classCode
				AND curriculum.classId = class.classId
				AND postDate <= '$date $time' 
				ORDER BY postDate DESC");
			return $result;
		}

		// Hämtar information om ett specifikt inlägg
		public function getPost($postId) {
			$result = $this->db->select("SELECT post.*, type, className FROM post, users, curriculum, class
				WHERE postId = $postId
				AND post.userId = users.userId
				AND post.classCode = curriculum.classCode
				AND curriculum.classId = class.classId");
			return $result;
		}

		// Saniterar och lägger till ett inlägg
		public function addPost($userId, $postDate, $title, $content, $classCode) {
			$postDate = $this->db->sanitize($postDate);
			$title = $this->db->sanitize($title);
			$content = strip_tags($content, "<p>, <em>, <strong>, <ol>, <ul>, <li>, <h1>, <h2>, <h3>, <a>, <img>, <hr>, <iframe>, <br>");
			$content = $this->db->sanitize($content);
			$classCode = $this->db->sanitize($classCode);
			$result = $this->db->query("INSERT INTO post (userId, postDate, title, content, classCode) VALUES ($userId, '$postDate', '$title', '$content', '$classCode')");
			if ($result) {
				$postId = $this->db->getId();
				return $postId;
			}
			else {
				return false;
			}
		}

		// Hämtar alla kommentarer för ett specifikt inlägg
		public function getComments($postId) {
			$postId = intval($postId);
			$result = $this->db->select("SELECT comment.*, firstname, lastname FROM comment, users
				WHERE postId = $postId
				AND comment.userId = users.userId
				ORDER BY commentDate DESC");
			return $result;
		}

		// Räknar antalet kommentarer ett specifikt inlägg har
		public function countComments($postId) {
			$postId = intval($postId);
			$comment = $this->db->select("SELECT COUNT(*) FROM comment WHERE postId = $postId");
			foreach ($comment as $key) {
				$result = $key['COUNT(*)'];
			}
			return $result;
		}

		// Saniterar och lägger till en kommentar
		public function addComment($userId, $content, $commentDate, $postId) {
			$content = strip_tags($content, "<p>, <em>, <strong>, <ol>, <ul>, <li>, <h1>, <h2>, <h3>, <a>, <img>, <hr>, <iframe>, <br>");
			$content = $this->db->sanitize($content);
			$result = $this->db->query("INSERT INTO comment (userId, content, commentDate, postId) VALUES ($userId, '$content', '$commentDate', $postId)");
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}
	}