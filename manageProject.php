<?php 
	$title = 'Manage Project';
	include('layouts/header.php');

	if(!isset($_GET['project_id'])){
		$project_id = "";
		header('refresh: 2; url=myProject.php');
	}else{
		$project_id = $_GET['project_id'];
	}

	$path = "img/items/";
 ?>

<div class="winner">
	<div class="container">
		
		<div class="prize">
			
			<?php 
				require 'connectDB.php';
				$sql = "SELECT  item_1st,item_image,item_id,prize_1st
			       		FROM projects
			     	  	LEFT JOIN items
			     	  	ON projects.item_1st = items.item_id
			     	  	WHERE projects.project_id = $project_id
			     	  	LIMIT 1
			        ";
				//echo $sql;
				$result = $mysqli->query($sql);
				if ($result->num_rows > 0) {
				    while ($rows = $result->fetch_assoc()) {
				    ?>
				    	<div class="prize-1st"><?php echo "฿ ".number_format($rows['prize_1st'], 0, '.', ','); ?></div>
						<a href="#id<?php echo $rows['item_id']; ?>" data-toggle="modal" data-target="#id<?php echo $rows['item_id']; ?>">
							<?php 
								if($rows['item_id'] == 0){
									?><img class="gold" src="<?php echo $path.$rows['item_1st']; ?>.jpg" alt=""><?php
								}else{
							 ?>
								<img class="gold" src="<?php echo $path.$rows['item_image']; ?>" alt="">
							<?php } ?>
						</a>
					<?php
						
				    }
				}else{
					?>
						
					<?php
				}
				$mysqli->close();
			?>
			
		</div>
		<div class="prize">
			<?php 
				require 'connectDB.php';
				$sql = "SELECT  item_2nd,item_image,item_id,prize_2nd
			       		FROM projects
			     	  	LEFT JOIN items
			     	  	ON projects.item_2nd = items.item_id
			     	  	WHERE projects.project_id = $project_id
			     	  	LIMIT 1
			        ";
				//echo $sql;
				$result = $mysqli->query($sql);
				if ($result->num_rows > 0) {
				    while ($rows = $result->fetch_assoc()) {
				    ?>
				    	<div class="prize-1st"><?php echo "฿ ".number_format($rows['prize_2nd'], 0, '.', ','); ?></div>
						<a href="#id<?php echo $rows['item_id']; ?>" data-toggle="modal" data-target="#id<?php echo $rows['item_id']; ?>">
							<?php 
								if($rows['item_id'] == 0){
									?><img class="silver" src="<?php echo $path.$rows['item_2nd']; ?>.jpg" alt=""><?php
								}else{
							 ?>
								<img class="silver" src="<?php echo $path.$rows['item_image']; ?>" alt="">
							<?php } ?>
						</a>
					<?php
				    }
				}else{
					?>
						
					<?php
				}
				$mysqli->close();
			?>
		</div>
		<div class="prize">
			<?php 
				require 'connectDB.php';
				$sql = "SELECT  item_3rd,item_image,item_id,prize_3rd
			       		FROM projects
			     	  	LEFT JOIN items
			     	  	ON projects.item_3rd = items.item_id
			     	  	WHERE projects.project_id = $project_id
			     	  	LIMIT 1
			        ";
				//echo $sql;
				$result = $mysqli->query($sql);
				if ($result->num_rows > 0) {
				    while ($rows = $result->fetch_assoc()) {
				    ?>
				    	<div class="prize-1st"><?php echo "฿ ".number_format($rows['prize_3rd'], 0, '.', ','); ?></div>
						<a href="#id<?php echo $rows['item_id']; ?>" data-toggle="modal" data-target="#id<?php echo $rows['item_id']; ?>">
							<?php 
								if($rows['item_id'] == 0){
									?><img class="bronz" src="<?php echo $path.$rows['item_3rd']; ?>.jpg" alt=""><?php
								}else{
							 ?>
								<img class="bronz" src="<?php echo $path.$rows['item_image']; ?>" alt="">
							<?php } ?>
						</a>
					<?php
				    }
				}else{
					?>
						
					<?php
				}
				$mysqli->close();
			?>
		</div>
	</div>
</div>
<div class="winner-b"></div>

<div class="container">
		
	<div class="row cb">
		<?php 
			require 'connectDB.php';
			$sql = "SELECT item_id,projects.project_name,projects.project_id,user_name,category_name,item_concept,item_image,user_image,users.user_id,item_concept
			        FROM items
			        LEFT JOIN projects
			        ON projects.project_id = items.project_id
			        LEFT JOIN users
			        ON users.user_id = items.user_id
			        LEFT JOIN categories
			        ON categories.category_id = items.category_id
			        WHERE projects.project_id = $project_id
			        ORDER BY item_id DESC
			        ";
			
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
			    while ($rows = $result->fetch_assoc()) {
			    	$path = "img/items/";
			    	$image = $path.$rows['item_image'];
			    ?>
			    	
					<a href="#id<?php echo $rows['item_id']; ?>" data-toggle="modal" data-target="#id<?php echo $rows['item_id']; ?>">
						<div class="w-3 pull">
							<div class="item-card w-12">
								<div class="img">
									<img src="<?php echo $image; ?>" alt="">
								</div>
								
								<div class="item-description">
									<div class="item-project">
										<p><?php echo $rows['item_concept'] ?></p>
									</div>
									<div class="item-designer">
										<a href="">by <?php echo $rows['user_name'] ?></a>
									</div>
								</div>
							</div>
						</div>
					</a>
					
					<div id="id<?php echo $rows['item_id']; ?>" role="dialog" class="modal item-modal fade">
					    <div class="container">
					    	<div class="w-12 detail">
					    		<div class="modal-header">
							  	 	<button type="button" class="close" data-dismiss="modal">&times;</button>	
									<h4 class="modal-title"><?php echo $rows['project_name']; ?></h4>
									
								</div>

								<form action="letPrize.php" method="post">
									<input type="hidden" name="item_id" value="<?php echo $rows['item_id']; ?>">
									<input type="hidden" name="project_id" value="<?php echo $rows['project_id']; ?>">
									<input class="btn btn-prize p1st" type="submit" name="1st" value="อันดับ 1">
									<input class="btn btn-prize p2nd" type="submit" name="2nd" value="อันดับ 2">
									<input class="btn btn-prize p3rd" type="submit" name="3rd" value="อันดับ 3">
								</form>


					    		<div class="image">
					    			<img src="<?php echo $image; ?>" alt="" >
					    		</div>

					    		
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
			    }
			}else{
				//echo $sql;

				echo "
				<h3 class=\"cb\">ไม่พบผลงาน</h3>";
			}
			$mysqli->close();
		 ?>

		</div>


</div>
	
 <?php 
	include('layouts/footer.php');
 ?>
