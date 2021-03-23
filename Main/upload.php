<?php
	session_start();
	session_regenerate_id();
	if(!isset($_SESSION['user'])) {
		// if no valid session id go to login
		header("Location: ../UserLogin/userLogin.php");
	}

	require_once("main.php");
	
	$form = new RecipeForm();

	$content = $form->createUploadForm();
	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("content", $content);
	
	echo($layout->output());

?>