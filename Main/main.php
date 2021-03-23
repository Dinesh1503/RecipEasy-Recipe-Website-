<?php 
	function console_log($msg) {
		echo("<script>console.log(\"$msg\");</script>");
	}

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

	function db_config() {
		$localSQL = true;
		if ($localSQL) {
			$servername = "localhost";
			$username   = "root";
			$password   = "";
			$database   = "recipeasy";
		} else {
			$servername = "dbhost.cs.man.ac.uk";
			$username   = "e95562sp";
			$password   = "STORED_recipes+";
			$database   = "2020_comp10120_y14";
		}

		$conn = mysqli_connect($servername, $username, $password, $database);
	}

	function db_search() {
		$localSQL = true;
		if ($localSQL) {
			$servername = "localhost";
			$username   = "root";
			$password   = "";
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
		$elements = "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"css/search.css\">
			<div class=\"searchResults\">
		";
		while($recipe = mysqli_fetch_assoc($result)){
			$recipe_id = $recipe['id'];
			$title = $recipe['title'];
			$cuisine_type = $recipe['cuisine_type'];
			$image_url = $recipe['image_url'];
			$number_of_servings = $recipe['number_of_servings'];
			$ready_in_minutes = $recipe['ready_in_minutes'];
			$description = $recipe['description'];
			$calories = $recipe['calories'];

			$ingredients_check_query = "SELECT * FROM ExtendedIngredient WHERE recipe_id=$recipe_id";
			$ingr_result = mysqli_query($conn, $ingredients_check_query);

			$elements = $elements . "<h1>".$title."</h1>";
			$elements = $elements . "<div id='image_container'><img src='".$image_url."'></div>";
			$elements = $elements . "<div id='info_container'><b>Ingredients:</b>";
			while($ingredient = mysqli_fetch_assoc($ingr_result)){
				$elements = $elements . "<p>".$ingredient['name']."</p>";
			}
			$elements = $elements . "<p><b>Number of servings: </b>".$number_of_servings."</p>
			<p><b>Ready in minutes: </b>".$ready_in_minutes."</p>
			<p><b>Calories: </b>".$calories."</p>
			<p><b>Instructions: </b></br>".$description."</p></div>";
		}
		return $elements . "</div>";
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
		$uploadedBy = 0; //user id
	
		/*  @Please explain this block of code@
	
		$dir = "uploads/";
	
		$filePath = $dir . uniqid() . basename($file["name"]);
	
		$filePath = str_replace(" ", "_", $filePath);
		$type = pathinfo($filePath, PATHINFO_EXTENSION);
	
	
		move_uploaded_file($file["tmp_name"], $filePath);
	
		*/
	
		// This part should be made to work with our new database
		// add ingredients, description, time, category columns
		/*
		$sql = "INSERT INTO Recipe(ingredients, description, time, category, image_url, title, number_of_servings, user_id, original_site_url, calories, total_weight, total_nutrients, total_daily, diet_labels, health_labels)
		VALUES('$ingredients', '$description', '$time', '$category', '$filePath', '$title', '$serving', '$uploadedBy','', 0, 0, '', '', '', '')";
		*/
	
	
		if($conn->query($sql))
		{
			echo("Uploaded sucessfully");
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
            <input class='form-control' type='text' placeholder='Ingredients' name='ingredientsInput' required>
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
		$password = "";
		$database = "recipeasy";
		$conn = mysqli_connect($servername, $username, $password, $database);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
	  
		  echo "Connected successfully";
		  $id = $_GET["userID"];
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
		return $output;
	  }
	  
	  function RemoveIngr(){
	  }
	  
	  function showFridge(){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$database = "recipeasy";
		$conn = mysqli_connect($servername, $username, $password, $database);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
	  
		//echo "Connected successfully";
	  
		$userid = $_SESSION['id'];
	  
		$sql ="SELECT * FROM fridge WHERE userID = $userid";
		$result = $conn->query($sql);
	  
		$output = "";
		if ($result->num_rows > 0) {
		  // output data of each row
	  
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
		
			}
		  	$output .="</table></div>";
		} else {
			$output = "0 results";
		}
		$conn->close();
		return $output;
	  }
	  
	  function changeFridge(){
			$servername = "localhost";
			$username = "root";
			$password = "";
			$database = "recipeasy";
			$conn = mysqli_connect($servername, $username, $password, $database);
		
		
		
			$userid = $_GET["userIDChange"];
		
			$sql = "SELECT * FROM fridge WHERE userID = $userid";
			$result = $conn->query($sql);
		
		
		$ingredients=$result->fetch_assoc();
		$ingredients = implode(",",$ingredients);
		$ingredients = str_replace(">","",$ingredients);
		$ingredients = explode(",", $ingredients);
		
		
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
		$password = "";
		$database = "recipeasy";
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