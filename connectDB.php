<?php 
 	$DB_host = "localhost";
 	$DB_user = "root";
 	$DB_pass = "";
 	$DB_name = "craftprize";

 	$mysqli = new mysqli($DB_host,$DB_user,$DB_pass,$DB_name) OR die("Connection Error!");

 	mysqli_set_charset($mysqli,"utf8");

 ?>
