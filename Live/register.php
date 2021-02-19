<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <h1>Register</h1>
        <div id='myForm' action="register.php">
            <form method='POST'>
                <label>Firts Name:</label> <br>
                <input type='text' name='first_name' id='first_name' required><br><br>
                <label>Last Name:</label><br>
                <input type='text' name='last_name' id='last_name' required><br><br>
                <label>Email:</label><br>
                <input type='email' name='email' id='email' required><br><br>
                <label>Password:</label><br>
                <input type='password' name='password' required><br><br>
                <button style="margin-right: 5px;"s>Register</button><a href="log_in.php">Log in</a>
            </form>
        </div>
    </body>
</html>

<?php
    include("config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
      
        $first_name = mysqli_real_escape_string($conn,$_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn,$_POST['last_name']); 
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $password = password_hash("newPassword", PASSWORD_DEFAULT);   
        $sql = "INSERT INTO User(first_name, last_name, email, password)
                VALUES ('$first_name', '$last_name', '$email', '$password')";
        if($conn->query($sql)){
            echo("Successfuly registered");
        }
        else{
            echo("Fail");
        }

    }

?>