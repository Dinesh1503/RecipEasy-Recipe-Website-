<!DOCTYPE html>
<html>
<head>
	<title>Results Page</title>
</head>

<link rel="stylesheet" href="styles.css">

<!-- This Style exists within the file for the recipes to hide/show via the buttons  -->
<style type="text/css" media="screen">
	.button {
	  border: none;
	  color: blue;
	  padding: 16px 32px;
	  text-align: center;
	  text-decoration: underline;
	  display: inline-block;
	  font-size: 30px;
	  margin: 4px 2px;
	  transition-duration: 0.4s;
	  cursor: pointer;
	}

	.button2 {
	  background-color: white; 
	  color: blue;
	  text-decoration: underline; 
	  
	}

	.button2:hover {
	  background-color: white;
	  color: blue;
	  text-decoration:underline;
	}	

</style>
	
<body>
	<?php 

		//Function call to display the recipes
		getdata_fromAPI();

		//To Parse the Data Entered by the User and to construct the API call Request URL
		function getdata_fromAPI()
		{
			$API_KEY = "eb165bf559944161ae56ab639b53c06c";

			if(isset($_POST['query']))
				$query = $_POST['query'];
			else
				$query = null;

			if(isset($_POST['includeIngredients']))
				$list_ing = $_POST['includeIngredients'];
			else
				$list_ing = null;

			if(isset($_POST['number']))
				$max_results = $_POST['number'];
			else
				$max_results = null;

			if(isset($_POST['offset']))
				$offset = $_POST['offset'];
			else
				$offset = null;

			if(isset($_POST['sortDirection']))
				$sort_direc = $_POST['sortDirection'];
			else
				$sort_direc = null;

			if(isset($_POST['sort']))
				$sort_filters = $_POST['sort'];
			else
				$sort_filters = null;

			if(isset($_POST['maxtime']))
				$max_time = $_POST['maxtime'];
			else
				$max_time = null;
			
			$intolerances = array();
			for ($i=1; $i <= 12; $i++) 
			{ 
				$string = "intolerance".$i;
				if(isset($_POST[$string]))
				{
					$intolerances[$i] = $_POST[$string];
				}
			}
			if($max_results == null)
				$max_results = 1;
			
			

			// $intolerances = $_POST['intolerances'];
			// print_r("Intolerances: ".$intolerances."<br><br>");
			if(isset($_POST['cuisine']))
				$cuisine = $_POST['cuisine'];
			else
				$cuisine = null;
			

			if(isset($_POST['type']))
			{	
				$mealtype = $_POST['type'];
			}
			else
			{	
				$mealtype = null;
			}

			if(isset($_POST['diet']))
			{	
				$diet = $_POST['diet'];
			}
			else
			{
				$diet = null;
			}
		

			

			//Totally Empty Search Query
			if(empty($query) && empty($list_ing) && empty(checkval($diet,$intolerances,$cuisine,$mealtype,$sort_filters,$max_time)))
			{
				print_r("<p>Empty Search Query <br><br> Redirecting to Main Page in 3 seconds...</p>");
					print_r("<script text='javascript'>
						 setTimeout(function(){  window.open('spoon.php'); }, 3000);
						
						 </script>");
				$API = "";
			}

			//Direct Search Query Entered 
			else if(empty($query) == false && empty($list_ing) == true)
			{
				searchedfor($query,$list_ing,$max_time,$max_results,$mealtype,$sort_filters,$intolerances,$diet,$cuisine,$sort_direc);
				$extra = checkval($diet,$intolerances,$cuisine,$mealtype,$sort_filters,$max_time);
				$API = "https://api.spoonacular.com/recipes/complexSearch?apiKey=" . $API_KEY."&query=". $query . "&addRecipeInformation=true&instructionsRequired=true&fillIngredients=true&number=".$max_results."&offset=".$offset."&sortDirection=".$sort_direc.$extra;
				//print_r("API: ".$API);
			}

			//Direct Ingredients Entered
			else if(empty($list_ing) == false)
			{
				searchedfor($query,$list_ing,$max_time,$max_results,$mealtype,$sort_filters,$intolerances,$diet,$cuisine,$sort_direc);
				$ingr_number = $_POST['ingr_number'];
				print_r("<p> Number of Ingredients Entered: ".$ingr_number."</p>");
				$temp = explode(",",$list_ing);
				$pattern = "/,/i";
				$i = preg_match_all($pattern, $list_ing);
				if($i != $ingr_number-1)
				{
					// print_r("<br>Return to Main Page<br>
				 // 		<a href = 'spoon.php'>");
					print_r("<p>Error In Search by Ingredients Option <br><br> Redirecting to Main Page in 3 seconds...</p>");
					print_r("<script text='javascript'>
						 setTimeout(function(){  window.open('spoon.php'); }, 3000);
						
						 </script>");
				}
				$extra = checkval($diet,$intolerances,$cuisine,$mealtype,$sort_filters,$max_time);
				$API = "https://api.spoonacular.com/recipes/complexSearch?apiKey=".$API_KEY."&includeIngredients=".$list_ing. "&addRecipeInformation=true&instructionsRequired=true&fillIngredients=true&number=".$max_results."&offset=".$offset."&sortDirection=".$sort_direc.$extra;
				//print_r("API: ".$API);
			}

			//If only Filter Options are used to search
			else
			{
				searchedfor($query,$list_ing,$max_time,$max_results,$mealtype,$sort_filters,$intolerances,$diet,$cuisine,$sort_direc);
				$extra = checkval($diet,$intolerances,$cuisine,$mealtype,$sort_filters,$max_time);
				$API = "https://api.spoonacular.com/recipes/complexSearch?apiKey=" . $API_KEY."&query=". $query . "&addRecipeInformation=true&instructionsRequired=true&fillIngredients=true&number=".$max_results."&offset=".$offset."&sortDirection=".$sort_direc.$extra;
			}
			
			

			$URL = $API;

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
		  	// parse JSON into useable objects
	      	$json = json_decode($head);
	      	$array = json_decode(json_encode($json), true);

	   		if(empty($json) || empty($array) || $array['totalResults'] == 0)
	   		{
	   			print_r("<p>Recipe Not Found <br><br> Redirecting to Main Page in 3 seconds... </p> <br><br>");
	   			print_r("<script text='javascript'>
						 setTimeout(function(){  window.open('spoon.php'); }, 3000);</script>");
	   		}	
	   		else
	   		{
	   			print_r("<br><br><br><br>");
	   			$results = $array['results'];
	   			for ($i=0; $i < sizeof($results); $i++) 
	   			{ 
	   				print_r("<button onclick='newfunction($i)' class='button button2'");
	   				print_r("<p>Recipe: ".$results[$i]['title']."</p>");
		    		print_r("<img src =".$results[$i]['image']."></button>");

		    		print_r("<div id='id$i' style='display:none;'>");
		    		getdata($results,$i);
		    		print_r("</div>");
	   			}
		    }  	
		}

		// To construct the URL to call the API endpoint by parsing the data of these parameters
	    function searchedfor($query,$list_ing,$max_time,$max_results,$mealtype,$sort_filters,$intolerances,$diet,$cuisine,$sort_direc)
		{
			print_r("<table>");
			print_r("<tr><th>Query Entered</th> 
				<th>Number of Results</th> 
				<th>Max Time</th>
				<th>Intolerances</th>
				<th>Sort_Filters</th>
				<th>Diet</th>
				<th>MealType</th>
				<th>Cuisine</th>");
			print_r("<tr><td>".$query."</td>");
			print_r("<td>".$max_results."</td>");
			print_r("<td>".$max_time."</td>");
			print_r("<td>");
			print_r($intolerances);
			print_r("</td><td>".$sort_filters."</td>");
			print_r("<td>".$diet."</td>");
			print_r("<td>".$mealtype."</td>");
			print_r("<td>".$cuisine."</td></tr>");
			print_r("</table>");

		}

		//To check if the extra parameters are entered by the User 
		function checkval($diet,$intolerances,$cuisine,$mealtype,$sort_filters,$max_time)
		{
			global $API_KEY;
			//if(empty($diet) && empty($intolerances) && empty($cuisine) && empty($mealtype) && empty($sort_filters))

			if(empty($diet) && empty($intolerances) && empty($cuisine) && empty($mealtype) && empty($sort_filters))
			{
				$str = "";
				return $str;
			}
			if(empty($diet))
				$d = "";
			else
				$d = "&diet=".$diet;

			if(empty($intolerances))
				$i = "";
			else
			{	
				$i = "";
				$x=0;
				$i = "&intolerances=".implode(",",$intolerances);
			}

			if(empty($cuisine))
				$c = "";
			else
				$c = "&cuisine=".$cuisine;

			if(empty($mealtype))
				$m = "";
			else
				$m = "&mealtype=".$mealtype;

			if(empty($sort_filters))
				$sf = "";
			else
				$sf = "&sort=".$sort_filters;
			if(empty($max_time))
				$mt = "";
			else
				$mt = "&maxReadyTime=".$max_time;

			$str = $sf.$d.$c.$m.$i.$mt;
			return $str;
		}

		//To dipsplay contents of a multi-dimensional associative array | only for testing/dveloping  purposes 
      	function test($array)
      	{
      		foreach ($array as $key => $value) 
      		{
      			if(gettype($value) == "array")
      			{
      				print_r("<b>".$key."</b> =>");
      				test($value);
      			}
      			else
      				print_r("<b>		".$key."</b> : ".$value."<br>");
      		}
      	}

      	//To display Ingredients detaiils in a Table Format
      	function dispdet($array)
      	{
	      	for ($i=0; $i < sizeof($array); $i++) 
	      	{ 
	      		print_r("<tr><td>".$array[$i]['name']
	      			."</td><td>".$array[$i]['consistency']
	      			."</td><td>".$array[$i]['measures']['metric']['amount']
	      			."  ".$array[$i]['measures']['metric']['unitLong']
	      			."</td><td>".$array[$i]['measures']['us']['amount']
	      			."  ".$array[$i]['measures']['us']['unitLong']
	      			."</td><td>".$array[$i]['aisle']
	      			."</td><td>".$array[$i]['original']
	      			."</td></tr>");
	      	}

	      }

	    //To display the values according to the keys of the array 
      	function check($key, $value)
		{
			if($value != null)
			{
				switch ($key) 
				{
					case 'vegetarian': print_r("<p><b>Vegeterian: </b>". $value."</p>");
									   break;
					case 'vegan': print_r(" <p><b>Vegan: </b>". $value."</p>");
									   break;
					case 'glutenFree': print_r("<p><b>Gluten Free: </b>". $value."</p>");
									   break;
					case 'diaryFree': print_r("<p><b> Dairy Free: </b>". $value."</p>");
									   break;
					case 'healthScore': print_r(" <p><b>Health Score: </b>". $value."</p>");
									   break;
					case 'creditsText': print_r(" <p><b>Credits Text: </b>". $value."</p>");
									   break;
					case 'license': print_r(" <p><b>License: </b>". $value."</p>");
									   break;
					case 'aggregateLikes': print_r("<p></p>");
											print_r("<p><b>Aggregate Likes: </b>".$value."</p>");
										   break;
					case 'sourceName': print_r(" <p><b>Source Name: </b>".$value."</p>");
									   break;
				    // case 'readyInMinutes': print_r(" <p>Time: ".$value. " mins"."</p>");
								// 	   break;
				    // case 'sourceUrl': print_r(" <p>Source URL: <a href =".$value.">".$value."</a></p>");
								// 	   break;
				    // case 'servings': print_r(" <p>Servings: ".$value. " Persons</p><br>");
								// 	   break;
				    // case 'summary': print_r(" <p><details><summary> <p>Summary</p> </summary></p><p>".$value."</p></details>");
								// 	   break;
				    case 'dishTypes': print_r(" <p><b>Dish Type: </b>".$value."</p>");
									   break;
					case 'diets': print_r(" <p><b>Diets: </b>". $value."</p>");
								  break;
					// case 'image': print_r(" <img src =".$value.">");
					// 			  break;
					// case 'title': print_r(" <p><b>Title: </b>". $value."</p><br><br><br>");
					// 			  break;
					case 'occasions': print_r(" <p><b>Ocassions: </b>". $value."</p>");
									  break;
					case 'diets': print_r(" <p><b>Diets: </b>". $value."</p>");
								  break;
					// case 'spoonacularSourceUrl': print_r("<p> Spoonacular Site (URL): "."<a href = ".$value.">".$value."</p></a>");
					// 							 break;
					default: break;
							
				}
			}
		}

		// To print the Equipments and Instructions Required
		function analyze($array)
		{
			print_r("<p><b>Equipment Required : </b>");
      		$x = 0;	
  			for ($j=0; $j < sizeof($array[0]['steps']); $j++) 
  			{ 
  				for ($k=0; $k < sizeof($array[0]['steps'][$j]['equipment']) ; $k++) 
  				{ 	$x++;
  					$temp[$x] = $array[0]['steps'][$j]['equipment'][$k]['name'];
  						
  				}
  				
  			}
      		$equipment = array_unique($temp);
      		$i = 0;
      		foreach ($equipment as $key => $value) 
      		{
      			$i = $i + 1;
      			if($i == sizeof($equipment))
      				print_r($value.".");
      			else
      				print_r($value.", ");
      		}
      		print_r("</p>");
      		print_r("<h1 id='TEMP'>Instructions</h1>");
  			for ($j=0; $j < sizeof($array[0]['steps']); $j++) 
  			{ 
  				print_r("<p>".($j+1)." - ".$array[0]['steps'][$j]['step']."</p>");
  			}	
		}

		//To print the Recipe Title 
		function getdata($array, $i)
		{
			print_r("<div id='$i'><h1>Title: ".$array[$i]['title']."</h1><br>");
			print_r("<button class = 'collapsible'><h1 id='TEMP'>Information on Recipe</h1></button>");
			print_r("<div class='content'");
			dispdata($array[$i]);
			print("</div><br><br>");
		}

		//To print the Cuisines 
		function call($array)
		{
	   		$i = 0;
			print_r("<p><b>Cuisines: </b>");
			foreach ($array['cuisines'] as $keys => $values) 
			{
				$i = $i + 1;
				if($i == sizeof($array['cuisines']))
					print_r($values);
				else
					print_r($values." / ");
			}
			print_r("</p>");
			print_r("<h1 id='TEMP'>Ingredients</h1>");
      		print_r("<table>
		      		<tr>
		      		<th>Ingredients</th>
		      		<th>Consistency</th>
		      		<th>Amount(Metric)</th>
		      		<th>Amount(US)</th>
		      		<th>Aisle</th>
		      		<th>Description</th></tr>");
			dispdet($array['extendedIngredients']);
			print_r("</table>");
      		analyze($array['analyzedInstructions']);
      		print_r("</div>");
		}

		//To print the extra information and other details of the recipe
      	function dispdata($array)
      	{
      		$keys = array_keys($array);
      		for ($i=0; $i < sizeof($keys); $i++) 
      		{ 
      			if($keys[$i] == "extendedIngredients")
      			{
      				print_r(" <details> <summary><b>Summary</b></summary> <p>".$array['summary']."</p></details>");
      				print_r("</div>");
      				print_r("<div>");
      				print_r(" <p><b>Time: </b>".$array['readyInMinutes']. " mins"."</p>");
      				print_r(" <p><b>Servings: </b>".$array['servings']. " Persons</p><br>");
      				print_r(" <img src =".$array['image'].">");
      				print_r("<br>");
      				print_r(" <p><b>Source URL: </b><a href =".$array['sourceUrl'].">".$array['sourceUrl']."</a></p>");
      				print_r("<p><b>Spoonacular Site (URL): </b><a href = ".$array['spoonacularSourceUrl'].">".$array['spoonacularSourceUrl']."</p></a>");
      				call($array);
      			}
      			else if($array[$keys[$i]] != null && gettype($array[$keys[$i]]) != "array")
      			{
      				print_r("<p>");
      				check($keys[$i],$array[$keys[$i]]);
      				print_r("</p>");
      			}
      		}      		
      	}

      	
	?>

</body>
<script>
	var coll = document.getElementsByClassName("collapsible");
	var i;

	//To display the the contents within the button on a button click 
	function newfunction(i)
	{
		var id = "id" + i;
		var x = document.getElementById(id);

		if(x.style.display === "none")
		{	
			x.style.display = "block";
			x.style.width = "100%";
			x.style.float = "left";		
		}
		else
		{	
			x.style.display = "none";
			x.style.width = "100%";
			x.style.float = "none";
		}
	}

	for (i = 0; i < coll.length; i++) {
	  coll[i].addEventListener("click", function() {
	    this.classList.toggle("active");
	    var content = this.nextElementSibling;
	    if (content.style.display === "block") {
	      content.style.display = "none";
	    } else {
	      content.style.display = "block";
	    }
	  });
	}
</script>
</html>	


