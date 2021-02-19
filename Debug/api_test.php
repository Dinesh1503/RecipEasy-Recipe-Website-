<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>My First Heading</h1>
    <?php
      // all php code is wrapped in php tags
      // echo or print writes to the main html page
      echo("<p>Hello World<p>\n");
      print("<p>Code writes webpage</p>\n");
    ?>
    <button id="btn" onclick="document.getElementById('btn').innerText='Hi'">Click Me</button>
    <br></br>
    <?php 
    // functions are same as ever but no type def in php
    // this is a basic console log by making a js script and dumping the message
    function console_log($msg) {
      echo("<script>console.log('$msg')</script>");
    } 
    console_log("Hello Console");
   
    // API

    // Test account api id and key
    // Only has 5000 requests so dont spam the shit out of it
    $APP_ID = "bfd62dd1";
    $APP_KEY = "e71158e6916e67abf8e557cff75df41c";
    $API = "https://api.edamam.com/search";
    // this is where you write the request by combining it into a url
    $URL = $API . "?q=chicken&app_id=" . $APP_ID . "&app_key=" . $APP_KEY . "&from=0&to=3&calories=591-722&health=alcohol-free";
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
    echo("q = $json->q<br/>");
    ?>
  </body>
</html>
