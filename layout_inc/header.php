<html>
	<head>
		<title>Gallery</title>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
		<link href="css/main.css" rel="stylesheet" type="text/css"/>
		<link href="css/mobile.css" rel="stylesheet" type="text/css"/>
		<link href="css/forms.css" rel="stylesheet" type="text/css"/>
		<link href="css/admin-panel.css" rel="stylesheet" type="text/css"/>
		<link href="css/image_upload.css" rel="stylesheet" type="text/css"/>
		<link href="css/profile.css" rel="stylesheet" type="text/css"/>
		<!--<script src="js/main.js"></script>-->
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<!--<script src="js/background.js"></script>-->
	</head>
	<body>
		<div id="container">
			<div id="header">
				<div id="header-content">
					<div class="header-logo">Gallery</div>
					<div id="user-status-div">
						<div class="user-status-content">
							<?php
								if(isset($_SESSION['session_username'])){
									$username = $_SESSION['session_username'];
									echo "Hello ". $username . ". <a href='php/logout.php'>Logout</a>";
									$background_echo = 'media/database_images/user_background/'. $background . '';
									
									echo "
										<style>
											body{
												background:url('$background_echo')no-repeat 50% 50% fixed;
											}
										</style>
									";
								}else{
									$default_background = 'media/backgrounds/background2.jpg';
									echo "
										<style>
											body{
												background:url('$default_background')no-repeat 50% 50% fixed;
											}
										</style>	
									";
								}
							?>

						</div>
					</div>
				</div>
			</div><br/><br/><br/><br/>
			<div id="content-div">
				<div id="content">	