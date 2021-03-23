<?php
	require_once("main.php");
	
	$content = file_get_contents("elements/landing.html");
	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("content", $content);
	
	echo($layout->output());

?>	

<script type="text/javascript">
	var yourVariable = '<%= Session["SessionKey"] %>';
	if (yourVariable.val() != null && yourVariable.val() != '') {
		alert('Your session value is  ' + yourVariable.val())
	}
	else {
		alert('Session value not exists')
	}
</script>