<?php
	//end session
	session_start();
	session_destroy();
	//redirect user to homepage
	header("Location: /login/login");
	die(); 
?>