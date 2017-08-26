<?php
	
	//Class that handles the directories used for conducting different 
	//activities within the Tribe API.
	class api_handler{
		var $auth = null;
		var $data = null;
		var $db = null;

		//Construct will take in the data that is sent in as a 
		//JSON object.
		public function __construct($auth,$data,$db){
			$this->auth = $auth;
			$this->data = $data;
			$this->db = $db;

			mysqli_select_db('tribe_db');

			switch($data["object"]){
				case "tribes":
					$this->return_user_tribes($auth->user_id);
				break;
				case "tribe":
					$this->return_tribe_info($data['tribe']['id']);
				break;
				case "auth_token":
					$this->return_auth_token();
				break;
				case "log_session":

				break;
			}
		}

		//Checks the username and password and if the user exists in the database with
		//the correct password then we want to return the session id as and MD5 encrypted token.
		private function return_auth_token(){
			session_start();
			echo md5(session_id());
			session_close();
		}

		//Returns all the Tribes the user is a part of.
		private function return_user_tribes($id){
			$query = "SELECT tribe.title,tribe.description FROM tribe_user INNER JOIN tribe ON tribe_user.tid=tribe.tid WHERE tribe_user.uid=".$id."";
			$result = mysqli_query($this->db->connection,$query);
			$tribes = array();

			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					array_push($tribes,$row);
				}

				echo json_encode($tribes);
			}else{

			}
		}

		//Returns info about the tribe with the given id
		//including all the tribe's current members.
		private function return_tribe_info($tribe_id){
			$users = $this->return_tribe_users($tribe_id);
			$tribe = $this->return_tribe_data($tribe_id);

			$tribe['users'] = $users;

			echo json_encode($tribe);
		}

		//Returns all the users that are part of a given Tribe.
		private function return_tribe_users($tribe_id){
			$users = array();
			$query = "SELECT * FROM tribe_user INNER JOIN user ON tribe_user.uid=user.uid WHERE tribe_user.tid=".$tribe_id;

			$result = mysqli_query($this->db->connection,$query);

			if($result->num_rows > 0){
				 while($row = $result->fetch_assoc()){
				 	array_push($users,$row);
				 }

				 return $users;
			}else{
				echo "There are no users in this Tribe.\n";
			}
		}

		private function return_tribe_data($tribe_id){
			$query = "SELECT tribe.title,tribe.description FROM tribe WHERE tid=".$tribe_id;

			$result = mysqli_query($this->db->connection,$query);
			$data = array();

			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					array_push($data,$row);
				}

				return $data;
			}else{
				echo "ERROR: There is no tribe data for the given id.\n";
			}
		}

		//Returns the user info as well as all the tribes the user is a part of etc.
		private function return_user_info($uid){
			$query = "SELECT * FROM user WHERE uid=".$uid;

			$result = mysqli_query($this->db->connection,$query);

			if($result->num_rows > 0){
				
			}else{
				echo "ERROR: User with given ID does not exist.";
			}
		}
	}
?>