<?php
	//Pull in our api handler to check if there has been a notification
	//handler.
	include("../../lib/api_handler.php");

	//Authenticates our user.
	include("../../lib/authentication_handler.php");
?>

<html>
	<head>
		<title>Add Notification</title>
	</head>
	<body>
		<form method = "POST" action = "/" name = "debug_add_notification">
			<input type = "text" value = "" placeholder = "notification name"/>
			<br />
			<input type = "text" value = "" placeholder = "notification content"/>
			<br />
			<input type = "submit" value = "Add"/>
		</form>
	</body>
</html>