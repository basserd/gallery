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
			$id = $_GET['id'];

			$showfullsize = $image->showFullSize($userid, $id);
		}else{
			$showthumbs = $image->showThumbs($userid);
		}
	?>
</div>

<!-- This really is a sloppy way of doing it, but it was a simple and quick fix the bax creates space between the images and the footer. -->
<div id="invisible_bar"></div>


<?php
	include 'layout_inc/footer.php';
?>