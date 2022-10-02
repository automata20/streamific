<?php
session_name('plex');
	session_start();
	unset($_SESSION['id']);
	unset($_SESSION['name']);
	session_destroy();
	// header('location:auth.php?auth=signin');
	$response=array();
	$response['url']="auth.php?auth=signin";
?>