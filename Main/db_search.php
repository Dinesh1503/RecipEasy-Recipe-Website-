<?php
	session_start();
	session_regenerate_id();

	require_once("main.php");
	
	$content = file_get_contents("elements/searchBar.html");
	$elements = "";
	if (array_key_exists("searchBtn", $_GET)) {
		$elements = db_search();
	}

	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("user", getUserElements());
	$layout->set("content", $content . $elements);

	echo($layout->output());
?>	