<?php
    session_start();
	session_regenerate_id();
	require_once("main.php");
    if(!isset($_SESSION['user'])) {
		// if no valid session id go to login
		header("Location: userLogin.php");
	}
	
	$content = "";
    $fridge = getFridge();

    $form = new Template("elements/fridge.tpl");
    $form->set("ingredient1", $fridge["INGREDIENT_ONE"]);
    $form->set("ingredient2", $fridge["INGREDIENT_TWO"]);
    $form->set("ingredient3", $fridge["INGREDIENT_THREE"]);
    $form->set("ingredient4", $fridge["INGREDIENT_FOUR"]);
    $form->set("ingredient5", $fridge["INGREDIENT_FIVE"]);

    $content = $form->output();

	$layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);
	
	echo($layout->output());

    if(array_key_exists("searchBtn", $_GET)) {
        if ($_GET["searchBtn"] == "Set Fridge") {
            changeFridge();
        } else {
            echo("NO");
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