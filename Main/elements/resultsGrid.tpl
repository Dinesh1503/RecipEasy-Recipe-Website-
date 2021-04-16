<div class="searchResults" >
    <div class="grid-settings">
    <form method = 'POST'>
        <label for="number">Max Number of Results:</label>
		<input type="number" id="quantity" name="number" min="1" max="100" value="10">
		<label for="offset">Number Results to Skip:</label>
		<input type="number" id="skips" name="offset" min="0" max="900" value="0">
		<br>
		<br>
		<label for="sortDirection">Sort Order:</label>
		<select name="sortDirection" id="sortDirection">
			<option value="asc">Ascending</option>
			<option value="desc">Descending</option>
		</select>
		<label for="sort">Sort By:</label>
		<select name="sort" id="sort">
			<option value=""></option>
			<option value="meta-score">Meta-Score</option>
			<option value="popularity">Popularity</option>
			<option value="healthiness">Healthiness</option>
			<option value="price">Price</option>
			<option value="time">Time</option>
			<option value="random">Random</option>
			<option value="max-used-ingredients">Max-Used-Ingredients</option>
			<option value="min-missing-ingredients">Min-Missing-Ingredients</option>
			<option value="alcohol">Alcohol</option>
			<option value="caffeine">Caffeine</option>
			<option value="energy">Energy</option>
			<option value="protein">Protein</option>
			<option value="sodium">Sodium</option>
			<option value="sugar">Sugar</option>
			<option value="calories">Calories</option>
			<option value="carbohydrates">Carbohydrates</option>
			<option value="carbs">Carbs</option>
			<option value="cholesterol">Cholesterol</option>
			<option value="total-fat">Total-Fat</option>
			<option value="trans-fat">Trans-Fat</option>
			<option value="saturated-fat">Saturated-Fat</option>
			<option value="fiber">Fiber</option>
		</select>
		<input type = 'submit' value = 'Save'>
		</form>
    </div>
    <div class="results-grid">
        [@results]
    </div>
</div>