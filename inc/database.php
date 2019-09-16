<?php
	class Database{
		private $cn = "";
		function connect(){
			$cn = new mysqli("202.155.223.165", "uabacare", "Hj7cQzaA", "aba_abvt_dev");
			// $cn = new mysqli("localhost", "root", "", "aba_abvt_dev");

			if ($cn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			    exit();
			} 

			return $cn;
		}

		function closeDB(){
			
		}
	}
?>