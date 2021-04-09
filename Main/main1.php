<?php
<<<<<<< HEAD
=======
	# set false if you're not Sam
	# sets db passwords for my setup
	const SAM = true;

>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61
	function console_log($msg) {
		echo("<script>console.log(\"$msg\");</script>");
	}

	const API_KEY = "apiKey=8e545c9e5dd0403485f5b74f1c43622f";

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
			}
			$ARGS = $ARGS . "&$key=$val";
		}
		return str_replace(" ", "%20", $API . "?" . API_KEY . $ARGS . $INSTRUCTIONS . $RECIPE_INFO . $NUTRITION_INFO);
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
				<a href=\"#\">Meal Plan</a>
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

		$localSQL = true;
		if ($localSQL) {
			$servername = "localhost";
			$username   = "root";
			$password   = "root";
			if (SAM == true) {
				$password = "";
			}
            $database   = "recipeasy";
		} else {
			$servername = "dbhost.cs.man.ac.uk";
			$username   = "e95562sp";
			$password   = "STORED_recipes+";
			$database   = "2020_comp10120_y14";
		}

		$conn = mysqli_connect($servername, $username, $password, $database);

		$check = mysqli_query($conn, "SELECT * FROM Recipe WHERE api_id='$recipe_id'");

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
			$calories = $data['calories'];
			$ketogenic = $data['ketogenic']=="true" ? true: false;
			$sustainable = $data['sustainable']=="true" ? true: false;
			$veryPopular = $data['veryPopular']=="true" ? true: false;

			$price_per_serving = intval($data['pricePerServing']);
			$health_score = intval($data['healthScore']);
			$aggregate_lies = intval($data['aggregateLikes']);
			$license = str_replace("'", "''", $data['license']);
			$image_type = $data['imageType'];
			$cuisine_type = $data['cuisines'][0];
			// $dishType

			$img_url = $data['image'];
			$title = str_replace("'", "''", $data['title']);
			$servings = $data['servings'];
			$readyTime = $data['readyInMinutes'];
			$source_url = $data['sourceUrl'];
			$instruction = strip_tags($data['instructions']);
			$instruction1 = str_replace("'", "''", $instruction);

			$result = mysqli_query($conn, "INSERT IGNORE INTO Recipe(api_id, vegetarian, vegan, gluten_free, dairy_free, very_healthy, cheap, ketogenic, sustainable, very_popular, calories, price_per_serving, health_score, aggregate_lies, license, image_type, cuisine_type, title, image_url, source_site_url, number_of_servings, ready_in_minutes, description)
			VALUES('$originalId', '$vegetarian', '$vegan', '$glutenFree','$dairyFree','$veryHealthy' , '$cheap', '$ketogenic', '$sustainable' , '$veryPopular', '$calories', '$price_per_serving', '$health_score', '$aggregate_lies', '$license', '$image_type', '$cuisine_type',
			'$title', '$img_url', '$source_url', '$servings', '$readyTime', '$instruction1')");

			$id = mysqli_insert_id($conn);

			// add a new table FavRecipes with columns id, favRecipeId(store recipe id), favBy(store user id)
			mysqli_query($conn, "INSERT IGNORE INTO FavRecipes(favRecipeId, favBy) VALUES('$id', '')");

			foreach($data['extendedIngredients'] as $d){

				$nm = $d['name'];
				$amount = $d['amount'];
				$original = str_replace("'", "''", $d['original']);
				$unit = $d['unit'];
				$recipeId = $id;
				$image = $d['image'];

				mysqli_query($conn, "INSERT IGNORE INTO ExtendedIngredient(name, amount, original, unit, recipe_id)
				VALUES('$nm', '$amount', '$original', '$unit', '$recipeId')")or die(mysqli_error($conn));

				// seems api doesn't provide images for ingredients
				$id_ = mysqli_insert_id($conn);
				mysqli_query($conn, "INSERT IGNORE INTO ingredient(name, image, extended_ingredient_id) VALUES('$nm', '$image', '$id_')");

			}
		}

		// otherwise, display it directly from db
		else{
			$id = mysqli_fetch_array($check)['id'];
		}

		$output = mysqli_query($conn, "SELECT * FROM Recipe WHERE id='$id'");
		$row = mysqli_fetch_array($output);
		$title1 = $row['title'];
		$img_url1 = $row['image_url'];
		$servings1 = $row['number_of_servings'];
		$readyTime1 = $row['ready_in_minutes'];
		$instructions1 = $row['description'];

		$outputFav = mysqli_query($conn, "SELECT * FROM FavRecipes WHERE favRecipeId='$id'");

		if(mysqli_num_rows($outputFav)!=0){
			$fav = mysqli_fetch_array($outputFav)['favBy'];
		}
		else{
			$fav = '';
		}

		$outputIngr = mysqli_query($conn, "SELECT * FROM ExtendedIngredient WHERE recipe_id = '$id' ");

		$ingr = array();
		while ($row = mysqli_fetch_array($outputIngr)) {
			array_push($ingr, $row['original']);
		}

			$elements = "
			<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
			<script src='script.js'></script>
			<link rel=\"stylesheet\" type=\"text/css\" href=\"css/search.css\">
			<div class=\"searchResults\">";

			$elements = $elements . "<h1>".$title1."</h1>";
			$userId = strval($_SESSION['id']);

			if($fav == $_SESSION['id']){
				$elements = $elements . "<input onchange='fav(" .strval($id).",".$userId.")' name='checkbox' class='checkbox' id='checkbox' type='checkbox' checked='checked'>
				<label for='checkbox'></label>";
			}
			else{
				$elements = $elements . "<input onchange='fav(" .strval($id).",".$userId.")' name='checkbox' class='checkbox' id='checkbox' type='checkbox'>
				<label for='checkbox'></label>";
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

		$localSQL = true;
		if ($localSQL) {
			$servername = "localhost";
			$username   = "root";
			$password   = "root";
			if (SAM == true) {
				$password = "";
			}
            $database   = "recipeasy";
		} else {
			$servername = "dbhost.cs.man.ac.uk";
			$username   = "e95562sp";
			$password   = "STORED_recipes+";
			$database   = "2020_comp10120_y14";
		}

		$conn = mysqli_connect($servername, $username, $password, $database);

		$userId = $_SESSION['id'];
		$query = mysqli_query($conn, "SELECT * FROM FavRecipes WHERE favBy='$userId'");

		$favRecipeId = array();
		while($row=mysqli_fetch_array($query)) {
			array_push($favRecipeId, $row['favRecipeId']);
		}

		foreach($favRecipeId as $recipeId) {
			$query1 = mysqli_query($conn, "SELECT * FROM Recipe WHERE id='$recipeId'");

			while($row = mysqli_fetch_array($query1)){

				$id = $row['id'];
				$title = $row['title'];
				$image = $row['image_url'];
				$servings = $row['number_of_servings'];
				$readyTime = $row['ready_in_minutes'];
				$instructions = $row['description'];

			$elements = $elements . "<h1>".$title."</h1>";
			$elements = $elements . "<div id='image_container'><img src='".$image."'></div>";
			// $elements = $elements . "<p><b>Ingredients: </b></p>";

			$outputIngr = mysqli_query($conn, "SELECT * FROM ExtendedIngredient WHERE recipe_id = '$id' ");

			$ingr = array();
			while ($row = mysqli_fetch_array($outputIngr)) {
				array_push($ingr, $row['original']);
			}

			$elements = $elements . "<p><b>Number of servings: </b>".$servings."</p>
			<p><b>Ready in minutes: </b>".$readyTime."</p>
			<p><b>Instructions: </b></br>".$instructions."</p></div>" ;
		}
	}
		$elements = $elements ."</div>";
		return $elements;
	}

	function db_config() {
		$localSQL = true;
		if ($localSQL) {
			$servername = "localhost";
			$username   = "root";
			$password   = "root";
			if (SAM == true) {
				$password = "";
			}
            $database   = "recipeasy";
		} else {
			$servername = "dbhost.cs.man.ac.uk";
			$username   = "e95562sp";
			$password   = "STORED_recipes+";
			$database   = "2020_comp10120_y14";
		}

		$conn = mysqli_connect($servername, $username, $password, $database);
	}

	// simple data structure for db search result
	class DBResult {
		var $link;
		var $title;
		var $img;
	}


	function db_search() {
		$localSQL = true;
		if ($localSQL) {
			$servername = "localhost";
			$username   = "root";
			$password   = "root";
			if (SAM == true) {
				$password = "";
			}
            $database   = "recipeasy";
		} else {
			$servername = "dbhost.cs.man.ac.uk";
			$username   = "e95562sp";
			$password   = "STORED_recipes+";
			$database   = "2020_comp10120_y14";
		}

		$conn = mysqli_connect($servername, $username, $password, $database);

		$sql = "USE $database";
		$conn->query($sql);

		$query = $_GET['query'];

		$recipe_check_query = "SELECT * FROM Recipe WHERE (`title` LIKE '%".$query."%')";
		$result = mysqli_query($conn, $recipe_check_query);
		$db_recipes = array();
		while($recipe = mysqli_fetch_assoc($result)){
			$db_recipe = new DBResult();
			$db_recipe->link = "recipe.php/?db_id=" . $recipe['id'];
			$db_recipe->title = $recipe['title'];
			$db_recipe->image = $recipe['image_url'];

			$db_recipes[] = $db_recipe;
		}
		return $db_recipes;
	}

	function db_upload() {
		include_once("db/config.php");

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

	class RecipeForm {

        public function createUploadForm() {

            $pictureInput = $this->createPictureInput();
            $titleInput = $this->createTitleInput();
            $ingredientsInput = $this->createIngredientsInput();
            $servingInput = $this->createServingInput();
            $timeInput = $this->createTimeInput();

            $categoriesInput = $this->createCategoriesInput();

            $descriptionInput = $this->createDescriptionInput();
            $uploadButton = $this->createUploadButton();

            return "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"css/upload.css\">
			<h1 >Upload Your Own Recipes!</h1>
			<div class=\"column\">
			<form action='processing.php' method='POST' enctype='multipart/form-data'>

			$pictureInput

			<div class = 'row'>

				<div class='col'>
				$categoriesInput
				</div>

				<div class='col'>
				$servingInput
				</div>

				<div class='col'>
				$timeInput
				</div>

			</div>

			$titleInput
			$ingredientsInput
			$descriptionInput
			$uploadButton

			</form>";

        }



        private function createPictureInput() {

            return "<div class='form-group'>
                <label for='photo'>Your photo</label><br>
                <input type='file' accept='.jpeg, .jpg, .png, .gif, .bmp, .webp, .raw, .ico, .tiff'
                class='form-control-file w-50' id='photo' name='pictureInput' required>
                <br><br>

                </div>";
                }

        private function createTitleInput() {
            return "<div class='form-group'>
            <br>
            <input class='form-control' type='text' placeholder='Title' name='titleInput' required>
            </div>";
        }

        private function createIngredientsInput() {
            return "<div class='form-group'>
            <input class='form-control' type='text' placeholder='Ingredients' pattern = '(\w+)(,*\s*\w+)*' name='ingredientsInput' required>
            </div>";
        }

        private function createDescriptionInput() {
            return "<div class='form-group'>
            <textarea class='textarea-control' style='resize: none;' placeholder='Instruction' name='descriptionInput' rows='10' required></textarea>
            </div>";
        }

        private function createServingInput() {

            return "<div class='outline'>
            <label class='form-label' for='serveNum'>Number of Servings</label>
            <input type='number' min='1' max='6' id='serveNum' name='servingInput' class='form-control input-sm' required/>
            </div>";
                }

        private function createTimeInput() {

            return "<div class='outline'>
            <label class='form-label' for='cookTime'>Cooking Time (min)</label>
            <input type='number' min='0' id='cookTime' name='timeInput' class='form-control input-sm' required/>
            </div>";
                }

        private function createCategoriesInput() {

            $html = "<div class='form-group'>
            <label class='form-label' for='select'>Cuisine Type</label>
            <select class='form-select' aria-label='Default select example' name='categoryInput' id='select' required>";

            for($i=0;$i<=11;$i++) {

                $category = ['British', 'French', 'Italian', 'Central Europe',
                'Caribbean', 'Eastern Europe', 'Chinese', 'Japanese', 'Indian',
                'South East Asia', 'American', 'Mexican'];

                $html .= "<option value=$category[$i]>$category[$i]</option>";

            }

            $html .= "</select></div>";

            return $html;


        }

        private function createUploadButton() {
            return "<div class='col text-center'><button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>
            </div>";
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

	function AddIngr(){
		$servername = "localhost";
		$username = "root";
		$password = "root";
<<<<<<< HEAD
		$database = "Fridge";
=======
		if (SAM == true) {
			$password = "";
		}
		$database = "recipeasy1";
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61
		$conn = mysqli_connect($servername, $username, $password, $database);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		  echo "Connected successfully";
		  $id = $_GET["userID"];
<<<<<<< HEAD
		  $ingredients = $_GET["addIngrList"];
			$ingredients = explode(",", $ingredients);
      $ingredientslength = count($ingredients);


			for ($i = 0; $i < $ingredientslength; $i++) {
				$sql = "INSERT INTO fridge2 (userID, INGREDIENT)
								VALUES ('$id','$ingredients[$i]')
								";
								if ($conn->query($sql))
								{
									echo ("Record created successfully");
								}
								else
								{
									echo("Error: " . $conn->error);
								}
			}

			$sql = "SELECT INGREDIENT FROM fridge2 where userID = $id";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row

				$output = "<table border = '2'>
										<th>Ingredient</th>
										";
				while($row = $result->fetch_assoc()) {
					$output .= "<tr>
												<td>$row[INGREDIENT]</td>

												</tr>";
				}
				$output .="</table>";
				echo ($output); }
				$conn->close();

=======
		  $ingredient1 = $_GET["addIngrList1"];
		  $ingredient2 = $_GET["addIngrList2"];
		  $ingredient3 = $_GET["addIngrList3"];
		  $ingredient4 = $_GET["addIngrList4"];
		  $ingredient5 = $_GET["addIngrList5"];

		$sql = "INSERT INTO fridge (userID, INGREDIENT_ONE,INGREDIENT_TWO,INGREDIENT_THREE,INGREDIENT_FOUR,INGREDIENT_FIVE)
				VALUES ('$id','$ingredient1', '$ingredient2', '$ingredient3', '$ingredient4', '$ingredient5')
				";
		if ($conn->query($sql))	{
		  //echo ("Record created successfully");
		} else {
		  //echo("Error: " . $conn->error);
		}

		$sql = "SELECT * FROM fridge where userID = $id";
		$result = $conn->query($sql);
		$output = "";
		if ($result->num_rows > 0) {
		  // output data of each row

		  $output = "<table border = '2'>
					  <th>UserId</th>
					  <th>Ingredient One</th>
					  <th>Ingredeint 2</th>
					  <th>Ingredient 3</th>
					  <th>Ingredient 4</th>
					  <th>Ingredient 5</th>
					  ";
		  while($row = $result->fetch_assoc()) {
			$output .= "<tr>
						  <td>$row[userID]</td>
						  <td>$row[INGREDIENT_ONE]</td>
						  <td>$row[INGREDIENT_TWO]</td>
						  <td>$row[INGREDIENT_THREE]</td>
						  <td>$row[INGREDIENT_FOUR]</td>
						  <td>$row[INGREDIENT_FIVE]</td>
						  </tr>";
		  }
		  $output .="</table>";
		} else {
		  $output = "0 results";
		}
		$conn->close();
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61
		return $output;
	  }

	  function RemoveIngr(){
	  }

	  function showFridge(){
		$servername = "localhost";
		$username = "root";
<<<<<<< HEAD
		$password = "root";
		$database = "Fridge";
=======
		$password = "root";if (SAM == true) {
			$password = "";
		}
		$database = "recipeasy1";
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61
		$conn = mysqli_connect($servername, $username, $password, $database);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		//echo "Connected successfully";

<<<<<<< HEAD
		// $userid = $_SESSION['id'];
		$userid = $_GET["userIdList"];

		$sql ="SELECT * FROM fridge2 WHERE userID = $userid";
=======
		$userid = $_SESSION['id'];

		$sql ="SELECT * FROM fridge WHERE userID = $userid";
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61
		$result = $conn->query($sql);

		$output = "";
		if ($result->num_rows > 0) {
		  // output data of each row

<<<<<<< HEAD
			$output = "<form><table border = '2'>

									<th>Ingredient</th>

									</form>
									";
			while($row = $result->fetch_assoc()) {
				$output .= "<tr>

											<td>$row[INGREDIENT]</td>

											</tr>";
=======
		  $output = "<div class=\"fridge-table\"><form><table border = '2'>
					  <th>Ingredient One</th>
					  <th>Ingredient Two</th>
					  <th>Ingredient Three</th>
					  <th>Ingredient Four</th>
					  <th>Ingredient Five</th>
					  </form>
					  ";
			while($row = $result->fetch_assoc()) {
				$output .= "<tr>
							<td>$row[INGREDIENT_ONE]></td>
							<td>$row[INGREDIENT_TWO] </td>
							<td>$row[INGREDIENT_THREE]</td>
							<td>$row[INGREDIENT_FOUR]</td>
							<td>$row[INGREDIENT_FIVE]</td>
							</tr>";
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61

			}
			$output .="</table>";
			echo ($output);

		} else {
			$output = "0 results";
		}
		$conn->close();
		return $output;
	  }

	  function changeFridge(){
			$servername = "localhost";
			$username = "root";
			$password = "root";
<<<<<<< HEAD
			$database = "Fridge";
=======
			if (SAM == true) {
				$password = "";
			}
			$database = "recipeasy1";
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61
			$conn = mysqli_connect($servername, $username, $password, $database);



			$userid = $_GET["userIDChange"];

			$sql = "SELECT * FROM fridge WHERE userID = $userid";
			$result = $conn->query($sql);


		$ingredients=$result->fetch_assoc();
		$ingredients = implode(",",$ingredients);
		$ingredients = str_replace(">","",$ingredients);
		$ingredients = explode(",", $ingredients);


<<<<<<< HEAD
		$ingredients = $_GET["ChangeIngrList"];
		$ingredients  = explode( ',', $ingredients);
		$length = count($ingredients);

		for ($i = 0; $i < $length; $i++) {
			$change = explode( '->', $ingredients[$i]);
			$orignal = $change[0];
			$new = $change[1];

			// if($new = "remove"){
			// 	$sql = "DELETE FROM fridge2 WHERE (userID = $userid AND INGREDIENT = '$orignal')";
			// 	if ($conn->query($sql))
			// 	{
			// 		echo ("Record deleted successfully");
			// 	}
			// }
			// else{
			$sql = "UPDATE fridge2 SET INGREDIENT = '$new' WHERE (userID = $userid AND INGREDIENT = '$orignal')";
							if ($conn->query($sql))
							{
								echo ("Record created successfully");
							}
							else
							{
								echo("Error: " . $conn->error);
							}
		}


=======
			if (empty($_GET["ChangeIngrList1"])){
			$ingredient1 = $ingredients[1];
			}
			elseif($_GET["ChangeIngrList1"] == "remove"){

			$ingredient1 = "";
			}
			else{
			$ingredient1 = $_GET["ChangeIngrList1"];
			}
			if (empty($_GET["ChangeIngrList2"])){
			$ingredient2 = $ingredients[2];
			}
			elseif($_GET["ChangeIngrList2"] == "remove"){

			$ingredient2 = "";
			}
			else{
			$ingredient2 = $_GET["ChangeIngrList2"];
			}
			if (empty($_GET["ChangeIngrList3"])){
			$ingredient3 = $ingredients[3];
			}
			elseif($_GET["ChangeIngrList3"] == "remove"){

			$ingredient3 = "";
			}
			else{
			$ingredient3 = $_GET["ChangeIngrList3"];
			}
			if (empty($_GET["ChangeIngrList4"])){
			$ingredient4 = $ingredients[4];
			}
			elseif($_GET["ChangeIngrList4"] == "remove"){

			$ingredient4 = "";
			}
			else{
			$ingredient4 = $_GET["ChangeIngrList4"];
			}
			if (empty($_GET["ChangeIngrList5"])){
			$ingredient5 = $ingredients[5];
			}
			elseif($_GET["ChangeIngrList5"] == "remove"){

			$ingredient5 = "";
			}
			else{
			$ingredient5 = $_GET["ChangeIngrList5"];
			}

			$sql = "UPDATE fridge SET INGREDIENT_ONE = '$ingredient1',INGREDIENT_TWO = '$ingredient2',INGREDIENT_THREE = '$ingredient3',INGREDIENT_FOUR = '$ingredient4',INGREDIENT_FIVE = '$ingredient5' WHERE userID = $userid";
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61

			if ($conn->query($sql))
			{
			echo ("Record updated successfully");
			}
			else
			{
			echo("Error: " . $conn->error);
			}

			$conn->close();
	  }

	  function getFridge(){
		$servername = "localhost";
		$username = "root";
		$password = "root";
<<<<<<< HEAD
		$database = "Fridge";
=======
		if (SAM == true) {
			$password = "";
		}
		$database = "recipeasy1";
>>>>>>> 1d605cbde2e98ccf492924507bf2244bbd76fd61
		$conn = mysqli_connect($servername, $username, $password, $database);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		//echo "Connected successfully";

		$userid = $_SESSION['id'];

		$sql ="SELECT * FROM fridge WHERE userID = $userid";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		$elements = $row;

		$conn->close();
		return $elements;
	}

?>
