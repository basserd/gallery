<?php
include 'php/user_info.php';
include 'layout_inc/header.php';

if(isset($_SESSION['session_username'])){
	echo "";
}else{
	header('Location: login.php');
}

if($_GET['action'] == ''){
	header('Location: profile.php?action=profile');
}

?>

<div id="profile_div">
	<div id="profile_header">
		<div class="profile_header_title"><?php echo $username ?></div>
	</div>
	<!-- structure for the navigation. -->
	<div id="profile_navigation">
		<div class="navigation_item">
			<a href="profile.php?action=profile"><div class="navigation_content">View Profile</div><div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
		<div class="navigation_item">
			<a href="profile.php?action=edit_profile"><div class="navigation_content">Edit Profile</div><div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
		<div class="navigation_item">
			<a href="profile.php?action=password"><div class="navigation_content">Password Management</div>
			<div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
		<div class="navigation_item">
			<a href="profile.php?action=email"><div class="navigation_content">Email Management</div>
			<div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
		<div class="navigation_item">
			<a href="profile.php?action=background"><div class="navigation_content">Background</div>
			<div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
		<div class="navigation_item">
			<a href="profile.php?action=template"><div class="navigation_content">Manage Template</div>
			<div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
	</div>
	<div id="profile_content">
		

		<?php
		/*<script type="text/javascript">
			function expandProfilePic(){
				var expandedProfilePic = "<?php echo '<img src='media/database_images/profile_image/full-size/' . $profile_pic .  ' ' ?>";
				return expandProfilePic;
			}
		</script>*/

			// Get for profile.
			if($_GET['action'] == 'profile'){
				echo '<div id="view_profile_div">';
				echo '<br/>';	
					echo '<div class="tab_title">';
						echo 'Profile';
					echo '</div>';
					echo $displayname.'<br/><br/>';
					echo '<img src="media/database_images/profile_image/thumb/'. $profile_pic .'" onclick="expandProfilePic()"/></br></br>';
					echo $bio;
				echo '</div>';
			}


			// else if for the action edit_profile.
			else if($_GET['action'] == 'edit_profile'){
				if(isset($_POST['profile_update'])){
					$errors_edit_profile = array();

					$displayname_new = $_POST['displayname_new'];
					$bio_new = $_POST['bio_new'];

					if(strlen($displayname_new) < 6){
						array_push($errors_edit_profile, "Your display name has to be 6 characters long.");
					}

					if(strlen($displayname_new) == ""){
						array_push($errors_edit_profile, "You need to fill in a displayname, or leave it.");
					}

					if(strlen($bio_new) > 150){
						array_push($errors_edit_profile, "Your bio cannot have more than 150 characters.");
					}

					if(strlen($bio_new) == ""){
						array_push($errors_edit_profile, "You need to fill in a bio, or leave it.");
					}

					/*if(!empty($_FILES['profile_pic'])){
						if(preg_match('/[.](jpg)|(gif)$/', $_FILES['profile_pic']['name'])){
							$path_to_image_directory = 'media/database_images/profile_image/full-size/';
							$filename = $_FILES['profile_pic']['name'];
							$source = $_FILES['profile_pic']['tmp_name'];
							$target = $path_to_image_directory . $filename;
							$profile_pic_new = $username . '_' .  $filename;

							$updateprofile_pic = $user->profile_picChange($id, $profile_pic_new);

							if($updateprofile_pic != false){
								// When settingsChange is true, The already existing image will be deleted from the webserver folder, and the new image will be uploaded.
								unlink('media/database_images/profile_image/full-size/'. $profile_pic .'');
								move_uploaded_file($source, $target);
								echo 'check image is true';
								// Page refresh.
								header('Refresh: 4;url=profile.php?action=edit_profile');
							}else{
								echo 'profile_pic upload not succeeded.';
							}
						}
					}*/

					if(count($errors_edit_profile) == 0){
						if($updateprofile = $user->profileChange($id, $displayname_new, $bio_new) == true){
							echo 'Profile settings updated';
							echo '</br>';
							echo $id . '</br>';
							echo $displayname_new .'</br>';
							echo $bio_new;

							header('Refresh: 4;url=profile.php?action=edit_profile');
						}else{
							echo 'There where some errors during updateprofile. Function not true. </br></br>';
							echo $id . '</br></br>';
							echo $displayname_new .'</br></br>';
							echo $bio_new;
						}
					}else{
						print_r($errors_edit_profile);
					}
				}else{
					?>
					<div id="edit_profile_div">
						<form action="#" method="post" >
						<br/>
							<div class="tab_title">Edit profile</div>
							<img class="pull-right" src="media/database_images/profile_image/thumb/<?php echo $profile_pic ?>"/>
							Display name <br/>
							<input type="text" class="pull-left" name="displayname_new" value="<?php echo $displayname ?>"/><br/><br/>
							Bio<br/>
							<textarea name="bio_new" class="bio_textarea"> <?php echo $bio ?> </textarea><br/><br/>
							<br/>
							<input type="submit" name="profile_update" value="Update"/>
						</form>
					</div>	
				<?php
				}
			}

			// Else if for action Password.
			else if($_GET['action'] == 'password'){
				// When the update button is pressed.
				if(isset($_POST['password_change'])){
					// Error array.
					$errors = array();

					// Making variables of the input fields.
					$old_password = $_POST['old_password'];
					$password_new = $_POST['password'];

					// Checking for valid length.
					if(strlen($old_password) < 6){
						array_push($errors, "Passwords are atleast 6 characters long.");
					}

					// Checking for empty field.
					if(strlen($old_password) == ""){
						array_push($errors, "Fill in your current password.");
					}

					// Checking for valid length.
					if(strlen($password_new) < 6){
						array_push($errors, "Passwords are atleast 6 characters long.");
					}

					// Checking for empty field.
					if(strlen($password_new) == ""){
						array_push($errors, "Fill in your new password.");
					}

					// After fields has been checked.
					if(count($errors) == 0){
						// When there are no errors.
						// User needs to confirm that its his account.
						$password_check = $user->passwordCheck($id, $old_password);
						// Checking for false or true.
						if($password_check != false){
							// When password_check is true.
							// passwordChange realy speaks for itself, no explaining needed.
							$password_change = $user->passwordChange($id, $password_new);
							// Checking for false or true.
							if($password_change != false){
								// When true is returned.
								echo 'Password changed. </br></br>';
								echo 'You will be directed back automatically. </br>';
								// Page refresh.
								header('Refresh: 3;url=profile.php?action=password');
							}else{
								// When false is returned.
								echo 'Password has not changed.';
							}
						}else{
							// When password_check is false.
							array_push($errors, "Current password is wrong.");
						}	
					}else{
						// Debugging.
						echo '<pre>';
							print_r($errors);
						echo '</pre>';
					}
				}else{
				?>

				<!-- Form for password change. -->
				<form action="#" method="post">
					<div id="password_div">
					<br/>
						<div class="tab_title">Password</div><br/>
						Current Password<br/><br/>
						<input type="password" name="old_password" placeholder="******"/><br/><br/>
						New password<br/><br/>
						<input type="password" name="password" placeholder="******"/><br/><br/>
						<input type="submit" name="password_change" value="Update"/>
					</div>
					
				</form>
				<?php
				}
			}
			// Else if for Email change.
			else if($_GET['action'] == 'email'){
				// When the 'update' button is pressed.
				if(isset($_POST['email_change'])){
					// Error array, for debugging and usability
					$errors_email = array();
					$succes_email = array();

					// Making a variable of the input field.
					$email_new = $_POST['email'];

					// Check to see if the input field contains a valid email adress.
					if (!filter_var($email_new, FILTER_VALIDATE_EMAIL)) {
				  		array_push($errors_email, "Your email adress is not valid."); 
					}	
					// Check for length.
					if(strlen($email_new) < 5){
						array_push($errors_email, "That is not a valid email adress.");
					}
					// Check for empty.
					if(strlen($email_new) == ""){
						array_push($errors_email, "You must enter an email adress.");
					}

					// Checking for errors.
					if(count($errors_email) == 0){
						// When there are no errors.
						// Function to check if the entered email adress is already in use by someone else.
						$email_check = $user->emailCheck($email_new);
						// To check if emailCheck returns false or true.
						if($email_check != false){
							// When it does return true.
							$email_change = $user->emailChange($email_new, $id);
							// Check to see if emailChange is false or true.
							if($email_change != false){
								// When it does return true
								array_push($succes_email, 'Email adress Changed.');
								array_push($succes_email, 'You will be directed back automatically.'); 

								echo '<div class="email_div">';
									echo json_encode($succes_email);
								echo '</div>';
								// Page refresh.
								header('Refresh: 0;url=profile.php?action=email');
							}else{
								array_push($error_email, 'Email adress has not been changed.');
							}
						}else{
							array_push($errors_email, "That email adress is already been used.");
						}
					}else{
						// Debugging.
						echo '<pre>';
							print_r($errors_email);
						echo '</pre>';
					}
				}else{
				?>

				<!-- Form which will be used to change the user's email-adress. -->
				<form action="#" method="post">
				<br/>
					<div id="email_div">
						<div class="tab_title">
							Email adress
						</div>
						<input type="email" name="email" value="<?php echo $email; ?>"/><br/><br/>
						<input type="submit" name="email_change" value="Update"/>
					</div>
				</form>	


				<?php
				}
			}

			// Else if for Action 'Settings', This is used to change the background of the web page.
			else if($_GET['action'] == 'background'){
				if(isset($_POST['background_change'])){
					$errors_background = array();
					$image = new Image();

					// Preg_match to check for a valid file format. Its not really a safe way to do this ** REMINDER (Making image upload more secure.)
					if(preg_match('/[.](jpg)|(gif)$/', $_FILES['background']['name'])){
						$path_to_image_directory = 'media/database_images/user_background/';
						$filename = $_FILES['background']['name'];
						$source = $_FILES['background']['tmp_name'];
						$target = $path_to_image_directory . $filename;
						$image_name = $filename;

						// Function checkforimagename is used to check in the Database if there is a image with the same name, If there is one, the user must change the image_name, Still working on this function. 
						$checkforimagename = $image->checkforimagename($image_name);

						// Check if the function returns true or false.
						if($checkforimagename != false){
							// When checkforimagename is true, function settingsChange will be executed.
							$updateBackground = $user->backgroundChange($id, $image_name);
							// Check if the function returns true or false.
							if($updateBackground != false){
								// When settingsChange is true, The already existing image will be deleted from the webserver folder, and the new image will be uploaded.
								unlink('media/database_images/user_background/'. $background .'');
								move_uploaded_file($source, $target);
								echo 'check image is true';
								// Page refresh.
								header('Refresh: 0;url=profile.php?action=background');
							}else{
								// When updates are not published.
								echo 'update background not used.';
							}
						}else{
							// Pushing an error to the array $error_settings. 
							array_push($errors_background, "Image name already exists.");
						}
					}else{
						array_push($errors_background, "Your file does not match the requirements.");
					}
					// This is for debugging.
					echo '<pre>';
						//print_r($$errors_background);
					echo '</pre>';
				}else{
				?>

				<!-- Form For changing the user_background which will be used when $_SESSION is set. -->
				<form enctype="multipart/form-data" action="#" method="post">
					<div id="background_div">
						<br/>
						<div class="tab_title">Background-Image</div> 
						<div class="current_background"><img src="media/database_images/user_background/<?php echo $background ?>" width="100%;"/></div><br/>
						<input type="file" value="<?php echo $background ?>" name="background"/><br/><br/>
						<input type="submit" value="update" class="update_button" name="background_change"/>
					</div>
				</form>
				<?php	
				}
			}
		?>
	</div>
</div>