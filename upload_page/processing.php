
<?php 

include("../DB/config.php");

$file = $_FILES["pictureInput"];
$title = $_POST["titleInput"];
$description = $_POST["descriptionInput"];
$time = $_POST["timeInput"];
$serving = $_POST["servingInput"];
$category = $_POST["categoryInput"];
$ingredients = $_POST["ingredientsInput"];
$uploadedBy = $_SESSION['user_id']; //user id

// move uploaded img to uploads/
$dir = "uploads/";
$filePath = $dir . uniqid() . basename($file["name"]);

$filePath = str_replace(" ", "_", $filePath);
$type = pathinfo($filePath, PATHINFO_EXTENSION);

move_uploaded_file($file["tmp_name"], $filePath);

$sql = "INSERT INTO Recipe(ingredients, description, time, 	cuisine_type, image_url, title, number_of_servings, user_id)
VALUES('$ingredients', '$description', '$time', '$category', '$filePath', '$title', '$serving', '$uploadedBy')";

if($conn->query($sql))
{
    echo("<h3 id='uploadSucess' style='text-align:center;'>Uploaded sucessfully<h3>");
    header( "refresh:2;url=http://localhost:8888/y14-group-project-master%208/Static/upload.php" );
} 
else{
    echo("Error: " . $conn->error);
}

?>
