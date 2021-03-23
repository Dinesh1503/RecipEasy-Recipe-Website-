<?php 
	function console_log($msg) {
		echo("<script>console.log(\"$msg\");</script>");
	}

	const API_KEY = "apiKey=ce69626b9c314ae1b20dd3f93aa0b2a7";

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

	function db_config() {
		$localSQL = false;
		if ($localSQL) {
			$servername = "localhost";
			$username   = "root";
			$password   = "root";
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
		db_config();

		$sql = "USE $database";
		$conn->query($sql);

		$query = $_GET['query']; 

		$recipe_check_query = "SELECT * FROM Recipe WHERE (`title` LIKE '%".$query."%')";
		$result = mysqli_query($conn, $recipe_check_query);
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

			echo("<h1>".$title."</h1>");
			echo("<div id='image_container'><img src='".$image_url."'></div>");
			echo("<div id='info_container'><b>Ingredients:</b>");
			while($ingredient = mysqli_fetch_assoc($ingr_result)){
				echo("<p>".$ingredient['name']."</p>");
			}
			echo("<p><b>Number of servings: </b>".$number_of_servings."</p>
			<p><b>Ready in minutes: </b>".$ready_in_minutes."</p>
			<p><b>Calories: </b>".$calories."</p>
			<p><b>Instructions: </b></br>".$description."</p></div>");
		}
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
	
?>