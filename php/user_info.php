<?php
	session_start();

	include 'classes/classes.php';

	if(isset($_SESSION['session_username'])){
		echo "";
		$username = $_SESSION['session_username'];

		$user = new User();

		$getdetails = $user->selectAllByUsername($username);
		if($getdetails != false){
			$id = $user->getId();
			$email = $user->getEmail();
			$displayname = $user->getDisplayName();
			$background = $user->getBackground();
		}else{
			echo "false";
		}
	}else{
		$background = 'media/backgrounds/background2.jpg';
		header('Location: login.php');
	}
?>