<?php

$localSQL = true;
if ($localSQL) {
    $servername = "localhost";
    $username   = "root";
    $password   = "root";
    $database   = "recipeasy1";
} else {
    $servername = "dbhost.cs.man.ac.uk";
    $username   = "e95562sp";
    $password   = "STORED_recipes+";
    $database   = "2020_comp10120_y14";
}
$conn = mysqli_connect($servername, $username, $password, $database);

if(isset($_POST['id']) && isset($_POST['userId']) && isset($_POST['isChecked']) && isset($_POST['date']) && isset($_POST['mealTime'])) {

	$isChecked = intval($_POST['isChecked']);
	$user_id = intval($_POST['userId']);
	$recipe_id = intval($_POST['id']);
	$date = $_POST['date'];
	$mealTime = $_POST['mealTime'];

	if($isChecked==1){
		$check = mysqli_query($conn, "SELECT * FROM MealPlan WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
		if(mysqli_num_rows($check)==0) {
			mysqli_query($conn, "INSERT INTO MealPlan(recipe_id, user_id, mealDate, mealTime) VALUES('$recipe_id', '$user_id', '$date', '$mealTime')");
		}
		else{	
			mysqli_query($conn, "UPDATE MealPlan SET mealTime='$mealTime', mealDate='$date' WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
		}
		
	}
	else if($isChecked==2){
		mysqli_query($conn, "UPDATE MealPlan SET mealDate='$date' WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
	}
	else{
		mysqli_query($conn, "UPDATE MealPlan SET mealTime='', mealDate='' WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
	}

}

else if(isset($_POST['id']) && isset($_POST['userId']) && isset($_POST['isChecked'])) {

$isChecked = intval($_POST['isChecked']);
$favBy = intval($_POST['userId']);
$id = intval($_POST['id']);

	if($isChecked==1){
		$check = mysqli_query($conn, "SELECT * FROM FavRecipes WHERE favBy = '$favBy' AND favRecipeId='$id'");
		if(mysqli_num_rows($check)==0){
			mysqli_query($conn, "INSERT INTO FavRecipes(favRecipeId, favBy) VALUES('$id', '$favBy')");
		}
		else{
			mysqli_query($conn, "UPDATE FavRecipes SET favBy='$favBy' WHERE favRecipeId='$id'");
		}
		
	}
	else{
		mysqli_query($conn, "UPDATE FavRecipes SET favBy='0' WHERE favRecipeId='$id'");
	}

}

?>
