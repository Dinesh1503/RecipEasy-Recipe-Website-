<div class="searchBar">
	<form method="get" style="display:block;text-decoration:none;">

		<!-- Set Ingredients -->
		<button type="button" class="collapsible">Search By Ingredients</button>
		<div class="content">
			<!-- query -->
			<input type="submit" name="searchBtn" class="submit" value="Search" style="width: 80%;"/>
			<br>
			<!-- ingredients list -->
			<br>
			<label for="ingrTextArea">Add Search Ingredients:</label>
			<textarea id="ingrTextArea" name="includeIngredients" value=""></textarea>
			<br>
			<label for="ingrTextArea"><small>*comma seperated</small></label>
			<br>
			<label for="fridgeCheckbox">Use your Fridge</label>
			<input type="checkbox" id="fridgeCheckbox" name="useFridge" value="true" [@UsePreferences]>
		</div>

	</form>
</div>
