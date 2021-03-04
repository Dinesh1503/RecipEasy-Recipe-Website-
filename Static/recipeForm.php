<?php
    class RecipeForm {
        
        public function createUploadForm() {
            
            $pictureInput = $this->createPictureInput();
            $titleInput = $this->createTitleInput();
            $ingredientsInput = $this->createIngredientsInput();
            $servingInput = $this->createServingInput();
            $timeInput = $this->createTimeInput();
            
            $categoriesInput = $this->createCategoriesInput();
            
            $descriptionInput = $this->createDescriptionInput();
            $uploadButton = $this->createUploadButton();
            
            return "<form action='processing.php' method='POST' enctype='multipart/form-data'>

                        $pictureInput

                        <div class = 'row'>

                            <div class='col'>
                            $categoriesInput
                            </div>
                    
                            <div class='col'>
                            $servingInput
                            </div>

                            <div class='col'>
                            $timeInput
                            </div>

                        </div>

                        $titleInput
                        $ingredientsInput
                        $descriptionInput
                        $uploadButton
                        
                    </form>";

        }

        
        
        private function createPictureInput() {
            
            return "<div class='form-group'>
                <label for='photo'>Your photo</label><br>
                <input type='file' accept='.jpeg, .jpg, .png, .gif, .bmp, .webp, .raw, .ico, .tiff'
                 class='form-control-file w-50' id='photo' name='pictureInput' required>
                <br><br>

                </div>";
                }
        
        private function createTitleInput() {
            return "<div class='form-group'>
            <br>
            <input class='form-control' type='text' placeholder='Title' name='titleInput' required>
            </div>";
        }
        
        private function createIngredientsInput() {
            return "<div class='form-group'>
            <input class='form-control' type='text' placeholder='Ingredients' name='ingredientsInput' required>
            </div>";
        }
        
        private function createDescriptionInput() {
            return "<div class='form-group'>
            <textarea class='textarea-control' style='resize: none;' placeholder='Instruction' name='descriptionInput' rows='10' required></textarea>
            </div>";
        }
        
        private function createServingInput() {

            return "<div class='outline'>
            <label class='form-label' for='serveNum'>Number of Servings</label>
            <input type='number' min='1' max='6' id='serveNum' name='servingInput' class='form-control input-sm' required/>
            </div>";
                }

        private function createTimeInput() {
            
            return "<div class='outline'>
            <label class='form-label' for='cookTime'>Cooking Time (min)</label>
            <input type='number' min='0' id='cookTime' name='timeInput' class='form-control input-sm' required/>
            </div>";
                }

        private function createCategoriesInput() {
        
            $html = "<div class='form-group'>
            <label class='form-label' for='select'>Cuisine Type</label>
            <select class='form-select' aria-label='Default select example' name='categoryInput' id='select' required>";
            
            for($i=0;$i<=11;$i++) {
                
                $category = ['British', 'French', 'Italian', 'Central Europe',
                'Caribbean', 'Eastern Europe', 'Chinese', 'Japanese', 'Indian',
                'South East Asia', 'American', 'Mexican'];

                $html .= "<option value=$category[$i]>$category[$i]</option>";

            }
            
            $html .= "</select></div>";
            
            return $html;
            
            
        }
        
        private function createUploadButton() {
            return "<div class='col text-center'><br><br><button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>
            </div>";
        }
    }

?>

