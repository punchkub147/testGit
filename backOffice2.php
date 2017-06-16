<?php 
	$title = 'Admin Item';
	include('layouts/adminHeader.php');
 ?>

<div class="container">



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
									<div class="item-delete">
										<!-- <form action="deleteItem_api.php" method="post">
											<input type="hidden" name="item_id" value="<?php echo $rows['item_id'] ?>">
											<input type="submit" class="btn btn-delete" value="Delete">
										</form> -->
										<button type="submit" value="Delete" class="btn btn-delete" onclick="deleteItem(<?php echo $rows['item_id']; ?>);">Delete
										</button>
										<script>
											function deleteItem(id){
												swal({
												  title: "Delete?",
												  text: "Confirm Deleting",
												  type: "warning",
												  showCancelButton: true,
												  confirmButtonColor: "red",
												  confirmButtonText: "Delete",
												  cancelButtonText: "Cancle",
												  closeOnConfirm: false,
												  closeOnCancel: false
												},
												function(isConfirm){
												  if (isConfirm) {
												  	//console.log(id);
												  	$.ajax({
													  method: "POST",
													  url: "deleteItem_api.php",
													  data: { item_id: id}
													})
													  .done(function( msg ) {
													    //alert( "Data Saved: " + msg );
													  });
												  	
												  	//swal("Deleted!", "Deleted Project.", "success");
												  	swal({
													  title: "Deleted!",
													  text: "Deleted Item.",
													  timer: 2000,
													  showConfirmButton: false
													});

												  	setInterval(function(){ window.location.href = 'backOffice2.php'; }, 2000);
													
												   	
												  } else {
												    swal("Cancelled", "Item has alive", "error");
												  }
												});

											}
										</script>
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
						    			<!-- <form action="" method="post"> -->
							    			<input class="input" id="commenting<?php echo $rows['item_id']; ?>" type="text" placeholder="เขียนความคิดเห็น">
							    			<!-- <input type="submit" value="ส่ง" class="btn btn-send"> -->
							    		<!-- </form> -->
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



</div>

<?php 
	include('layouts/adminFooter.php');
 ?>
