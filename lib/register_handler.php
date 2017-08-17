<?php
	class register_handler{

		var $database = null;

		function __construct($db){
			$this->database = $db;
		}

		//Checks if all the correct information had been sent into the form
		//as well as checks the email against current users to make sure
		//there are not duplicate records.
		public function register(){
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_repeat']) && isset($_POST['email'])){
				//Checks if the email exists in the database as well if the password was repeated correctly.
				if($this->check_email($_POST['email']) && $_POST['password'] == $_POST['password_repeat']){
					$query = "INSERT INTO tribe__user(username,password,email) VALUES('".$_POST['username']."','".$_POST['password']."','".$_POST['email']."')";

					mysqli_query($this->database->connection,$query);
				}
			}
		}

		//Checks if there are any users that already have the desired email.
		private function check_email($email){
			$query = "SELECT * FROM tribe__user WHERE email='".$email."'";
			$result = mysqli_query($this->database->connection,$query);

			if($result->num_rows > 0){
				echo "ERROR: Email is already being used by another user.";
				return false;
			}else{
				return true;
			}
		}

		//Checks if the username exists in the databse.
		private function check_username(){
			
		}
	}
?>