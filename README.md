# Y14 - Group Project

COMP10120 Y14 group project. A repository for putting ideas and prototypes in to get a head start.

Sam: 14/02/21
From what I've figured out the Edamam API uses a RESTful API meaning it uses HTTP requests to send and recieve information. This basically means you have to send a "packet of internet" where you fill it with the request information according to their documentation. It will then send their own packet back in the form of a JSON load that we will have to parse and display.
Due to this, we need some form of library to make these http requests. The best one available is php-cURL a.k.a. the first one I found. Its a basic library and very easy to use. You just have to open a request, load it, then execute it. Ez Pz. It does mean, however, if you're running a local server for testing, you're going to have to install the library.

TLDR: write "sudo apt-get update && sudo apt-get install curl && sudo apt-get install php-curl" into terminal to install cURL which we're going to need. Reboot apache for it to work "sudo systemctl restart apache2".

The config.php file contains the logic for the database. If you going to run it locally first run the instruction that creates the database and remove the variable $database. On the second run, you should specify the database you are working on so the file should look as it is now. There are 4 tables -> User, Food, Ingredient, and Recipe. The Recipe and Ingredient tables are connected with one to many relation, the User and Recipe -> one to many, Ingredient and Food -> one to one.
There are two additional files that contain a simple logic for login and register just to test the database and look at them if you don't want to bother with the database.