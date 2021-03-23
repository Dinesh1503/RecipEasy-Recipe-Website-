<?php
	require_once("main.php");

	$content = file_get_contents("elements/signUp.html");
	$layout = new Template("user.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("content", $content);
	
	echo($layout->output());

    include("../DB/config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
      
        $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn,$_POST['last_name']); 
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $hash = password_hash($password, PASSWORD_DEFAULT);   
        $sql = "INSERT INTO User(first_name, last_name, email, password)
                VALUES ('$first_name', '$last_name', '$email', '$hash')";
        if($conn->query($sql)){
            header("Location: userLogin.php");
        }
        else{
            echo("Fail");
        }

    }

?>