
<?php 

include_once("../DB/config.php");

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


?>
