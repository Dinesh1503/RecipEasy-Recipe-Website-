<div class="searchBar">
	<form method="get" style="display:block;text-decoration:none;">

		<!-- Set Ingredients -->
		<button type="button" class="collapsible">Search By Ingredients</button>
		<div class="content">
			<!-- query -->
			<input type="submit" name="searchBtn" class="submit" value="Search" style="width: 80%;"/>
			<br>
			<label for="query">Query:</label>
			<input type="text" name="query" class="text"/>
			<!-- ingredients list -->
			<label for="ingrTextArea">List of Ingredients:  <br><small>*comma seperated</small></label>
			<textarea id="ingrTextArea" name="includeIngredients" value=""></textarea>
			<br>
			<label for="fridgeCheckbox">Use your Fridge</label>
			<input type="checkbox" id="fridgeCheckbox" name="useFridge" value="true">
		</div>

		<!-- Meal Type -->
		<button type="button" class="collapsible">Meal Type</button>
		<div class="content">
			<label>Select Cuisine Type:</label>
			[@cuisine]
			<br>
			<label>Select Meal Type:</label>
			[@meal]
		</div>

		<!-- Set diet type -->
		<button type="button" class="collapsible">Diet Type</button>
		<div class="content">
			<label>Select Diet:</label>
			<div class="grid-container">
				[@diet]
			</div>
		</div>

		<!-- Set intolerance(s) -->
		<button type="button" class="collapsible">Intolerances</button>
		<div class="content">
			<label>Set Intolerances:</label>
			<div class="grid-container">
				[@intolerances]
			</div>
		</div>
		
	</form>
</div>