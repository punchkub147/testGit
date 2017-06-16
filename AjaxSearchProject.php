<?php
	session_start();
	require 'connectDB.php';
	//$user_id = $userLogin['user_id'];
	
	$sql = "SELECT projects.project_id,project_name,prize_1st,prize_2nd,prize_3rd,end_at,categories.category_name,(prize_1st+prize_2nd+prize_3rd) as prize,project_description,categories.category_id,project_poster,user_name,users.user_id,NOW() as nowDate
	        FROM projects
	        LEFT JOIN categories
	        ON projects.category_id = categories.category_id
	        LEFT JOIN users
	        ON users.user_id = projects.user_id
	        WHERE NOW() < end_at
	        AND( project_name LIKE '%{$_POST['project_name']}%'
	        OR category_name LIKE '%{$_POST['project_name']}%')
	        ";

	//echo $sql;
	
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
	    while ($rows = $result->fetch_assoc()) {
	    	$path = "img/projects/";
	    	$poster = $path.$rows['project_poster'];
	    ?>

			<a href="#id<?php echo $rows['project_id']; ?>" id="modal-btn-project" data-toggle="modal" data-target="#id<?php echo $rows['project_id']; ?>">
				<div class="project-card b-gold w-12" id="cardProject<?php echo $rows['project_id']; ?>">
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
								echo "<p style=\"color:red;\">".round($countdown/(60*60))." ชั่วโมง"."</p>";
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

			<div id="id<?php echo $rows['project_id']; ?>" role="dialog" class="modal project-modal fade">
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
			<script>

				$(document).ready(function(){
				    $("#cardProject<?php echo $rows['project_id']; ?>").hide(0).delay(0).fadeIn(500)
				});
			</script>

		<?php
	    }
	}else{
		//echo $sql;

		//echo "
		//<h3 class=\"cb\">ไม่พบโครงการที่ค้นหา</h3>";
	}
	$mysqli->close();
?>


