<?php
	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
	header("Content-Type: application/json");

	if(isset($_GET['tribeInstall'])){
		include("lib/install.php");
		$inst = new tribe_install();
		$inst->purge_data();
		$inst->install();
	}else{
		include("lib/api_handler.php");
		include("lib/database_handler.php");
		include("lib/authentication_handler.php");

		$db = new database_handler();
		$authenticate = new authentication_handler($db);

		if(isset($_GET['tribe_data'])){
			if(isset($_GET['newAccount'])){
				//Create accounts go here.
			}else{
				if(isset($_GET["tribe_data"])){
					//Any time any client on any platform interacts with our database
					//they are going to send a JSON object containing the information
					//of where they are requesting from, what they want and their 
					//credentials.
					echo $_GET['tribe_data'];
				}

				//If we are not trying to create a new account we want to check 
				//if the user is trying to authenticate.
				if($authenticate->authenticate($_GET['auth'])){
					//Makesure there is a request variable set before we send the request to the api handler.
					if(isset($_GET['action']) && isset($_GET['data'])){
						//initialize our api class to start communicating with the database.
						$api = new api_handler($_GET['action'],$_GET['data'],$authenticate,$db);
					}else{
						//Return and error if the variable is missing.
						echo "\nERROR: There was an error in the request that you sent.";
					}
				}else{
					echo "Authentication failed.";
				}
			}
		}
	}
?>