<?php 
	$title = 'Profile';
	include('layouts/header.php');

	$user_id_info = array();

	if(!isset($_GET['user_id_info'])){
		$user_id_info = $userLogin;
	}else{
		$id = $_GET['user_id_info'];

		require 'connectDB.php';
		$sql = "SELECT users.user_id,user_name,user_email,user_image,contact_detail,contact_name,user_detail
	            FROM users
	            LEFT JOIN user_contact
	            ON users.user_id = user_contact.user_id
	            LEFT JOIN contacts
	            ON contacts.contact_id = user_contact.user_id
	            WHERE users.user_id = '$id'
	            LIMIT 1
	            ";
	    
	    $result = $mysqli->query($sql);
	        if ($result->num_rows > 0) {
	            while ($get_users = $result->fetch_assoc()) {
	                array_push($user_id_info,$get_users);
	            }
	        }else{
	            echo $sql;
	        }
	    $mysqli->close();
	    $user_id_info = $user_id_info['0'];
	}
 ?>


 <div class="banner"></div>

<div class="container">
	<div class="row">
		<div class="w-3 pull">
			<div class="w-12 profile">
				<img class="display" src="<?php echo $user_id_info['user_image']; ?>" alt="">
				<div class="name"><?php echo $user_id_info['user_name']; ?></div>
				<div class="detail"><?php echo $user_id_info['user_detail']; ?></div>
				<div class="contact">
					<?php 
						require 'connectDB.php';
						$sql = "SELECT contact_name,contact_detail
						        FROM user_contact
						        LEFT JOIN contacts
						        ON contacts.contact_id = user_contact.contact_id
						        WHERE user_id = ".$user_id_info['user_id']."
						        ";
						
						$result = $mysqli->query($sql);
						if ($result->num_rows > 0) {
						    while ($rows = $result->fetch_assoc()) {
						    ?>
								<a href="<?php echo $rows['contact_detail']; ?>"><?php echo $rows['contact_name']; ?></a>
							<?php
						    }
						}else{
							//echo $sql;
							echo "<p>ไม่มีช่องทางการติดต่อ</p>";
						}
						$mysqli->close();
					?>
				</div>
				<div class="attribute">
					<?php 
						require 'connectDB.php';
						$sql = "SELECT attribute_name,attribute_detail
						        FROM user_attribute
						        LEFT JOIN attributes
						        ON attributes.attribute_id = user_attribute.attribute_id
						        WHERE user_id = ".$user_id_info['user_id']."
						        ";
						
						$result = $mysqli->query($sql);
						if ($result->num_rows > 0) {
						    while ($rows = $result->fetch_assoc()) {
						    ?>
								<p><?php echo $rows['attribute_detail']; ?></p>
							<?php
						    }
						}else{
							//echo $sql;
							echo "<p>ไม่มีคุณสมบัติพิเศษ</p>";
						}
						$mysqli->close();
					?>
				</div>
			</div>
		</div>
		

		<div class="w-9 portfolio pull">
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
					        WHERE users.user_id = ".$user_id_info['user_id']."
					        ORDER BY item_id DESC
					        ";
					
					$result = $mysqli->query($sql);
					if ($result->num_rows > 0) {
					    while ($rows = $result->fetch_assoc()) {
					    	$path = "img/items/";
					    	$image = $path.$rows['item_image'];
					    ?>
					    	
							<a href="#id<?php echo $rows['item_id']; ?>" data-toggle="modal" data-target="#id<?php echo $rows['item_id']; ?>">
								<div class="w-4 pull">
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
										<div class="item-prize">
											<h5>
											<?php 
												if($rows['item_id']==$rows['item_1st'])echo "฿ ".number_format($rows['prize_1st'], 0, '.', ',');
												else if($rows['item_id']==$rows['item_2nd'])echo "฿ ".number_format($rows['prize_2nd'], 0, '.', ',');
												else if($rows['item_id']==$rows['item_3rd'])echo "฿ ".number_format($rows['prize_3rd'], 0, '.', ',');
												else echo "฿ 0";
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
					    }
					}else{
						//echo $sql;

						echo "
						<h6 class=\"cb\">สร้างผลงานของคุณให้โลกรู้สิ</h6>";
					}
					$mysqli->close();
				 ?>

			</div>

		</div>
	</div>
</div>
	
 <?php 
	include('layouts/footer.php');
 ?>
