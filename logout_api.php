<?php 
	session_start();
	session_destroy();

	$url = $_GET['url'];
	header("Location: ".$url);
 ?>