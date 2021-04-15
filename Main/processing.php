
<?php 

session_start();
session_regenerate_id();
if(!isset($_SESSION['user'])) {
	// if no valid session id go to login
	header("Location: userLogin.php");
}

require_once("main.php");


$title = $_POST["titleInput"];
$cuisine = $_POST["cuisineInput"];
$meal = $_POST["mealInput"];
$file = $_FILES["pictureInput"];
$serving = $_POST["servingInput"];
$time = $_POST["timeInput"];
$instructions = $_POST["instructionsInput"];

# check if any diets set
$diet_array = array();
if (isset($_POST["diets"])) {
	$diet_array = $_POST["diets"];
}
# convert to string for SQL
$diets = "";
if (count($diet_array) == 0) {
	$diets = "NULL";	
} else {
	$diets = $diet_array[0];
	for ($i = 1; $i < count($diet_array); $i++) {
		$diets = $diets . "," . $diet_array[$i];
	}
	$diets = "'$diets'" ;
}

# check if any intolerances set
$intolerances_array = array();
if (isset($_POST["intolerances"])) {
	$intolerances_array = $_POST["intolerances"];
}
# convert to string for SQL
$intolerances = "";
if (count($intolerances_array) == 0) {
	$intolerances = "NULL";
} else {
	$intolerances = $intolerances_array[0];
	for ($i = 1; $i < count($intolerances_array); $i++) {
		$intolerances = $intolerances . "," . $intolerances_array[$i];
	}
	$intolerances = "'$intolerances'";
}


$dir = "uploads/";

$filePath = $dir . uniqid() . basename($file["name"]);

$filePath = str_replace(" ", "_", $filePath);
$type = pathinfo($filePath, PATHINFO_EXTENSION);

move_uploaded_file($file["tmp_name"], $filePath);

$user_id = intval($_SESSION['id']);

# make sql 
$sql = "INSERT INTO Recipe(title, cuisine_type, meal_type, image_url, number_of_servings, ready_in_minutes, instructions, intls, diets, user_id)
VALUES('$title', '$cuisine', '$meal', '$filePath', '$serving', '$time', '$instructions', $intolerances, $diets, '$user_id')";
echo($sql);
if(!$conn->query($sql)) {
    echo("Error: " . $conn->error);
}

$recipe_check_query = "SELECT * FROM Recipe WHERE (`title` LIKE '%".$title."%') LIMIT 1";
$result = mysqli_query($conn, $recipe_check_query);
$recipe = mysqli_fetch_assoc($result);

# insert ingredients to ingredient table
$recipe_id = intval($recipe['recipe_id']);
$ingredientsInput = $_POST["ingredientsInput"];
$ingredients = explode(", ", $ingredientsInput);

for ($i = 0; $i < count($ingredients); $i++) {
 	$sql = "INSERT INTO Ingredients(recipe_id, ingr_name, ingr_amount, ingr_unit)
			VALUES ('$recipe_id', '$ingredients[$i]', '0', 'unit', )";
   	$conn->query($sql);
}

header("Location: index.php");


?>
