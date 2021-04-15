<?php
    session_start();
	session_regenerate_id();
	require_once("main.php");
    if(!isset($_SESSION['user'])) {
		// if no valid session id go to login
		header("Location: userLogin.php");
	}

    # remove any duplicate items
    parseFridge();

    # check if adding or removing an item
    if (isset($_GET["rmIngr"])) {
        removeFridge($_GET["rmIngr"]);
    }

    if (isset($_GET["addIngr"])) {
        addFridge($_GET["addIngr"]);
    }

    if (isset($_GET["updateBtn"])) {
        $usePref = isset($_GET["usePreferences"]);
        $diet = "";
        if (isset($_GET["diet"])) {
            $diet = $_GET["diet"];
        }
        $intls = array();
        if (isset($_GET["intolerances"])) {
            $intls = $_GET["intolerances"];
        }
    }

    # remove any empty items
    removeFridge("");

    # gets all the items from the fridge
    $items = getFridge();

    # parses all the fridge items into templated format
    $itemList = "";
    foreach ($items as $item) {
        $fridgeItem = new Template("elements/fridgeItem.tpl");
        $fridgeItem->set("item", $item);
        $fridgeItem->set("remove", "fridge.php?rmIngr=$item");
        $itemList = $itemList . $fridgeItem->output();
    }

    $form = new Template("elements/fridge.tpl");
    $form->set("diet", file_get_contents("elements/form-diet.tpl"));
    $form->set("intolerances", file_get_contents("elements/form-intolerances.tpl"));
    $form->set("items", $itemList);

    $content = $form->output();

	$layout = new Template("index.tpl");
	$layout->set("title", "Fridge");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);

	echo($layout->output());
?>