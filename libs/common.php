<?php 

function getDB()
{
	$mysqli = new mysqli('localhost','root','','mrts');
	if ($mysqli ->connect_errno){
		echo "Failed to connect to MySQL:(" .$mysqli ->connect_errno .")".$mysqli->connect_error;
	}
	return $mysqli;
}



?>