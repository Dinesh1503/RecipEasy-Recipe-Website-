<?php
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $database = "Fridge";
  $conn = mysqli_connect($servername, $username, $password, $database);

  if (!$conn)
    {
      die("Connection failed: " . mysqli_connect_error());
    }

    echo "Connected successfully";


    //Use this to create the table
    $sql = "
        CREATE TABLE fridge (
        userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        INGREDIENT_ONE VARCHAR(30) NULL,
        INGREDIENT_TWO VARCHAR(30) NULL,
        INGREDIENT_THREE VARCHAR(30) NULL,
        INGREDIENT_FOUR VARCHAR(30) NULL,
        INGREDIENT_FIVE VARCHAR(30) NULL,
        INGREDIENT_SIX VARCHAR(30) NULL,
        INGREDIENT_SEVEN VARCHAR(30) NULL,
        INGREDIENT_EIGHT VARCHAR(30) NULL,
        INGREDIENT_NINE VARCHAR(30) NULL,
        INGREDIENT_TEN VARCHAR(30) NULL
        )";

    // $sql = "CREATE TABLE fridge (   //Use this to delete table if needed
    //   userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    //   INGREDIENT VARCHAR(100) NULL
    // )";
    //
    // $sql = "DROP TABLE fridge";
    if ($conn->query($sql))
    {
      echo ("Table created successfully");
    }
    else
    {
      echo ("Error: " . $conn->error);
    }


 ?>
