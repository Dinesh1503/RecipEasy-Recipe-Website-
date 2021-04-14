<!DOCTYPE html>
<html>
<head>
	<title>Upload Page</title>
</head>
<style type="text/css" media="screen">
.label
{
  font-size: 25px;
  font-family: "Times New Roman",'Times',serif; 
}
h1
{

}
	div[id="ID"]
	{
		background-image: linear-gradient(white,turquoise);
		width: 100%;
		float:left;
	}
	.collapsible 
	{
	  background-image: linear-gradient(red,pink);
	  color: white;
	  cursor: pointer;
	  padding: 18px;
	  width: 15%;
	  border: solid black;
	  text-align: left;
	  outline: none;
	  font-size: 20px;
	  font-family: "Times New Roman",'Times',serif;
	  float: none;
	}

	.active, .collapsible:hover {
	  background-image: linear-gradient(white,black);
	  color: white;
	}

	.content {
	  padding: 20px 10px;
	  display: none;
	  overflow: hidden;
	  background-color: white;
	}
	input[type=text]
	{
	  font-size: 20px;
	  border: 2px solid black;
	  padding: 5px 5px;
	  font-family: "Times New Roman",'Times',serif;
	}
	input[type=submit]
	{
	  font-size: 20px;
	  border: 0.5px solid black;
	  padding: 5px 5px;
	  font-family: "Times New Roman",'Times',serif;
	}
	
	input[type=number]
	{
	  font-size: 20px;
	  border: 2px solid black;
	  padding: 5px 5px;
	  font-family: "Times New Roman",'Times',serif;
	}
	select
	{
		font-size: 20px;
	  border: 0.5px solid black;
	  padding: 5px 5px;
	  font-family: "Times New Roman",'Times',serif;
	}
	textarea
	{
		font-size: 20px;
		border: 2px solid black;
		padding: 5px 5px;
		font-family: "Times New Roman",'Times',serif;
	}
	.labels
	{
	  font-size: 25px;
	  padding: 5px 5px;
	  font-family: "Times New Roman",'Times',serif;
	}
	.grid-container 
	{
	  display: grid;
	  grid-template-columns: auto auto auto;
	  /*border: 3px solid rgba(0, 0, 0, 0.8);*/
	  background-color: none;/* #2196F3;*/
	  padding: 10px;
	  grid-column-gap: 10px;
	  grid-row-gap: 10px; 
	}
	.grid-item {
	  background-image: linear-gradient(to right,orange,red); /*rgba(255, 255, 255, 0.8);*/
	  border: 2px solid rgba(0, 0, 0, 0.8);
	  font-family: "Times New Roman",'Times', serif;
	  padding: 10px;
	  font-size: 20px;
	  text-align: left;
	}	
</style>
<script>
	function validate(title,author,servings,time,type,cuisne,ingredients,instructions)
	{
		if(validateForm(title) == true)
			if(validateForm(author) == true)
				if(validateForm(servings) == true)
					if(validateForm(time) == true)
						if(validateForm(type) == true)
							if(validateForm(cuisine) == true)
								if(validateForm(ingredients) == true)
									if(validateForm(instructions) == true)
										return true;
		else
			return false;
	}
function validateForm(str) {
  var x = document.forms["myForm"][str].value;
  if (x == "" || x == null) {
    alert(str + " must be filled out");
    event.preventDefault();
    return false;
  }
  else
  	return true;
}
</script>
<body>
	<div>
		<h1 style="
			font-size: 50px;
	font-family: 'Times New Roman','Times',serif; 
	">Upload your Page</h1>


		<form name="myForm" action="upload-test.php" method="post" onsubmit="validate(
		'title','author','servings','time','type','cuisne','ingredients','instructions')" required>
			<label class="label">Recipe Title: &emsp;</label>
			<input type="text" name="title">
			<br><br>

			<label class="label">Author: &emsp;</label>
			<input type="text" name="author">
			<br><br>

			<label class="label">Servings: &emsp;</label>
			<input type="text" name="servings" placeholder="eg: 6 Persons">
			<br><br>

			<label class="label">Time Required
			<small>*in mins</small>: &emsp;</label>
			<input type="text" name="time">
			<br><br>

			<div>
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
	        </div><br><br>

	        <div>
	          <label for="cuisine" class="labels">Choose Cuisine Type:</label>
	          <select name="cuisine" id="cuisineList">
	            <option value="None">None</option>
	            <option value="African">African</option>
	            <option value="American">American</option>
	            <option value="British">British</option>
	            <option value="Cajun">Cajun</option>
	            <option value="Caribbean">Caribbean</option>
	            <option value="Chinese">Chinese</option>
	            <option value="Eastern European">Eastern European</option>
	            <option value="European">European</option>
	            <option value="French">French</option>
	            <option value="German">German</option>
	            <option value="Greek">Greek</option>
	            <option value="Indian">Indian</option>
	            <option value="Irish">Irish</option>
	            <option value="Italian">Italian</option>
	            <option value="Japanese">Japanese</option>
	            <option value="Jewish">Jewish</option>
	            <option value="Korean">Korean</option>
	            <option value="Latin American">Latin American</option>
	            <option value="Mediterranean">Mediterranean</option>
	            <option value="Mexican">Mexican</option>
	            <option value="Middle Eastern">Middle Eastern</option>
	            <option value="Nordic">Nordic</option>
	            <option value="Southern">Southern</option>
	            <option value="Spanish">Spanish</option>
	            <option value="Thai">Thai</option>
	            <option value="Vietnamese">Vietnamese</option>
	          </select>
	        </div><br><br>


	        <div>
			<label class="label">Ingredients and Quantity: <br></label>
			<textarea name="ingredients" rows="5" cols="100" placeholder="1-Ingr A - Quantity B unit C"></textarea>
			<br><br>
			</div>

			<div>
			<label class="label">Description/Instructions <br></label>
			<textarea name="instructions" rows="10" cols="130" placeholder="1-Instruction1"></textarea>
			<br><br>
			</div>
			<input type="submit" name="submit" value="&#128269">
		</form>	
	</div>
</body>
</html>