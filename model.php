<?php 
	session_start();

	$userLogin = array();
	if(!isset($_SESSION['userLogin'])){

	}else{
		$user_email = $_SESSION['userLogin'];
		require 'connectDB.php';
			$sql = "SELECT users.user_id,user_name,user_email,user_image,contact_detail,contact_name,user_detail,user_admin
	                FROM users
	                LEFT JOIN user_contact
	                ON users.user_id = user_contact.user_id
	                LEFT JOIN contacts
	                ON contacts.contact_id = user_contact.user_id
	                WHERE user_email = '$user_email'
	                LIMIT 1
	                ";
	        
	        $result = $mysqli->query($sql);
	            if ($result->num_rows > 0) {
	                while ($get_users = $result->fetch_assoc()) {
	                    array_push($userLogin,$get_users);
	                }
	            }else{
	                echo $sql;
	            }
	        $mysqli->close();

	        $userLogin = $userLogin['0'];

	        $user_id = $userLogin['user_id'];
	}
	
 ?>