<?php
    session_start();
	session_regenerate_id();
	require_once("main.php");
    if(!isset($_SESSION['user'])) {
		// if no valid session id go to login
		header("Location: userLogin.php");
	}

	$content = "";
    

    $form = new Template("elements/fridge.tpl");


    $content = $form->output();

	$layout = new Template("index.tpl");
	$layout->set("title", "Fridge");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);

	echo($layout->output());

    if(array_key_exists("searchBtn", $_GET)) {
        if ($_GET["searchBtn"] == "Change Ingredients") {
            changeFridge();
        } else if($_GET["searchBtn"] == "Add Ingredients") {
            AddIngr();
        }
        else if($_GET["searchBtn"] == "Show Fridge") {
            showFridge();
        }
        else{
          echo("No");
        }
    }
?>

<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
        content.style.display = "none";
        } else {
        content.style.display = "block";
        }
    });
    }
</script>
