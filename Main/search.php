<?php
	require_once("main.php");
	
	$content = file_get_contents("elements/searchBar.html");
	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("content", $content);

	echo($layout->output());
?>	