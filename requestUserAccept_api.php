<?php 
	$user_id = $_POST["user_id"];
	require 'connectDB.php';
				
	$sql = "UPDATE `users` 
			SET `user_admin`=2
			WHERE user_id = $user_id
			";



	if ($mysqli->query($sql) === TRUE) {
		
		header('Location: backOffice3.php');
	}else{
		echo $sql;
	}
	$mysqli->close();
 ?>