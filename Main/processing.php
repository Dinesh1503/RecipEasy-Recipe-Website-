
<?php 

require_once("main.php");


$file = $_FILES["pictureInput"];
$title = $_POST["titleInput"];
$description = $_POST["descriptionInput"];
$time = $_POST["timeInput"];
$serving = $_POST["servingInput"];
$category = $_POST["categoryInput"];
$ingredientsInput = $_POST["ingredientsInput"];
$calories = $_POST["caloriesInput"];
$cuisine = $_POST["cuisineInput"];
$meal = $_POST["mealInput"];
$intolerances = $_POST["intolerances"];
$diets = $_POST["diets"];

$dir = "uploads/";

$filePath = $dir . uniqid() . basename($file["name"]);

$filePath = str_replace(" ", "_", $filePath);
$type = pathinfo($filePath, PATHINFO_EXTENSION);

echo($filePath);

move_uploaded_file($file["tmp_name"], $filePath);

session_start();
session_regenerate_id();

$user_id = intval($_SESSION['user_id']);

$sql = "INSERT INTO Recipe(title, cuisine_type, image_url, image_type, number_of_servings, ready_in_minutes,calories,description,user_id)
VALUES('$title', '$category', '$filePath', 'jpg', '$serving', '$time', '$calories', '$description','$user_id')";

if(!$conn->query($sql)) {
    echo("Error: " . $conn->error);
}

$recipe_check_query = "SELECT * FROM Recipe WHERE (`title` LIKE '%".$title."%') LIMIT 1";
$result = mysqli_query($conn, $recipe_check_query);
$recipe = mysqli_fetch_assoc($result);
$recipe_id = intval($recipe['id']);


$ingredients = explode(", ", $ingredientsInput);

for ($i = 0; $i < count($ingredients); $i++) {
 	$sql = "INSERT INTO ExtendedIngredient(name, amount, original, unit, recipe_id)
			VALUES ('$ingredients[$i]', '0', 'text', 'unit', '$recipe_id')";
   	$conn->query($sql);
}

header("Location: index.php");


?>
