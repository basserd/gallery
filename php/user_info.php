<?php
	session_start();

	include 'classes/classes.php';

	if(isset($_SESSION['session_username'])){
		echo "";
		$username = $_SESSION['session_username'];

		$user = new User();
		$image_class = new Image();

		$getdetails = $user->selectAllByUsername($username);
		if($getdetails != false){
			$id = $user->getId();
			$email = $user->getEmail();
			$displayname = $user->getDisplayName();
			$background = $user->getBackground();
			$profile_pic = $user->getProfilePic();
			$bio = $user->getBio();
		}else{
			echo "false";
		}
	}else{
		$background = 'media/backgrounds/background2.jpg';
		header('Location: login.php');
	}
?>