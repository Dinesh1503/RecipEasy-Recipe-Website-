<link rel="stylesheet" type="text/css" href="css/upload.css">

<script>
	function validate(pictureInput,titleInput,diets[],servings,time,mealInput,cuisineInput,ingredientsInput,descriptionInput,intolerances[])
	{
		if(validateForm(titleInput) == true)
			if(validateForm(diets[]) == true)
				if(validateForm(servingInput) == true)
					if(validateForm(timeInput) == true)
						if(validateForm(mealInput) == true)
							if(validateForm(cuisineInput) == true)
								if(validateForm(ingredientsInput) == true)
									if(validateForm(descriptionInput) == true)
										if(validateForm(intolerances[]) == true)
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

<h1 >Upload Your Own Recipes!</h1>
<div class="column">
<form action='processing.php' method='POST' enctype='multipart/form-data'
onsubmit="validate('pictureInput',
		'titleInput','diets[]','servingInput','timeInput','mealInput','cuisineInput','ingredientsInput','descriptionInput','intolerances[]')" required>

    <div class='form-group'>
        <label for='photo'>Your photo</label><br>
        <input type='file' accept='.jpeg, .jpg, .png, .gif, .bmp, .webp, .raw, .ico, .tiff'
        class='form-control-file w-50' id='photo' name='pictureInput' required>
        <br><br>
    </div>

    <div class = 'row'>

        <div class='col'>
            <div class='form-group'>
                <div>
                    <label class='form-label' for='cuisine-select'>Cuisine Type</label>
                    <select class='form-select' aria-label='Default select example' name='cuisineInput' id='cuisine-select' required>
                        <option value='British'>British</option>
                        <option value='French'>French</option>
                        <option value='Italian'>Italian</option>
                        <option value="German">German</option>
                        <option value="Greek">Greek</option>
                        <option value="Nordic">Nordic</option>
                        <option value="Spanish">Spanish</option>
                        <option value='Central Europe'>Central Europe</option>
                        <option value="European">European</option>
                        <option value='Eastern Europe'>Eastern Europe</option>
                        <option value='Caribbean'>Caribbean</option>
                        <option value='Chinese'>Chinese</option>
                        <option value='Japanese'>Japanese</option>
                        <option value='Indian'>Indian</option>
                        <option value='South East Asia'>South East Asia</option>
                        <option value="Thai">Thai</option>
                        <option value="Korean">Korean</option>
                        <option value="Vietnamese">Vietnamese</option>
                        <option value='American'>American</option>
                        <option value='Mexican'>Mexican</option>
                        <option value="Jewish">Jewish</option>
                        <option value="African">African</option>
                        <option value="Cajun">Cajun</option>
                        <option value="Irish">Irish</option>
                        <option value="Latin American">Latin American</option>
                        <option value="Mediterranean">Mediterranean</option>
                        <option value="Middle Eastern">Middle Eastern</option>
                        <option value="Southern">Southern</option>
                    </select>
                </div>
                
                <div>
                    <label class='form-label' for='meal-select'>Meal Type</label>
                    <select class='form-select' aria-label='Default select example' name='mealInput' id='meal-select' required>
                        <option name="type" value="main course">Main Course</option>
                        <option name="type" value="side dish">Side Dish</option>
                        <option name="type" value="dessert">Dessert</option>
                        <option name="type" value="appetizer">Appetizer</option>
                        <option name="type" value="salad">Salad</option>
                        <option name="type" value="bread">Bread</option>
                        <option name="type" value="breakfast">Breakfast</option>
                        <option name="type" value="soup">Soup</option>
                        <option name="type" value="beverage">Beverage</option>
                        <option name="type" value="sauce">Sauce</option>
                        <option name="type" value="marinade">Marinade</option>
                        <option name="type" value="fingerfood">Fingerfood</option>
                        <option name="type" value="snack">Snack</option>
                        <option name="type" value="drink">Drink</option>
                    </select>
                </div>
                

                <div class='outline'>
                    <label class='form-label' for='serveNum'>Number of Servings</label>
                    <input type='number' min='1' max='12' id='serveNum' name='servingInput' class='form-control input-sm' required/>
                </div>

                <div class='outline'>
                    <label class='form-label' for='cookTime'>Cooking Time (min)</label>
                    <input type='number' min='0' id='cookTime' name='timeInput' class='form-control input-sm' required/>
                </div>
            </div>
        </div>

        <div class='col'>
            
            <div class="grid-container">
            <label>Enter Diet Types: </label>
            <label></label>
            <label></label>
                <div>
                    <input type="checkbox" id="diet0" name="diets[]" value="Unrestricted">Unrestricted</input>
                </div>
                <div>
                    <input type="checkbox" id="diet1" name="diets[]" value="Gluten Free">Gluten Free</input>
                </div>
                <div>
                    <input type="checkbox" id="diet2" name="diets[]" value="Ketogenic">Ketogenic</input>
                </div>
                <div>
                    <input type="checkbox" id="diet3" name="diets[]" value="Vegetarian">Vegetarian</input>
                </div>
                <div>
                    <input type="checkbox" id="diet4" name="diets[]" value="Lacto-Vegetarian">Lacto-Vegetarian</input>
                </div>
                <div>
                    <input type="checkbox" id="diet5" name="diets[]" value="Ovo-Vegetarian">Ovo-Vegetarian</input>
                </div>
                <div>
                    <input type="checkbox" id="diet6" name="diets[]" value="Vegan">Vegan</input>
                </div>
                <div>
                    <input type="checkbox" id="diet7" name="diets[]" value="Pescetarian">Pescetarian</input>
                </div>
                <div>
                    <input type="checkbox" id="diet8" name="diets[]" value="Paleo">Paleo</input>
                </div>
                <div>
                    <input type="checkbox" id="diet9" name="diets[]" value="Primal">Prima</input>
                </div>
                <div>
                    <input type="checkbox" id="diet10" name="diets[]" value="Whole30">Whole30</input>
                </div>
            </div>
        </div>
        <div class='col'>
            <div class="grid-container">
            <label>Set Intolerances:</label>
            <label></label>
            <label></label>
                <div>
                    <input type="checkbox" id="intolerance1" name="intolerances[]" value="Dairy">Dairy</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance2" name="intolerances[]" value="Egg">Egg</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance3" name="intolerances[]" value="Gluten">Gluten</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance4" name="intolerances[]" value="Grain">Grain</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance5" name="intolerances[]" value="Peanut">Peanut</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance6" name="intolerances[]" value="Seafood">Seafood</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance7" name="intolerances[]" value="Sesame">Sesame</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance8" name="intolerances[]" value="Shellfish">Shellfish</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance9" name="intolerances[]" value="Soy">Soy</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance10" name="intolerances[]" value="Sulfite">Sulfite</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance11" name="intolerances[]" value="Tree Nut">Tree Nut</input>
                </div>
                <div>
                    <input type="checkbox" id="intolerance12" name="intolerances[]" value="Wheat">Wheat</input>
                </div>
            </div>
        </div>

    </div>

    <div class='form-group'>
        <br>
        <label for="title-textbox">Title:</label>
        <input class='form-control' type='text' placeholder='Title' name='titleInput' id="title-textbox" required>
    </div>
    <div class='form-group'>
        <label for="ingredients-textbox">Ingredients (Comma Seperated):</label>
        <input class='form-control' type='text' placeholder='Ingredients' pattern = '(\w+)(,*\s*\w+)*' name='ingredientsInput' id="ingredients-textbox" required>
    </div>

    <div class='form-group'>
        <textarea class='textarea-control' style='resize: none;' placeholder='Instruction' name='descriptionInput' rows='10' required></textarea>
    </div>
    <div class='col text-center'>
        <button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button><br><br>
    </div>

</form>