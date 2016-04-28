<?php
	class DBConnection{
	public function connect(){
			$conn = $this->createDBConnection();
			RETURN $conn;
		}

	public function createDBConnection(){
			$servername = "localhost";
	 		$username = "root";
			$password = "521buaa";
			$dbname = "exercise";
			$mysqli = new mysqli($servername, $username, $password, $dbname);
         	return $mysqli;
 	}	
 }
?>
