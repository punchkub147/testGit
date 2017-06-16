<?php 

	if(!isset($_GET['search'])){
		$search = "";
	}else{
		$search = $_GET['search'];
	}

	if(!isset($_GET['filter'])){
		$filter = "99";
	}else{
		$filter = $_GET['filter'];
	}

	if(!isset($_GET['category'])){
		$category = "";
	}else{
		$category = $_GET['category'];
	}

	$title = 'Search Member';
	include('layouts/header.php');
 ?>

<div class="container">
		<div class="search w-12">
			<form action="searchDesigner.php?search=$search" method="">
				<input type="text" class="input" name="search" placeholder="ค้นหาชื่อนักออกแบบ">
				<input type="submit" value="ค้นหา" class="btn btn-search">
			</form>
		</div>
		
		<div class="box-20 cb"></div>



	<div class="row cb">
		<?php 
		require 'connectDB.php';
			//$user_id = $userLogin['user_id'];
			$search = " users.user_name LIKE '%$search%'
						";
			$category = " users.category_id LIKE '%$category%'
						";

			if($filter == 10){
				$filter = "	WHERE users.category_id = '$category'";
			}else if($filter == 1){
				$filter = "	LEFT JOIN user_category
			    			ON users.category_id = user_category.category_id
							WHERE user_category.user_id = '$user_id'
			    			AND $search AND $category
			    			";
			}else if($filter == 2){
				$filter = 	"	WHERE $search AND $category
								ORDER BY end_at ASC
							";
			}else if($filter == 3){
				$filter = 	"	WHERE $search AND $category
								ORDER BY prize DESC
							";
			}else if($filter == 4){
				$filter = "	LEFT JOIN items
			    			ON users.project_id = items.project_id
							WHERE user_category.user_id = '$user_id'
							AND $search AND $category
							";
			}else if($filter == 5){
				$filter = "	WHERE $search AND $category
							ORDER BY end_at ASC		
							";	
			}else{
				$filter = " WHERE $search
							";
			}

			
			$sql = "SELECT users.user_id,user_name,user_image
			        FROM users
			        ".$filter."
			        ORDER BY user_id ASC

			        ";

			//echo $sql;
			
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
			    while ($rows = $result->fetch_assoc()) {
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
									$sql2 = "SELECT item_id,prize_1st,prize_2nd,prize_3rd,item_1st,item_2nd,item_3rd
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
										<?php echo "<h5>฿ ".number_format($maxPrize, 0, '.', ',')."</h5>"; ?>
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
				<h3 class=\"cb\">ไม่พบผู้ต้องหา</h3>";
			}
			$mysqli->close();
		?>
	</div>
		

	<div class="cb"></div>
</div>


 <?php 
	include('layouts/footer.php');
 ?>
