<?php 
	$title = 'Home';
	include('layouts/header.php');
 ?>

	<div class="banner">
		<h1>Craft Prize</h1>
	</div>

	<div class="banner-news">
		<h3>ประกาศโครงการของคุณ <br> ให้นักออกแบบกว่า   <?php 
															require 'connectDB.php';
															$sql = "SELECT COUNT(user_id) as count_user
															        FROM users
															        ";

															//echo $sql;
															
															$result = $mysqli->query($sql);
															if ($result->num_rows > 0) {
															    while ($rows = $result->fetch_assoc()) {
															    	?><?php echo $rows['count_user']; ?><?php
															    }
															}else{
																?>0<?php
															}
														 ?>     คนได้เห็น</h3>
		<a href="createProject.php"><button class="btn">ประกาศโครงการ</button></a>
	</div>

	<div class="container">
		<div class="row">
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
			        WHERE items.item_id = projects.item_1st OR items.item_id = projects.item_2nd OR items.item_id = projects.item_3rd
			        ORDER BY item_id DESC
			        LIMIT 4
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

		</div>
		<div class="cb"></div>
	</div>

	<div class="banner-news2">
		<h3>โชว์ฝีมือการออกแบบของคุณ <br> เพื่อชิงเงินรางวัลกว่า <?php 
																	require 'connectDB.php';
																	$sql = "SELECT SUM(prize_1st+prize_2nd+prize_3rd) as total_prize
																	        FROM projects
																	        ";
										
																	//echo $sql;
																	
																	$result = $mysqli->query($sql);
																	if ($result->num_rows > 0) {
																	    while ($rows = $result->fetch_assoc()) {
																	    	?><?php echo number_format($rows['total_prize'], 0, '.', ','); ?><?php
																	    }
																	}else{
																		?>0<?php
																	}
																?> บาท</h3>
		<a href="searchProject.php"><button class="btn">ค้นหาโครงการ</button></a>
	</div>



	<div class="container">
		<div class="project-head w-12">
			<div class="project-head-in w-6">
				<p>ชื่อโครงการ</p>
			</div>
			<div class="project-head-in w-2">
				<p>ผู้เข้าร่วม</p>
			</div>
			<div class="project-head-in w-2">
				<p>รางวัลรวม</p>
			</div>
			<div class="project-head-in w-2">
				<p>หมดเขต</p>
			</div>
		</div>
		<?php 
			require 'connectDB.php';
			$sql = "SELECT project_name,prize_1st,prize_2nd,prize_3rd,end_at,categories.category_name,(prize_1st+prize_2nd+prize_3rd) as prize,project_id,projects.user_id,users.user_name,project_poster,project_description,NOW() as nowDate,categories.category_id
			        FROM projects
			        LEFT JOIN categories
			        ON projects.category_id = categories.category_id
			        LEFT JOIN users
			        ON projects.user_id = users.user_id
			        WHERE NOW() < end_at
			        ORDER BY end_at ASC

			        LIMIT 3
			        ";
			//echo $sql;
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
			    while ($rows = $result->fetch_assoc()) {
			    	$path = "img/projects/";
			    	$poster = $path.$rows['project_poster'];
			    ?>
					<a href="#id<?php echo $rows['project_id']; ?>" id="modal-btn-project" data-toggle="modal" data-target="#pid<?php echo $rows['project_id']; ?>">
						<div class="project-card w-12">
							<div class="project-name w-6">
								<p><?php echo $rows['project_name']; ?></p>
								<p><?php echo $rows['category_name']; ?></p>
							</div>
							<div class="project-competitor w-2">
								<p>
									<?php 
										$sql3 = "SELECT  COUNT(item_id) as competitor
									        FROM items
									        WHERE project_id = ".$rows['project_id']."
									        ";
									
										$result3 = $mysqli->query($sql3);
										if ($result3->num_rows > 0) {
										    while ($rows3 = $result3->fetch_assoc()) {
										    ?>
										    	
												<p><?php echo $rows3['competitor']; ?></p>
											<?php
										    }
										}else{
											echo "<p>0</p>";
										}
										//$mysqli->close();
										?>
								</p>
							</div>
							<div class="project-prize w-2">
								<p><?php echo "฿ ".number_format($rows['prize'], 0, '.', ','); ?></p>
							</div>
							<div class="project-countdown w-2">
								<?php 
									// echo $rows['nowDate'];
									$countdown = round((strtotime($rows['end_at']) - strtotime($rows['nowDate']))); //second
									// /60=min /(60*60)=hour /(60*60*24)=day /(60*60*24*30)=month

									if($countdown/(60*60*24*30) >= 1){
										echo "<p style=\"color:#1c75bc;\">".round($countdown/(60*60*24*30))." เดือน"."</p>";
									}else if($countdown/(60*60*24) >= 1){
										echo "<p style=\"color:#1c75bc;\">".round($countdown/(60*60*24))." วัน"."</p>";
									}else if($countdown/(60*60) >= 1){
										echo "<p style=\"color:#1c75bc;\">".round($countdown/(60*60))." ชั่วโมง"."</p>";
									}else if($countdown/(60) >= 1){
										echo "<p style=\"color:red;\">".round($countdown/(60))." นาที"."</p>";
									}else if($countdown >= 1){
										echo "<p style=\"color:red;\">".round($countdown)." วินาที"."</p>";
									}else if($countdown < 1){
										echo "<p style=\"color:red;\">"."หมดเขต"."</p>";
									}
								?>
								<p><?php echo date("d-m-Y", strtotime($rows['end_at'])); ?></p>
							</div>
						</div>
					</a>

					<div id="pid<?php echo $rows['project_id']; ?>" role="dialog" class="modal project-modal fade">
					    <div class="container">
					    	
					    	<div class="w-12 detail">
					    		<div class="modal-header">
							  	 	<button type="button" class="close" data-dismiss="modal">&times;</button>	
									<h4 class="modal-title"><?php echo $rows['project_name']; ?></h4><a href="profile.php?user_id_info=<?php echo $rows['user_id']; ?>">by <?php echo $rows['user_name']; ?></a>
									
								</div>
					    		
					    		<div class="w-6 poster">
									<img src="<?php echo $poster; ?>" alt="">	
								</div>
								<div class="w-6 item">
										
									<p>ประเภท : <?php echo $rows['category_name']; ?></p>
									<p>รายละเอียด : <?php echo $rows['project_description']; ?></p>
									<div class="line"></div>

									<h6>เงินรางวัล</h6>
									<p>อันดับที่ 1 : <?php echo number_format($rows['prize_1st'], 0, '.', ','); ?> บาท</p>
									<p>อันดับที่ 2 : <?php echo number_format($rows['prize_2nd'], 0, '.', ','); ?> บาท</p>
									<p>อันดับที่ 3 : <?php echo number_format($rows['prize_3rd'], 0, '.', ','); ?> บาท</p>
									
									<div class="line"></div>

									<h6>คุณสมบัติ</h6>
									<?php
									$sql2 = "SELECT  attribute_detail,attribute_name
									        FROM project_attribute
											LEFT JOIN attributes
											ON project_attribute.attribute_id = attributes.attribute_id
									        WHERE project_id = ".$rows['project_id']."
									        ";
									
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    ?>
									    	
											<p><?php echo $rows2['attribute_name']." : ".$rows2['attribute_detail']; ?></p>
										<?php
									    }
									}else{
										//echo $sql2;
										echo "<p>ไม่กำหนด</p>";
									}
									//$mysqli->close();
									?>

									<div class="line"></div>

									<p>หมดเขตการส่ง : <?php echo date("d-m-Y", strtotime($rows['end_at'])); ?></p>

									<?php 
										if(isset($_SESSION['userLogin'])){
									 ?>
											<div class="line"></div>

											<form action="postItem_api.php" method="post" enctype="multipart/form-data">

												<input type="hidden" name="project_id" value="<?php echo $rows['project_id']; ?>">
												<input type="hidden" name="category_id" value="<?php echo $rows['category_id']; ?>">

												<label for="">ส่งผลงาน</label>
												<input class="input" type="file" name="fileToUpload" placeholder="รูปภาพ" required>
												<label for="">แนวความคิด</label>
												<textarea class="input-textarea" name="concept" id="" cols="30" rows="10"></textarea>
												<input class="btn w-12" type="submit" value="ส่งผลงาน" required>

											</form>

									<?php } ?>

								</div>
					    	</div>
					    </div>
					    
					</div>
				<?php
			    }
			}else{
				//echo $sql;

				echo "
				<h3 class=\"cb\">ไม่พบโครงการที่ค้นหา</h3>";
			}
			$mysqli->close();
		 ?>

		<div class="cb"></div>
	</div>
	
 <?php 
	include('layouts/footer.php');
 ?>
