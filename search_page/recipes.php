
<?php
session_start();
include("config.php");


if(isset($_GET['id'])){

    $id = $_GET['id'];

    $query = mysqli_query($con, "SELECT * FROM Recipe WHERE user_id IS NULL AND id='$id'");
    
    if(mysqli_num_rows($query)==0){
        $query1 = mysqli_query($con, "SELECT * FROM Recipe WHERE id='$id'");

        //sth to display
        while($row1 = mysqli_fetch_array($query1)) {
            $title1 = $row1['title'];
            $ingr1 = $row1['ingredients'];
            $category1 = $row1['category'];
            $img_url1 = $row1['image_url'];
            $servings1 = $row1['number_of_servings'];
            $time1 = $row1['time'];

            echo "<div >
                <h2> $title1 </h2>
                <img src='" . $img_url1 . "'>
                <ul>
                    <li>" . "Time: " . $time1 . "
                    <li>" . "Servings: " . $servings1 . "
                    <li>" . "category: " . $category1 . "</li> 
                    <li>" . "Ingredients: " . $ingr1 . "</li>
                <ul>
                <div class='recipes'><br><br>
                <div>
            </div>";
        }
    }

    else{

        while($row = mysqli_fetch_array($query)) {

            $title = $row['title'];
            $summary = $row['summary'];
            $time = $row['time'];
            $description = $row['description'];
            $s_url = $row['original_site_url'];
            $img_url = $row['image_url'];
            $servings = $row['number_of_servings'];

            echo "<div >
                    <h2> $title </h2>
                    <img src='" . $img_url . "'>
                    <ul>
                        <li>" . "Time: " . $time . "
                        <li>" . "Servings: " . $servings . "
                        <li>" . "Summary: " . $summary . "</li> 
                        <li>" . "Description: " . $description . "</li>
                    <ul>
                    <div class='recipes'><br>
                    <a href='" . $s_url . "'>Source Website</a><br>
                    <div>
                </div>";
            }
        }
    
    echo "<button style='width:30%;height:30px' onclick='window.history.back()'>Back</button>";

}
?>
