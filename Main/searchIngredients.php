<?php
	session_start();
	session_regenerate_id();

	require_once("main.php");

	$bar = new Template("elements/searchIngredientBar.tpl");

	if (isset($_SESSION) && !isset($_GET["searchBtn"])) {
		$user = getUserDB();

		$usePref = 1;
		if (isset($user["use_fridge"])) {
			$usePref = $user["use_fridge"];
		}

		if ($usePref == 1) {
			$bar->set("UsePreferences", "checked");
		}
	} elseif (isset($_GET["searchBtn"])) {
		if (isset($_GET["useFridge"])) {
			$bar->set("UsePreferences", "checked");
		} else {
			$bar->set("UsePreferences", "");
		}
	}

	if (isset($_GET["includeIngredients"])) {
		$bar->set("includeIngredients", $_GET["includeIngredients"]);
	} else {
		$bar->set("includeIngredients", "");
	}


	$grid = new Template("elements/resultsGrid.tpl");

	if (array_key_exists("searchBtn", $_GET)) {
		$URL = getSearchIngredient();
		console_log($URL);
		$json_string = makeCURL($URL);
			// parse JSON into useable objects
		$json = json_decode($json_string);
		console_log("$json_string");

		if(isset($_POST['number'])){
			$number_of_results = $_POST['number'];
		}
		else{
			$number_of_results = 10;
		}
		if(isset($_POST['offset'])){
			$offset = $_POST['offset'];
		}
		else{
			$offset = 0;
		}

		$shown_recipes = array();
		$results = "";
		if (is_countable($json)) {
			if (count($json) != 0) {
				if(($offset > count($json) - $number_of_results) && (count($json) - $number_of_results >= 0)){
					$offset = $json - $number_of_results;
				}
				for ($i = $offset; $i < $number_of_results + $offset && $i < count($json); $i++) {
					$recipe = $json[$i];
					if(!in_array($recipe->title, $shown_recipes)){
						array_push($shown_recipes, $recipe->title);
						$result = new Template("elements/searchResult.tpl");
						$result->set("link", "redirect_to_recipe.php/?recipe_id=$recipe->id");
						$result->set("title", "$recipe->title");
						$result->set("img", "$recipe->image");
						$results = $results . $result->output();
					}
				}
				$grid->set("results", $results);
			} else {
				$grid->set("results", "No results found.");
			}
		} else {
			$grid->set("results", "No results found.");
		}



	}

	$page = new Template("elements/page-search.tpl");
	$page->set("searchBar", $bar->output());
	$page->set("searchResults", $grid->output());

	$content = $page->output();

	$layout = new Template("index.tpl");
	$layout->set("title", "Search");
	$layout->set("user", getUserElements());
	$layout->set("content", $content);
	echo($layout->output());
?>
