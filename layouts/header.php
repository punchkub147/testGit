<?php
	require('model.php');
	// =========== facebook ===========
	include_once('fb-config.php');
	include_once('fb-login.php');
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>

	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/sweetalert-master/dist/sweetalert.css">
	
	<link rel="stylesheet" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	
	<script src="vendor/jquery/jquery.min.js"></script>

	<script src="vendor/sweetalert-master/dist/sweetalert-dev.js"></script>

</head>
<body>
	<header>
		<a href="index.php"><div class="logo w-1 m0">Craft Prize</div></a>
		<nav>
			<ul>
				<a href="searchProject.php"><li class="fl" <?php if($title == "Search Project")echo "id=\"activeHead\"";?>>ค้นหาโครงการ</li></a>
				
				<a href="winnerProject.php"><li class="fl" <?php if($title == "Winner Project")echo "id=\"activeHead\"";?>>ผลงานชนะเลิศ</li></a>
				<a href="searchDesigner.php"><li class="fl" <?php if($title == "Search Member")echo "id=\"activeHead\"";?>>ค้นหานักออกแบบ</li></a>

				<a href="createProject.php"><li class="fl" <?php if($title == "Create Project")echo "id=\"activeHead\"";?>>ประกาศโครงการ</li></a>
			</ul>
		</nav>
		<?php
		if(isset($_SESSION['userLogin'])){
				?>
					<a href="###" id="modal-btn-login"><div class="logined w-2 m0">
					<img src="<?= $userLogin['user_image'] ?>">
					<?= $userLogin['user_name'] ?>
					</div></a>
				<?php 
		}else{
			echo "<a href=\"###\" id=\"modal-btn-login\"><div class=\"login w-2 m0\">Login & Register</div></a>";
		}
		?>
	</header>
	<div class="b-header"></div>

	<div id="modal-login" class="modal-login">

	  <!-- Modal content -->

	  <div class="modal-content w-2">
	    <span class="close"></span>
	    
		
		<?php

	    if(isset($_SESSION['userLogin'])){
			//echo "<img src=\"$userImage\" alt=\"\">";
			echo '<a href="profile.php"><button class="btn w-12">Edit Profile</button></a>';
			echo '<a href="myProject.php"><button class="btn w-12">My Project</button></a>';

			?>
				<div class="line cb"></div>
				<br>
			<?php
			if($userLogin['user_admin'] == 1){
	        	echo '<a href="backOffice.php"><button style="background: red;" class="btn w-12">Back Office</button></a>';
	        }

	        echo "<a href=\"logout_api.php?url=".basename($_SERVER["SCRIPT_FILENAME"])."\"><button class=\"btn w-12\">Logout</button></a>";

	        

    	}else{
    		echo '<a href="'.$fbloginUrl.'"><button class="btn w-12" id="facebook">Facebook Login</button></a>';
    		?>
    			<div class="line m10 cb"></div>
    			<h4>Login</h4>
				<form action="login_api.php" method="post">
			    	<input class="input" type="text" placeholder="Email" name="email" required>
			    	<input class="input" type="password" placeholder="Password" name="password" required>
			    	<input type="hidden" name="url" value="<?php echo basename($_SERVER["SCRIPT_FILENAME"]); ?>">
			    	<input class="btn w-12" type="submit" value="Login">
			    </form>
			    <div class="line m10 cb"></div>

				<h4>Register</h4>
			    <form action="register_api.php" method="">
			    	<input class="input" type="text" placeholder="Email" name="email" required>
			    	<input class="input" type="password" placeholder="Password" name="password" required>
			    	<input class="input" type="password" placeholder="Comfirm Password" name="password2" required>
			    	<input type="hidden" name="url" value="<?php echo basename($_SERVER["SCRIPT_FILENAME"]); ?>">
			    	<input class="btn w-12" type="submit" value="Register">
			    </form>
    		<?php 
    	}
    	?>

	    <!-- <a href="'.$fbloginUrl.'"><button class="btn w-12">Facebook Login</button></a> -->
	    <!-- <a href="###"><button class="btn w-12">Google Login</button></a> -->
	    
	    
	  </div>

	</div>

<script>
	var modal = document.getElementById('modal-login');

	// Get the button that opens the modal
	var btn = document.getElementById("modal-btn-login");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	btn.onclick = function() {
	    modal.style.display = "block";
	    modal.style.opacity = "1";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	    modal.style.display = "none";
	    modal.style.opacity = "0";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == modal) {
	        modal.style.display = "none";
	        modal.style.opacity = "0";
	    }
	} 
</script>