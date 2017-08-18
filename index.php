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
			if(isset($_GET["tribe_data"])){
				//Any time any client on any platform interacts with our database
				//they are going to send a JSON object containing the information
				//of where they are requesting from, what they want and their 
				//credentials.
				echo $_GET['tribe_data']."\n";

				$data = json_decode($_GET['tribe_data'],true);

				if($authenticate->authenticate($data['credentials']['username'],$data['credentials']['password'])){
					//Since the credentials have passed we then
					//want to start up the api handler to get or
					//recieve data.
					$retriever = new api_handler($authenticate,$data,$db);

			
				}else{
					echo "ERROR: Not a valid username or password.\n";
				}
			}
		}
	}
?>