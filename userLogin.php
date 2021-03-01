<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Page</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="temp.css">
</head>

<body>
	<header class="header1">
	
	</header>
	<main>
		<form class="loginForm" method="POST">
			<label>Email:</label><br>
			<input type="email" name="email" id="email" class="textInput" required>
			<br>
			<br>
			<label>Password:</label><br>
			<input type="password" name="password" id="password" minlength="8" class="textInput" required>
			<br>
			<br>
			<button class="submitButton">Log In</button>
			<br>
		</form>
		<br>
		<a href="signUp.php">Sign Up</a>
		<br>
		<a href="resetPassword.html">Reset Password</a>
	</main>
</body>
</html>

<?php
    include("config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $user_check_query = "SELECT * FROM User WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if($user){
            echo($user['first_name']." ".$user['last_name']);
        }
        else{
            echo("Try again!");
        }
    }

?>