<?php 
	session_start();

	$email = $_GET['email'];

	$imagePath = 'img/user/';
	$userImage = $imagePath.'user.jpg';

	$password = $_GET['password'];
	$password2 = $_GET['password2'];

	$url = $_POST['url'];

	if($password != $password2){
		echo "รหัสผ่านไม่ตรงกัน";
	}else{
		require 'connectDB.php';
		$sql = "SELECT user_email
		        FROM users
		        WHERE user_email = '$email';
		        ";
		
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0) {
		    while ($rows = $result->fetch_assoc()) {
		        echo "มีอีเมลล์นี้อยู่ในระบบแล้ว";
		        header('refresh: 3; Location: index.php');
		    }
		}else{
		    $sql = "INSERT INTO users(user_name,user_password,user_email,user_image)
	           		VALUES ('$email','$password','$email','$userImage')
	            	";
	            if ($mysqli->query($sql) === TRUE) {
	                //echo "Registered";
	                $_SESSION['userLogin'] = $email;
	                $_SESSION['flash'] = array("Registered","Email : $email");
	                
	                header('Location: '.$url);
	            } else {
	                echo "Error: " . $sql . "<br>" . $mysqli->error;
	            }
		}

		
        $mysqli->close();
	}
	
 ?>