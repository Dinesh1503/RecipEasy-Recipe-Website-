

<?php
    session_start();
    require_once("main.php");

    if(isset($_POST['date'])) {
        $_SESSION['date'] = $_POST['date'];
    }

    else{
        if(!isset($_SESSION['date'])) {
            // current date
            $date = date("Y-m-d");
        }
        else{
            // set date
            $date = $_SESSION['date'];
        }
        $content = mealPlan($date);
    }
    
    $layout = new Template("index.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("user", getUserElements());
    
    $layout->set("content", $content);
	
	echo($layout->output());
?>



