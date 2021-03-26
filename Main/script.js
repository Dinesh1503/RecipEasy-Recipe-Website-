
function fav(id, userId) {

    var checkbox = document.getElementById('checkbox');
    var isChecked = 0;
    if (checkbox.checked) {
        isChecked = 1;
    }
    // console.log(isChecked);
    // console.log(id);
    // console.log(userId);
    $.ajax({
        type: "POST",
        url: 'query.php',
        data: { 'id' : id , 'userId' : userId, 'isChecked' : isChecked},
        success: function()
        {
            if(isChecked){
                alert("Favorite!");
            }
            else{
                alert("Cancel Favorite");
            }    
        }
    });
    
}