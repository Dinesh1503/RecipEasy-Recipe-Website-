<?php
	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['user'])) {
		// if no valid session id go to login
		header("Location: userLogin.php");
	}

	require_once("main.php");
	
	$content = file_get_contents("elements/page-upload.tpl");
	$layout = new Template("index.tpl");
	$layout->set("title", "Upload");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);
	
	echo($layout->output());

?>