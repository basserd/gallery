<?php
	include 'php/user_info.php';
	include 'layout_inc/header.php';

	include 'php/image_upload/config.php';
	include 'php/image_upload/functions.php';


	$image = new Image();
	$errors = array();

	if(isset($_POST['upload_image'])){
		if(isset($_FILES['fupload'])){
			if(preg_match('/[.](jpg)|(gif)$/', $_FILES['fupload']['name'])){
				$filename = $username .'_'. $_FILES['fupload']['name'];
				$source = $_FILES['fupload']['tmp_name'];
				$target = $path_to_image_directory . $filename;

				move_uploaded_file($source, $target);
				$title = $_POST['title'];
				$description = $_POST['description'];
				$userid = $id;
				$image_name = $filename;

				$checkforimagename = $image->checkforimagename($image_name);

				if(($checkforimagename) == true){
					$todb = $image->imagetodb($title, $description, $image_name, $userid);
					createThumbnail($filename);
				}else{
					array_push($errors, "Image name already exists.");
				}
			}else{
				array_push($errors, "Your file does not match the requirements.");
			}
		}else{
			array_push($errors, "Upload an image please");
		}
	}
?>

<div id="image_upload_background"><br/>
	<center><h1>Upload a Image.</h1>

	<script>
		$(":file").jfilestyle({buttonText: "Find file"});
		$(":file").jfilestyle({theme : "orange"});
	</script>

	<form enctype="multipart/form-data" action="" method="post">
		Title : <input type="text" placeholder="Paardjes" class="form_input" name="title"/> <br/><br/>
		Description : <textarea name="description"></textarea><br/><br/>
		<input type="file"  name="fupload" data-buttonText="Find file"/>
		<input type="submit" name="upload_image" class="image_upload_button" value="upload"/><br/>
	</form>
	</center>
	<?php
		if(count($errors) == 0){

		}else{
			$error_output = json_encode($errors);

			echo "<br/><center><pre>";
				//print_r($errors);
				print_r($error_output);
			echo "</pre></center>";
		}
	?>
</div>


<?php
	include 'layout_inc/footer.php';
?>