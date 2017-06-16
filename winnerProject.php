<?php 
	$title = 'Winner Project';
	include('layouts/header.php');

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
 ?>

<div class="container">
		<div class="search w-12">
			<form action="" method="">
				<input type="text" class="input" placeholder="ค้นหาชื่อโครงการ">
				<input type="submit" value="ค้นหา" class="btn btn-search">
			</form>
		</div>
		<div class="filter w-6">
			<nav>
				<ul>
					<a href="winnerProject.php?filter=<?php echo $filter; ?>&category=" <?php if($category == "")echo "id=\"active\""; ?>class="fl"><li>All</li></a>
					<a href="winnerProject.php?filter=<?php echo $filter; ?>&category=1" <?php if($category == 1)echo "id=\"active\""; ?>class="fl"><li>Logo</li></a>
					<a href="winnerProject.php?filter=<?php echo $filter; ?>&category=2" <?php if($category == 2)echo "id=\"active\""; ?>class="fl"><li>Model</li></a>
					<a href="winnerProject.php?filter=<?php echo $filter; ?>&category=3" <?php if($category == 3)echo "id=\"active\""; ?>class="fl"><li>Mascot</li></a>
				</ul>
			</nav>
		</div>

		<div class="filter w-6">
			<nav>
				<ul>
					<!-- <a href="searchProject.php?filter=10" <?php if($filter == 0)echo "id=\"active\""; ?>><li>หมวดหมู่</li></a> -->
					<!-- <a href="searchProject.php?filter=1" <?php if($filter == 1)echo "id=\"active\""; ?>><li>สำหรับคุณ</li></a> -->
					<!-- <a href="winnerProject.php?filter=2&category=<?php echo $category; ?>" <?php if($filter == 2)echo "id=\"active\""; ?>class="fr"><li>เงินรางวัลสูงสุด</li></a> -->
					<a href="winnerProject.php?filter=3&category=<?php echo $category; ?>" <?php if($filter == 3)echo "id=\"active\""; ?>class="fr"><li>ผลงานล่าสุด</li></a>
					<!-- <a href="searchProject.php?filter=4" <?php if($filter == 4)echo "id=\"active\""; ?>><li>ยอดนิยม</li></a> -->
					<!-- <a href="searchProject.php?filter=5" <?php if($filter == 5)echo "id=\"active\""; ?>><li>สิ้นสุด</li></a> -->
				</ul>
			</nav>
			
		</div>

	<div class="row cb">
		<?php 
			require 'connectDB.php';
			$sql = "SELECT item_id,projects.project_name,user_name,category_name,item_concept,item_image,user_image,users.user_id,item_concept,prize_1st,prize_2nd,prize_3rd,item_1st,item_2nd,item_3rd
			        FROM items
			        LEFT JOIN projects
			        ON projects.project_id = items.project_id
			        LEFT JOIN users
			        ON users.user_id = items.user_id
			        LEFT JOIN categories
			        ON categories.category_id = items.category_id
			        WHERE items.category_id LIKE '%".$category."%'
			        AND (items.item_id = projects.item_1st OR items.item_id = projects.item_2nd OR items.item_id = projects.item_3rd)
			        ORDER BY item_id DESC
			        ";
			//echo $sql;
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
			    while ($rows = $result->fetch_assoc()) {
			    	$path = "img/items/";
			    	$image = $path.$rows['item_image'];
			    	//if($rows['item_id']==$rows['item_1st'] || $rows['item_id']==$rows['item_2nd'] || $rows['item_id']==$rows['item_3rd']){
			    ?>
						<a href="#id<?php echo $rows['item_id']; ?>" data-toggle="modal" data-target="#id<?php echo $rows['item_id']; ?>">
							<div class="w-3 pull">
								<div class="item-card w-12">
									<div class="img">
										<img src="<?php echo $image; ?>" alt="">
									</div>
									
									<div class="item-description">
										<div class="item-project">
											<p><?php echo $rows['project_name'] ?></p>
										</div>
										<div class="item-designer">
											<a href="profile.php?user_id_info=<?php echo $rows['user_id'] ?>">by <?php echo $rows['user_name'] ?></a>
										</div>
									</div>

									<?php 
										if($rows['item_id']==$rows['item_1st'])echo "<div class=\"line gold\"></div>";
										else if($rows['item_id']==$rows['item_2nd'])echo "<div class=\"line silver\"></div>";
										else if($rows['item_id']==$rows['item_3rd'])echo "<div class=\"line bronz\"></div>";
										else echo "<div class=\"line fail\"></div>";
									?>
									<div class="line"></div>
									<div class="item-prize">
										<h5>
										<?php 
											if($rows['item_id']==$rows['item_1st'])echo "฿ ".number_format($rows['prize_1st'], 0, '.', ',');
											else if($rows['item_id']==$rows['item_2nd'])echo "฿ ".number_format($rows['prize_2nd'], 0, '.', ',');
											else if($rows['item_id']==$rows['item_3rd'])echo "฿ ".number_format($rows['prize_3rd'], 0, '.', ',');
											else echo "--";
										 ?>
										</h5>
									</div>
								</div>
							</div>
						</a>
						
						<div id="id<?php echo $rows['item_id']; ?>" role="dialog" class="modal item-modal fade">
						    <div class="container">

						    	
						    	<div class="w-12 detail">
						    		<div class="modal-header">
								  	 	<button type="button" class="close" data-dismiss="modal">&times;</button>	
										<h4 class="modal-title"><?php echo $rows['project_name']; ?>
											<?php 
												if($rows['item_id']==$rows['item_1st'])echo "฿ ".number_format($rows['prize_1st'], 0, '.', ',');
												else if($rows['item_id']==$rows['item_2nd'])echo "฿ ".number_format($rows['prize_2nd'], 0, '.', ',');
												else if($rows['item_id']==$rows['item_3rd'])echo "฿ ".number_format($rows['prize_3rd'], 0, '.', ',');
											 ?>
										</h4>
									</div>
						    		<img src="<?php echo $image; ?>" alt="">
						    		<p>แนวความคิด : <?php echo $rows['item_concept'] ?></p>
									<div class="owner">
										<a href="profile.php?user_id_info=<?php echo $rows['user_id'] ?>">
							    			<img src="<?php echo $rows['user_image']; ?>" alt="">
							    			<p><?php echo $rows['user_name']; ?></p>
							    		</a>
									</div>
						    		
						    	</div>
						    	
						    </div>
						    <div class="container m-20">
						    	<div class="w-12 comment">
						    		<h5>Comment</h5>
						    		<div class="image">
						    			<img src="<?php echo $userLogin['user_image']; ?>" alt="">
						    		</div>
						    		<div class="w-5 send-comment">
						    			<?php 
						    				if(isset($_SESSION['userLogin'])){
						    			 ?>
						    			<!-- <form action="" method="post"> -->
							    			<input class="input" id="commenting<?php echo $rows['item_id']; ?>" type="text" placeholder="เขียนความคิดเห็น">
							    			<!-- <input type="submit" value="ส่ง" class="btn btn-send"> -->
							    		<!-- </form> -->
							    		<?php 
											}else{
												echo "เข้าสู่ระบบเพื่อแสดงความคิดเห็น";
											}
							    		 ?>
						    		</div>	



									<!-- comment -->
									 <div id="list-comment<?php echo $rows['item_id']; ?>"></div>
									<!-- comment -->



									 <script>

									 	if($( "#commenting<?php echo $rows['item_id']; ?>" ).val() == ""){
									 		$.ajax({
												method: "POST",
												url: "AjaxComment.php",
												data: {
													item_id: <?php echo $rows['item_id']; ?>,
												}
											})
											.done(function( msg ) {
												$("#list-comment<?php echo $rows['item_id']; ?>").html(msg)
											});
									 	}
														
										$( "#commenting<?php echo $rows['item_id']; ?>" ).keyup(function(e) {
											if(e.which == 13){
												//console.log('enter');
												$.ajax({
													method: "POST",
													url: "AjaxComment.php",
													data: {
														comment_detail: $("#commenting<?php echo $rows['item_id']; ?>").val(),
														item_id: <?php echo $rows['item_id']; ?>,
														user_id: <?php echo $userLogin['user_id']; ?>
													}
												})
												.done(function( msg ) {
													$("#list-comment<?php echo $rows['item_id']; ?>").html(msg)
												});

												$( "#commenting<?php echo $rows['item_id']; ?>" ).val("");
											}
										 	
										});


									</script>
						    			    		
						    	</div>
						    	
						    </div>
						    
							</div>
				<?php
					//}
			    }
			}else{
				//echo $sql;

				echo "
				<h3 class=\"cb\">ไม่พบผลงาน</h3>";
			}
			$mysqli->close();
		 ?>

<!-- 			<a href="###">
				<div class="w-3 pull">
					<div class="item-card w-12">
						<img src="" alt="" class="img">
						<div class="item-description">
							<div class="item-project">
								<p>ตราสัญลักษณ์ โลโก้องกรณ์</p>
							</div>
							<div class="item-designer">
								<p>by <a href="###">PunchilZ</a></p>
							</div>
						</div>
						<div class="line"></div>
						<div class="item-prize">
							<h5> ฿ 30,000 </h5>
						</div>
					</div>
				</div>
			</a> -->



		</div>


</div>
	
 <?php 
	include('layouts/footer.php');
 ?>
