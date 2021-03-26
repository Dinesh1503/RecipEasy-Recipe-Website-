<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css.css">
  </head>
  <body>
    <h1>Spoonacular</h1>
    <div class="searchBar">
      <form method="get" style="display:block;text-decoration:none;">
        <br/>
        <!-- Set Ingredients -->
        <button type="button" class="collapsible">Search By Ingredients</button>
        <div class="content">
          <!-- query -->
          <label for="query">Query:</label>
          <input type="text" name="query" class="text"/>
          <input type="submit" name="searchBtn" class="submit" value="submit"/>
          <br>
          <!-- ingredients list -->
          <label for="ingrTextArea">List of Ingredients:  <br><small>*comma seperated</small></label>
          <textarea id="ingrTextArea" name="includeIngredients" value=""></textarea>
        </div>
        <button type="button" class="collapsible">General Search Settings</button>
        <div class="content">
          <!-- get number of search results -->
          <label for="number">Max Number of Results:</label><br>
          <input type="number" id="quantity" name="number" min="1" max="100" value="10">
          <label for="offset">Number Results to Skip:</label><br>
          <input type="number" id="skips" name="offset" min="0" max="900" value="0">
          <select name="sortDirection" id="sortDirection">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
          </select>
          <label for="sort">Sort By:</label>
          <select name="sort" id="sort">
            <option value=""></option>
            <option value="meta-score">Meta-Score</option>
            <option value="popularity">Popularity</option>
            <option value="healthiness">Healthiness</option>
            <option value="price">Price</option>
            <option value="time">Time</option>
            <option value="random">Random</option>
            <option value="max-used-ingredients">Max-Used-Ingredients</option>
            <option value="min-missing-ingredients">Min-Missing-Ingredients</option>
            <option value="alcohol">Alcohol</option>
            <option value="caffeine">Caffeine</option>
            <option value="energy">Energy</option>
            <option value="protein">Protein</option>
            <option value="sodium">Sodium</option>
            <option value="sugar">Sugar</option>
            <option value="calories">Calories</option>
            <option value="carbohydrates">Carbohydrates</option>
            <option value="carbs">Carbs</option>
            <option value="cholesterol">Cholesterol</option>
            <option value="total-fat">Total-Fat</option>
            <option value="trans-fat">Trans-Fat</option>
            <option value="saturated-fat">Saturated-Fat</option>
            <option value="fiber">Fiber</option>
          </select>
          <input type="submit" name="updateBtn" class="submit" value="Update Results"/>
        </div>
        <br/>
        <!-- Set diet type -->
        <button type="button" class="collapsible">Diet Type</button>
        <div class="content">
          <label>Select Diet:</label>
          <div class="grid-container">
            <div>
              <input type="radio" id="diet0" name="diet" value="">
              <label for="diet0">Unrestricted</label>
            </div>
            <div>
              <input type="radio" id="diet1" name="diet" value="Gluten Free">
              <label for="diet1">Gluten Free</label>
            </div>
            <div>
              <input type="radio" id="diet2" name="diet" value="Ketogenic">
              <label for="diet2">Ketogenic</label>
            </div>
            <div>
              <input type="radio" id="diet3" name="diet" value="Vegetarian">
              <label for="diet3">Vegetarian</label>
            </div>
            <div>
              <input type="radio" id="diet4" name="diet" value="Lacto-Vegetarian">
              <label for="diet4">Lacto-Vegetarian</label>
            </div>
            <div>
              <input type="radio" id="diet5" name="diet" value="Ovo-Vegetarian">
              <label for="diet5">Ovo-Vegetarian</label>
            </div>
            <div>
              <input type="radio" id="diet6" name="diet" value="Vegan">
              <label for="diet6">Vegan</label>
            </div>
            <div>
              <input type="radio" id="diet7" name="diet" value="Pescetarian">
              <label for="diet7">Pescetarian</label>
            </div>
            <div>
              <input type="radio" id="diet8" name="diet" value="Paleo">
              <label for="diet8">Paleo</label>
            </div>
            <div>
              <input type="radio" id="diet9" name="diet" value="Primal">
              <label for="diet9">Primal</label>
            </div>
            <div>
              <input type="radio" id="diet10" name="diet" value="Whole30">
              <label for="diet10">Whole30</label>
            </div>
          </div>
        </div>
        <br/>
        <!-- Set intolerance(s) -->
        <button type="button" class="collapsible">Intolerances</button>
        <div class="content">
          <label>Set Intolerances:</label>
          <div class="grid-container">
            <div>
              <input type="checkbox" id="intolerance1" name="intolerances" value="Dairy">
              <label for="intolerance1">Dairy</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance2" name="intolerances" value="Egg">
              <label for="intolerance2">Egg</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance3" name="intolerances" value="Gluten">
              <label for="intolerance3">Gluten</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance4" name="intolerances" value="Grain">
              <label for="intolerance4">Grain</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance5" name="intolerances" value="Peanut">
              <label for="intolerance5">Peanut</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance6" name="intolerances" value="Seafood">
              <label for="intolerance6">Seafood</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance7" name="intolerances" value="Sesame">
              <label for="intolerance7">Sesame</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance8" name="intolerances" value="Shellfish">
              <label for="intolerance8">Shellfish</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance9" name="intolerances" value="Soy">
              <label for="intolerance9">Soy</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance10" name="intolerances" value="Sulfite">
              <label for="intolerance10">Sulfite</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance11" name="intolerances" value="Tree Nut">
              <label for="intolerance11">Tree Nut</label>
            </div>
            <div>
              <input type="checkbox" id="intolerance12" name="intolerances" value="Wheat">
              <label for="intolerance12">Wheat</label>
            </div>
          </div>
        </div>
        <br/>
        <!-- Set cuisin type -->
        <button type="button" class="collapsible">Cuisine Type</button>
        <div class="content">
          <br/>
          <label for="cuisine">Choose Cuisine Type:</label>
          <select name="cuisine" id="cuisineList">
            <option value=""></option>
            <option value="African">African</option>
            <option value="American">American</option>
            <option value="British">British</option>
            <option value="Cajun">Cajun</option>
            <option value="Caribbean">Caribbean</option>
            <option value="Chinese">Chinese</option>
            <option value="Eastern European">Eastern European</option>
            <option value="European">European</option>
            <option value="French">French</option>
            <option value="German">German</option>
            <option value="Greek">Greek</option>
            <option value="Indian">Indian</option>
            <option value="Irish">Irish</option>
            <option value="Italian">Italian</option>
            <option value="Japanese">Japanese</option>
            <option value="Jewish">Jewish</option>
            <option value="Korean">Korean</option>
            <option value="Latin American">Latin American</option>
            <option value="Mediterranean">Mediterranean</option>
            <option value="Mexican">Mexican</option>
            <option value="Middle Eastern">Middle Eastern</option>
            <option value="Nordic">Nordic</option>
            <option value="Southern">Southern</option>
            <option value="Spanish">Spanish</option>
            <option value="Thai">Thai</option>
            <option value="Vietnamese">Vietnamese</option>
          </select>
        </div>
        <br/>
        <!-- Meal Type -->
        <button type="button" class="collapsible">Meal Type</button>
        <div class="content">
          <label>Select Meal Types:</label>
          <div class="grid-container">
            <div>
              <input type="checkbox" id="mealType1" name="type" value="main course">
              <label for="mealType1">Main Course</label>
            </div>
            <div>
              <input type="checkbox" id="mealType2" name="type" value="side dish">
              <label for="mealType2">Side Dish</label>
            </div>
            <div>
              <input type="checkbox" id="mealType3" name="type" value="dessert">
              <label for="mealType3">Dessert</label>
            </div>
            <div>
              <input type="checkbox" id="mealType4" name="type" value="appetizer">
              <label for="mealType4">Appetizer</label>
            </div>
            <div>
              <input type="checkbox" id="mealType5" name="type" value="salad">
              <label for="mealType5">Salad</label>
            </div>
            <div>
              <input type="checkbox" id="mealType6" name="type" value="bread">
              <label for="mealType6">Bread</label>
            </div>
            <div>
              <input type="checkbox" id="mealType7" name="type" value="breakfast">
              <label for="mealType7">Breakfast</label>
            </div>
            <div>
              <input type="checkbox" id="mealType8" name="type" value="soup">
              <label for="mealType8">Soup</label>
            </div>
            <div>
              <input type="checkbox" id="mealType9" name="type" value="beverage">
              <label for="mealType9">Beverage</label>
            </div>
            <div>
              <input type="checkbox" id="mealType10" name="type" value="sauce">
              <label for="mealType10">Sauce</label>
            </div>
            <div>
              <input type="checkbox" id="mealType11" name="type" value="marinade">
              <label for="mealType11">Marinade</label>
            </div>
            <div>
              <input type="checkbox" id="mealType12" name="type" value="fingerfood">
              <label for="mealType12">Fingerfood</label>
            </div>
            <div>
              <input type="checkbox" id="mealType13" name="type" value="snack">
              <label for="mealType13">Snack</label>
            </div>
            <div>
              <input type="checkbox" id="mealType14" name="type" value="drink">
              <label for="mealType14">Drink</label>
            </div>
          </div>
        </div>
        <br/>
      </form>
    </div>

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
      coll[i].nextElementSibling.style.display = "block";
    }
    </script>
    <?php
    // functions are same as ever but no type def in php
    // this is a basic console log by making a js script and dumping the message
    const API_KEY = "apiKey=ce69626b9c314ae1b20dd3f93aa0b2a7";

    function console_log($msg) {
      echo("<script>console.log('$msg')</script>");
    }
    console_log("Hello Console");

    if(array_key_exists("searchBtn", $_GET) || array_key_exists("updateBtn", $_GET)) {
      makeSearch();
    }

    function makeSearch() {
      $API = "https://api.spoonacular.com/recipes/complexSearch";
      $URL = $API . "?" . API_KEY;
      // COMPILE REST OF REQUEST HERE
      $INSTRUCTIONS = "&instructionsRequired=true";
      $INFO = "&addRecipeInformation=true&addRecipeNutrition=true";
      foreach ($_GET as $key => $val) {
        if ($key == "searchBtn") {
          continue;
        } elseif ($val == "") {
          continue;
        }      
        $URL = $URL . "&$key=$val";

      }
      $URL = str_replace(" ", "%20", $URL . $INSTRUCTIONS . $INFO);
      echo($URL);
      echo("<br>");
      makeCURL($URL);
     }

    function makeCURL($URL) {
      ///---API---///
      console_log($URL);
      // create client url (CURL)
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
      // write status to console for debug
      console_log($httpCode);
      if ($httpCode == 401) {
        echo("<br>HTTP ERROR 401: BAD REQUEST");
        return;
      }
      // parse JSON into useable objects
      $json = json_decode($head);
      echo($head);
      echo("<style>
        a {
          background-color:#333;
          color:white;
          text-align:center;
        }
        a:hover {
          background-color:#555;
        }
      </style>");
      echo("<div style='display:grid; grid-template-columns: 20% 20% 20% 20%'>");
      console_log($json->totalResults);
      if ($json->totalResults == 0) {
        echo("NO RESULTS FOUND THAT MATCH THE CRITERIA");
      }
      for ($i = 0; $i < $json->totalResults; $i++) {
        $recipe = $json[$i];
        echo("<a><img src=$recipe->image style='width:100px; height:auto;'></img></br>$recipe->title</a>");
      }
      echo("</grid>");
    }

    ?>
  </body>
</html>