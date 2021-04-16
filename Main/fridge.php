<?php
    session_start();
	session_regenerate_id();
	require_once("main.php");
    if(!isset($_SESSION['user'])) {
		// if no valid session id go to login
		header("Location: userLogin.php");
	}

    # check if adding or removing an item
    if (isset($_GET["rmIngr"])) {
        removeFridge($_GET["rmIngr"]);
    }

    if (isset($_GET["addIngr"])) {
        addFridge($_GET["addIngr"]);
    }

    if (isset($_GET["updateBtn"])) {
        updateUserDB();
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

    $intolerances_layout = new Template("elements/form-intolerances.tpl");
    $diets_layout = new Template("elements/form-diet.tpl");
    $form = new Template("elements/fridge.tpl");

    $user = getUserDB();

    $intls = array();
    if (isset($user["intls"])) {
        $intls = preg_split("/(\s*),(\s*)/", $user["intls"], -1, PREG_SPLIT_NO_EMPTY);
    }
    foreach ($intls as $intl) {
        $intolerances_layout->set($intl, "checked");
    }

    $diet = "Unrestricted";
    if (isset($user["diets"])) {
        $diet = $user["diets"];
    }
    $diets_layout->set($diet, "checked");

    $usePref = 1;
    if (isset($user["use_fridge"])) {
        $usePref = $user["use_fridge"];
    }
    if ($usePref == 1) {
        $form->set("UsePreferences", "checked");
    }

    $form->set("intolerances", $intolerances_layout->output());
    $form->set("diet", $diets_layout->output());
    $form->set("items", $itemList);

    $content = $form->output();

	$layout = new Template("index.tpl");
	$layout->set("title", "Fridge");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);

	echo($layout->output());
?>
