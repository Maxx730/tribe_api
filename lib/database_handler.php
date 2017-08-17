<?php
//Class that will handle connecting to the database
//as well as passing info between the client and the server.
class database_handler{

	//Database variables for connecting to localhost live here.
	var $url = "localhost";
	var $database = "tribe_db";
	var $usrname = "root";
	var $password = "dRmario43";
	var $connection = null;

	//Database class constructor.
	function __construct(){
		//echo "\nInitializing database...";
		//Connect to our database.
		$this->connection = mysqli_connect($this->url,$this->usrname,$this->password,$this->database);

		//Check if the connection to the database worked.
		if(!mysqli_connect_errno()){
			//echo "\nSUCCESS: Database connection initialized.";
		}else{
			echo "\nERROR: There was a problem connecting to the database.".mysqli_connect_error();
		}
	}
}

?>