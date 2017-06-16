<?php 
	//detail
	$project_id = $_POST['project_id'];
	$project_name = $_POST['project_name'];
	$project_description = $_POST['project_description'];

	//$poster = $_POST['poster'];
	//prize
	$prize1 = $_POST['prize_1st'];
	$prize2 = $_POST['prize_2nd'];
	$prize3 = $_POST['prize_3rd'];
	// attribute
	
	$attr_job = $_POST['attr_1'];
	$attr_other = $_POST['attr_2'];
	$attr_age_min = $_POST['attr_3'];
	$attr_age_max = $_POST['attr_4'];
	//contact
	$website = $_POST['contact_1'];
	$tel = $_POST['contact_2'];
	//date
	$end_at = $_POST['end_at'];
	//category
	$category = $_POST['category'];


	$target_dir = "img/projects/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
	    echo "File is an image - " . $check["mime"] . ".";
	    $uploadOk = 1;
	} else {
	    echo "File is not an image.";
	    $uploadOk = 0;
	}
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 1;
	}
	if ($_FILES["fileToUpload"]["size"] > 50000000) {
	    echo "Sorry, your file is too large 5MB.";
	    $uploadOk = 0;
	}
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			
			require 'connectDB.php';
				
			// $sql = "INSERT INTO `projects`(`user_id`, `project_name`, `project_description`, `project_poster`, `category_id`, `end_at`, `prize_1st`, `prize_2nd`, `prize_3rd`) 
			// 		VALUES ($user_id,'$name','$description','".basename($_FILES["fileToUpload"]["name"])."','$category','$end_at','$prize1','$prize2','$prize3')";

			$sql = "UPDATE `projects` 
					SET `project_name`='$project_name',`project_description`='$project_description',`project_poster`='".basename( $_FILES["fileToUpload"]["name"])."',`category_id`='$category',`end_at`='$end_at',`prize_1st`=$prize1,`prize_2nd`=$prize2,`prize_3rd`=$prize3
					WHERE project_id = $project_id";

			if ($mysqli->query($sql) === TRUE) {
			    echo "Updated";
			    header('Location: myProject.php');

			 	// $sql = "UPDATE project_attribute
				//         SET ('$project_id','1','$attr_job'),
				//         	('$project_id','2','$attr_other'),
				//         	('$project_id','3','$attr_age_min'),
				//         	('$project_id','4','$attr_age_max')
				// 		WHERE project_id = $project_id

				//         ";

				// if ($mysqli->query($sql) === TRUE) {
				//     echo "Created Attribute";
				//     $sql = "UPDATE project_contact
				//     		SET	('$project_id','1','$website'),
				//     				('$project_id','2','$tel')
				// 			WHERE project_id = $project_id
				//     		";

				// 	if ($mysqli->query($sql) === TRUE) {
				// 	    echo "Created Contact";
				// 	    echo "Update Project Complete";
				// 	    header('refresh: 2; url=myProject.php');
					    
				// 	} else {
				// 	    echo "Error: " . $sql . "<br>" . $mysqli->error;
				// 	}

				// } else {
				//     echo "Error: " . $sql . "<br>" . $mysqli->error;
				// }
			}else{
			    echo $sql;
			}
			//$_SESSION['userLogin'] = $email;
			//header('Location: myProject.php');
			
			$mysqli->close();
		
		}else{
		    echo "Sorry, there was an error uploading your file.";
		}
	}
	
	
 ?>