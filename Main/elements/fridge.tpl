<link rel="stylesheet" type="text/css" href="css/fridge.css">
<h2>Add Ingredients to Fridge</h2>
<div class="fridge-form">
    <!-- <form method="get"> -->
        <!-- ingredients list -->
        <!-- <label for="addIngrList1">Ingredients</label>
        <input type="text" id="ingredientinput" type="text" name="addIngrList1" value="[@ingredients]"></input type="text"> -->
        <!-- complete the search -->
        <!-- <br><input type="submit" name="searchBtn" class="submit" value="Set Fridge"/>
    </form> -->

      <form method="get">
        <!-- ingredients list -->
        <p>User ID<br><small></small></p>
          <textarea id="ingredientTextArea" name="userID" value="tomato, cheese, pepper"></textarea>
        <p >Ingredients <br><small>comma separated</small></p>
        <textarea id="ingredientTextArea" name="addIngrList" value="tomato, cheese, pepper"></textarea>
        <!-- complete the search -->
        <input type="submit" name="searchBtn" class="submit" value="Add Ingredients"/>
      </form>

</div>
<h2>Change Ingredients</h2>
<div class="fridge-form">
  <form method="get">
    <!-- ingredients list -->
    <p>User ID<br><small></small></p>
      <textarea id="ChangeIngredientTextArea" name="userIDChange" value="tomato, cheese, pepper"></textarea>
    <p >Ingredients  <br><small>old->new</small><br><small>comma separated</small><br><small>To delete: old->remove</small></p>
    <textarea id="ChangeIngredientTextArea" name="ChangeIngrList" value="tomato, cheese, pepper"></textarea>

    <!-- complete the search -->
    <input type="submit" name="searchBtn" class="submit" value="Change Ingredients"/>
  </form>
  </div>
<h2>Show Fridge</h2>
<div class = "fridge-form">
  <form method = "get">
    <p>Enter User ID  <br><small></small></p>
    <textarea id="userIdTextArea" name="userIdList" value="tomato, cheese, pepper"></textarea>
    <!-- complete the search -->
    <input type="submit" name="searchBtn" class="submit" value="Show Fridge"/>
  </form>
</div>

</div>
