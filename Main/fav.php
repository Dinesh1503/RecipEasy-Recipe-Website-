<?php
	session_start();
	session_regenerate_id();
	require_once("main.php");

    $content = showFav();
	$layout = new Template("index.tpl");
	$layout->set("title", "Favourites");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);

	echo($layout->output());

?>
