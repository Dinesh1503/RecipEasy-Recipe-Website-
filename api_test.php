<!DOCTYPE html>
<html>
  <head>
  </head>
  <body>
    <h1>My First Heading</h1>
    <?php echo("<p>Hello World<p>\n"); ?>
    <?php 
    function clog($msg) {
      echo("<script>console.log('" . $msg . "')</script>");
    } 
    clog("Hello Console");
    
    $APP_ID = "bfd62dd1";
    $APP_KEY = "e71158e6916e67abf8e557cff75df41c";
    $API = "https://api.edamam.com/search";
    $URL = $API . "?q=chicken&app_id=" . $APP_ID . "&app_key=" . $APP_KEY . "&from=0&to=3&calories=591-722&health=alcohol-free";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL);
    $head = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch); 
    clog($head);
    clog($httpCode);
    ?>
  </body>
</html>
