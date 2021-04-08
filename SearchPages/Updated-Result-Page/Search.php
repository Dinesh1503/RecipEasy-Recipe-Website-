<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="improvedCSS.css">
  </head>
  <body>
    <h1>Search Page</h1>
    <div class="searchBar">
      <form method="post" action="onlyphp.php">
        <!-- Set Ingredients -->
        <button type="button" class="collapsible">Search / Ingredients</button>
        <div class="content" id="ID">
          <!-- query -->
          <br><label for="query" class="labels">Search Query: </label>
          <input type="text" name="query" class="text"/>
          <br><br>

          <label for="number" class="labels">Max Number of Results:</label>
          <input type="number" id="quantity" name="number" min="1" max="30"><br><br>
          
          <label for="maxtime" class="labels">Maximum Time for Recipes: </label>
          <input type="number" name="maxtime" min='0'><br><br>

          
          <!-- ingredients list -->
          <label for="ingr_number" class="labels">Enter number of Ingredients: </label>
          <input type="number" name="ingr_number" min = "2"><br><br>
          <label for="ingrTextArea" class="labels">List of Ingredients:  <br><small>*space seperated (ingr A, ingr B, ingr C)</small></label><br>
          <textarea id="ingrTextArea" name="includeIngredients" rows="5" cols="40"></textarea>
          <input type="submit" name="searchBtn" class="submit" value="&#128269">
        </div>

        <button type="button" class="collapsible">Meal Type</button>
        <div class="content" id="ID"><br>
          <label class="labels">Select Meal Types:</label>
          <div class="grid-container">
            <div>
              <input type="radio" id="mealType1" name="type" value="main course">
              <label for="mealType1" class="labels">Main Course</label>
            </div>
            <div>
              <input type="radio" id="mealType2" name="type" value="side dish">
              <label for="mealType2" class="labels">Side Dish</label>
            </div>
            <div>
              <input type="radio" id="mealType3" name="type" value="dessert">
              <label for="mealType3" class="labels">Dessert</label>
            </div>
            <div>
              <input type="radio" id="mealType4" name="type" value="appetizer">
              <label for="mealType4" class="labels">Appetizer</label>
            </div>
            <div>
              <input type="radio" id="mealType5" name="type" value="salad">
              <label for="mealType5" class="labels">Salad</label>
            </div>
            <div>
              <input type="radio" id="mealType6" name="type" value="bread">
              <label for="mealType6" class="labels">Bread</label>
            </div>
            <div>
              <input type="radio" id="mealType7" name="type" value="breakfast">
              <label for="mealType7" class="labels">Breakfast</label>
            </div>
            <div>
              <input type="radio" id="mealType8" name="type" value="soup">
              <label for="mealType8" class="labels">Soup</label>
            </div>
            <div>
              <input type="radio" id="mealType9" name="type" value="beverage">
              <label for="mealType9" class="labels">Beverage</label>
            </div>
            <div>
              <input type="radio" id="mealType10" name="type" value="sauce">
              <label for="mealType10" class="labels">Sauce</label>
            </div>
            <div>
              <input type="radio" id="mealType11" name="type" value="marinade">
              <label for="mealType11" class="labels">Marinade</label>
            </div>
            <div>
              <input type="radio" id="mealType12" name="type" value="fingerfood">
              <label for="mealType12" class="labels">Fingerfood</label>
            </div>
            <div>
              <input type="radio" id="mealType13" name="type" value="snack">
              <label for="mealType13" class="labels">Snack</label>
            </div>
            <div>
              <input type="radio" id="mealType14" name="type" value="drink">
              <label for="mealType14" class="labels">Drink</label>
            </div>
          </div>
          <input type="submit" name="searchBtn" class="submit" value="&#128269">
        </div>

    </form>
    </div>

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