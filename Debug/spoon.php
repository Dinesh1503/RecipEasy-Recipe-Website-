<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css.css">
  </head>
  <body>
    <h1>Spoonacular</h1>
    <div class="search">
      <p>Query:</p>
      <form method="get">
        <input type="text" name="searchBox" class="text"/>
        <input type="submit" name="searchBtn" class="submit" value="qSearch"/>
      </form>
    </div>
    <button type="button" class="collapsible">Search By Ingredients</button>
    <div class="content">
      <form method="get">
        <!-- ingredients list -->
        <p >List of Ingredients:  <br><small>*comma seperated</small></p>
        <textarea id="ingrTextArea" name="ingrList" value="tomato, cheese, pepper"></textarea>
        <!-- ranking -->
        <p >Ranking:</p>
        <input type="radio" id="minimise" name="ranking" value="2">
        <label for="minimise">Minimise</label><br>
        <input type="radio" id="maximise" name="ranking" value="1">
        <label for="maximise">Maximise</label><br>
        <!-- complete the search -->
        <input type="submit" name="searchBtn" class="submit" value="ingrSearch"/>
      </form>
    </div>
    <button type="button" class="collapsible">General Search Settings</button>
    <div class="content">
      <!-- get number of search results -->
      <label for="quantity">Max Number of Results:</label><br>
      <input type="number" id="quantity" name="quantity" min="1" max="100" value="1">
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

    if(array_key_exists("searchBtn", $_GET)) {
      if ($_GET["searchBtn"] == "ingrSearch") {
        makeIngrSearch();
      } elseif ($_GET["searchBtn"] == "qSearch") {
        makeQuerySearch();
      } else {
        echo("NO");
      }
    }

    function makeQuerySearch() {

    }

    function makeIngrSearch() {
      $API = "https://api.spoonacular.com/recipes/findByIngredients";

      if (isset($_GET["ingrList"])) {
        $ingredients = "ingredients=".$_GET["ingrList"];
      } else {
        $ingredients = "ingredients=";
      }
      if (isset($_GET["ranking"])) {
        $ranking = "ranking=".$_GET["ranking"];
      } else {
        $ranking = "ranking=1";
      }
      $URL = "$API?".API_KEY."&$ingredients&$ranking";
      echo($URL);
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
      // parse JSON into useable objects
      $json = json_decode($head);
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
      console_log(count($json));
      for ($i = 0; $i < count($json); $i++) {
        $recipe = $json[$i];
        echo("<a><img src=$recipe->image style='width:100px; height:auto;'></img></br>$recipe->title</a>");
      }
      echo("</grid>");
    }

    ?>
  </body>
</html>
