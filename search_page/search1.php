
<?php

    include("config.php"); 
    include("Api.php");
    session_start();

    //Database search
    function search($term, $con, $sel) {
        
        if($sel == 'b'){
            $term = str_replace(",", "|", $term);
            $Query = mysqli_query($con, "SELECT * FROM Recipe WHERE user_id IS NOT NULL AND ingredients REGEXP '$term'");
        }
        else{
            $Query = mysqli_query($con, "SELECT * FROM Recipe WHERE user_id IS NOT NULL AND title LIKE '%$term%'");
        }

        $b = array();
        if(mysqli_num_rows($Query) == 0){
            echo "<span class='noResults'> No recipes found matching " . $term . "</span>";
        }

        else{
            while($row = mysqli_fetch_array($Query)) {
                
                array_push($b, "<div class='gridItem'>
                        <a href=\"recipes.php?id=" . $row['id'] . "\">
                            <img src='" . $row['image_url'] ."'>
                            <div class='gridTitle'>"
                                . $row['title'] .
                            "</div>
                        </a>
                    </div>");    
        }
        }
        return $b;
    }

    //display & pagination
    function resultDisplay($p, $id, $num, $con, $term, $sel) {
        
        $numberOfResults = intval($num);

        $ids = implode(',', $id);
        $query = mysqli_query($con, "SELECT * FROM Recipe WHERE id IN (" . $ids . ")");
        
        $searchData = array();
        while ($row = mysqli_fetch_array($query)){
            $searchData[] = $row;
        };

            $begin = 12 * ($p-1);
            if($numberOfResults - $begin >= 12){
                $end = $begin + 12;
            }
            else{
                $end = $numberOfResults;
            }
            $a="";

        for($i=$begin;$i<$end;$i++) {
            $a = $a . "<div class='gridItem'>
                    <a href=\"recipes.php?id=" . $searchData[$i]['id'] . "\" >
                            <img src='" . $searchData[$i]['image_url'] ."'>
                            <div class='gridTitle'>"
                            . $searchData[$i]['title'] .
                            "</div>
                            </a>
                    </div>";
            }
            
            // call search function get user recipes
            $userRecipes = search($term, $con, $sel); 
            
            $numOfUserRecipes = count($userRecipes);

            if($numberOfResults - $begin >= 12){
                echo "<div class='searchResults'>" . $a . "</div>";
            }

            else if(($numberOfResults - $begin) < 12 && ($numberOfResults - $begin) > 0){
                
                $uRes = "";
                if(!$numOfUserRecipes == 0){
                    $rest = 12 - ($end - $begin) ;
                    if($numOfUserRecipes > $rest){
                        $stop = $rest;
                    }
                    else{
                        $stop = $numOfUserRecipes;
                    }
                    for($z=0;$z<$stop;$z++){
                        $uRes .= $userRecipes[$z];
                    }
                }
                
                echo "<div class='searchResults'>" . $a . $uRes . "</div>";}

            else if($begin >= $numberOfResults){
                $uRes = "";
                    if($numOfUserRecipes + $numberOfResults - $begin <= 12){
                        $stop = $numOfUserRecipes;
                    }
                    else{
                        $stop = - $numberOfResults + $begin + 12;
                    }
                for($z= - $numberOfResults + $begin ;$z < $stop;$z++){
                    $uRes .= $userRecipes[$z];
                }
                echo "<div class='searchResults'>" . $uRes . "</div>";
            }
            
        
        for ($j = 1; $j <= ceil(($numberOfResults + $numOfUserRecipes)/12); $j++) {
            $url = "http://localhost:8888/y14-group-project-master%208/Static/search.php?page=" . strval($j);
            $b = $b . "<li class='pageTurnLi'> <a class='page" . $j . "' href='$url'> " . strval($j) . "</a></li>";
        }
        $c = "<div class='page'><ul class='pageTurnUl'>" . $b . "</ul></div>";
        
        echo $c;
    }  
?>

<html>
<head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="sty.css">
    <script>
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    
</head>
<body>
<div class="searchContainer">
    
    <form autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?page=1";?>" >
    
        <select name="select" id="select">
        <?php
            $category = ['a'=>'General Search', 'b'=>'Search by Ingredients'];
            foreach($category as $key=>$value){
                
                if(isset($_POST['select'])){
                    $selected = ($_POST['select']==$key) ? 'selected="true"': '';
                }
                else if(isset($_SESSION['select'])){
                    $selected = ($_SESSION['select'] == $key) ? 'selected="true"': '';
                }
                else{
                    $selected = '';
                }
                echo  '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
            }
            ?>
        </select>

        <div class="ingr" hidden>

            <div class="search"> 
                <input value="<?php echo isset($_POST['ingrSearch']) ? $_POST['ingrSearch'] : (isset($_SESSION['ingrSearch']) ? $_SESSION['ingrSearch'] : ""); ?>" 
                    pattern = '(\w+)(,*\s*\w+)*' type="text" class="searchInput" name="ingrSearch" placeholder="Search in ingredients by commas">
                <button name='submit' id="submit" class="button" type="submit" >Search</button>
            </div>

            <select  class="ingr" name="ingrSelect" id="ingrSelect">

            <?php
            $category = ['1'=>'maximize used ingredients', '2'=>'minimize missing ingredients'];
            foreach($category as $key=>$value){
                
                if(isset($_POST['ingrSelect'])){
                    $selected = ($_POST['ingrSelect']==$key) ? 'selected="true"': '';
                }
                else if(isset($_SESSION['ingrSelect'])){
                    $selected = ($_SESSION['ingrSelect'] == $key) ? 'selected="true"': '';
                }
                else{
                    $selected = '';
                }
                echo  '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
            }
            ?>
            </select>
            
            <label class="ingr" for="ingrNumber" >number:</label>
            <input value="<?php echo isset($_POST['ingrNumber']) ? $_POST['ingrNumber'] : (isset($_SESSION['ingrNumber']) ? $_SESSION['ingrNumber'] : 2);?>" type="number" id="ingrNum" class="ingr" name="ingrNumber" value="2">
        </div>
    
        <div class="general" hidden>

            <div class='search'>
                <input value="<?php echo isset($_POST['search']) ? $_POST['search'] : (isset($_SESSION['search']) ? $_SESSION['search'] : ""); ?>" type="text" class="searchInput" name="search" placeholder="Find recipes...">
                <button name='submit' id="submit" class="button" type="submit" >Search</button>
            </div>

            <div class="select">

                <div class="numberInput">
                    <label for="sort" >Sort By</label>
                    <select name="sort" >
                    
                    
                    <?php
                    $category = ['popularity', 'time', 'price', 'healthiness', 'calories'];
                    foreach($category as $value){
                        
                        if(isset($_POST['sort'])){
                            $selected = ($_POST['sort']==$value) ? 'selected="true"': '';
                        }
                        else if(isset($_SESSION['sort'])){
                            $selected = ($_SESSION['sort'] == $value) ? 'selected="true"': '';
                        }
                        else{
                            $selected = '';
                        }
                        echo  '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
                    }
                    ?>
                    </select>
                </div>

                <div class="numberInput">
                    <label for="cuisine" >cuisine filter:</label>
                    <select name="cuisine" >
                        
                        <?php
                        $category = ['', 'British', 'French', 'Italian', 'German', 'European',
                        'Caribbean', 'Eastern European', 'Chinese', 'Japanese', 'Indian',
                        'South East Asia', 'American'];
                        foreach($category as $value){
                            
                            if(isset($_POST['cuisine'])){
                                $selected = ($_POST['cuisine']==$value) ? 'selected="true"': '';
                            }
                            else if(isset($_SESSION['cuisine'])){
                                $selected = ($_SESSION['cuisine'] == $value) ? 'selected="true"': '';
                            }
                            else{
                                $selected = '';
                            }
                            echo  '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
                        }
                        ?>

                    </select>
                </div>

                <div class="numberInput">
                    <label for="diet" >diet filter:</label>
                    <select name="diet" >
                    <?php
                    $category = ['', 'Gluten Free', 'Ketogenic', 'Vegetarian', 'Vegan',
                    'Pescetarian', 'Paleo', 'Primal', 'Whole30']; 
                    foreach($category as $value){
                        
                        if(isset($_POST['diet'])){
                            $selected = ($_POST['diet']==$value) ? 'selected="true"': '';
                        }
                        else if(isset($_SESSION['diet'])){
                            $selected = ($_SESSION['diet'] == $value) ? 'selected="true"': '';
                        }
                        else{
                            $selected = '';
                        }
                        echo  '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
                    }
                    ?>

                    </select>
                </div>

                <div class="numberInput">
                    <label for="number" >number:</label>
                    <input value="<?php echo isset($_POST['number']) ? $_POST['number'] : (isset($_SESSION['number']) ? $_SESSION['number'] : 2);?>" type="number" name="number" class="filter number">
                </div>

            </div>
        
            <div class="number"> 
                <div class="numberInput">
                    <label for="maxReadyTime" >maxReadyTime</label>
                    <input value="<?php echo isset($_POST['maxReadyTime']) ? $_POST['maxReadyTime'] : (isset($_SESSION['maxReadyTime']) ? $_SESSION['maxReadyTime'] : 200);?>" type="number" name="maxReadyTime" class="filter number">
                </div>
                <div class="numberInput">
                    <label for="maxFat" >maxFat</label>
                    <input value="<?php echo isset($_POST['maxFat']) ? $_POST['maxFat'] : (isset($_SESSION['maxFat']) ? $_SESSION['maxFat'] : 2000);?>" type="number" name="maxFat" class="filter number">
                </div>
                <div class="numberInput">
                    <label for="maxCalories" >maxCalories</label>
                    <input value="<?php echo isset($_POST['maxCalories']) ? $_POST['maxCalories'] : (isset($_SESSION['maxCalories']) ? $_SESSION['maxCalories'] : 3000);?>" type="number" name="maxCalories" class="filter number">
                </div>
            </div>

        </div>

    </form>

    <script type="text/javascript" language="javascript">
    
    // change search fields based on selected value & page reload

    $(function() {
        
        $("#select").change(function(){
            var value = $('#select').val();
            if (value == 'b') {
                $(".general").hide();
                $(".ingr").show();
            }
            else if(value == 'a'){
                $(".ingr").hide();
                $(".general").show();
            }
        });
    });
    
    var val = $("#select").val();
            if (val == "b") {
                $(".general").hide();
                $(".ingr").show();
            }
            else if(val == "a"){
                $(".ingr").hide();
                $(".general").show();
            }

    </script>

</div>

    <h2 class="h2Recipe">Recipes</h2>

</body>
</html>


    <?php
        
        if(isset($_POST['submit'])){

            if($_POST['select']=='a'){
                $term = $_POST['search'];
                $_SESSION['search'] = $_POST['search'];
            }
            else{
                $term = $_POST['ingrSearch'];
                $_SESSION['ingrSearch'] = $_POST['ingrSearch'];
            }

            $api = new Api($term, ""); // api key
            $_SESSION['select'] = $_POST['select'];

            // search by ingr
            if($_POST['select']=='b'){
            
                $rank = $_POST['ingrSelect'];
                $number = $_POST['ingrNumber'];
                $_SESSION['ingrSelect'] = $_POST['ingrSelect'];
                $_SESSION['ingrNumber'] = $_POST['ingrNumber'];

                //get id from api ingr search 
                $api_data = $api->searchByIngr($rank, $number);

            }

            // general search
            else{
                
                $cuisine = $_POST['cuisine'];
                $diet = $_POST['diet'];
                $number = strval($_POST['number']);
                $maxReadyTime = strval($_POST['maxReadyTime']);
                $maxFat = strval($_POST['maxFat']);
                $maxCalories = strval($_POST['maxCalories']);
                $sort = $_POST['sort'];
                $_SESSION['cuisine'] = $_POST['cuisine'];
                $_SESSION['diet'] = $_POST['diet'];
                $_SESSION['number'] = $_POST['number'];
                $_SESSION['maxReadyTime'] = $_POST['maxReadyTime'];
                $_SESSION['maxFat'] = $_POST['maxFat'];
                $_SESSION['maxCalories'] = $_POST['maxCalories'];
                $_SESSION['sort'] = $_POST['sort'];
                
                $data = $api->generalSearch($cuisine, $diet, $number, $maxReadyTime, $maxFat, $maxCalories, $sort);
                $api_data = $data['results'];
            }

            $id = array();
            foreach($api_data as $data) {
                    array_push($id, $data['id']);
                }

                $idw = "ids=" . join(",", $id);
                //get recipe info from api info call
                $rrdata = $api->getRecipeInfo($idw);

            $_SESSION['result'] = strval(count($rrdata));
            
            $ids = array();

            //insert database 
        foreach($rrdata as $data) {
            
            $vegetarian = $data['vegetarian']=="true" ? true: false;
            $vegan = $data['vegan']=="true" ? true: false;
            $glutenFree = $data['glutenFree']=="true" ? true: false;
            $dairyFree = $data['dairyFree']=="true" ? true: false;
            $veryHealthy = ($data['veryHealthy']=="true") ? true: false;
            $cheap = $data['cheap']=="true" ? true: false;
            $calories = $data['calories'];
            $ketogenic = $data['ketogenic']=="true" ? true: false;
            $sustainable = $data['sustainable']=="true" ? true: false;
            $veryPopular = $data['veryPopular']=="true" ? true: false;
            
            $price_per_serving = intval($data['pricePerServing']);
            $health_score = intval($data['healthScore']);
            $aggregate_lies = intval($data['aggregateLikes']);
            $license = str_replace("'", "''", $data['license']);
            $image_type = $data['imageType'];

            $cuisine_type = $data['cuisines'][0];
            // $dishType

            $img_url = $data['image'];
            $title = str_replace("'", "''", $data['title']);
            $servings = $data['servings'];
            $readyTime = $data['readyInMinutes'];
            $source_url = $data['sourceUrl'];
            $instruction = strip_tags($data['instructions']);
            $instruction1 = str_replace("'", "''", $instruction);    

            $result = mysqli_query($con, "INSERT IGNORE INTO Recipe(vegetarian, vegan, gluten_free, dairy_free, very_healthy, cheap, ketogenic, sustainable, very_popular, calories, price_per_serving, health_score, aggregate_lies, license, image_type, cuisine_type, title, image_url, source_site_url, number_of_servings, ready_in_minutes, description)
            VALUES('$vegetarian', '$vegan', '$glutenFree','$dairyFree','$veryHealthy' , '$cheap', '$ketogenic', '$sustainable' , '$veryPopular', '$calories', '$price_per_serving', '$health_score', '$aggregate_lies', '$license', '$image_type', '$cuisine_type',
            '$title', '$img_url', '$source_url', '$servings', '$readyTime', '$instruction1')")or die(mysqli_error($con));

            $idss = mysqli_insert_id($con);
            array_push($ids, $idss);
            
            foreach($data['extendedIngredients'] as $d){

                $nm = $d['name'];
                $amount = $d['amount'];
                $original = str_replace("'", "''", $d['original']);
                $unit = $d['unit'];
                $recipeId = $idss;
                $image = $d['image'];

                mysqli_query($con, "INSERT IGNORE INTO ExtendedIngredient(name, amount, original, unit, recipe_id)
                VALUES('$nm', '$amount', '$original', '$unit', '$recipeId')")or die(mysqli_error($con));
                
                // seems api doesn't provide images for ingredients
                $id_ = mysqli_insert_id($con);
                mysqli_query($con, "INSERT IGNORE INTO ingredient(name, image, extended_ingredient_id) VALUES('$nm', '$image', '$id_')");
            }
        }
                $_SESSION['ids'] = $ids;
    }

    // display
    if(isset($_GET['page']) && !empty($_SESSION['ids'])){

        $p = intval($_GET['page']);
        $id5 = $_SESSION['ids'];
        
        $numberOfResults = $_SESSION['result'];
        if($_SESSION['select']=='b'){
            $term = $_SESSION['ingrSearch'];
        }
        else{
            $term = $_SESSION['search'];
        }

        $select = $_SESSION['select'];
        resultDisplay($p, $id5, $numberOfResults, $con, $term, $select);
        
        ?>
        <script type="text/javascript" language="javascript">
            
            var className = "<?php echo '.page' . strval($p); ?>";
            $(className).css("background", "#f0c929");

        </script>

        <?php
            
    }
    
    ?>
    



