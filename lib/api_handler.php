<?php
	
	//Class that handles the directories used for conducting different 
	//activities within the Tribe API.
	class api_handler{
		//Variable that will be the class that will handle
		//interactions with the database.
		var $database = null;
		//Different variables that will be used to determine
		//what the user is trying to do with the API.
		var $method = null;
		var $object = null;
		var $auth = null;

		//Initialize our api class.
		//Takes in the request which is going to be the url.
		function __construct($request,$data,$auth,$db){
			$this->database = $db;
			$this->auth = $auth;
			$parsed = json_decode($data,true);

	        //
	        echo "\nInitializing api handler to process request.";
	        //$this->database = new database_handler();
	       	echo "\nFinding out what the request is...";

	        //Figure out what the user is trying to request.
	        switch($request){
	        	case "get":
	        		$query = $this->get_parse($parsed);
	        		$result = mysqli_query($this->database->connection,$query);

	        		switch($parsed['obj']){
	        			case "tribe":
	        				//There will be annother variable set in the JSON 
	        				//that will determine if we are looking for a specific
	        				//tribe or not.
	        				if(array_key_exists('id', $parsed)){
	        					$this->find_tribe($parsed['id']);
	        				}else{
		        				$output = "\n\n".$this->auth->username."'s Tribes";
				        		if($result->num_rows > 0){
				        			while($row = $result->fetch_assoc()){
				        				$output .= "\n(".$row['tribe_id'].") : ".$row['tribe_title'];
				        			}
				        		}

				        		echo $output;
	        				}
	        			break;
	        			case "user":
	        			//Find all the users that are in the tribes that you are
	        			//in.


	        			break;
	        			//Returns the information for a tribe with the given id.
	        			case "tribe_info":
	        				//This assumes that this command will also accompany 
	        				//an object with an id.
	        				$id=$parsed['tribe_id'];
	        			break;
	        		}
	        	break;
	        	case "create":
					if($this->check_user_tribe($parsed['data']['title'])){
	        			$query = "INSERT INTO ".$this->creation_parse($parsed);
	        			
	        			$result = mysqli_query($this->database->connection,$query);
	        			//We then want to insert the new user and say they are the creator.
						if(!mysqli_error()){
							echo "\nInserting new data into connecting table.";
							$query = "INSERT INTO tribe_user(tid,uid,creator) VALUES(".mysqli_insert_id($this->database->connection).",".$this->auth->user_id.",1)";
							echo "\n".$query;
							mysqli_query($this->database->connection,$query);

							if(mysqli_error()){
								echo "\nERROR: New tribe user was not found.";
							}
						}else{
							echo "\nERROR: Tribe was not created...";
						}
	        		}
	        	break;
	        }
		}

		//Translates and object to a table name for security reasons.
		private function creation_parse($obj){
			switch($obj['obj']){
				case "tribe":
					return "tribe(tribe_title,tribe_description) VALUES('".$obj['data']['title']."','".$obj['data']['description']."')";
				break;
				case "user":
					return "tribe_user(username,password,firstname,lastname,email) VALUES('".$obj['data']['username']."','".$obj['data']['password']."','".$obj['data']['firstname']."','".$obj['data']['lastname']."','".$obj['data']['email']."')";
				break;
			}
		}

		//Parse used to build the mysql query for getting information out of the database.
		private function get_parse($obj){
			switch($obj['obj']){
				case "tribe":
					//Returns all the logged in users tribes to 
					return "SELECT * FROM tribe_user LEFT JOIN tribe ON tribe_user.tid=tribe.tribe_id WHERE tribe_user.uid=".$this->auth->user_id;
				break;
				case "user":
					return "SELECT * FROM user";
				break;
			}
		}

		//Searches the database to see if the user that is creating a new tribe
		//already is part of a tribe with the same name.
		private function check_user_tribe($title){
			$query = "SELECT * FROM tribe_user LEFT JOIN tribe ON tribe_user.tid=tribe.tribe_id WHERE tribe.tribe_title='".$title."'";

			$result = mysqli_query($this->database->connection,$query);

			if($result->num_rows > 0){
				echo "\nERROR:Tribe with the same name already exists.";
				return false;
			}else{
				echo "\nCheck passed, creating tribe...";
				return true;
			}
		}

		//Finds the tribe information IF the user is actually part of the tribe, 
		//otherwise returns and error saying the user is not part of the tribe.
		private function find_tribe($id){
			$query = "SELECT * FROM tribe_user LEFT JOIN tribe ON tribe_user.tid=tribe.tribe_id WHERE tribe_user.uid=".$this->auth->user_id." AND tribe_user.tid=".$id;
			$result = mysqli_query($this->database->connection,$query);

			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					echo "\n\n".$row["tribe_title"];
				}
			}else{
				echo "\nERROR: User is not part of this tribe.";
			}
		}

		//Function that will grab all the users that the current user
		//is in a tribe with.
		private function find_users($id){
			$query = "SELECT * FROM tribe_users LEFT JOIN users ON tribe_users.uid=".$id." WHERE ";
		}
	}
?>