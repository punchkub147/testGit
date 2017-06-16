<?php 
	require ('model.php');
	//print_r($userLogin);

	$user_id = $userLogin['user_id'];

	$project_id = $_POST['project_id'];
	$category_id = $_POST['category_id'];
	
	//$image = $_POST['image'];
	//category
	$concept = $_POST['concept'];

	// image------------------------------
	// image------------------------------
	$target_dir = "img/items/";
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
					
			$sql = "INSERT INTO `items`(`user_id`, `project_id`, `category_id`, `item_concept`, `item_image`) 
					VALUES ($user_id,$project_id,$category_id,'$concept','".basename($_FILES["fileToUpload"]["name"])."')";

			if ($mysqli->query($sql) === TRUE) {
				echo "Post Item Complete";
				header('Location: searchProject.php');
			    
			} else {
			    echo "Error: " . $sql . "<br>" . $mysqli->error;
			}
			$mysqli->close();


	    }else{
	        echo "Sorry, there was an error uploading your file.";
	    }
	}


	
	

 ?>