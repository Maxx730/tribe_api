<?php
	if(isset($_GET['tribeInstall'])){
		include("lib/install.php");
		$inst = new tribe_install();
		$inst->purge_data();
		$inst->install();
	}elseif(isset($_GET['tribe_data'])){
		header("Access-Control-Allow-Orgin: *");
		header("Access-Control-Allow-Methods: *");
		header("Content-Type: application/json");

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
				//echo $_GET['tribe_data']."\n";

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
	}else{
		//Always require the head of our Tribe interface.
		require_once("lib/helpers.php");
		require_once('modules/head.php');
		require_once('modules/tribe_panel.php');
		include("lib/api_handler.php");
		include("lib/database_handler.php");
		include("lib/authentication_handler.php");

		$helper = new debug_helper();
		$db = new database_handler();
		$authenticate = new authentication_handler($db);

		if(isset($_GET['logout']) && $_GET['logout'] == true){
			session_unset();
			session_destroy();

			//Redirect the user to the login page.
			header("Location:/tribe/");
		}else if(isset($_SESSION['tribe_user'])){
			require_once('modules/dashboard.php');
		}else if((isset($_POST['sign-in-username']) && isset($_POST['sign-in-password']))){
			if($authenticate->authenticate($_POST['sign-in-username'],$_POST['sign-in-password'])){
				$api = new api_handler($authenticate,'{"action":"get","object":"log_session"}',$db);
				require_once('modules/dashboard.php');
			}
		}else{
		?>
					<div id = "tribal_top">

					</div>
					<div id = "login-container">
						<h1>Firepit</h1>

						<div class = "center-content">
							<form name = "tribe-login-form" action = "/tribe/" method = "POST">
								<input name = "sign-in-username" class = "tribe-input dark" type = "text" placeholder = "Username" value = ""/>

								<input name = "sign-in-password" class = "push-down tribe-input dark" type = "password" placeholder = "Password" value = ""/>

								<input id = 'login-btn' class = 'tribe-round-btn orange push-down' type = 'submit' value = 'Sign In'/>
							</form>
						</div>

						<div class = "sign-up-contain push-down">
						Don't have an account? Sign up Here!
						</div>
					</div>
					<div id = "register-container">
						<h1>Register</h1>
						<div class = "center-content">
							<input id = "register-username" class = "tribe-input dark" type = "text" placeholder = "New Username" value = ""/>

							<input id = "register-password" class = "push-down tribe-input dark" type = "password" placeholder = "New Password" value = ""/>

							<input id = "register-password-repeat" class = "push-down tribe-input dark" type = "password" placeholder = "Confirm New Password" value = ""/>

							<input id = "register-email" class = "push-down tribe-input dark" type = "text" placeholder = "E-Mail" value = ""/>

							<button id = 'register-btn' class = 'tribe-round-btn orange push-down'>
								REGISTER
							</button>
						</div>
					</div>
		<?php
		}
			require_once('modules/foot.php');
	}
?>



