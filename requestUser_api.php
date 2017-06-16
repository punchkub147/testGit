<?php 
	$user_id = $_POST["user_id"];

	require 'connectDB.php';
				
	$sql = "UPDATE `users` 
			SET `user_admin`=9
			WHERE user_id = $user_id
			";

	if ($mysqli->query($sql) === TRUE) {
		
		
		
		header('Location: createProject.php');
	}else{

	}
	$mysqli->close();
 ?>