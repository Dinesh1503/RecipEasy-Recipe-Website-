<?php
	require_once("main.php");

	$content = file_get_contents("elements/resetPassword.html");
	$layout = new Template("user.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("content", $content);
	
	echo($layout->output());

	include("../DB/config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {

    	$email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $hash = password_hash($password, PASSWORD_DEFAULT);   
        $sql = "UPDATE User SET password = '$hash' WHERE email = '$email'";
        if($conn->query($sql)){
            echo("Successfuly changed.");
        }
        else{
            echo("Fail");
        }

    }
?>
		