<!DOCTYPE html>
<html>
<head>
	<title>Results Page</title>
</head>
	<link rel="stylesheet" href="styles.css">
<body>
	<?php 
		$query = $_POST['searchBox'];
		$API_KEY = "eb165bf559944161ae56ab639b53c06c";
		$API = "https://api.spoonacular.com/recipes/complexSearch?apiKey=" . $API_KEY . "&query=". $query . "&addRecipeInformation=true&instructionsRequired=true&fillIngredients=true&number=2";
		
	
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

		function getdata($array, $i)
		{
			print_r("<h1>Title: ".$array[$i]['title']."</h1><br>");
			print_r("<button class = 'collapsible'><h1 id='TEMP'>Information on Recipe</h1></button>");
			print_r("<div class='content'");
			dispdata($array[$i]);
			print("<br><br>");
		}

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
			print_r("<div>");
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
			print_r("</div>");
			print_r("<div>");
      		analyze($array['analyzedInstructions']);
      		print_r("</div>");
		}

      	function dispdata($array)
      	{
      		$keys = array_keys($array);
      		for ($i=0; $i < sizeof($keys); $i++) 
      		{ 
      			if($keys[$i] == "extendedIngredients")
      			{
      				print_r("</div>");
      				print_r("<div style = 'font-size:150%'>");
      				print_r(" <p><b>Time: </b>".$array['readyInMinutes']. " mins"."</p>");
      				print_r(" <p><b>Servings: </b>".$array['servings']. " Persons</p><br>");
      				print_r(" <img src =".$array['image'].">");
      				print_r("<br>");
      				print_r(" <details> <summary><b>Summary</b></summary> <p>".$array['summary']."</p></details>");
      				print_r(" <p><b>Source URL: </b><a href =".$array['sourceUrl'].">".$array['sourceUrl']."</a></p>");
      				print_r("<p><b>Spoonacular Site (URL): </b><a href = ".$array['spoonacularSourceUrl'].">".$array['spoonacularSourceUrl']."</p></a>");
      				print_r("</div>");
      				call($array);
      			}
      			else if($array[$keys[$i]] != null && gettype($array[$keys[$i]]) != "array")
      			{
      				check($keys[$i],$array[$keys[$i]]);
      			}
      		}      		
      	}
      	
	?>
	
</body>
<script>
	var coll = document.getElementsByClassName("collapsible");
	var i;

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