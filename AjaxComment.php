<?php 
session_start();
require 'connectDB.php';

$item_id = $_POST['item_id'];

if(isset($_POST['item_id']) && isset($_POST['comment_detail']) && isset($_POST['user_id']) ){
	$item_id = $_POST['item_id'];
	$comment_detail = $_POST['comment_detail'];
	$user_id = $_POST['user_id'];

	require 'connectDB.php';

	$sql = "INSERT INTO `comments`(`comment_id`, `user_id`, `item_id`, `comment_detail`) 
			VALUES (null,'$user_id','$item_id','$comment_detail')
			";

	if ($mysqli->query($sql) === TRUE) {

	}else{
		echo "error";
	}

}


	$sql2 = "SELECT comment_detail,users.user_name,user_image,create_at,NOW() as nowDate
			FROM comments
			LEFT JOIN users
			ON users.user_id = comments.user_id
			WHERE item_id = '".$item_id."'
			ORDER BY comment_id DESC
	        ";
	//echo $sql2;
	$result2 = $mysqli->query($sql2);
	if ($result2->num_rows > 0) {
	    while ($rows2 = $result2->fetch_assoc()) {
	    	?>
				

				<div class="commented cb">
					<div class="image">
		    			<a href="###">
		    				<img src="<?php echo $rows2['user_image']; ?>" alt="">
		    				
		    			</a>
		    			<?php echo $rows2['user_name']; ?>
						<?php 
							// echo $rows['nowDate'];
							$countdown = round((strtotime($rows2['nowDate']) - strtotime($rows2['create_at']))); //second
							// /60=min /(60*60)=hour /(60*60*24)=day /(60*60*24*30)=month

							if($countdown/(60*60*24*30) >= 1){
								echo "<div style=\"color:#aaa; display:inline-block;\">".round($countdown/(60*60*24*30))." เดือน"."</div>";
							}else if($countdown/(60*60*24) >= 1){
								echo "<div style=\"color:#aaa; display:inline-block;\">".round($countdown/(60*60*24))." วัน"."</div>";
							}else if($countdown/(60*60) >= 1){
								echo "<div style=\"color:#aaa; display:inline-block;\">".round($countdown/(60*60))." ชั่วโมง"."</div>";
							}else if($countdown/(60) >= 1){
								echo "<div style=\"color:#aaa; display:inline-block;\">".round($countdown/(60))." นาที"."</div>";
							}else if($countdown >= 1){
								echo "<div style=\"color:#aaa; display:inline-block;\">".round($countdown)." วินาที"."</div>";
							}else if($countdown < 1){
								echo "<div style=\"color:#aaa; display:inline-block;\">"."ไม่กี่วินาที"."</div>";
							}
						?>

		    		</div>

		    		<div class="w-11">
		    			<p style="float:left;"><?php echo $rows2['comment_detail']; ?></p>

		    			
		    		</div>	
				</div>
	    	<?php


	    }
	}else{

		//echo "<div class=\"br\">No Comment</div>";


	}

	$mysqli->close();

?>
