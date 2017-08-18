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
					$this->return_tribe_users($data['tribe']['id']);
				break;
			}
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
		}

		//Returns all the users that are part of a given Tribe.
		private function return_tribe_users($tribe_id){
			$query = "";
		}

		private function return_tribe_data($tribe_id){

		}
	}
?>