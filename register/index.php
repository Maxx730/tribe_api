<?php
	include("../lib/register_handler.php");
	include("../lib/database_handler.php");

	$db = new database_handler();
	$reg = new register_handler($db);
	$reg->register();
?>
<html>
	<head>
		<title>Register for Tribe</title>
	</head>
	<body>
		<form method = "POST" action = "index.php">
			<ul>
				<li>
					<input type = "text" name = "username" placeholder ="Desired Username"/>
				</li>
				<li>
					<input type = "password" name = "password" placeholder ="Password"/>
				</li>
				<li>
					<input type = "password" name = "password_repeat" placeholder ="Repeat Password"/>
				</li>
				<li>
					<input type = "text" name = "email" placeholder ="Email"/>
				</li>	
				<li>
					<input type = "submit" value = "Submit"/>
				</li>
			</ul>
		</form>
	</body>
</html>