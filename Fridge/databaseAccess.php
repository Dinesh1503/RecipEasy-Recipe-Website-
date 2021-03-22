<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="css.css">
  </head>
  <body>
    <h1>Spoonacular</h1>
  <button type="button" class="collapsible">Add Ingredients to Fridge</button>
  <div class="content">
    <form method="get">
      <!-- ingredients list -->
      <p>User ID<br><small></small></p>
        <textarea id="ingredientTextArea" name="userID" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient 1 <br><small></small></p>
      <textarea id="ingredientTextArea" name="addIngrList1" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient 2  <br><small></small></p>
      <textarea id="ingredientTextArea" name="addIngrList2" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient 3 <br><small></small></p>
      <textarea id="ingredientTextArea" name="addIngrList3" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient 4 <br><small></small></p>
      <textarea id="ingredientTextArea" name="addIngrList4" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient 5 <br><small></small></p>
      <textarea id="ingredientTextArea" name="addIngrList5" value="tomato, cheese, pepper"></textarea>
      <!-- complete the search -->
      <input type="submit" name="searchBtn" class="submit" value="Add Ingredients"/>
    </form>
  </div>
  <button type="button" class="collapsible">Change Ingredients</button>
  <div class="content">
    <form method="get">
      <!-- ingredients list -->
      <p>User ID<br><small></small></p>
        <textarea id="ChangeIngredientTextArea" name="userIDChange" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient One:  <br><small></small></p>
      <textarea id="ChangeIngredientTextArea" name="ChangeIngrList1" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient Two:  <br><small></small></p>
      <textarea id="ChangeIngredientTextArea" name="ChangeIngrList2" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient Three:  <br><small></small></p>
      <textarea id="ChangeIngredientTextArea" name="ChangeIngrList3" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient Four:  <br><small></small></p>
      <textarea id="ChangeIngredientTextArea" name="ChangeIngrList4" value="tomato, cheese, pepper"></textarea>
      <p >Ingredient Five:  <br><small></small></p>
      <textarea id="ChangeIngredientTextArea" name="ChangeIngrList5" value="tomato, cheese, pepper"></textarea>
      <!-- complete the search -->
      <input type="submit" name="searchBtn" class="submit" value="Change Ingredients"/>
    </form>
  </div>
  <button type="button" class="collapsible">Show Fridge</button>
  <div class="content">
    <form method="get">
      <!-- ingredients list -->
      <p >Enter User ID  <br><small></small></p>
      <textarea id="userIdTextArea" name="userIdList" value="tomato, cheese, pepper"></textarea>
      <!-- complete the search -->
      <input type="submit" name="searchBtn" class="submit" value="Show Fridge"/>
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
}
</script>

<?php
function console_log($msg) {
  echo("<script>console.log('$msg')</script>");
}
console_log("Hello Console");

if(array_key_exists("searchBtn", $_GET)) {
  if ($_GET["searchBtn"] == "Add Ingredients") {
    AddIngr();
  } elseif ($_GET["searchBtn"] == "Change Ingredients") {
    changeFridge();
  }
  elseif ($_GET["searchBtn"] == "Show Fridge") {
   showFridge();
 }
  else {
    echo("NO");
  }
}

function AddIngr(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $database = "Fridge";
  $conn = mysqli_connect($servername, $username, $password, $database);
  if (!$conn)
    {
      die("Connection failed: " . mysqli_connect_error());
    }

    echo "Connected successfully";
    $id = $_GET["userID"];
    $ingredient1 = $_GET["addIngrList1"];
    $ingredient2 = $_GET["addIngrList2"];
    $ingredient3 = $_GET["addIngrList3"];
    $ingredient4 = $_GET["addIngrList4"];
    $ingredient5 = $_GET["addIngrList5"];

  $sql = "INSERT INTO fridge (userID, INGREDIENT_ONE,INGREDIENT_TWO,INGREDIENT_THREE,INGREDIENT_FOUR,INGREDIENT_FIVE)
          VALUES ('$id','$ingredient1', '$ingredient2', '$ingredient3', '$ingredient4', '$ingredient5')
          ";
  if ($conn->query($sql))
  {
    echo ("Record created successfully");
  }
  else
  {
    echo("Error: " . $conn->error);
  }

  $sql = "SELECT * FROM fridge where userID = $id";
  $result = $conn->query($sql);



  if ($result->num_rows > 0) {
    // output data of each row

    $output = "<table border = '2'>
                <th>UserId</th>
                <th>Ingredient One</th>
                <th>Ingredeint 2</th>
                <th>Ingredient 3</th>
                <th>Ingredient 4</th>
                <th>Ingredient 5</th>
                ";
    while($row = $result->fetch_assoc()) {
      $output .= "<tr>
                    <td>$row[userID]</td>
                    <td>$row[INGREDIENT_ONE]</td>
                    <td>$row[INGREDIENT_TWO]</td>
                    <td>$row[INGREDIENT_THREE]</td>
                    <td>$row[INGREDIENT_FOUR]</td>
                    <td>$row[INGREDIENT_FIVE]</td>
                    </tr>";
    }
    $output .="</table>";
    echo ($output);
  } else {
    echo "0 results";
  }
  $conn->close();


}

