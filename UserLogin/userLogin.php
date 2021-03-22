<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Page</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="temp-login.css">
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
		<a href="resetPassword.php">Reset Password</a>
		<br>
		<a href="../Static/index.php">Return to Main Page</a>
		<br>
		<a href="contactUs.html">Contact Us</a>
		<br>
	</main>
</body>
</html>

<?php
    include("../DB/config.php");

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $user_check_query = "SELECT * FROM User WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if($user){
            if(password_verify($password, $user['password']))
            {
            	$_SESSION['user'] = $user['first_name']." ".$user['last_name'];
            	$_SESSION['user_id'] = $user['id'];
            	header("Location: ../Static/index.php");
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