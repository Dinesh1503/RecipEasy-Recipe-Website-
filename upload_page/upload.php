<?php require_once("config.php"); ?>
<?php require_once("recipeForm.php"); ?>

<!DOCTYPE html>
<html>
<head>
<title>RecipeE</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="style.css">


</head>

<body>

<h1 >Upload Your Own Recipes!</h1>

<div class="column">

<?php
    
    $form = new RecipeForm();
    echo $form->createUploadForm();
    
?>

</div>


</body>
