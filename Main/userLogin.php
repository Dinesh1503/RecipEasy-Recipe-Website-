<?php
	require_once("main.php");

	$content = file_get_contents("elements/userLogin.html");
	$layout = new Template("user.tpl");
	$layout->set("title", "TEMPLATE");
	$layout->set("content", $content);

	echo($layout->output());

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        echo($email.$password);

        $user_check_query = "SELECT * FROM User WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if($user){
            if(password_verify($password, $user['password']))
            {
            	$_SESSION['user'] = $user['first_name']." ".$user['last_name'];
                $_SESSION['id'] = $user['id'];
            	header("Location: index.php");
            }
            else{
            	echo("Incorrect Details. Please try again!");
            }
        }
        else{
            echo("Email not found. Please try again!");
        }
    }

?>