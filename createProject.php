<?php 
	$title = 'Create Project';
	include('layouts/header.php');
 ?>


<div class="container">

	<div class="w-12" style="text-align: center;">
		<?php 
		if(!isset($_SESSION['userLogin'])){ 
			?>
				<h3>กรุณาเข้าสู่ระบบ</h3>
			<?php
		}else{
			if($userLogin['user_admin'] == 9){
				
				?> 
					<h3>คุณได้ขอสิทธิการสร้างโครงการแล้ว</h3>
					
				<?php
			}else if($userLogin['user_admin'] == 0 || $userLogin['user_admin'] == 9){
				
				?> 
					<h3>คุณไม่มีสิทธิสร้างโครงการ</h3>
					<form action="requestUser_api.php" method="post">
						<input type="hidden" name="user_id" value="<?php echo $userLogin['user_id']; ?>">
						<input type="submit" class="btn" value="ขอสิทธิ" style="margin-top: 20px;">
					</form>
				<?php
			}else if($userLogin['user_admin'] == 1 || $userLogin['user_admin'] == 2){
		?>
	</div>

	<form action="createProject_api.php" method="post" enctype="multipart/form-data">

		<div class="w-6 formProject">
			<label for="">ชื่อโครงการ</label>
			<input class="input" type="text" placeholder="ชื่อโครงการ" name="name" required>
			<label for="">ประเภทงาน</label>
			<select class="select" name="category" id="">
				<?php 
					require 'connectDB.php';
					$sql = "SELECT category_id,category_name
					        FROM categories
					        ";
					
					$result = $mysqli->query($sql);
					if ($result->num_rows > 0) {
					    while ($rows = $result->fetch_assoc()) {
					    ?>
							<option value="<?php echo $rows['category_id'];?>"><?php echo $rows['category_name']; ?></option>
						<?php
					    }
					}else{
						?>
							<option value="">ไม่มีประเภท</option>
						<?php
					}

				 ?>
			
				 
			</select>
			<label for="">รายละเอียด</label>
			<textarea class="input-textarea" placeholder="รายละเอียด" name="description" id="" cols="30" rows="3" required></textarea>
			<label for="">รูปภาพ</label>
			<!-- <input class="input" type="file" placeholder="Upload Poster" name="fileToUpload" required> -->
			<div class="upload-file">
				<input id="imgInp" class="input" type="file" placeholder="Upload Poster" name="fileToUpload" required/>
    			<img id="blah" src=""/>
			</div>
			

			<label for="">เงินรางวัล</label>
			<input class="input" type="number" placeholder="อันดับที่ 1" name="prize1" required>
			<input class="input" type="number" placeholder="อันดับที่ 2" name="prize2" required>
			<input class="input" type="number" placeholder="อันดับที่ 3" name="prize3" required>
			<label for="">คุณสมบัติ</label>
			<input class="input" type="number" placeholder="อายุขั้นต่ำ" name="age1" required>
			<input class="input" type="number" placeholder="อายุไม่เกิน" name="age2" required>
			<input class="input" type="text" placeholder="อาชีพ" name="job" required>
			<input class="input" type="text" placeholder="คุณสมบัติอื่น" name="other" required>
			<label for="">สิ้นสุดโครงการ</label>
			<input class="input" type="date" placeholder="End Date" name="end_at" value="<?php echo date("Y-m-d", strtotime("+7 days")); ?>" required>
			<label for="">ช่องทางการติดต่อ</label>
			<input class="input" type="text" placeholder="เว็บไซต์" name="website" required>
			<input class="input" type="text" placeholder="เบอร์โทรศัพท์" name="tel" required>

			<input class="btn w-12" type="submit" value="ยืนยันการสร้าง">
			<div class="cb"></div>
			
		</div>
	</form>



	<?php 

		} 
	}

	?>
</div>


</div>


<script>
	function readURL(input) {

	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#blah').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$("#imgInp").change(function(){
	    readURL(this);
	});
</script>


 <?php 
	include('layouts/footer.php');
 ?>
