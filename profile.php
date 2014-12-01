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
	<div id="profile_navigation">
		<div class="navigation_item">
			<a href="profile.php?action=profile"><div class="navigation_content">View profile</div><div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
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
			<a href="profile.php?action=settings"><div class="navigation_content">Profile settings</div>
			<div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
		<div class="navigation_item">
			<a href="profile.php?action=template"><div class="navigation_content">Manage Template</div>
			<div class="navigation_icon"><img src="media/icons/arrow-right16-icon.png" width="60%"/></div></a>
		</div>
	</div>
	<div id="profile_content">
		<?php
			if($_GET['action'] == 'profile'){
				echo $username;
			}

			else if($_GET['action'] == 'password'){
				if(isset($_POST['password_change'])){
					$errors = array();

					$old_password = $_POST['old_password'];
					$password_new = $_POST['password'];

					if(strlen($old_password) < 6){
						array_push($errors, "Passwords are atleast 6 characters long.");
					}

					if(strlen($old_password) == ""){
						array_push($errors, "Fill in your current password.");
					}

					if(strlen($password_new) < 6){
						array_push($errors, "Passwords are atleast 6 characters long.");
					}

					if(strlen($password_new) == ""){
						array_push($errors, "Fill in your new password.");
					}

					// After fields has been checked.
					if(count($errors) == 0){
						$password_check = $user->passwordCheck($id, $old_password);
						if($password_check != false){
							$password_change = $user->passwordChange($id, $password_new);
							if($password_change != false){
								echo 'Password changed. </br></br>';
								echo 'You will be directed back automatically. </br>';
								header('Refresh: 3;url=profile.php?action=password');
							}else{
								echo 'Password has not changed.';
							}
						}else{
							array_push($errors, "Current password is wrong.");
						}	
					}else{
						echo '<pre>';
							print_r($errors);
						echo '</pre>';
					}
				}else{
				?>
				<form action="#" method="post">
					<table>
						<tr><td>Current password : </td><td><input type="password" name="old_password" placeholder="*******"/></td></tr>
						<tr><td>New password : </td><td><input type="password" name="password" placeholder="*******"/></td></tr>
						<tr><td><input type="submit" value="Update" name="password_change"/></td></tr>
					</table>
				</form>
				<?php
				}
			}

			else if($_GET['action'] == 'email'){
				if(isset($_POST['email_change'])){
					$errors_email = array();

					$email_new = $_POST['email'];

					if (!filter_var($email_new, FILTER_VALIDATE_EMAIL)) {
				  		array_push($errors_email, "Your email adress is not valid."); 
					}	
					if(strlen($email_new) < 5){
						array_push($errors_email, "That is not a valid email adress.");
					}
					if(strlen($email_new) == ""){
						array_push($errors_email, "You must enter an email adress.");
					}

					// After fields are being checked.
					if(count($errors_email) == 0){
						$email_check = $user->emailCheck($email_new);
						if($email_check != false){
							$email_change = $user->emailChange($email_new, $id);
							if($email_change != false){
								echo 'Email changed. </br></br>';
								echo 'You will be directed back automatically. </br>';
								header('Refresh: 3;url=profile.php?action=email');
							}else{
								echo 'Email has not been changed.</br>';

							}
						}else{
							array_push($errors_email, "That email adress is already been used.");
						}
					}else{
						echo '<pre>';
							print_r($errors_email);
						echo '</pre>';
					}
				}else{
				?>
				<form action="#" method="post">
					<table>
						<tr><td>Email adress : </td><td><input type="email" name="email" value="<?php echo $email; ?>"/></td></tr>
						<tr><td><input type="submit" name="email_change" value="Update"/></td></tr>
					</table>
				</form>	
				<?php
				}
			}

			else if($_GET['action'] == 'settings'){
				if(isset($_POST['settings_change'])){
					$errors_settings = array();
					$image = new Image();
					if(preg_match('/[.](jpg)|(gif)$/', $_FILES['background']['name'])){
						$path_to_image_directory = 'media/database_images/user_background/';
						$filename = $_FILES['background']['name'];
						$source = $_FILES['background']['tmp_name'];
						$target = $path_to_image_directory . $filename;
						$image_name = $filename;
						$checkforimagename = $image->checkforimagename($image_name);

						if($checkforimagename != false){
							$updateSettings = $user->settingsChange($id, $image_name);
							if($updateSettings != false){
								unlink('media/database_images/user_background/'. $background .'');
								move_uploaded_file($source, $target);
								echo 'check image is true';
							}else{
								echo 'update settings not used.';
							}
						}else{
							array_push($errors_settings, "Image name already exists.");
						}
					}else{
						array_push($errors_settings, "Your file does not match the requirements.");
					}

					echo '<pre>';
						print_r($errors_settings);
					echo '</pre>';
				}else{
				?>
				<form enctype="multipart/form-data" action="#" method="post">
					<table>
						<tr><td>Background-Image : </td><td><img src="media/database_images/user_background/<?php echo $background ?>" width="300px;"/></td></tr>
						<tr><td>Upload-Background : </td><td><input type="file" value="<?php echo $background ?>" name="background" data-buttonText="Find file"/></td></tr>
						<tr><td><input type="submit" value="update" name="settings_change"/></td></tr>
					</table>	
				</form>
				<?php	
				}
			}
		?>
	</div>
</div>