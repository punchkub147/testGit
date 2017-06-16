<?php 
	$item_id = $_POST["item_id"];
	echo $item_id;

	require 'connectDB.php';
				
	$sql = "DELETE FROM `items` 
			WHERE item_id = $item_id
			";

	if ($mysqli->query($sql) === TRUE) {
		header('Location: backOffice2.php');
	}else{

	}

 ?>