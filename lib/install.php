<?php
	//Class that will be used to install the tribe database
	//onto a given server.
	class tribe_install{
		var $url = "localhost";
		var $database = "tribe_db";
		var $usrname = "root";
		var $password = "dRmario43";
		var $connection = null;

		public function __construct(){
			//Initialize our connection to the database.
			$this->connection = mysqli_connect($this->url,$this->usrname,$this->password);

			if($this->connection){
				echo "SUCCESS: Connected to mysql.\n";
			}else{
				echo "ERROR: Could not connect to mysql.\nERROR:".mysqli_connect_error()."\n";
			}
		}

		//Function we will use when we would like to install 
		//the database fresh.
	 	public function install(){
	 		$query = "CREATE DATABASE tribe_db;";

	 		if(mysqli_query($this->connection,$query)){
	 			echo "SUCCESS: Created the Tribe Database.\n";
	 		}else{
	 			echo "ERROR: Problem creating database.\n";
	 		}

	 		//Select the database that was just created.
	 		if(mysqli_select_db($this->connection,$this->database)){
		 		$query = "CREATE TABLE IF NOT EXISTS user(uid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,username VARCHAR(255) NOT NULL,password VARCHAR(255) NOT NULL)";

		 		//Make sure there are no errors when installing the Tribe database.
		 		if(mysqli_query($this->connection,$query)){
		 			echo "SUCCESS: Users installed succesfully!\n";

		 			//Below we start do build out our other tables using a chain of checks to make sure everything was installed correctly
		 			$query = "CREATE TABLE IF NOT EXISTS tribe(tid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,title VARCHAR(255) NOT NULL,description VARCHAR(255) NOT NULL,creator INT NOT NULL)";

		 			if(mysqli_query($this->connection,$query)){
		 				echo "SUCCESS: Successfully installed tribe table.\n";

		 				$query = "CREATE TABLE IF NOT EXISTS tribe_user(tuid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,tid INT NOT NULL,uid INT NOT NULL)";

		 				if(mysqli_query($this->connection,$query)){
		 					echo "SUCCESS: Installed Tribe_User table successfully.\n";

		 					$this->create_mock_data();
		 				}else{
		 					echo "ERROR: Problem creating tribe user table.";
		 				}
		 			}else{
		 				echo "ERROR: Problem installing tribe table.\n";
		 			}
		 		}else{
		 			echo "ERROR: There was a problem installing the Tribe database.\n";
		 		}
	 		}else{
	 			echo "ERROR: Problem switching to created database.\n";
	 		}
	 	}

	 	//Function that will totally delete the tribe database from the server.
	 	public function delete(){

	 	}

	 	//Purges data from all the tables in the database.
	 	public function purge_data(){
	 		$this->purge_table("user");
	 		$this->purge_table("tribe");
	 		$this->purge_table("tribe_user");
	 	}

	 	//Data used for testing our database.
	 	public function create_mock_data(){
	 		$query = "INSERT INTO user(username,password) VALUES('maxx730','remote12')";

	 		if(mysqli_query($this->connection,$query)){
	 			echo "SUCCESS: Succesfully inserted mock users into database.\n";

	 			$query = "INSERT INTO tribe(title,description,creator) VALUES('My First Tribe','Example data for testing purposes.',0)";

	 			if(mysqli_query($this->connection,$query)){
	 				echo "SUCCESS: Successfully created Test Tribe.\n";

	 				$query = "INSERT INTO tribe_user() VALUES()";
	 			}else{
	 				echo "ERROR: Unable to create test Tribe.\n";
	 			}
	 		}else{	
	 			echo "ERROR: Problem inserting mock users into database.\n";
	 		}
	 	}

	 	//Drops all the records from a given table in the tribe database.
	 	public function purge_table($table){
	 		if(mysqli_select_db($this->connection,$this->database)){
		 		$query = "TRUNCATE TABLE ".$table;

		 		if(mysqli_query($this->connection,$query)){
		 			echo "SUCCESS: Succesfully purged all data from ".$table.".\n";
		 		}else{
		 			echo "ERROR: Problem purging data from database.\n";
		 		}
	 		}else{
	 			echo "ERROR: Could not select the Tribe database to purge data.\n";
	 		}
	 	}
	}
?>