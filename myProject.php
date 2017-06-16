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


	$title = 'My Project';
	include('layouts/header.php');



	if(isset($_SESSION['flash']) && $_SESSION['flash'] != null){
		//echo $_SESSION['flash'];
		?>
		<script>
			swal("<?php echo $_SESSION['flash'][0]; ?>", "<?php echo $_SESSION['flash'][1]; ?>", "success");
		</script>
		<?php
		$_SESSION['flash'] = null;
	}
 ?>

<div class="container">
		<div class="search w-12">
			<form action="myProject.php?search=$search" method="">
				<input type="text" class="input" name="search" placeholder="ค้นหาชื่อโครงการ">
				<input type="submit" value="ค้นหา" class="btn btn-search">
			</form>
		</div>
		<div class="filter w-6">
			<nav>
				<ul>
					<a href="myProject.php?filter=<?php echo $filter; ?>&category=" <?php if($category == "")echo "id=\"active\""; ?>class="fl"><li>All</li></a>
					<a href="myProject.php?filter=<?php echo $filter; ?>&category=1" <?php if($category == 1)echo "id=\"active\""; ?>class="fl"><li>Logo</li></a>
					<a href="myProject.php?filter=<?php echo $filter; ?>&category=2" <?php if($category == 2)echo "id=\"active\""; ?>class="fl"><li>Model</li></a>
					<a href="myProject.php?filter=<?php echo $filter; ?>&category=3" <?php if($category == 3)echo "id=\"active\""; ?>class="fl"><li>Mascot</li></a>
				</ul>
			</nav>
		</div>
		<div class="filter w-6">
			<nav>
				<ul>
					<!-- <a href="searchProject.php?filter=10" <?php if($filter == 0)echo "id=\"active\""; ?>><li>หมวดหมู่</li></a> -->
					<!-- <a href="searchProject.php?filter=1" <?php if($filter == 1)echo "id=\"active\""; ?>><li>สำหรับคุณ</li></a> -->
					<a href="myProject.php?filter=2&category=<?php echo $category; ?>" <?php if($filter == 2)echo "id=\"active\""; ?>class="fr"><li>ใกล้หมดเวลา</li></a>
					<a href="myProject.php?filter=3&category=<?php echo $category; ?>" <?php if($filter == 3)echo "id=\"active\""; ?>class="fr"><li>เงินรางวัลมากที่สุด</li></a>
					<!-- <a href="searchProject.php?filter=4" <?php if($filter == 4)echo "id=\"active\""; ?>><li>ยอดนิยม</li></a> -->
					<!-- <a href="searchProject.php?filter=5" <?php if($filter == 5)echo "id=\"active\""; ?>><li>สิ้นสุด</li></a> -->
				</ul>
			</nav>
			
		</div>


			<div class="project-head w-12">
				<div class="project-head-in w-4">
					<p>ชื่อโครงการ</p>
				</div>
				<div class="project-head-in w-2">
					<p>ผู้เข้าร่วม</p>
				</div>
				<div class="project-head-in w-2">
					<p>รางวัลรวม</p>
				</div>
				<div class="project-head-in w-2">
					<p>สิ้นสุดเมื่อ</p>
				</div>
				<div class="project-head-in w-2">
					<p>รางวัล</p>
				</div>
			</div>

		<?php 

		$search = " projects.project_name LIKE '%$search%'
						";
			$category = " projects.category_id LIKE '%$category%'
						";
			if($filter == 10){
				$filter = "	AND projects.category_id = '$category'";
			}else if($filter == 1){
				$filter = "	LEFT JOIN user_category
			    			ON projects.category_id = user_category.category_id
							AND user_category.user_id = '$user_id'
			    			AND $search AND $category
			    			";
			}else if($filter == 2){
				$filter = 	"	AND $search AND $category
								AND NOW() < end_at
								ORDER BY end_at ASC
							";
			}else if($filter == 3){
				$filter = 	"	AND $search AND $category
								
								ORDER BY prize DESC
							";
			}else if($filter == 4){
				$filter = "	LEFT JOIN items
			    			ON projects.project_id = items.project_id
							WHERE user_category.user_id = '$user_id'
							AND $search AND $category
							";
			}else if($filter == 5){
				$filter = "	AND $search AND $category
							ORDER BY end_at ASC		
							";	
			}else{
				$filter = " AND $search AND $category
							ORDER BY project_id DESC		
							";
			}

		require 'connectDB.php';
			$user_id = $userLogin['user_id'];

			$sql = "SELECT projects.project_id,project_name,prize_1st,prize_2nd,prize_3rd,end_at,categories.category_name,(prize_1st+prize_2nd+prize_3rd) as prize,project_description,categories.category_id,project_poster,NOW() as nowDate
			        FROM projects
			        LEFT JOIN categories
			        ON projects.category_id = categories.category_id
			        WHERE user_id = '$user_id'

			        ".$filter."
			        ";

			//echo $sql;	       
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
			    while ($rows = $result->fetch_assoc()) {
			    	$path = "img/projects/";
			    	$poster = $path.$rows['project_poster'];
			    ?>
					<a href="#id<?php echo $rows['project_id']; ?>" id="modal-btn-project" data-toggle="modal" data-target="#id<?php echo $rows['project_id']; ?>">
						<div class="project-card w-12">
							<div class="project-name w-4">
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
							<div class="project-winner w-2">

								<?php $pathItem = "img/items/"; ?>
								<?php 
									$sql2 = "SELECT item_image
									        FROM items
									        LEFT JOIN projects
									        ON projects.item_1st = items.item_id
									        WHERE projects.project_id = ".$rows['project_id']."
									        ";
									//echo $sql2;
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    	//echo $rows2['item_image'];
									    	?>
									    		<a href="manageProject.php?project_id=<?php echo $rows['project_id']; ?>" class="btn fail">
									    			<img src="<?php echo $pathItem.$rows2['item_image']; ?>" alt="">
									    		</a>
												<?php
									    }
									}else{
										?>
											<a href="manageProject.php?project_id=<?php echo $rows['project_id']; ?>" class="btn c-gold">1</a>
										<?php
									}
								 ?>
								 <?php 
									$sql2 = "SELECT item_image
									        FROM items
									        LEFT JOIN projects
									        ON projects.item_2nd = items.item_id
									        WHERE projects.project_id = ".$rows['project_id']."
									        ";
									//echo $sql2;
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    	//echo $rows2['item_image'];
									    	?>
									    		<a href="manageProject.php?project_id=<?php echo $rows['project_id']; ?>" class="btn fail">
									    			<img src="<?php echo $pathItem.$rows2['item_image']; ?>" alt="">
									    		</a>
												<?php
									    }
									}else{
										?>
											<a href="manageProject.php?project_id=<?php echo $rows['project_id']; ?>" class="btn c-silver">2</a>
										<?php
									}
								 ?>
								 <?php 
									$sql2 = "SELECT item_image
									        FROM items
									        LEFT JOIN projects
									        ON projects.item_3rd = items.item_id
									        WHERE projects.project_id = ".$rows['project_id']."
									        ";
									//echo $sql2;
									$result2 = $mysqli->query($sql2);
									if ($result2->num_rows > 0) {
									    while ($rows2 = $result2->fetch_assoc()) {
									    	//echo $rows2['item_image'];
									    	?>
									    		<a href="manageProject.php?project_id=<?php echo $rows['project_id']; ?>" class="btn fail">
									    			<img src="<?php echo $pathItem.$rows2['item_image']; ?>" alt="">
									    		</a>
												<?php
									    }
									}else{
										?>
											<a href="manageProject.php?project_id=<?php echo $rows['project_id']; ?>" class="btn c-bronz">3</a>
										<?php
									}
								 ?>
								<!-- <img src="<?php echo $pathItem.$rows['item_1st']; ?>" alt=""> -->
								
							</div>
						</div>
					</a>
		
					<div id="id<?php echo $rows['project_id']; ?>" role="dialog" class="modal project-modal fade">
					    
					    <div class="container">
					    
					    	
					    	<form action="updateProject_api.php" method="post" enctype="multipart/form-data">
					    	
								<input type="hidden" name="project_id" value="<?php echo $rows['project_id']; ?>">
								
						    	<div class="w-12 detail">
							        <div class="modal-header">
								  	 	<button type="button" class="close" data-dismiss="modal">&times;</button>	
										<h4 class="modal-title"><?php echo $rows['project_name']; ?></h4>	
									</div>
							       	
							       	<div class="w-6 poster">
										<img src="<?php echo $poster; ?>" alt="">
										<input class="input" type="file" placeholder="Upload Poster" name="fileToUpload" required>
									</div>
									<div class="w-6 item">
										<label for="">ชื่อโครงการ</label>
										<input class="input" type="text" name="project_name" value="<?php echo $rows['project_name']; ?>" placeholder="ชื่อโครงการ">
										<label for="">ประเภท</label>

										<select class="select" name="category" id="">
											<?php 

												$sql2 = "SELECT category_id,category_name
												        FROM categories
												        ";
												
												$result2 = $mysqli->query($sql2);
												if ($result2->num_rows > 0) {
												    while ($rows2 = $result2->fetch_assoc()) {
												    	if($rows['category_id'] == $rows2['category_id']){
												    	?>
															<option value="<?php echo $rows2['category_id'];?>"><?php echo $rows2['category_name']; ?></option>
														<?php
														}
												    }
												}else{
													?>
														<option value="">ไม่มีประเภท</option>
													<?php
												}
												
												$result2 = $mysqli->query($sql2);
												if ($result2->num_rows > 0) {
												    while ($rows2 = $result2->fetch_assoc()) {
												    	if($rows['category_id'] != $rows2['category_id']){
												    	?>
															<option value="<?php echo $rows2['category_id'];?>"><?php echo $rows2['category_name']; ?></option>
														<?php
														}
												    }
												}else{
													?>
														<option value="">ไม่มีประเภท</option>
													<?php
												}
											 ?>
										</select>

										<label for="">รายละเอียด</label>
							       		<textarea class="input-textarea" name="project_description" id="" cols="30" rows="5"><?php echo $rows['project_description']; ?></textarea>


										<label for="">เงินรางวัล</label>
										
										<input class="input" type="text" name="prize_1st" placeholder="อันดับที่1" value="<?php echo $rows['prize_1st']; ?>">
										<input class="input" type="text" name="prize_2nd" placeholder="อันดับที่2" value="<?php echo $rows['prize_2nd']; ?>">
										<input class="input" type="text" name="prize_3rd" placeholder="อันดับที่3" value="<?php echo $rows['prize_3rd']; ?>">
									
										<label for="">คุณสมบัติ</label>
										<?php
										$sql2 = "SELECT  attribute_detail,attribute_name,attributes.attribute_id
										        FROM project_attribute
												LEFT JOIN attributes
												ON project_attribute.attribute_id = attributes.attribute_id
										        WHERE project_id = ".$rows['project_id']."
										        ";
										
										$result2 = $mysqli->query($sql2);
										if ($result2->num_rows > 0) {
										    while ($rows2 = $result2->fetch_assoc()) {
										    ?>
										    	<!-- <p><?php echo $rows2['attribute_name']; ?></p> -->
										    	<input class="input" type="text" name="attr_<?php echo $rows2['attribute_id']; ?>" placeholder="<?php echo $rows2['attribute_name']; ?>" value="<?php echo $rows2['attribute_detail']; ?>">
												
											<?php
										    }

										}else{
											//echo $sql2;
											echo "<p>ไม่กำหนด</p>";
										}
										//$mysqli->close();
										?>
										<label for="">สิ้นสุดโครงการ</label>
										<input class="input" type="date" name="end_at" placeholder="dd-mm-yyyy" value="<?php echo date("Y-m-d", strtotime($rows['end_at'])); ?>" readonly>
									

										<label for="">ติดต่อ</label>
										<?php
										$sql3 = "SELECT  contact_detail,contact_name,contacts.contact_id
										        FROM project_contact
												LEFT JOIN contacts
												ON project_contact.contact_id = contacts.contact_id
										        WHERE project_id = ".$rows['project_id']."
										        ";
										
										$result3 = $mysqli->query($sql3);
										if ($result3->num_rows > 0) {
										    while ($rows3 = $result3->fetch_assoc()) {
										    ?>
										    	<!-- <p><?php echo $rows3['contact_name']; ?></p> -->
										    	<input class="input" type="text" name="contact_<?php echo $rows3['contact_id']; ?>" placeholder="<?php echo $rows3['contact_name']; ?>" value="<?php echo $rows3['contact_detail']; ?>">
												
											<?php
										    }

										}else{
											//echo $sql3;
											echo "<p>ไม่กำหนด</p>";
										}
										//$mysqli->close();
										?>
										<input class="btn w-12" type="submit" value="อัพเดท">
									</div>
									
						    	</div>
								
					    	</form>
					    </div>
					    
					</div>
				<?php
			    }
			}else{
				//echo $sql;
				echo "<h3 class=\"cb\">คุณไม่ได้สร้างโครงการ</h3>";
			}
		?>
		
		

	<div class="cb"></div>
</div>

	
 <?php 
	include('layouts/footer.php');
 ?>
