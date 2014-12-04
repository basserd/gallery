<?php
	function createThumbnail($filename){
		$final_width_of_image = 200;
		$path_to_image_directory = 'media/database_images/full-size/';
		$path_to_thumbs_directory = 'media/database_images/thumb/';
		
		if(preg_match('/[.](jpg)$/', $filename)){
			$im = imagecreatefromjpeg($path_to_image_directory . $filename);
		}else if(preg_match('/[.](gif)$/', $filename)){
			$im = imagecreatefromgif($path_to_image_directory . $filename);
		}else if(preg_match('/[.](png)$/', $filename)){
			$im = imagecreatefrompng($path_to_image_directory . $filename);
		}

		$ox = imagesx($im);
		$oy = imagesy($im);

		$nx = $final_width_of_image;
		$ny = floor($oy * ($final_width_of_image / $ox));

		$nm = imagecreatetruecolor($nx, $ny);

		imagecopyresized($nm, $im, 0,0,0,0, $nx, $ny, $ox, $oy);

		if(!file_exists($path_to_thumbs_directory)){
			if(!mkdir($path_to_thumbs_directory)){
				die("There was a problem, Please try again.");
			}
		}

		imagejpeg($nm, $path_to_thumbs_directory . $filename);

		echo "<div class='image_upload_succes'>";
	    $tn = '<center><br/><br/><img src="' . $path_to_thumbs_directory . $filename . '" alt="image" /></center>';
	    $tn .= '<br /><center>Congratulations. Your file has been successfully uploaded, and a      thumbnail has been created.</center>';
	    $tn .= '<br/><center>Page will refresh in 3 seconds.</center>';
	    echo $tn;
	    header('Refresh: 3;url=image_upload.php');
	    echo "</div>";
	}
?>