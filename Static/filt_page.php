<html>
<head>
  <title>RecipEasy</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/base_style.css">
  <link rel="stylesheet" type="text/css" href="css/filt_page.css">
</head>
<body>
  <!--HEADER -->
    <header>
      <h1>RecipEasy</h1>
        <div id="login_container">
          <?php
            session_start();
            session_regenerate_id();
            if(isset($_SESSION['user']))      // if there is no valid session
            {
                echo("<div><b>".$_SESSION['user']."</b></div>");
            }
            else{
              echo("<a href='../UserLogin/userLogin.php' class='login'>Login</a>
                  <a href='../UserLogin/signUp.php'>Register</a>");
            }
          ?>
         </div>
    </header>

    <!--NAV BAR -->
    <nav>
      <div id="nav_container">
        <a href="index.php">Main Page</a>
        |
        <a href="search.php">Search</a>
        |
        <a href="filt_page.php">Filter</a>
        |
        <a href="upload.php">Upload</a>
      </div>
    </nav>

    <!-- MAIN AREA -->
    <main>
      <h2><b>Search :</b><input type="text" value="" class="mytxt" /></h2>
      <div class="account">
          <a href="#"><img src="account.png" alt="account"></a>
      </div>

      <div class="functions">
              <span><img src="functions.png" alt="functions"></span>
              <div class="downbtn">
                  <ul>
                      <li><a href="#">Wish list</a></li>
                      <li><a href="#">Diet Tracker</a></li>
                      <li><a href="#">Meal Planning</a></li>
                      <li><a href="#">Update your Own Menu</a></li>
                  </ul>
              </div>
          </div>

        <div class="filters">
            <table>
              <tr>
                  <td><a href="#"><img src="filter1.jpg" alt="filter1" height="100" width="100"></a></td>
                  <td><a href="#"><img src="filter2.jpg" alt="filter1" height="100" width="100"></a></td>
                  <td><a href="#"><img src="filter3.jpg" alt="filter1" height="100" width="100"></a></td>
                  <td><a href="#"><img src="filter4.jpg" alt="filter1" height="100" width="100"></a></td>
              </tr>
              <tr>
                <td><a href="#"><img src="filter1.jpg" alt="filter1" height="100" width="100"></a></td>
                <td><a href="#"><img src="filter2.jpg" alt="filter1" height="100" width="100"></a></td>
                <td><a href="#"><img src="filter3.jpg" alt="filter1" height="100" width="100"></a></td>
                <td><a href="#"><img src="filter4.jpg" alt="filter1" height="100" width="100"></a></td>
              </tr>
              <tr>
                <td><a href="#"><img src="filter1.jpg" alt="filter1" height="100" width="100"></a></td>
                <td><a href="#"><img src="filter2.jpg" alt="filter1" height="100" width="100"></a></td>
                <td><a href="#"><img src="filter3.jpg" alt="filter1" height="100" width="100"></a></td>
                <td><a href="#"><img src="filter4.jpg" alt="filter1" height="100" width="100"></a></td>
              </tr>
            </table>
        </div>
      </main>
    <!-- FOOTER -->
    <footer>
    </footer>
</body>
</html>
