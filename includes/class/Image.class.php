<?php
/* Sara Petersson - Web 2.0, DT091G 
Skapar objekt som hämtar och sparar bilder */

	class Image {

		public function __construct() {
			$this->db = new Database();
		}

		// Skapar ett unikt filnamn genom att loopa fram en siffra tills filnamnet blir unikt
		public function file_newname($path, $filename){
			// Kolla om en punkt hittas i filnamnet och spara vilken position den har i strängen
		    if ($position = strrpos($filename, '.')) {
		    	// Spara filnamn
				$name = substr($filename, 0, $position);
				// Spara filtyp
				$ext = substr($filename, $position);
		    }
		    // Om ingen punkt hittades, spara filnamn
		    else {
		        $name = $filename;
		    }
		    // Spara filens sökväg
		    $newpath = $path . '/' . $filename;
		    $newname = $filename;
		    $counter = 0;
		    // Loopa fram ett unikt namn
		    while (file_exists($newpath)) {
				$newname = $name . '_' . $counter . $ext;
				$newpath = $path.'/'.$newname;
				$counter++;
		    }
		    return $newname;
		}

		// Lägger till en profilbild och skapar en tumnagelbild av den uppladdade bilden
		public function addPhoto($url, $userId) {
			$url = $this->db->sanitize($url);
			$result = $this->db->query("INSERT INTO photo (url, userId) VALUES ('$url', $userId)");
            // Om bilden lagts till skapas tumbild
            if ($result) {
            	// Skapar variabel för miniatyrbildens namn
	            $thumbnail = "thumb_" . $url;
	            // Maximal storlek i höjd och bredd för miniatyr
	            $width_thumbnail = 158;
	            $height_thumbnail = 300;
	            // Läser in originalstorleken på den uppladdade bilden, och sparar den i variabler
	            list($width_thumbnail_orig, $height_thumbnail_orig) = getimagesize('../images/uploads/' . $url);
	            // Räknar ut förhållandet mellan höjd och bredd, för att få samma förhållanden på miniatyren
	            $ratio_orig = $width_thumbnail_orig / $height_thumbnail_orig;                                      
	            // Räknar ut storlek på miniatyr
	            if ($width_thumbnail / $height_thumbnail > $ratio_orig) {
	                $width_thumbnail = $height_thumbnail * $ratio_orig;
	                $height_thumbnail = $width_thumbnail / $ratio_orig;
	            }
	            else {
	                $height_thumbnail = $width_thumbnail / $ratio_orig;
	                $width_thumbnail = $height_thumbnail * $ratio_orig;
	            }
	            //Skapar en ny miniatyrbild med rätt storlek
	            $image_p = imagecreatetruecolor($width_thumbnail, $height_thumbnail);
	            $image_j = imagecreatefromjpeg('../images/uploads/' . $url);
	            imagecopyresampled($image_p, $image_j, 0, 0, 0, 0, $width_thumbnail, $height_thumbnail, $width_thumbnail_orig, $height_thumbnail_orig);
	            //Sparar miniatyr
	            imagejpeg($image_p, '../images/uploads/' . $thumbnail);
	            return true;
            }
			else {
				return false;
			}
		}

		// Hämtar användarens profilbild
		public function getPhoto($userId) {
			$result = $this->db->select("SELECT url FROM photo WHERE userId = $userId");
			if ($result) {
				foreach ($result as $key) {
					$url = $key['url'];
				}
				return $url;
			}
		}

		// Raderar användarens profilbild
		public function deletePhoto($userId) {
			$result = $this->db->query("DELETE FROM photo WHERE userId = $userId");
			if ($result) {
				return true;
			}
			else {
				return false;
			}
		}
	}