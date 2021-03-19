<!DOCTYPE html>
<html>
<head>
	<title>Results Page</title>
	<h1>Results Page</h1>
</head>
<style type="text/css">
	.demo
	{
		font-family: "Times New Roman", Times, serif;
		display: inline-block;
	}
	.p 
	{
	  font-family: "Times New Roman", Times, serif;
	}
	.button 
	{
	  background-color: #4CAF50; /* Green */
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
	  border: 2px solid #4CAF50;
	}
	.button1:hover 
	{
	  background-color: #4CAF50;
	  color: white;
	}
	.button2
	{
	  background-color: black; /* Green */
	  border: black;
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
	.button2:hover 
	{
	  background-color: white;
	  color: black;
	}
	a:link, a:visited 
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
	}
</style>
<body>
	<?php 

		$query = $_POST['searchBox'];
		$API_KEY = "2d11793350c74121a361866f6ad3666c";
		$API = "https://api.spoonacular.com/recipes/complexSearch?apiKey=" . $API_KEY . "&query=". $query . "&addRecipeInformation=true&instructionsRequired=true";
		
	
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
      	//print_r($array);
      	$results = $array['results'];      	
      	for ($i=0; $i < $array['totalResults']; $i++) 
      	{ 
      		getdata($results,$i);
      	}
      	function check($key, $value)
		{
			if($value != null)
			{
				switch ($key) 
				{
					case 'vegetarian': print_r("<b>Vegeterian: </b>". $value."<br>");
									   break;
					case 'vegan': print_r(" <b>Vegan: </b>". $value."<br>");
									   break;
					case 'glutenFree': print_r("<b> Gluten Free: </b>". $value."<br>");
									   break;
					case 'diaryFree': print_r("<b> Dairy Free: </b>". $value."<br>");
									   break;
					case 'healthScore': print_r(" <b>Health Score: </b>". $value."<br>");
									   break;
					case 'creditsText': print_r(" <b>Credits Text: </b>". $value."<br>");
									   break;
					case 'license': print_r(" <b>License: </b>". $value."<br>");
									   break;
					case 'aggregateLikes': print_r(" <b>Aggregate Likes: </b>".$value."<br>");
										   break;
					case 'sourceName': print_r(" <b>Source Name: </b>".$value."<br>");
									   break;
				    case 'readyInMinutes': print_r(" <b>Time: </b>".$value. " mins"."<br>");
									   break;
				    case 'sourceUrl': print_r(" <b>Source URL: </b>".$value."<br>");
									   break;
				    case 'servings': print_r(" <b>Servings: </b>".$value. "Persons"."<br>");
									   break;
				    case 'summary': print_r(" <b><br>Summary: </b>".$value."<br><br>");
									   break;
					case 'cuisines': print_r(" <b>Cuisines: </b>".$value."<br>");
									   break;
				    case 'dishTypes': print_r(" <b>Dish Type: </b>".$value."<br>");
									   break;
					case 'diets': print_r(" <b>Diets: </b>". $value."<br>");
								  break;
					//case 'title': print_r(" <b>Title: </b>". $value."<br><br><br>");
					//			  break;
					case 'occasions': print_r(" <b>Ocassions: ". $value."<br><br>");
									  break;
					case 'diets': print_r(" <b> Diets: </b>". $value."<br>");
								  break;
					// case 'analyzedInstructions': print_r(" <b>Instructions</b>: ".$value."<br>");
					// 							 break;
					// case 'name': print_r($value." ");
	      			// 			 break;
	      			// case 'steps': print_r(" <b>Steps</b>: ".$value."<br>");
	      			// 			 break;
	      			// case 'step': print_r("<br><b>".$value."</b><br>");
	      			// 			break;
	      			// case 'number': print_r("<br>".$value." - ");
	      			// 			 break;
	      			// case 'ingredients': print_r("<br> <b>Ingredients</b>: ".$value."<br>");
	      			// 			 break;
	      			// case 'equipment': print_r("<br> <b>Equipment</b>: ".$value."<br>");
	      			// 			 break;
	      			// case 'temperature': print_r("<br> <b>Temperature</b>: ".$value."<br>");
	      			// 			break;
					case 'spoonacularSourceUrl': print_r("<br> <b>Spoonacular Source URL: </b>".$value."<br>");
												 break;
					default: break;
							
				}
			}
		}

		function analyze($value)
		{
			global $ingredients;  
      		global $equipment;
      		global $step;
      		global $ingrlist;
      		global $equipmentlist;
      		$step = array();
      		$ingrlist = array();
      		print_r("<h3>Ingredients</h3>");
      		foreach ($value as $key1 => $value1) 
      		{
      			$step = $value1['steps'];
      			$i = 0;
      			foreach ($step as $key2 => $value2) 
      			{
      				if(gettype($key2) == "integer" && $value2 != null)
      				{
      					$ingrlist = $step[$key2]['ingredients'];
      					foreach ($ingrlist as $key3 => $value3) 
      					{
      						if(gettype($key3) == "integer" && $value3 != null)
      						{
      							$i = $i + 1;
      							$ingredients = $ingrlist[$key3]['name'];
      							print_r($i." - " . $ingredients."<br>");

      						}
      					}
      				}
      			}
      			
      		}
      		print_r("<h3>Equipments</h3>");
      		$step = array();
      		$equipmentlist = array();
      		foreach ($value as $key5 => $value5) 
      		{
      			$step = $value5['steps'];
      			$i = 0;
      			foreach ($step as $key6 => $value6) 
      			{
      				$equipmentlist = $value6['equipment'];
      				if($equipmentlist != null)
      				{
      					foreach ($equipmentlist as $key7 => $value7) 
      					{
      						$i = $i + 1;
      						print_r($i." - ".$value7['name']);
      						if(gettype($value7) == "array")
      						{
      							foreach ($value7 as $key8 => $value8) 
      							{
      								if($key8 == "temperature")
      								{
      									print_r(" [Temperature ".$value8['number']. " ". $value8['unit']."]");
      								}
      							}
      						}
      						print_r("<br>");
      					}
      				}
      			}
      			
      		}
      		print_r("<h3>Instructions</h3>");
      		$step = array();
      		$steps = array();
      		foreach ($value as $keyA => $valueA) 
      		{
      			$step = $valueA['steps'];
      			$i = 0;
      			foreach ($step as $keyB => $valueB) 
      			{
      				if(gettype($keyB) == "integer")
	      			{
	      				$i = $i + 1;
	      				$steps = $valueB['step'];
	      				print_r("<br>".$i." - ".$steps."<br>");
	      			}
      			}
      			
      		}

		}

		function getdata($array, $i)
		{
			print_r("<h1>Title: ".$array[$i]['title']."</h1><br>");
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
      				else 
      					dispdata($value);
      			}
      			else
      				check($key,$value);
      		}
      	}
      	
	?>
	<!-- <div>
		<a href="Search.php"class="button2 button2" target="Nothing">Return</a>
		<button class="button2 button2" onclick="erase()">Clear</button>
		<button class="button button1" onclick="display(1)"><?php //print_r($results[0]['title']); ?></button>
		<button class="button button1" onclick="display(2)"><?php //print_r($results[1]['title']); ?></button>
		<button class="button button1" onclick="display(3)"><?php //print_r($results[2]['title']); ?></button>
		<button class="button button1" onclick="display(4)"><?php //print_r($results[3]['title']); ?></button>
		<button class="button button1" onclick="display(5)"><?php //print_r($results[4]['title']); ?></button>
		<button class="button button1" onclick="display(6)"><?php //print_r($results[5]['title']); ?></button>
		<button class="button button1" onclick="display(7)"><?php //print_r($results[6]['title']); ?></button>
		<button class="button button1" onclick="display(8)"><?php //print_r($results[7]['title']); ?></button>
		<button class="button button1" onclick="display(9)"><?php //print_r($results[8]['title']); ?></button>
		<button class="button button1" onclick="display(10)"><?php //print_r($results[9]['title']); ?></button>
	</div>
	

	<p id = "demo"></p>
	<script type="text/javascript">
		function erase()
		{
			var top = document.getElementById("demo");
		    top.style.display = "none";
		}
		function display(int x)
		{
			var top = document.getElementById("demo");
		    top.style.display = "block";
			var recipe;
			switch(x)
			{
				case "1": recipe = '<?php //getdata($results,0); ?>';
						  break;
				case "2": recipe = '<?php //getdata($results,1); ?>';
						  break;
				case "3": recipe = '<?php //getdata($results,2); ?>';
						  break;
				case "4": recipe = '<?php //getdata($results,3); ?>';
						  break;
				case "5": recipe = '<?php //getdata($results,4); ?>';
						  break;
				case "6": recipe = '<?php //getdata($results,5); ?>';
						  break;
				case "7": recipe = '<?php //getdata($results,6); ?>';
						  break;
				case "8": recipe = '<?php //getdata($results,7); ?>';
						  break;
				case "9": recipe = '<?php //getdata($results,8); ?>';
						  break;
				case "10": recipe = '<?php //getdata($results,9); ?>';
						  break;
				default: var error = "Invalid Choice";
						 document.getElementById('demo').innerHTML = error;
						 break;
			}
			document.getElementById('demo').innerHTML = recipe;
		}
	</script> -->
</body>
</html>
