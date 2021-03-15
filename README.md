# Y14 - Group Project

COMP10120 Y14 group project.

Directories:
@ DB - A directory containing the database logic.
@ Debug - Most of the things that are being tested right now. Working with the API.
@ Static - Currently contains all the main pages of our webiste. Most of the work should be done here.
@ UserLogin - The user login and register pages with their styling. User authentication, email validation or password reset should be implemented here. 

Angel:
Currently all we have is contained in the directories DB, Debug, Static, UserLogin.
I have left the other files just in case I have missed something.
I have commented Yunyi's upload processing file because as we are now going to change the database this block of code is not going to work,
If you find something that I have made wrong please message me,
Also what I have put is what was pushed in gitlab. If you have more recent versions please push them and try to work on it as it is now, because everything is connected. We should try to stick as sooner as possible to a signle design that everyone should use

Sam: 14/02/21
From what I've figured out the Edamam API uses a RESTful API meaning it uses HTTP requests to send and recieve information. This basically means you have to send a "packet of internet" where you fill it with the request information according to their documentation. It will then send their own packet back in the form of a JSON load that we will have to parse and display.
Due to this, we need some form of library to make these http requests. The best one available is php-cURL a.k.a. the first one I found. Its a basic library and very easy to use. You just have to open a request, load it, then execute it. Ez Pz. It does mean, however, if you're running a local server for testing, you're going to have to install the library.

TLDR: write "sudo apt-get update && sudo apt-get install curl && sudo apt-get install php-curl" into terminal to install cURL which we're going to need. Reboot apache for it to work "sudo systemctl restart apache2".

The config.php file contains the logic for the database. There are 4 tables -> User, Food, Ingredient, and Recipe. The Recipe and Ingredient tables are connected with one to many relation, the User and Recipe -> one to many, Ingredient and Food -> one to one.
There are two additional files that contain a simple logic for login and register just to test the database and look at them if you don't want to bother with the database.