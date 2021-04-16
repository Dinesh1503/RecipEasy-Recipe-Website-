<link rel="stylesheet" type="text/css" href="css/fridge.css">

<div class="fridge-form">
  <form method="get">
    <h2>My Fridge</h2>
    <h5>Current Items:</h5>
    <div class="fridge-list">
      [@items]
    </div>
    <h5>Add Ingredient to Fridge:</h5>
    <input type="text" id="addIngr" name="addIngr" value=""></input>
    <input type="submit" name="addBtn" class="submit" value="Add Ingredient"></input>
    <h2>Diet Preferences</h2>

    <div class="dual-column">
      <div class="column">
        <div class="column-title">
          <h5>Set Diet:</h5>
        </div>
        <div class="grid-container">
          [@diet]
        </div>
      </div>
      <div class="column">
        <div class="column-title">
          <h5>Set Intolerances:</h5>
        </div>
        <div class="grid-container">
          [@intolerances]
        </div>
      </div>
    </div>
    
    <div>
      <h5>Default Use Preferences:</h5>
      <label for="usePreferences">Use preferences by default</label>
      <input type="checkbox" id="usePreferences" name="usePreferences" value="true" [@UsePreferences]></input>
      <br>
      <input type="submit" id="updateBtn" name="updateBtn" value="Update Preferences"></input> 
    </div>
     
  </form>
</div>