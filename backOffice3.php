<?php 
	$title = 'Admin Item';
	include('layouts/adminHeader.php');

	$user_id1 = null;
	$user_id2 = null;
	$user_id3 = null;
	$user_id4 = null;
 ?>

<div class="container">


	
	<div class="row cb">

		<?php 
		require 'connectDB.php';
			//$user_id = $userLogin['user_id'];
		
			$sql = "SELECT users.user_id,user_name,user_image
			        FROM users
			        WHERE user_admin = 9
			        ORDER BY user_id DESC

			        ";

			//echo $sql;
			
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
				
				?><h5>ผู้ขอสิทธิสร้างโครงการ</h5><br><?php
				
			    while ($rows = $result->fetch_assoc()) {
			    	$user_id1 = $rows['user_id'];
			    	?>
			    	<a href="profile.php?user_id_info=<?php echo $rows['user_id']; ?>">
						<div class="w-3 pull">
							<div class="user-card w-12">
								
								
								<div class="user-detail">
									<div class="img">
										<img src="<?php echo $rows['user_image']; ?>" alt="">
									</div>
									<div class="user-name">
										<p><?php echo $rows['user_name']; ?></p>
									</div>
									
								
								<?php
									$sql2 = "SELECT item_id,prize_1st,prize_2nd,prize_3rd,item_1st,item_2nd,item_3rd,users.user_id
									        FROM items
									        LEFT JOIN users
									        ON users.user_id = items.user_id
									        LEFT JOIN projects
									        ON projects.project_id = items.project_id
									        LEFT JOIN categories
									        ON categories.category_id = items.category_id
									        WHERE (items.item_id = projects.item_1st OR items.item_id = projects.item_2nd OR items.item_id = projects.item_3rd)
									        AND users.user_id = ".$rows['user_id']."
									        ORDER BY item_id DESC
									        ";

									//echo $sql;
									$maxPrize = 0;
									$countWin = 0;
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    	

									    	if($rows2['item_id']==$rows2['item_1st'])$maxPrize +=$rows2['prize_1st'];
											else if($rows2['item_id']==$rows2['item_2nd'])$maxPrize +=$rows2['prize_2nd'];
											else if($rows2['item_id']==$rows2['item_3rd'])$maxPrize +=$rows2['prize_3rd'];
											else echo "--";
											$countWin++;
									    }

									}else{

									}
									
									?>
										<div class="user-win">
											<p><?php echo $countWin; ?> win</p>
										</div>
									</div>
									<div class="line"></div>
									<div class="user-prize">
										<form action="requestUserAccept_api.php" method="post">
											<input type="hidden" name="user_id" value="<?php echo $user_id1; ?>">

											<input type="submit" value="ให้สิทธื" class="btn">
										</form>
									</div>
									<?php
									?>

									<!-- <h5> ฿ 30,000 </h5> -->
								
							</div>
						</div>
					</a>
					<?php
			    }
			}else{
				//echo $sql;

				echo "
				<h3 class=\"cb\"></h3>";
			}
			$mysqli->close();
		?>
	</div>
		

	<div class="cb"></div>





		<div class="row cb">

		<?php 
		require 'connectDB.php';
			//$user_id = $userLogin['user_id'];
		
			$sql = "SELECT users.user_id,user_name,user_image
			        FROM users
			        WHERE user_admin = 0
			        ORDER BY user_id DESC

			        ";

			//echo $sql;
			
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
				
				?><h5>สมาชิกทั่วไป</h5><br><?php
				
			    while ($rows = $result->fetch_assoc()) {
			    	$user_id2 = $rows['user_id'];
			    	?>
			    	<a href="profile.php?user_id_info=<?php echo $rows['user_id']; ?>">
						<div class="w-3 pull">
							<div class="user-card w-12">
								
								
								<div class="user-detail">
									<div class="img">
										<img src="<?php echo $rows['user_image']; ?>" alt="">
									</div>
									<div class="user-name">
										<p><?php echo $rows['user_name']; ?></p>
									</div>
									
								
								<?php
									$sql2 = "SELECT item_id,prize_1st,prize_2nd,prize_3rd,item_1st,item_2nd,item_3rd,users.user_id
									        FROM items
									        LEFT JOIN users
									        ON users.user_id = items.user_id
									        LEFT JOIN projects
									        ON projects.project_id = items.project_id
									        LEFT JOIN categories
									        ON categories.category_id = items.category_id
									        WHERE (items.item_id = projects.item_1st OR items.item_id = projects.item_2nd OR items.item_id = projects.item_3rd)
									        AND users.user_id = ".$rows['user_id']."
									        ORDER BY item_id DESC
									        ";

									//echo $sql;
									$maxPrize = 0;
									$countWin = 0;
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    	
									    	if($rows2['item_id']==$rows2['item_1st'])$maxPrize +=$rows2['prize_1st'];
											else if($rows2['item_id']==$rows2['item_2nd'])$maxPrize +=$rows2['prize_2nd'];
											else if($rows2['item_id']==$rows2['item_3rd'])$maxPrize +=$rows2['prize_3rd'];
											else echo "--";
											$countWin++;
									    }

									}else{

									}
									
									?>
										<div class="user-win">
											<p><?php echo $countWin; ?> win</p>
										</div>
									</div>
									<div class="line"></div>
									<div class="user-prize">
										<form action="requestUserAccept_api.php" method="post">
											<input type="hidden" name="user_id" value="<?php echo $user_id2; ?>">
											<input type="submit" value="ให้สิทธิ" class="btn">
										</form>
									</div>
									<?php
									?>

									<!-- <h5> ฿ 30,000 </h5> -->
								
							</div>
						</div>
					</a>
					<?php
			    }
			}else{
				//echo $sql;

				echo "
				<h3 class=\"cb\"></h3>";
			}
			$mysqli->close();
		?>
	</div>
		

	<div class="cb"></div>






		<div class="row cb">

		<?php 
		require 'connectDB.php';
			//$user_id = $userLogin['user_id'];
		
			$sql = "SELECT users.user_id,user_name,user_image
			        FROM users
			        WHERE user_admin = 2
			        ORDER BY user_id DESC

			        ";

			//echo $sql;
			
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
				
				?><h5>ผู้มีสิทธิสร้างโครงการ</h5><br><?php
				
			    while ($rows = $result->fetch_assoc()) {
			    	$user_id3 = $rows['user_id'];
			    	?>
			    	<a href="profile.php?user_id_info=<?php echo $rows['user_id']; ?>">
						<div class="w-3 pull">
							<div class="user-card w-12">
								
								
								<div class="user-detail">
									<div class="img">
										<img src="<?php echo $rows['user_image']; ?>" alt="">
									</div>
									<div class="user-name">
										<p><?php echo $rows['user_name']; ?></p>
									</div>
									
								
								<?php
									$sql2 = "SELECT item_id,prize_1st,prize_2nd,prize_3rd,item_1st,item_2nd,item_3rd,users.user_id
									        FROM items
									        LEFT JOIN users
									        ON users.user_id = items.user_id
									        LEFT JOIN projects
									        ON projects.project_id = items.project_id
									        LEFT JOIN categories
									        ON categories.category_id = items.category_id
									        WHERE (items.item_id = projects.item_1st OR items.item_id = projects.item_2nd OR items.item_id = projects.item_3rd)
									        AND users.user_id = ".$rows['user_id']."
									        ORDER BY item_id DESC
									        ";

									//echo $sql;
									$maxPrize = 0;
									$countWin = 0;
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    	
									    	if($rows2['item_id']==$rows2['item_1st'])$maxPrize +=$rows2['prize_1st'];
											else if($rows2['item_id']==$rows2['item_2nd'])$maxPrize +=$rows2['prize_2nd'];
											else if($rows2['item_id']==$rows2['item_3rd'])$maxPrize +=$rows2['prize_3rd'];
											else echo "--";
											$countWin++;
									    }

									}else{

									}
									
									?>
										<div class="user-win">
											<p><?php echo $countWin; ?> win</p>
										</div>
									</div>
									<div class="line"></div>
									<div class="user-prize">
										<form action="requestUserDecept_api.php" method="post">
											<input type="hidden" name="user_id" value="<?php echo $user_id3; ?>">
											<input type="submit" value="ยกเลิกสิทธิ" class="btn" style="background: red;">
										</form>
									</div>
									<?php
									?>

									<!-- <h5> ฿ 30,000 </h5> -->
								
							</div>
						</div>
					</a>
					<?php
			    }
			}else{
				//echo $sql;

				echo "
				<h3 class=\"cb\"></h3>";
			}
			$mysqli->close();
		?>
	</div>
		

	<div class="cb"></div>














		<div class="row cb">

		<?php 
		require 'connectDB.php';
			//$user_id = $userLogin['user_id'];
		
			$sql = "SELECT users.user_id,user_name,user_image
			        FROM users
			        WHERE user_admin = 1
			        ORDER BY user_id DESC

			        ";

			//echo $sql;
			
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
				
				?><h5>Admin</h5><br><?php
				
			    while ($rows = $result->fetch_assoc()) {
			    	$user_id4 = $rows['user_id'];
			    	?>
			    	<a href="profile.php?user_id_info=<?php echo $rows['user_id']; ?>">
						<div class="w-3 pull">
							<div class="user-card w-12">
								
								
								<div class="user-detail">
									<div class="img">
										<img src="<?php echo $rows['user_image']; ?>" alt="">
									</div>
									<div class="user-name">
										<p><?php echo $rows['user_name']; ?></p>
									</div>
									
								
								<?php
									$sql2 = "SELECT item_id,prize_1st,prize_2nd,prize_3rd,item_1st,item_2nd,item_3rd,users.user_id
									        FROM items
									        LEFT JOIN users
									        ON users.user_id = items.user_id
									        LEFT JOIN projects
									        ON projects.project_id = items.project_id
									        LEFT JOIN categories
									        ON categories.category_id = items.category_id
									        WHERE (items.item_id = projects.item_1st OR items.item_id = projects.item_2nd OR items.item_id = projects.item_3rd)
									        AND users.user_id = ".$rows['user_id']."
									        ORDER BY item_id DESC
									        ";

									//echo $sql;
									$maxPrize = 0;
									$countWin = 0;
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    	
									    	if($rows2['item_id']==$rows2['item_1st'])$maxPrize +=$rows2['prize_1st'];
											else if($rows2['item_id']==$rows2['item_2nd'])$maxPrize +=$rows2['prize_2nd'];
											else if($rows2['item_id']==$rows2['item_3rd'])$maxPrize +=$rows2['prize_3rd'];
											else echo "--";
											$countWin++;
									    }

									}else{

									}
									
									?>
										<div class="user-win">
											<p><?php echo $countWin; ?> win</p>
										</div>
									</div>
									<div class="line"></div>
									<div class="user-prize">
										
									</div>
									<?php
									?>

									<!-- <h5> ฿ 30,000 </h5> -->
								
							</div>
						</div>
					</a>
					<?php
			    }
			}else{
				//echo $sql;

				echo "
				<h3 class=\"cb\"></h3>";
			}
			$mysqli->close();
		?>
	</div>
		

	<div class="cb"></div>


</div>

<?php 
	include('layouts/adminFooter.php');
 ?>
