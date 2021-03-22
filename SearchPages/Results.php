<!DOCTYPE html>
<html>
<head>
	<title>Results Page</title>
</head>
<style type="text/css">
	.demo
	{
		font-family: "Times New Roman", Times, serif;
		display: block;
	}
	p 
	{
	  font-family: 'Times New Roman',Times, serif;
	  font-size: 25px;
	  color: black;
	  background-color: white;
	}
	h1{

	  font-family: 'Times New Roman',Times, serif;
	  font-size: 35px;
	  color: black;
	  background-color: white;
	}
	.button 
	{
	  background-color: white; /* Green */
	  border: none;
	  color: white;
	  padding: 10px 20px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 16px;
	  margin: 4px 2px;
	  transition-duration: 0.2s;
	  cursor: pointer;
	}

	.button1 
	{
	  background-color: white; 
	  color: black; 
	  border: 2px solid white;
	}
	.button1:hover 
	{
	  background-color: #4CAF50;
	  color: white;
	}
	.button2
	{
	  background-color: white; /* Green */
	  border: black;
	  color: black;
	  padding: 10px 20px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 16px;
	  margin: 4px 2px;
	  transition-duration: 0.2s;
	  cursor: pointer;
	}
	.button2:hover 
	{
	  background-color: #4CAF50;
	  color: white;
	}
	table, th, td 
	{
	  border: 1px solid black;
	  border-collapse: collapse;
	  font-family: 'Times New Roman',Times, serif;
	  font-size: 15px;
	  color: black;
	  background-color: white;
	  text-align: left;
	  padding: 8px;
	}
	.btn-group button 
	{
	  background-color: white; /* Green background */
	  border: 1px white; /* Green border */
	  color: black; /* White text */
	  padding: 10px 24px; /* Some padding */
	  cursor: pointer; /* Pointer/hand icon */
	  width: 25%; /* Set a width if needed */
	  display: block; /* Make the buttons appear below each other */
	}

	.btn-group button:not(:last-child) 
	{
	  border-bottom: none; /* Prevent double borders */
	}

	/* Add a background color on hover */
	.btn-group button:hover 
	{
	  background-color: #3e8e41;
	}
	.title
	{
		font-family: "Times New Roman",'Times', serif;
		font-size: 50px;
	}
	table
	{
		width: 100%;
	}
	/*a:link, a:visited 
	{
	  background-color: #f44336;
	  color: white;
	  padding: 14px 25px;
	  text-align: center;
	  text-decoration: none;
	  display: inline-block;
	}

	a:hover, a:active 
	{
	  background-color: pink;
	}*/
</style>
<body>
	<?php 

		$query = $_POST['searchBox'];
		$API_KEY = "eb165bf559944161ae56ab639b53c06c";
		$API = "https://api.spoonacular.com/recipes/complexSearch?apiKey=" . $API_KEY . "&query=". $query . "&addRecipeInformation=true&instructionsRequired=true&fillIngredients=true&number=10";
		
	
		$URL = $API;

		$ch = curl_init();
		  // set url
	  	curl_setopt($ch, CURLOPT_URL, $URL);
	  	// stop echo to webpage
	  	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	  	// execute request
	  	$head = curl_exec($ch);;
	  	// get request status info
	  	//$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	  	// close request like a good boy
	  	curl_close($ch);
	  	// parse JSON into useable objects
      	$json = json_decode($head);
      	$array = json_decode(json_encode($json), true);
      	
      	$results = $array['results'];     	

      	//test($results);
      	for ($i=0; $i < sizeof($results); $i++) { 
      		getdata($results,$i);
      	}
      	
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
					case 'glutenFree': print_r("<p><b> Gluten Free: </b>". $value."</p>");
									   break;
					case 'diaryFree': print_r("<p><b> Dairy Free: </b>". $value."</p>");
									   break;
					case 'healthScore': print_r(" <p><b>Health Score: </b>". $value."</p>");
									   break;
					case 'creditsText': print_r(" <p><b>Credits Text: </b>". $value."</p>");
									   break;
					case 'license': print_r(" <p><b>License: </b>". $value."</p>");
									   break;
					case 'aggregateLikes': print_r(" <p><b>Aggregate Likes: </b>".$value."</p>");
										   break;
					case 'sourceName': print_r(" <p><b>Source Name: </b>".$value."</p>");
									   break;
				    case 'readyInMinutes': print_r(" <p><b>Time: </b>".$value. " mins"."</p>");
									   break;
				    case 'sourceUrl': print_r(" <p><b>Source URL: </b><a href =".$value.">".$value."</a></p>");
									   break;
				    case 'servings': print_r(" <p><b>Servings: </b>".$value. " Persons</p><br>");
									   break;
				    case 'summary': print_r(" <p><details><summary> <p><b>Summary </b></p> </summary></p><p>".$value."</p></details>");
									   break;
				    case 'dishTypes': print_r(" <p><b>Dish Type: </b>".$value."</p>");
									   break;
					case 'diets': print_r(" <p><b>Diets: </b>". $value."</p>");
								  break;
					case 'image': print_r(" <img src =".$value.">");
								  break;
					// case 'title': print_r(" <p><b>Title: </b>". $value."</p><br><br><br>");
					// 			  break;
					case 'occasions': print_r(" <p><b>Ocassions: ". $value."</p>");
									  break;
					case 'diets': print_r(" <p><b> Diets: </b>". $value."</p>");
								  break;
					case 'spoonacularSourceUrl': print_r("<p> <b>Spoonacular Site (URL): </b>"."<a href = ".$value.">".$value."</p></a>");
												 break;
					default: break;
							
				}
			}
		}

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
      		print_r("</p><br>");
      		print_r("<h1>Instructions</h1>");
  			for ($j=0; $j < sizeof($array[0]['steps']); $j++) 
  			{ 
  				print_r("<p>".($j+1)." - ".$array[0]['steps'][$j]['step']."</p>");
  			}
      
      		
      		
		}

		function getdata($array, $i)
		{
			print_r("<h1>Title: ".$array[$i]['title']."<h1><br>");
			dispdata($array[$i]);
			print("<br><br>");
		}
      	function dispdata($array)
      	{
      		foreach ($array as $key => $value) 
      		{
      			if(gettype($value) == "array" && $value != null)
      			{
      				if($key == "analyzedInstructions")
      				{
      					analyze($value);
      				}
      				else if ($key == "extendedIngredients") 
      				{
      					print_r("<table>
					      		<tr>
					      		<th>Ingredients</th>
					      		<th>Consistency</th>
					      		<th>Amount(Metric)</th>
					      		<th>Amount(US)</th>
					      		<th>Aisle</th>
					      		<th>Description</th></tr>");
      					dispdet($value);
      					print_r("</table>");
      				}
      				else if($key == "cuisines")
      				{
      					$i = 0;
      					print_r("<p> Cuisines: ");
      					foreach ($value as $keys => $values) 
      					{
      						$i = $i + 1;
      						if($i == sizeof($value))
      							print_r($values);
      						else
      							print_r($values." / ");
      					}
      					print_r("</p>");
      				}
      				else 
      					dispdata($value);
      			}
      			else if($key == "spoonacularSourceUrl")
      			{
      				print_r("<p> <b>Spoonacular Site (URL): </b>"."<a href = ".$value.">".$value."</p></a>");
      				break;
      			}
      			else
      				check($key,$value);
      		}
      	}
      	
	?>
	
</body>
</html>