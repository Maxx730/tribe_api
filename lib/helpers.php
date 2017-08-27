<?php

	class debug_helper{
		
		public function __construct(){
			
		}

		//Simply gives us a visual JS alert by output and manual script to the page
		//to make it easier to debug the PHP side.
		public function js_alert($val,$type){
			$output = "<script type = 'text/javascript'>";

			switch($type){
				case "console":
					$output .= "console.log('".$val."');";
				break;
				case "alert":
					$output .= "alert('".$val."');";
				break;
			}

			$output .= "</script>";

			echo $output;
		}
	}

?>