	<div class="cb"></div>
	<div class="b-footer"></div>
	<footer>
		<div class="container">
				<div class="w-12 top">
					<div class="stat w-3">
						<?php 
							require 'connectDB.php';
							$sql = "SELECT COUNT(project_id) as count_project
							        FROM projects
							        ";

							//echo $sql;
							
							$result = $mysqli->query($sql);
							if ($result->num_rows > 0) {
							    while ($rows = $result->fetch_assoc()) {
							    	?><h3><?php echo $rows['count_project']; ?></h3><?php
							    }
							}else{
								?><h3>0</h3><?php
							}
						 ?>
						
						<p>Projects</p>
					</div>
					<div class="stat w-3">
						<?php 
							require 'connectDB.php';
							$sql = "SELECT COUNT(user_id) as count_user
							        FROM users
							        ";

							//echo $sql;
							
							$result = $mysqli->query($sql);
							if ($result->num_rows > 0) {
							    while ($rows = $result->fetch_assoc()) {
							    	?><h3><?php echo $rows['count_user']; ?></h3><?php
							    }
							}else{
								?><h3>0</h3><?php
							}
						 ?>
						<p>Designers</p>
					</div>
					<div class="stat w-3">
						<?php 
							require 'connectDB.php';
							$sql = "SELECT SUM(prize_1st+prize_2nd+prize_3rd) as total_prize
							        FROM projects
							        ";

							//echo $sql;
							
							$result = $mysqli->query($sql);
							if ($result->num_rows > 0) {
							    while ($rows = $result->fetch_assoc()) {
							    	?><h3><?php echo number_format($rows['total_prize'], 0, '.', ','); ?></h3><?php
							    }
							}else{
								?><h3>0</h3><?php
							}
						 ?>
						<p>Prizes</p>
					</div>
					<div class="register">
						<a href="###"><button class="btn fr">สมัครสมาชิก</button></a>
					</div>
				</div>
		</div>
		<div class="cb line"></div>
		<div class="container">
				<div class="w-12 bottom">
					<nav>
						<ul>
							<a href="###"><li>Home</li></a>
							<a href="###"><li>Forum</li></a>
							<a href="###"><li>About</li></a>
							<a href="###"><li>Contact</li></a>
						</ul>
					</nav>
				</div>
		</div>

	</footer>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<?php 
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
</body>
</html>
<?php 
	$mysqli->close();
 ?>

