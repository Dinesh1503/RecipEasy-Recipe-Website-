<link rel=\"stylesheet\" type=\"text/css\" href=\"css/upload.css\">
<h1 >Upload Your Own Recipes!</h1>
<div class=\"column\">
<form action='processing.php' method='POST' enctype='multipart/form-data'>

    <div class='form-group'>
        <label for='photo'>Your photo</label><br>
        <input type='file' accept='.jpeg, .jpg, .png, .gif, .bmp, .webp, .raw, .ico, .tiff'
        class='form-control-file w-50' id='photo' name='pictureInput' required>
        <br><br>
    </div>

    <div class = 'row'>

        <div class='col'>
            <div class='form-group'>
                <label class='form-label' for='select'>Cuisine Type</label>
                <select class='form-select' aria-label='Default select example' name='categoryInput' id='select' required>
                    <option value='British'>'British'</option>
                    <option value='French'>'French'</option>
                    <option value='Italian'>'Italian'</option>
                    <option value='Central Europe'>'Central Europe'</option>
                    <option value='Caribbean'>'Caribbean'</option>
                    <option value='Eastern Europe'>'Eastern Europe'</option>
                    <option value='Chinese'>'Chinese'</option>
                    <option value='Japanese'>'Japanese'</option>
                    <option value='Indian'>'Indian'</option>
                    <option value='South East Asia'>'South East Asia'</option>
                    <option value='American'>'American'</option>
                    <option value='Mexican'>'Mexican'</option>
                </select>
            </div>
        </div>

        <div class='col'>
            <div class='outline'>
                <label class='form-label' for='serveNum'>Number of Servings</label>
                <input type='number' min='1' max='6' id='serveNum' name='servingInput' class='form-control input-sm' required/>
            </div>
        </div>

        <div class='col'>
            <div class='outline'>
                <label class='form-label' for='cookTime'>Cooking Time (min)</label>
                <input type='number' min='0' id='cookTime' name='timeInput' class='form-control input-sm' required/>
            </div>
        </div>

    </div>

    <div class='form-group'>
        <br>
        <input class='form-control' type='text' placeholder='Title' name='titleInput' required>
    </div>
    <div class='form-group'>
        <input class='form-control' type='text' placeholder='Ingredients' pattern = '(\w+)(,*\s*\w+)*' name='ingredientsInput' required>
    </div>
    <div class='form-group'>
        <textarea class='textarea-control' style='resize: none;' placeholder='Instruction' name='descriptionInput' rows='10' required></textarea>
    </div>
    <div class='col text-center'>
        <button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>
    </div>

</form>