function RemoveIngr(){


}



function showFridge(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $database = "Fridge";
  $conn = mysqli_connect($servername, $username, $password, $database);
  if (!$conn)
    {
      die("Connection failed: " . mysqli_connect_error());
    }

  echo "Connected successfully";

  $userid = $_GET["userIdList"];

  $sql ="SELECT * FROM fridge WHERE userID = $userid";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row

    $output = "<form><table border = '2'>
                <th>UserId</th>
                <th>Ingredient One</th>
                <th>Ingredient Two</th>
                <th>Ingredient Three</th>
                <th>Ingredient Four</th>
                <th>Ingredient Five</th>
                </form>
                ";
    while($row = $result->fetch_assoc()) {
      $output .= "<tr>
                    <td>$row[userID]</td>
                    <td>$row[INGREDIENT_ONE]></td>
                    <td>$row[INGREDIENT_TWO] </td>
                    <td>$row[INGREDIENT_THREE]</td>
                    <td>$row[INGREDIENT_FOUR]</td>
                    <td>$row[INGREDIENT_FIVE]</td>
                    </tr>";

    }
    $output .="</table>";
    echo ($output);


  } else {
    echo "0 results";


  }






  $conn->close();


}

function changeFridge(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $database = "Fridge";
  $conn = mysqli_connect($servername, $username, $password, $database);



  $userid = $_GET["userIDChange"];

  $sql = "SELECT * FROM fridge WHERE userID = $userid";
  $result = $conn->query($sql);


$ingredients=$result->fetch_assoc();
$ingredients = implode(",",$ingredients);
$ingredients = str_replace(">","",$ingredients);
$ingredients = explode(",", $ingredients);


  if (empty($_GET["ChangeIngrList1"])){
    $ingredient1 = $ingredients[1];
  }
  elseif($_GET["ChangeIngrList1"] == "remove"){

    $ingredient1 = "";
  }
  else{
    $ingredient1 = $_GET["ChangeIngrList1"];
  }
  if (empty($_GET["ChangeIngrList2"])){
    $ingredient2 = $ingredients[2];
  }
  elseif($_GET["ChangeIngrList2"] == "remove"){

    $ingredient2 = "";
  }
  else{
    $ingredient2 = $_GET["ChangeIngrList2"];
  }
  if (empty($_GET["ChangeIngrList3"])){
    $ingredient3 = $ingredients[3];
  }
  elseif($_GET["ChangeIngrList3"] == "remove"){

    $ingredient3 = "";
  }
  else{
    $ingredient3 = $_GET["ChangeIngrList3"];
  }
  if (empty($_GET["ChangeIngrList4"])){
    $ingredient4 = $ingredients[4];
  }
  elseif($_GET["ChangeIngrList4"] == "remove"){

    $ingredient4 = "";
  }
  else{
    $ingredient4 = $_GET["ChangeIngrList4"];
  }
  if (empty($_GET["ChangeIngrList5"])){
    $ingredient5 = $ingredients[5];
  }
  elseif($_GET["ChangeIngrList5"] == "remove"){

    $ingredient5 = "";
  }
  else{
    $ingredient5 = $_GET["ChangeIngrList5"];
  }

  $sql = "UPDATE fridge SET INGREDIENT_ONE = '$ingredient1',INGREDIENT_TWO = '$ingredient2',INGREDIENT_THREE = '$ingredient3',INGREDIENT_FOUR = '$ingredient4',INGREDIENT_FIVE = '$ingredient5' WHERE userID = $userid";

  if ($conn->query($sql))
  {
    echo ("Record updated successfully");
  }
  else
  {
    echo("Error: " . $conn->error);
  }

  $conn->close();
}

 ?>
</body>
</html>
