<?php 

	$project_id = $_POST['project_id'];
	$item_id = $_POST['item_id'];

	if(isset($_POST["1st"])){
		$prize = "item_1st";
	}else if(isset($_POST["2nd"])){
		$prize = "item_2nd";
	}else if(isset($_POST["3rd"])){
		$prize = "item_3rd";
	}
	require 'connectDB.php';

	$sql = "SELECT item_1st,item_2nd,item_3rd
			FROM projects
			WHERE project_id = $project_id
			LIMIT 1
			";
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
	    while ($rows = $result->fetch_assoc()) {
	    	if($item_id == $rows['item_1st']){

	    		$sql2 = "UPDATE `projects` 
						SET item_1st = '".$rows["$prize"]."'
						WHERE project_id = $project_id
						";
						//echo $sql;
				if ($mysqli->query($sql2) === TRUE) {
				    echo "SWAP";
				}else{
				    //echo $sql;
				}

	    		$sql2 = "UPDATE `projects` 
						SET $prize ='$item_id'
						WHERE project_id = $project_id
						";
						//echo $sql;
				if ($mysqli->query($sql2) === TRUE) {
				    echo "SWAP";
				    header("Location: manageProject.php?project_id=$project_id");
				}else{
				    //echo $sql;
				}
	    	}else if($item_id == $rows['item_2nd']){

	    		$sql2 = "UPDATE `projects` 
						SET item_2nd = '".$rows["$prize"]."'
						WHERE project_id = $project_id
						";
						//echo $sql;
				if ($mysqli->query($sql2) === TRUE) {
				    echo "SWAP";
				}else{
				    //echo $sql;
				}

	    		$sql2 = "UPDATE `projects` 
						SET $prize ='$item_id'
						WHERE project_id = $project_id
						";
						//echo $sql;
				if ($mysqli->query($sql2) === TRUE) {
				    echo "SWAP";
				    header("Location: manageProject.php?project_id=$project_id");
				}else{
				    //echo $sql;
				}
	    	}else if($item_id == $rows['item_3rd']){

	    		$sql2 = "UPDATE `projects` 
						SET item_3rd = '".$rows["$prize"]."'
						WHERE project_id = $project_id
						";
						//echo $sql;
				if ($mysqli->query($sql2) === TRUE) {
				    echo "SWAP";
				}else{
				    //echo $sql;
				}

	    		$sql2 = "UPDATE `projects` 
						SET $prize ='$item_id'
						WHERE project_id = $project_id
						";
						//echo $sql;
				if ($mysqli->query($sql2) === TRUE) {
				    echo "SWAP";
				    header("Location: manageProject.php?project_id=$project_id");
				}else{
				    //echo $sql;
				}
	    	}else{
	    		$sql3 = "UPDATE `projects` 
						SET $prize ='$item_id'
						WHERE project_id = $project_id
						";
						//echo $sql;
				if ($mysqli->query($sql3) === TRUE) {
				    echo "Updated";
				    header("Location: manageProject.php?project_id=$project_id");

				}else{
				    echo $sql3;
				}
			}
	    }
	}else{
		
	}

	

	$mysqli->close();
 ?>