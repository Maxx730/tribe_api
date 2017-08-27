<?php
	//Class that will check for authentication every time a request is sent to the database.
	class authentication_handler{

		var $database = null;
		var $user_id = null;
		var $username = null;

		function __construct($db){
			$this->database = $db;
		}

		//Takes in user data and compares it against the data
		//base to make sure the user is allowed to access.
		public function authenticate($user,$password){
			//Start our session as well as destroy it after every check.

			$parsed = json_decode($user,true);
			$query = "SELECT * FROM user WHERE username='".$user."' AND password='".$password."'";
			
			$result = mysqli_query($this->database->connection,$query);

			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$this->user_id = $row["uid"];
					$this->username = $row["username"];
				}
				
				$_SESSION['tribe_user'] = $this->user_id;

				return true;
			}else{
				return false;
			}
		}
	}
?>