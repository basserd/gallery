<?php 
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "gallery";

	$connection = mysql_connect("$host", "$user", "$password") or die("<p>De verbinding met de database kan niet worden gemaakt</p>" . mysql_error());
mysql_select_db($database) or die("<p>De database kan niet geselecteerd worden</p>");


?>