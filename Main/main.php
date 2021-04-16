<?php

	#DATABASE CONFIG
	require_once("config.php");

	function console_log($msg) {
		echo("<script>console.log(\"$msg\");</script>");
	}

	#const API_KEY = "apiKey=8e545c9e5dd0403485f5b74f1c43622f";
	const API_KEY = "apiKey=fe7fe2e4a56344fdbde2f14b8d05b5b3";

	function getSearch() {
		$API = "https://api.spoonacular.com/recipes/complexSearch";
		// COMPILE REST OF REQUEST HERE
		//$INSTRUCTIONS = "&instructionsRequired=true";
		$RECIPE_INFO = "&addRecipeInformation=true";
		//$NUTRITION_INFO = "&addRecipeNutrition=true";
		$INSTRUCTIONS = "";
		//$RECIPE_INFO = "";
		$NUTRITION_INFO = "";
		$ARGS = "";
		foreach ($_GET as $key => $val) {
			if ($key == "searchBtn") {
				continue;
			} elseif ($val == "") {
				continue;
			} elseif ($key == "intolerances") {
				$intls = $val[0];
				for ($i = 1; $i < count($val); $i++) {
					$intls = $intls . ", " . $val[$i];
				}
				$ARGS = $ARGS . "&$key=$intls";
			} else {
				$ARGS = $ARGS . "&$key=$val";
			}
		}
		$items = array();
		if (isset($_GET["includeIngredients"])) {
			if ($_GET["includeIngredients"] != "") {
				$items = preg_split("/(\s*),(\s*)/", $_GET["includeIngredients"], -1, PREG_SPLIT_NO_EMPTY);
			}
		}
		if (isset($_GET["useFridge"])) {
			$items = array_merge($items, getFridge());
		}
		$INGRS = "";
		if (count($items) > 0) {
			$INGRS = "&includeIngredients=" . $items[0];
			for ($i = 1; $i < count($items); $i++) {
				$INGRS = $INGRS . ", " . $items[$i];
			}
		}
		return str_replace(" ", "%20", $API . "?" . API_KEY . "&fillIngredients=true" . $ARGS . $INGRS . $INSTRUCTIONS . $RECIPE_INFO . $NUTRITION_INFO);
	}

	function getSearchIngredient() {
		$API = "https://api.spoonacular.com/recipes/findByIngredients";
		// COMPILE REST OF REQUEST HERE
		//$INSTRUCTIONS = "&instructionsRequired=true";
		$RECIPE_INFO = "&addRecipeInformation=true";
		//$NUTRITION_INFO = "&addRecipeNutrition=true";
		$INSTRUCTIONS = "";
		//$RECIPE_INFO = "";
		$NUTRITION_INFO = "";
		$ARGS = "";
		$items = array();
		if (isset($_GET["includeIngredients"])) {
			if ($_GET["includeIngredients"] != "") {
				$items = preg_split("/(\s*),(\s*)/", $_GET["includeIngredients"], -1, PREG_SPLIT_NO_EMPTY);
			}
		}
		if (isset($_GET["useFridge"])) {
			$items = array_merge($items, getFridge());
		}
		$INGRS = "";
		if (count($items) > 0) {
			$INGRS = "&ingredients=" . $items[0];
			for ($i = 1; $i < count($items); $i++) {
				$INGRS = $INGRS . ", " . $items[$i];
			}
		}
		return str_replace(" ", "%20", $API . "?" . API_KEY . "&ranking=2" . $ARGS . $INGRS . $INSTRUCTIONS . $RECIPE_INFO . $NUTRITION_INFO);
	}

	function makeCURL($URL) {
		///---API---///
		// create client url (CURL)
		$ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, $URL);
		// stop echo to webpage
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		// execute request
		$head = curl_exec($ch);;
		// get request status info
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		// close request like a good boy
		curl_close($ch);
		// write status to console for debug
		if ($httpCode == 401) {
			console_log("<br>HTTP ERROR 401: BAD REQUEST");
			return;
		}
		return $head;
	}

	function getUserElements() {
		if(isset($_SESSION['user'])) {
			return "
				<a href='#.php'>" . $_SESSION['user'] . "</a>
				<a href=\"fridge.php\">My Fridge</a>
				<a href=\"fav.php\">Favorites</a>
				<a href=\"mealplan.php\">Meal Plan</a>
				<a href='logout.php' class ='login'>Logout</a>
			";
		} else {
			return "
				<a href='userLogin.php' class='login'>Login</a>
				<a href='signUp.php'>Register</a>
			";
		}
	}

	function show_recipe($recipe_id){

		/**
		 * Store it if not exist, and display it directly from db
		 * Add a column "api_id" for table Recipe to check whether exists
		 * Add a new table to store relation between user and fav recipes
		 */
		if(isset($_SESSION['id'])){
			$user_id = $_SESSION['id'];
		}

		$conn = getConnSQL();

		$check = mysqli_query($conn, "SELECT * FROM Recipe WHERE recipe_id='$recipe_id'");

		// if not exist, store it first
		if(mysqli_num_rows($check)==0){

			$URL = "https://api.spoonacular.com/recipes/" . $recipe_id . "/information" . "?" . API_KEY;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $URL);
			$response = curl_exec ($ch);
			curl_close ($ch);

			$data = json_decode($response, true);

			$originalId = $data['id'];
			$vegetarian = $data['vegetarian']=="true" ? true: false;
			$vegan = $data['vegan']=="true" ? true: false;
			$glutenFree = $data['glutenFree']=="true" ? true: false;
			$dairyFree = $data['dairyFree']=="true" ? true: false;
			$veryHealthy = ($data['veryHealthy']=="true") ? true: false;
			$cheap = $data['cheap']=="true" ? true: false;
			// $calories = intval($data['calories']);
			//$ketogenic = $data['ketogenic']=="true" ? true: false;
			$sustainable = $data['sustainable']=="true" ? true: false;
			$veryPopular = $data['veryPopular']=="true" ? true: false;

			$price_per_serving = intval($data['pricePerServing']);
			$health_score = intval($data['healthScore']);
			$aggregate_lies = intval($data['aggregateLikes']);
			$license = str_replace("'", "''", $data['license']);
			$image_type = $data['imageType'];
			if($data['cuisines']){
				$cuisine_type = $data['cuisines'][0];
			}
			else{
				$cuisine_type = "None";
			}

			// $dishType

			$img_url = $data['image'];
			$title = str_replace("'", "''", $data['title']);
			$servings = $data['servings'];
			$readyTime = $data['readyInMinutes'];
			$source_url = $data['sourceUrl'];
			$instruction = strip_tags($data['instructions']);
			$instruction1 = str_replace("'", "''", $instruction);

			mysqli_query($conn, "INSERT IGNORE INTO Recipe(recipe_id, title, cuisine_type, meal_type, image_url,
								number_of_servings, ready_in_minutes, instructions)
			VALUES('$originalId', '$title', '$cuisine_type', 'None', '$img_url', '$servings', '$readyTime', '$instruction1')");

			$id = mysqli_insert_id($conn);

			// add a new table FavRecipes with columns id, favRecipeId(store recipe id), favBy(store user id)

			foreach($data['extendedIngredients'] as $d){

				$nm = $d['name'];
				$amount = $d['amount'];
				$original = str_replace("'", "''", $d['original']);
				$unit = $d['unit'];
				$recipeId = $id;
				$image = $d['image'];

				// seems api doesn't provide images for ingredients
				$id_ = mysqli_insert_id($conn);
				mysqli_query($conn, "INSERT IGNORE INTO Ingredients(recipe_id, ingr_name, ingr_amount, ingr_unit)
						VALUES('$recipeId','$original', '$amount', '$unit')");

			}
		}

		// otherwise, display it directly from db
		else{
			$id = mysqli_fetch_assoc($check)['recipe_id'];
		}

		$output = mysqli_query($conn, "SELECT * FROM Recipe WHERE recipe_id='$id'");
		$row = mysqli_fetch_assoc($output);
		$title1 = $row['title'];
		$img_url1 = $row['image_url'];
		$servings1 = $row['number_of_servings'];
		$readyTime1 = $row['ready_in_minutes'];
		$instructions1 = $row['instructions'];

		$outputFav = mysqli_query($conn, "SELECT * FROM FavRecipes WHERE fav_recipe_id='$id'");

		if(!$outputFav && $outputFav != null && mysqli_num_rows($outputFav)!=0){
			$fav = mysqli_fetch_assoc($outputFav)['fav_by'];
		}
		else{
			$fav = '';
		}

		$outputIngr = mysqli_query($conn, "SELECT * FROM Ingredients WHERE recipe_id = '$id' ");

		$ingr = array();
		while ($row = mysqli_fetch_assoc($outputIngr)) {
			array_push($ingr, $row['ingr_name']);
		}

			$elements = "
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
			<script src='script.js'></script>
			<link rel=\"stylesheet\" type=\"text/css\" href=\"css/search.css\">
			<div class=\"searchResults\">";

			$elements = $elements . "<h1>".$title1."</h1>";
			if(isset($_SESSION['id'])){
				$userId = strval($_SESSION['id']);
			}
			$a = strval(uniqid());
			$b = strval($id);

			if($fav == $userId ){
				$elements = $elements . "<input onchange='fav(`$b`,`$userId`,`$a`)' id='$a' name='checkbox' class='checkbox' type='checkbox' checked='checked'>
				<label id='heart' for='$a'></label>";
			}
			else{
				$elements = $elements . "<input onchange='fav(`$b`,`$userId`,`$a`)' id='$a' name='checkbox' class='checkbox' type='checkbox'>
				<label id='heart' for='$a'></label>";
			}

			$outputPlan = mysqli_query($conn, "SELECT * FROM MealPlan WHERE user_id='$user_id' AND recipe_id = '$id' AND meal_date!=''");

			if(!$outputPlan && $outputPlan != null && mysqli_num_rows($outputPlan)!=1){
				$date2 = date('Y-m-d');
			$elements = $elements . "<input onchange='mealPlan(`$b`,`$userId`,``, `1`)' id='date' value='$date2' type='date'>" .
			"<input onchange='mealPlan(`$b`,`$userId`,`breakfast`, `0`)' id='breakfast' type='checkbox'>
				<label for='breakfast'>breakfast</label>" .
				"<input onchange='mealPlan(`$b`,`$userId`,`lunch`, `0`)' id='lunch' type='checkbox'>
				<label for='lunch'>lunch</label>" .
				"<input onchange='mealPlan(`$b`,`$userId`,`dinner`, `0`)' id='dinner' type='checkbox'>
				<label for='dinner'>dinner</label>"
				;
			}
			else if (!$outputPlan && $outputPlan != null){
				$isBreakfast;
				$isLunch;
				$isDinner;

				while($row=mysqli_fetch_assoc($outputPlan)){
					$mealDate = $row['meal_date'];
					$mealTime = $row['meal_time'];
				}
				if($mealTime=='breakfast'){
					$isBreakfast='checked';
				}
				else if($mealTime=='lunch'){
					$isLunch='checked';
				}
				else{
					$isDinner='checked';
				}
				$elements = $elements . "<input onchange='mealPlan(`$b`,`$userId`,``, `1`)' id='date' value='$mealDate' type='date'>" .
				"<input onchange='mealPlan(`$b`,`$userId`,`breakfast`, `0`)' id='breakfast' ".$isBreakfast." type='checkbox'>
				<label for='breakfast'>breakfast</label>" .
				"<input onchange='mealPlan(`$b`,`$userId`,`lunch`, `0`)' id='lunch' " . $isLunch . " type='checkbox'>
				<label for='lunch'>lunch</label>" .
				"<input onchange='mealPlan(`$b`,`$userId`,`dinner`, `0`)' id='dinner' " . $isDinner . " type='checkbox'>
				<label for='dinner'>dinner</label>" ;
			}


			$elements = $elements . "<div id='image_container'><img src='".$img_url1."'></div>";
			$elements = $elements . "<p><b>Ingredients: </b></p>";
			foreach($ingr as $ingredient1){
				$elements = $elements . "<p>".$ingredient1."</p>";
			}

			$elements = $elements . "<p><b>Number of servings: </b>".$servings1."</p>
			<p><b>Ready in minutes: </b>".$readyTime1."</p>
			<p><b>Instructions: </b></br>".$instructions1."</p></div>" ."</div>";

			return $elements;
	}


	function showFav() {

		$conn = getConnSQL();
		$userId = $_SESSION['id'];

		$result = $conn->query("SELECT * FROM FavRecipes WHERE fav_by = '$userId'");

		if ($result->num_rows > 0) {
			$favRecipeId = array();
			while($row = $result->fetch_assoc()) {
				array_push($favRecipeId, $row['fav_recipe_id']);
			}

			$elements = "
					<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
					<script src='script.js'></script>
					<link rel=\"stylesheet\" type=\"text/css\" href=\"css/search.css\">
					<div class=\"searchResults\">";

			foreach($favRecipeId as $recipeId) {
				$query1 = mysqli_query($conn, "SELECT * FROM Recipe WHERE recipe_id='$recipeId'");

				while($row = mysqli_fetch_assoc($query1)){

					$id = $row['recipe_id'];
					$title = $row['title'];
					$image = $row['image_url'];
					$servings = $row['number_of_servings'];
					$readyTime = $row['ready_in_minutes'];
					$instructions = $row['instructions'];

					$a = uniqid();
					$b = strval($id);

					$elements = $elements . "<input id='$a' onchange='fav(`$b`, `$userId` , `$a`)' name='checkbox' class='checkbox'  type='checkbox' checked='checked'>"
					."<label for='$a'></label>";

					$elements = $elements . "<h1>".$title."</h1>";
					$elements = $elements . "<div id='image_container'><img src='".$image."'></div>";
					// $elements = $elements . "<p><b>Ingredients: </b></p>";
					$outputIngr = mysqli_query($conn, "SELECT * FROM Ingredients WHERE recipe_id = '$id' ");

					$ingr = array();
					while ($row = mysqli_fetch_assoc($outputIngr)) {
						array_push($ingr, $row['ingr_name']);
					}
					$elements = $elements . "<p><b>Ingredients: </b></p>";
					foreach($ingr as $ingredient1){
						$elements = $elements . "<p>".$ingredient1."</p>";
					}

					$elements = $elements . "<p><b>Number of servings: </b>".$servings."</p>
					<p><b>Ready in minutes: </b>".$readyTime."</p>
					<p><b>Instructions: </b></br>".$instructions."</p></div>" ;
				}
			}
			$elements = $elements ."</div>";
			return $elements;

		} else {
			return "<h1 style='color: white; width: 100%; padding-top: 20px; text-align:center;'>You haven't added anything to favorites</h1>";
		}
	}

	function mealPlan($date) {

		$conn = getConnSQL();

		$user_id = $_SESSION["id"];

		$query = mysqli_query($conn, "SELECT * FROM MealPlan WHERE user_id = '$user_id' AND meal_date = '$date' ");
		if(!$query){
			$breakfast = array();
			$lunch = array();
			$dinner = array();
			while($row = mysqli_fetch_assoc($query)){
				if($row['meal_time']=='breakfast'){
					array_push($breakfast, $row['recipe_id']);
				}
				else if($row['meal_time']=='lunch') {
					array_push($lunch, $row['recipe_id']);
				}
				else {
					array_push($dinner, $row['recipe_id']);
				}
			}
			$breakfast_id = $breakfast[0];
			$select1 = mysqli_query($conn, "SELECT * FROM Recipe WHERE id = '$breakfast_id'");
			$row1 = mysqli_fetch_assoc($select1);
			$img1 = $row1['image_url'];
			$time1 = $row1['ready_in_minutes'];
			$title1 = $row1['title'];
			$price1 = $row1['price_per_serving'] * 0.73 ;
			$b_api_id1 = $row1['api_id'];

			$breakfast_id_1 = $breakfast[1];
			$select1_1 = mysqli_query($conn, "SELECT * FROM Recipe WHERE id = '$breakfast_id_1'");
			$row1_1 = mysqli_fetch_assoc($select1_1);
			$img1_1 = $row1_1['image_url'];
			$time1_1 = $row1_1['ready_in_minutes'];
			$title1_1 = $row1_1['title'];
			$price1_1 = $row1_1['price_per_serving'] * 0.73;
			$b_api_id1_1 = $row1_1['api_id'];

			$lunch_id = $lunch[0];
			$select2 = mysqli_query($conn, "SELECT * FROM Recipe WHERE id = '$lunch_id'");
			$row2 = mysqli_fetch_assoc($select2);
			$img2 = $row2['image_url'];
			$time2 = $row2['ready_in_minutes'];
			$title2 = $row2['title'];
			$price2 = $row2['price_per_serving'] * 0.73;
			$b_api_id2 = $row2['api_id'];

			$lunch_id_1 = $lunch[1];
			$select2_1 = mysqli_query($conn, "SELECT * FROM Recipe WHERE id = '$lunch_id_1'");
			$row2_1 = mysqli_fetch_assoc($select2_1);
			$img2_1 = $row2_1['image_url'];
			$time2_1 = $row2_1['ready_in_minutes'];
			$price2_1 = $row2_1['price_per_serving'] * 0.73;
			$b_api_id2_1 = $row2_1['api_id'];

			$dinner_id = $dinner[0];
			$select3 = mysqli_query($conn, "SELECT * FROM Recipe WHERE id = '$dinner_id'");
			$row3 = mysqli_fetch_assoc($select3);
			$img3 = $row3['image_url'];
			$time3 = $row3['ready_in_minutes'];
			$title3 = $row3['title'];
			$price3 = $row3['price_per_serving'] * 0.73;
			$b_api_id3 = $row3['api_id'];

			$dinner_id_1 = $dinner[1];
			$select3_1 = mysqli_query($conn, "SELECT * FROM Recipe WHERE id = '$dinner_id_1'");
			$row3_1 = mysqli_fetch_assoc($select3_1);
			$img3_1 = $row3_1['image_url'];
			$time3_1 = $row3_1['ready_in_minutes'];
			$title3_1 = $row3_1['title'];
			$price3_1 = $row3_1['price_per_serving'] * 0.73;
			$b_api_id3_1 = $row3_1['api_id'];

			$element = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			<script src="script.js"></script>
			<link rel="stylesheet" href="mealplan.css">
			<link rel="stylesheet" type="text/css" href="css/search.css">
			<title>MealPlan</title><p id="mealplan_title">Meal Plan</p>';

			$element .= '
			<p id="date_p">
				<input onchange="refresh()" id="mealDate" value="' .  $date . '" type="date">
			</p>';

			if($breakfast_id!=null) {
				$element.='<table id="mealplan_brekfast">
				<tr>
				<td id="breakfast" rowspan="0">Breakfast</td>
					<td>
					<a href="recipe.php?recipe_id=' . $b_api_id1 . '">
						<img id="recipe_image" src="' .  $img1 . '" alt="">
						</a>
							<p id="recipe_name">'.$title1.'</p>
							<p id="recommend">Recommend</p>
							<p id="calorie">Time :</p>
							<p id="calorie_num">'.$time1.' min</p>
							<p id="expected_cost_num">£ '.$price1.'</p>
							<p id="uploader">Uploader</p>
					</td>
				</tr>';
			}
			else {
				$element.='<table id="mealplan_brekfast">
				<tr>
				<td id="breakfast" rowspan="0">Breakfast</td>
					<td>
					</td>
				</tr>';
			}
			if($breakfast_id_1!=null) {
				$element.='<tr>
				<td>
					<a href="recipe.php?recipe_id=' . $b_api_id1_1 . '">
						<img id="recipe_image" src="' .  $img1_1 . '" alt="">
						</a>
						<p id="recipe_name">'.$title1_1.'</p>
						<p id="recommend">Recommend</p>
						<p id="calorie">Time :</p>
						<p id="calorie_num">'.$time1_1.' min</p>
						<p id="expected_cost_num">£ '.$price1_1.'</p>
						<p id="uploader">Uploader</p>

				</td>
			</tr>
			</table>';
			}
			else {
				$element.='<tr>
				<td>
				</td>
			</tr>
			</table>';
			}
			if($lunch_id!=null) {
				$element.='<table id="mealplan_lunch">
				<tr>
				<td id="lunch" rowspan="0">Lunch</td>
				<td>
					<a href="recipe.php?recipe_id=' . $b_api_id2 .'">
						<img id="recipe_image" src="' . $img2 . '" alt="">
						</a>
						<p id="recipe_name">'.$title2.'</p>
						<p id="recommend">Recommend</p>
						<p id="calorie">Time :</p>
						<p id="calorie_num">'.$time2.' min</p>
						<p id="expected_cost_num">£ '.$price2.'</p>
						<p id="uploader">Uploader</p>
				</td>
			</tr>';
			}
			else {
				$element.='<table id="mealplan_lunch">
				<tr>
				<td id="lunch" rowspan="0">Lunch</td>
				<td>
				</td>
			</tr>';
			}
			if($lunch_id_1!=null) {
				$element.='<tr>
				<td>
					<a href="recipe.php?recipe_id=' . $b_api_id2_1 .'">
						<img id="recipe_image" src="' . $img2_1 . '" alt="">
						</a>
						<p id="recipe_name">'.$title2_1.'</p>
						<p id="recommend">Recommend</p>
						<p id="calorie">Time :</p>
						<p id="calorie_num">'.$time2_1.' min</p>
						<p id="expected_cost_num">£ '.$price2_1.'</p>
						<p id="uploader">Uploader</p>
				</td>
			</tr>
			</table>';
			}
			else {
				$element.='<tr>
				<td>
				</td>
			</tr>
			</table>';
			}
			if($dinner_id!=null) {
				$element.='<table id="mealplan_dinner">
				<tr>
					<td id="dinner" rowspan="0">Dinner</td>
					<td>
						<a href="recipe.php?recipe_id=' . $b_api_id3 .'">
							<img id="recipe_image" src="' . $img3 . '" alt="">
						</a>
							<p id="recipe_name">'.$title3.'</p>
							<p id="recommend">Recommend</p>
							<p id="calorie">Time :</p>
							<p id="calorie_num">'.$time3.' min</p>
							<p id="expected_cost_num">£ '.$price3.'</p>
							<p id="uploader">Uploader</p>
					</td>
				</tr>';
			}
			else {
				$element.='<table id="mealplan_dinner">
				<tr>
					<td id="dinner" rowspan="0">Dinner</td>
					<td>
					</td>
				</tr>';
			}
			if($dinner_id_1!=null) {
				$element.='<tr>
				<td>
				<a href="recipe.php?recipe_id=' . $b_api_id3_1 .'">
						<img id="recipe_image" src="' . $img3_1 . '" alt="">
				</a>
						<p id="recipe_name">'.$title3_1.'</p>
						<p id="recommend">Recommend</p>
						<p id="calorie">Time :</p>
						<p id="calorie_num">'.$time3_1.' min</p>
						<p id="expected_cost_num">£ '.$price3_1.'</p>
						<p id="uploader">Uploader</p>
				</td>
			</tr>
		</table>';
			}
			else {
				$element.='<tr>
				<td>
				</td>
			</tr>
		</table>';
			}

		return $element;
	}
	else{
		return "<h1 style='color: white; width: 100%; padding-top: 20px; text-align:center;'>You haven't added anything to your mealplan</h1>";
	}
}


	// simple data structure for db search result
	class DBResult {
		var $link;
		var $title;
		var $img;
	}

	function db_search() {
		$conn = getConnSQL();
		$database = getDatabase();
		$sql = "USE $database";
		$conn->query($sql);

		$query = $_GET['query'];

		$recipe_check_query = "SELECT * FROM Recipe WHERE (`title` LIKE '%".$query."%')";
		$result = mysqli_query($conn, $recipe_check_query);
		$db_recipes = array();
		while($recipe = mysqli_fetch_assoc($result)){
			$db_recipe = new DBResult();
			$db_recipe->link = "redirect_to_recipe.php/?db_id=" . $recipe['recipe_id'];
			$db_recipe->title = $recipe['title'];
			$db_recipe->image = $recipe['image_url'];

			$db_recipes[] = $db_recipe;
		}
		return $db_recipes;
	}

	function db_upload() {
		$file = $_FILES["pictureInput"];
		$title = $_POST["titleInput"];
		$description = $_POST["descriptionInput"];
		$time = $_POST["timeInput"];
		$serving = $_POST["servingInput"];
		$category = $_POST["categoryInput"];
		$ingredients = $_POST["ingredientsInput"];
		$uploadedBy = $_SESSION['id']; //user id

		// move uploaded img to uploads/ and store ref

		$path = "uploads/" . uniqid() . basename($file["name"]);
		$path = str_replace(" ", "_", $path);
		$type = pathinfo($path, PATHINFO_EXTENSION);

		move_uploaded_file($file["tmp_name"], $path);

		$sql = "INSERT INTO Recipe(ingredients, description, time, 	cuisine_type, image_url, title, number_of_servings, user_id)
		VALUES('$ingredients', '$description', '$time', '$category', '$path', '$title', '$serving', '$uploadedBy')";

		if($conn->query($sql))
		{
			echo("<h3 id='uploadSucess' style='text-align:center;'>Uploaded sucessfully<h3>");
			header( "refresh:2;url=upload.php" );
		}
		else{
			echo("Error: " . $conn->error);
		}

	}


	class Template {
    	/**
    	 * The filename of the template to load.
    	 *
    	 * @access protected
    	 * @var string
    	 */
        protected $file;

        /**
         * An array of values for replacing each tag on the template (the key for each value is its corresponding tag).
         *
         * @access protected
         * @var array
         */
        protected $values = array();

        /**
         * Creates a new Template object and sets its associated file.
         *
         * @param string $file the filename of the template to load
         */
        public function __construct($file) {
            $this->file = $file;
        }

        /**
         * Sets a value for replacing a specific tag.
         *
         * @param string $key the name of the tag to replace
         * @param string $value the value to replace
         */
        public function set($key, $value) {
            $this->values[$key] = $value;
        }

        /**
         * Outputs the content of the template, replacing the keys for its respective values.
         *
         * @return string
         */
        public function output() {
        	/**
        	 * Tries to verify if the file exists.
        	 * If it doesn't return with an error message.
        	 * Anything else loads the file contents and loops through the array replacing every key for its value.
        	 */
            if (!file_exists($this->file)) {
            	return "Error loading template file ($this->file).<br />";
            }
            $output = file_get_contents($this->file);

            foreach ($this->values as $key => $value) {
            	$tagToReplace = "[@$key]";
            	$output = str_replace($tagToReplace, $value, $output);
            }

            return $output;
        }

        /**
         * Merges the content from an array of templates and separates it with $separator.
         *
         * @param array $templates an array of Template objects to merge
         * @param string $separator the string that is used between each Template object
         * @return string
         */
        static public function merge($templates, $separator = "\n") {
        	/**
        	 * Loops through the array concatenating the outputs from each template, separating with $separator.
        	 * If a type different from Template is found we provide an error message.
        	 */
            $output = "";

            foreach ($templates as $template) {
            	$content = (get_class($template) !== "Template")
            		? "Error, incorrect type - expected Template."
            		: $template->output();
            	$output .= $content . $separator;
            }

            return $output;
        }
    }


	/*
	--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	FRIDGE
	*/

	function addFridge($item) {
		$conn = getConnSQL();
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$userid = $_SESSION["id"];

		$sql ="INSERT INTO Fridge (user_id, ingredient) VALUES ($userid, '$item')";

		$result = $conn->query($sql);
		if (!$result) {
			echo "Error inserting record: " . mysqli_error($conn);
		}
		$conn->close();
	}

	function removeFridge($item) {
		$conn = getConnSQL();
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		$userid = $_SESSION["id"];

		$sql ="DELETE FROM Fridge WHERE user_id = $userid AND INGREDIENT = '$item'";
		$result = $conn->query($sql);
		$conn->close();
	}

	function getFridge() {
		$conn = getConnSQL();
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$userid = $_SESSION["id"];

		$sql ="SELECT * FROM Fridge WHERE user_id = $userid";
		$result = $conn->query($sql);
		$items = array();
		if ($result) {
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$items[] = $row["ingredient"];
				}
			}
		}

		$conn->close();
		return $items;
	}

	function getUserDB() {
		if (!isset($_SESSION["id"])) {
			return NULL;
		}
		$conn = getConnSQL();

		$user_id = $_SESSION["id"];
		$query = "SELECT * FROM User WHERE id = $user_id";
		$result = mysqli_query($conn, $query);
		$user = mysqli_fetch_assoc($result);
		return $user;
	}

	function updateUserDB() {
		if (!isset($_SESSION)) {
			return NULL;
		}
		$user_id = $_SESSION["id"];

		$intolerances = "NULL";
		if (isset($_GET["intolerances"])) {
			$intls_array = $_GET["intolerances"];
			$intolerances = "";
			if (count($intls_array) > 0) {
				$intolerances = $intls_array[0];
			}
			for ($i = 1; $i < count($intls_array); $i++) {
				$intolerances = $intolerances . "," . $intls_array[$i];
			}
			$intolerances = "'" . $intolerances . "'";
		}
		$diet = "NULL";
		if (isset($_GET["diet"])) {
			if ($_GET["diet"] != "Unrestricted") {
				$diet = $_GET["diet"];
				$diet = "'" . $diet . "'";
			}
		}

		$usePref = 0;
		if (isset($_GET["usePreferences"])) {
			$usePref = 1;
		}

		$conn = getConnSQL();
		$query =
			"UPDATE User
			SET intls = $intolerances,
		 	diets = $diet,
			use_fridge = $usePref
			WHERE
			id = $user_id";
		$result = mysqli_query($conn, $query);
	}

?>
