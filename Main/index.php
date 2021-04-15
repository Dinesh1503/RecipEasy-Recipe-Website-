<?php
	session_start();
	session_regenerate_id();
	require_once("main.php");
	
	$content = file_get_contents("elements/landing.html");
	$layout = new Template("index.tpl");
	$layout->set("title", "RecipEasy");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);
	
	echo($layout->output());

?>	
