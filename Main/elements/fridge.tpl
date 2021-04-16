<link rel="stylesheet" type="text/css" href="css/fridge.css">

<div class="fridge-form">
  <form method="get">
    <h1>My Fridge</h1>
    <h1>Current Items:</h1>
    <div class="fridge-list">
      [@items]
    </div>
    <p>
    <input type="text" id="addIngr" name="addIngr" value=""></input>
    <input type="submit" name="addBtn" class="submit" value="Add Ingredient"></input>
    <h1>Diet Preferences</h1>

    <div class="dual-column">
      <div class="column">
        <div class="column-title">
          <h1 class = "h5">Set Diet:</h1>
        </div>
        <div class="grid-container">
          [@diet]
        </div>
      </div>
      <div class="column">
        <div class="column-title">
          <h1 class = "h5">Set Intolerances:</h1>
        </div>
        <div class="grid-container">
          [@intolerances]
        </div>
      </div>
    </div>

    <div>
      <label for="usePreferences">Use preferences by default</label>
      <input type="checkbox" id="usePreferences" name="usePreferences" value="true"></input>
      <br>
      <input type="submit" id="updateBtn" name="updateBtn" value="Update Preferences"></input>
    </div>

  </form>
</div>
