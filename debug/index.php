<?php
	include("../lib/database_handler.php");
	//We are going to use this file for testing inputing and outputting data
	//while the app is in development mode so that we can test the functionality.

	if(isset($_GET['debug_tribes'])){
		$database = new database_handler();

		$query = "SELECT * FROM tribe";
		$result = mysqli_query($database->connection,$query);

		$output = "<h2>Tribes</h2><table id = ''>";
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$output .= "<tr><td>".$row["tribe_id"]."</td><td>".$row["tribe_title"]."</td><td>".$row["tribe_description"]."</td></tr>";
			}

			$output .= "</table>";

			echo $output;
		}else{
			echo "No records to display.";
		}
?>
	<!-- Output a table will all the tribes listed here as well as a form for
	adding more tribes to the database. -->
<?php
	}
?>