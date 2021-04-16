<?php
	session_start();
	session_regenerate_id();

	require_once("main.php");

	$intolerances_layout = new Template("elements/form-intolerances.tpl");
	$diets_layout = new Template("elements/form-diet.tpl");

	$bar = new Template("elements/searchBar.tpl");

	if (isset($_SESSION)) {
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

		$bar->set("intolerances", $intolerances_layout->output());
		$bar->set("diet", $diets_layout->output());

	}

	$bar->set("cuisine", file_get_contents("elements/form-cuisine.tpl"));
	$bar->set("meal", file_get_contents("elements/form-meal.tpl"));

	$grid = new Template("elements/resultsGrid.tpl");

	if (array_key_exists("searchBtn", $_GET)) {
		$URL = getSearch();
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


		$results = "";
		$db_results = db_search();

		if (isset($json->totalResults)) {
			if ($json->totalResults != 0) {
				$recipes = $json->results;
				if(($offset > $json->totalResults - $number_of_results) && ($json->totalResults - $number_of_results >= 0)){
					$offset = $json->totalResults - $number_of_results;
				}
				for ($i = $offset; $i < $number_of_results + $offset && $i < count($recipes); $i++) {
					$recipe = $recipes[$i];

					$result = new Template("elements/searchResult.tpl");
					$result->set("link", "redirect_to_recipe.php/?recipe_id=$recipe->id");
					$result->set("title", "$recipe->title");
					$result->set("img", "$recipe->image");
					$results = $results . $result->output();

				}
			}
		}

		if (count($db_results) != 0) {
			for ($i = 0; $i < count($db_results); $i++) {
				$db_recipe = $db_results[$i];

				$result = new Template("elements/searchResult.tpl");
				$result->set("link", $db_recipe->link);
				$result->set("title", $db_recipe->title);
				$result->set("img", $db_recipe->image);
				$results = $results . $result->output();

			}
		}

		$grid->set("results", $results);
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
