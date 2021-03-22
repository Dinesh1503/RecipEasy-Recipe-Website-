<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sign Up</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="temp-login.css">
</head>

<body>
	<header class="header2">
	</header>
	<main>
		<form class="signUpForm" method="POST">
			<label>First Name</label><br>
			<input type="text" name="first_name" id="first_name" class="textInput" required>
			<br>
			<br>
			<label>Last Name</label><br>
			<input type="text" name="last_name" id="last_name" class="textInput" required>
			<br>
			<br>
			<label>Email</label><br>
			<input type="email" name="email" id="email" class="textInput" required>
			<br>
			<br>
			<label>Password:</label><br>
			<input type="password" name="password" id="password" minlength="8" class="textInput" required>
			<br>
			<br>
			<button class="submitButton">Sign Up</button>
		</form>
		<br>
		<a href="userLogin.php">Login</a>
		<br>
		<a href="resetPassword.php">Reset Password</a>
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