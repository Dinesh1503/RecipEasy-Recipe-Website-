# Y14 - Group Project

COMP10120 Y14 group project. A repository for putting ideas and prototypes in to get a head start.

Sam: 14/02/21
From what I've figured out the Edamam API uses a RESTful API meaning it uses HTTP requests to send and recieve information. This basically means you have to send a "packet of internet" where you fill it with the request information according to their documentation. It will then send their own packet back in the form of a JSON load that we will have to parse and display.
Due to this, we need some form of library to make these http requests. The best one available is php-cURL a.k.a. the first one I found. Its a basic library and very easy to use. You just have to open a request, load it, then execute it. Ez Pz. It does mean, however, if you're running a local server for testing, you're going to have to install the library.

TLDR: write "sudo apt-get update && sudo apt-get install curl && sudo apt-get install php-curl" into terminal to install cURL which we're going to need. Reboot apache for it to work "sudo systemctl restart apache2".

