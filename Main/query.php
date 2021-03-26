<?php

if(isset($_POST['id']) && isset($_POST['userId']) && isset($_POST['isChecked'])) {

$isChecked = intval($_POST['isChecked']);
$favBy = intval($_POST['userId']);
$id = intval($_POST['id']);

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

if($isChecked==1){
    mysqli_query($conn, "UPDATE FavRecipes SET favBy='$favBy' WHERE favRecipeId='$id'");
}
else{
    mysqli_query($conn, "UPDATE FavRecipes SET favBy='0' WHERE favRecipeId='$id'");
}

}

?>
