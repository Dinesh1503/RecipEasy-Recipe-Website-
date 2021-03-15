<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign Up</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="temp-login.css">
</head>

<body>
	<header class="header3">
	
	</header>
	<main>
		<form class="resetForm" method="POST">
			<h3>Enter your Email.</h3>
			<h4>A link will be sent to reset your password.</h4>
			<label>Email:</label><br>
			<input type="email" name="email" id="email" class="textInput" required>
			<br>
			<br>
			<label>New Password:</label><br>
			<input type="password" name="password" id="password" class="textInput" minlength="8" required>
			<br>
			<br>
			<button class="submitButton">Reset Password</button>
		</form>
		<br>
		<a href="userLogin.php">Login</a>
		<br>
		<a href="signUp.php">Sign Up</a>
		<br>
		<a href="../Static/index.html">Return to Main Page</a>
		<br>
		<a href="contactUs.html">Contact Us</a>
		<br>
	</main>
</body>
</html>

<?php
    include("../DB/config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {

    	$email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $password = password_hash("newPassword", PASSWORD_DEFAULT);   
        $sql = "UPDATE User SET password = '$password' WHERE email = '$email'";
        if($conn->query($sql)){
            echo("Successfuly changed.");
        }
        else{
            echo("Fail");
        }

    }

?>