<!DOCTYPE html>
<html>
<head>
	<title>Spoonacular Test Page</title>
	<h1>API Test Page</h1>
</head>
<body>
<style type="text/css">
	div[id="ID"]
	{
		background-color:white;

	}
	.collapsible 
	{
	  background-color: grey;
	  color: white;
	  cursor: pointer;
	  padding: 18px;
	  width: 100%;
	  border: none;
	  text-align: left;
	  outline: none;
	  font-size: 15px;
	}

	.active, .collapsible:hover {
	  background-color: blue;
	}

	.content {
	  padding: 0 18px;
	  display: none;
	  overflow: hidden;
	  background-color: white;
	}
</style>
	<!-- Search by Name Button -->
	<button type="button" class="collapsible">Search</button>
	<div class="content" id = "ID" >
      <form method="post" action="Results.php">
        <input type="text" name="searchBox" class="text">
        <input type="Submit" name="&#128269" value="&#128269">
      </form>
    </div>


    <button type="button" class="collapsible">Search By Ingredients</button>
	<div class="content">
	  <form method="post" action="Results.php">
	  	<label>List the ingredients followed by a comma</label>
	  	<p></p>
	  	<textarea name="ingrds" rows="5" cols = "50">ingr A,ingr B,ingr C</textarea>
        <input type="Submit" name="ingrds" value="&#128269">
	  </form>
	</div>
	
</body>
<script>
	var coll = document.getElementsByClassName("collapsible");
	var i;

	for (i = 0; i < coll.length; i++) {
	  coll[i].addEventListener("click", function() {
	    this.classList.toggle("active");
	    var content = this.nextElementSibling;
	    if (content.style.display === "block") {
	      content.style.display = "none";
	    } else {
	      content.style.display = "block";
	    }
	  });
	}
</script>
</html>
