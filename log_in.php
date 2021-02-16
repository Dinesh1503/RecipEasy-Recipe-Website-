<!DOCTYPE html>
<html>
    <head>
        <title>Log in</title>
    </head>
    <body>
        <h1>Log in</h1>
        <div id='myForm'>
            <form method='POST'>
                <label>Email:</label><br>
                <input type='email' name='email' id='email' required><br><br>
                <label>Password:</label><br>
                <input type='password' name='password' required><br><br>
                <button style="margin-right: 5px;">Log in</button><a href="register.php">Register</a>
            </form>
        </div>
    </body>
</html>

<?php
    include("config.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        $user_check_query = "SELECT * FROM user WHERE email='$email' LIMIT 1";
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