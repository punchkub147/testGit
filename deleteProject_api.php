<?php 
	$project_id = $_POST["project_id"];
	echo "project_id : ",$project_id;

	require 'connectDB.php';
				
	$sql = "DELETE FROM `projects` 
			WHERE project_id = $project_id
			";

	if ($mysqli->query($sql) === TRUE) {
		
		//header('Location: backOffice.php');
		echo "deleted";
	}else{

	}

	$mysqli->close();

 ?>