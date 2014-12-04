<?php
session_start();

if(isset($_SESSION['session_username'])){
	header('Location: admin_panel.php');
}else{
	include 'layout_inc/header.php';
	include 'php/classes/classes.php';

	if(isset($_POST['login_button'])){
		$user = new User();

		// $_POST to get the input fields.
		$username = $_POST['username'];
		$password = $_POST['password'];

		// Array where all errors will be placed in.
		$errors = array();

		// Function to check for empty fields by Login.
		$checkfields_for_empty = $user->checkforEmptyFields($username, $password);
		if($checkfields_for_empty = false){
			array_push($errors, "You must fill in both formfields.");
		}

		// Function to check for input lengths.
		$checkfields_for_length = $user->checkforFieldChars($username, $password);
		if($checkfields_for_length = false){
			array_push($errors, "Username must have atleast 5 chars, and password atleast 6 chars.");
		}	

		// After checking the forms, there will be errors or not.
		if(count($errors) == 0){
			$Login = $user->Login($username, $password);
			if($Login != false){
				// Making the session for validating login.
				$_SESSION['session_username'] = $username;
				header("Location: admin_panel.php");
			}else{
				echo "Wachtwoord or Username wrong.";
			}
		}else{
			print_r($errors);
		}
	}
	?>	

	<div id="login-form"><br/>
		<div class="login_form_title">
			Login
		</div>
		<form action="" method="post">
			<input type="text" name="username" class="form_input" id="login_form_username" placeholder="Username"/><br/>
			<input type="password" name="password" class="form_input" id="login_form_username" placeholder="*******"/><br/>
			<input type="submit" name="login_button" class="form_button" id="login_form_button" value="Send"/>
		</form>	
		<div class="clickhere_login">Don't have an account yet ? <a href="register.php">Click here</a></div>
	</div>

<?php
	include 'layout_inc/footer.php';
}	
?>