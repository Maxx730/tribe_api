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
			$parsed = json_decode($user,true);
			$query = "SELECT * FROM user WHERE username='".$user."' AND password='".$password."'";
			
			$result = mysqli_query($this->database->connection,$query);

			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$this->user_id = $row["uid"];
					$this->username = $row["username"];

					echo "\nUser ID: ".$this->user_id."\n";
				}
				
				return true;
			}else{
				return false;
			}
		}
	}
?>