<?php
	include 'php/user_info.php';
	include 'layout_inc/header.php';

	$image = new Image();
	$errors = array();
?>

<div id="image_overview_background"><br/>
	<?php
		$userid = $id;

		if(isset($_GET['id'])){
			$imageId = $_GET['id'];
			echo '<form action="" method="post">';
				echo 'Are you sure about deleting this image</br></br>';
				echo '<input type="submit" name="delete_sure" value="Yes"> ';
				echo '<input type="submit" name="delete_not_sure" value="No">';
			echo '</form>';
			if(isset($_POST['delete_sure'])){
				$deleteImage = $image->deleteImage($imageId);
				if(($deleteImage) != false){
					echo 'Image deleted, You will be automatically send back to Thumbs';
					header('Refresh: 3;url=image_overview.php');
				}else{
					echo 'Image not deleted, There went something wrong </br></br>';
					echo $imageId;
				}
			}
			if(isset($_POST['delete_not_sure'])){
				header('Location: image_overview.php');
			}
		}else{
			header('Location: image_overview.php');
		}

		//
	?>
</div>

<!-- This really is a sloppy way of doing it, but it was a simple and quick fix the bax creates space between the images and the footer. -->
<div id="invisible_bar"></div>


<?php
	include 'layout_inc/footer.php';
?>