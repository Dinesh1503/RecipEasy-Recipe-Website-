<link rel="stylesheet" type="text/css" href="css/fridge.css">

<div class="fridge-form">
  <form method="get">
    <h2>Add Ingredients to Fridge</h2>
    <p >Ingredients <br><small>comma separated</small></p>
    <textarea id="ingredientTextArea" name="addIngrList" value="tomato, cheese, pepper"></textarea>
    <input type="submit" name="searchBtn" class="submit" value="Add Ingredients"/>

    <h2>Change Ingredients</h2>
    <p >Ingredients  <br><small>old->new</small><br><small>comma separated</small><br><small>To delete: old->remove</small></p>
    <textarea id="ChangeIngredientTextArea" name="ChangeIngrList" value="tomato, cheese, pepper"></textarea>
    <input type="submit" name="searchBtn" class="submit" value="Change Ingredients"/>

    <h2>Show Fridge</h2>
    <input type="submit" name="searchBtn" class="submit" value="Show Fridge"/>

  </form>
</div>