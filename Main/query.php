<?php
require_once("config.php");
$conn = getConnSQL();

if(isset($_POST['id']) && isset($_POST['userId']) && isset($_POST['isChecked']) && isset($_POST['date']) && isset($_POST['mealTime'])) {

	$isChecked = intval($_POST['isChecked']);
	$user_id = intval($_POST['userId']);
	$recipe_id = intval($_POST['id']);
	$date = $_POST['date'];
	$meal_time = $_POST['meal_time'];

	if($isChecked==1){
		$check = mysqli_query($conn, "SELECT * FROM MealPlan WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
		if(mysqli_num_rows($check)==0) {
			mysqli_query($conn, "INSERT INTO MealPlan(recipe_id, user_id, meal_date, meal_time) VALUES('$recipe_id', '$user_id', '$date', '$meal_time')");
		}
		else{
			mysqli_query($conn, "UPDATE MealPlan SET meal_time='$meal_time', meal_date='$date' WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
		}

	}
	else if($isChecked==2){
		mysqli_query($conn, "UPDATE MealPlan SET meal_date='$date' WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
	}
	else{
		mysqli_query($conn, "UPDATE MealPlan SET meal_time='', meal_date='' WHERE recipe_id='$recipe_id' AND user_id='$user_id'");
	}

}

else if(isset($_POST['id']) && isset($_POST['userId']) && isset($_POST['isChecked'])) {

$isChecked = intval($_POST['isChecked']);
$favBy = intval($_POST['userId']);
$id = intval($_POST['id']);

	if($isChecked==1){
		$check = mysqli_query($conn, "SELECT * FROM FavRecipes WHERE fav_by = '$favBy' AND fav_recipe_id='$id'");
		if(mysqli_num_rows($check)==0){
			mysqli_query($conn, "INSERT INTO FavRecipes(fav_recipe_id, fav_by) VALUES('$id', '$favBy')");
		}
		else{
			mysqli_query($conn, "UPDATE FavRecipes SET fav_by='$favBy' WHERE fav_recipe_id='$id'");
		}

	}
	else{
		mysqli_query($conn, "UPDATE FavRecipes SET fav_by='0' WHERE fav_recipe_id='$id'");
	}

}

?>
