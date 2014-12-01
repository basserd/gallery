<?php
	include 'layout_inc/header.php';
	include 'php/classes/classes.php';

	session_start();

	if(isset($_POST['register_button'])){
		$user = new User();

		// Making variables of the input fields, for later use.
		$displayname = $_POST['displayname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_confirm = $_POST['password_confirm'];

		$errors = array();

		// check for empty fields, basically explains itself, if any of the input fields is like "empty", an $error will be pushed into the array. This array will be used to as security for the backend functions(called $errors).
		if(strlen($password) == ""){
			array_push($errors, "You must enter a password.");
		}
		if(strlen($password_confirm) == ""){
			array_push($errors, "you must repeat your password.");
		}
		if(strlen($username) == ""){
			array_push($errors, "You must enter a username.");
		}
		if(strlen($email) == ""){
			array_push($errors, "You must enter an email adress.");
		}
		if(strlen($displayname) == ""){
			array_push($errors, "You must enter a displayname.");
		}

		// Check for password fields, if they match.
		if($password != $password_confirm){
			array_push($errors, "Your passwords don't match.");
		}

		// check for correct lengths.
		if(strlen($username) < 5){
			array_push($errors, "Your username must have a minimum of 5 characters.");
		}
		if(strlen($username) > 15){
			array_push($errors, "Your username cant have more than 15 characters.");
		}
		if(strlen($email) < 5){
			array_push($errors, "That is not a valid email adress.");
		}
		if(strlen($password) < 6){
			array_push($errors, "Your password should atleast have 6 characters.");
		}
		if(strlen($password) > 15){
			array_push($errors, "Your password cant have more than 15 characters.");
		}
		if(strlen($displayname) < 6){
			array_push($errors, "Your display name must have atleast 6 characters.");
		}
		if(strlen($displayname) > 15){
			array_push($errors, "Your display name cant have more than 15 characters.");
		}

		// Validation, checking for what symbols are used, in the input fields, this is needed if you want people to have normal usernames and display names, and its used to check for valid email adresses.
		if (!preg_match("/^[a-zA-Z ]*$/",$displayname)) {
			array_push($errors, "Thats not a valid displayname, Only letters and white space allowed.");
		}

		// We dont want numbers.
		if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
			array_push($errors, "Thats not a valid username, Only letters and white space allowed.");
		}

		// This process is an extra check, since where using Html5 type="email" in the input form for the email adress.
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  			array_push($errors, "Your email adress is not valid."); 
		}

		//$Register = $user->Register($username, $displayname, $email, $password);
		//$Login = $user->Login($username, $password);

		// Checking if there were no errors.
		if(count($errors) == 0){
			if($Register = $user->Register($username, $displayname, $email, $password) != false){
				if($Login = $user->Login($username, $password)!= false){
					$_SESSION['session_username'] = $username;
					header("Location: admin_panel.php");
				}else{
					echo "Jammer zeg, functie login niet uitgevoerd.";
				}
			}else{
				echo "Jammer zeg, functie register niet uitgevoerd.";
			}
		}else{
			echo "<div class='error_handling'>";
				print_r($errors);
			echo "</div>";	
		}
	}
?>

<div id="register-form"><br/>
	<div class="register_form_title">
		Register
	</div>
	<form action="" method="post">
		<input type="text" name="displayname" class="form_input" placeholder="Display name" id="register_form_displayname"/>
		<input type="text" name="username" id="register_form_username" class="form_input" placeholder="Username"/><br/>
		<input type="email" name="email" id="register_form_email" class="form_input" placeholder="example@email.nl"/><br/>
		<input type="password" name="password" id="register_form_password" class="form_input" placeholder="*******"/><br/>
		<input type="password" name="password_confirm" id="register_form_password_confirm" class="form_input" placeholder="*******"/><br/>
		<input type="submit" name="register_button" id="register_form_button" class="form_button" value="Send"/>
	</form>	
	<div class="clickhere_register">Already have an account ? <a href="login.php">click here.</a></div>
</div>

<?php
	include 'layout_inc/footer.php';
?>