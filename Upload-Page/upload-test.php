<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
</head>
<style>
table, th, td {
  border: 2px solid black;
  border-collapse: collapse;
  text-align: center;
  font-family: "Times New Roman",'Times', serif;
  font-size: 25px;
}
</style>
<body>
	<?php
	// function return_to_main($str)
	// {
	// 	print_r("<p>Error $str not Specified <br><br> Redirecting to Main Page in 3 seconds...</p>");
	// 		print_r("<script text='javascript'>
	// 			 setTimeout(function(){  window.open('Upload.php'); }, 3000);
				
	// 			 </script>");
	// }
	// function checkfield($str,$var)
	// {
	// 	if(isset($_POST[$str]) != true)
	// 	{
	// 		$var = $_POST[$str];
	// 		return $var;
	// 	}	
	// 	else
	// 	{
	// 		return_to_main($str);
	// 	}
	// }
	// $title = null;
	// $title = checkfield('title',$title);
	$title = $_POST['title'];
	$author = $_POST["author"];
	$servings = $_POST["servings"];
	$time = $_POST["time"];
	$mealtype = $_POST["type"];
	$cuisine = $_POST["cuisine"];
	$ingredients = $_POST["ingredients"];
	$instructions = $_POST["instructions"];
	print_r("<table style='width:100%''>
	  <tr>
	  <th>Title</th>
	  <th>Author</th>
	  <th>Servings</th>
	  <th>Time</th>
	  <th>Meal_Type</th>
	  <th>Cuisine</th></tr>");
	print_r("<tr>
		<td>".$title."</td>
		<td>".$author."</td>
		<td>".$servings."</td>
		<td>".$time."</td>
		<td>".$mealtype."</td>
		<td>".$cuisine."</td></tr></table>
		<br><br>");

	    print_r("<table style='width:100%'>
	    	<tr>
	    	<th>Ingredients</th></tr>
	    	<tr><td>".$ingredients."</td></tr></table><br><br>
	");
	    print_r("<table style='width:100%'>
	    	<tr>
	    	<th>Instructions</th>
	    	</tr>
	    	<tr><td>".$instructions."</td></tr></table>
	")

	

	?>
</body>
</html>